<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class VacancyController extends Controller
{
    /* =========================
     |  LOGIN & OTP
     ========================= */

    public function login(Request $request)
    {
        // Jika sudah login (middleware simpan data)
        if (Session::has('applier_id')) {
            return redirect('auth/profile');
        }

        $remaining = $this->remainingOtpValid();

        // OTP kadaluarsa
        if (Session::has('otp_phone') && $remaining <= 1) {
            Session::forget(['otp_code', 'otp_phone', 'otp_expired_at']);
            return redirect('auth?time=' . time());
        }

        if ($request->isMethod('post')) {

            // REQUEST OTP
            if ($request->request_otp) {
                $request->validate([
                    'phone' => 'required|digits_between:9,13'
                ]);

                $otp = random_int(100000, 999999);

                Session::put([
                    'otp_code'       => $otp,
                    'otp_phone'      => '62' . $request->phone,
                    'otp_expired_at' => now()->addSeconds(90),
                ]);

                defer(fn() =>
                    $this->sendWhatasapp(
                        '62' . $request->phone,
                        "KODE OTP ANDA $otp\n\nJangan membagikan kode ini."
                    )
                );
            }

            // VERIFIKASI OTP
            if ($request->otp) {
                return $this->verifyOtp($request->otp);
            }

            return redirect('auth?time=' . time());
        }

        return view(get_view('page.masuk-mitra'), [
            'remainingValidOtp' => max(0, $remaining),
            'hasOtp'            => Session::has('otp_phone'),
        ]);
    }

    /* =========================
     |  OTP UTILITIES
     ========================= */

    private function remainingOtpValid(): int
    {
        $expiredAt = Session::get('otp_expired_at');

        if (!$expiredAt) {
            return 0;
        }

        return max(0, Carbon::now()->diffInSeconds($expiredAt, false));
    }

    public function verifyOtp($otp)
    {
        if (!Session::has('otp_code')) {
            return back()->withErrors(['otp' => 'OTP tidak ditemukan atau sudah kadaluarsa']);
        }

        if (now()->greaterThan(Session::get('otp_expired_at'))) {
            Session::forget(['otp_code', 'otp_phone', 'otp_expired_at']);
            return back()->withErrors(['otp' => 'OTP sudah kadaluarsa']);
        }

        if ($otp != Session::get('otp_code')) {
            return back()->withErrors(['otp' => 'OTP salah']);
        }

        // OTP VALID
        $phone = Session::get('otp_phone');

        $data = query()->firstOrCreate(
            [
                'title' => $phone,
                'type'  => 'lamaran',
            ],
            [
                'user_id' => 1,
                'status'  => 'new',
            ]
        );

        Session::put('applier_id', $data->id);
        Session::forget(['otp_code', 'otp_phone', 'otp_expired_at']);

        return redirect('auth/profile');
    }

    /* =========================
     |  PROTECTED AREA
     ========================= */

    public function profile()
    {
        // 🔥 Data sudah divalidasi oleh middleware

        page_name(name: 'Lengkapi Data Profile');

        return view(get_view('page.profile'));
    }

    public function dashboard()
    {
        $data = query()->whereType('lamaran')->find(Session::get('applier_id'));
        if($data->status=='new'){
            return redirect('auth/profile');
        }
        // dashboard logic
    }

    /* =========================
     |  WHATSAPP OTP
     ========================= */

    private function sendWhatasapp($phone, $message)
    {
        Http::post(config('app.wa_host') . '/message/send-text', [
            'session'  => config('app.wa_session'),
            'to'       => $phone,
            'text'     => str_replace('\n', "\r", $message),
            'is_group' => false,
        ]);
    }
}
