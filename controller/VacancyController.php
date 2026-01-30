<?php

namespace App\Http\Controllers\controller;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class VacancyController extends Controller
{
  public function login(Request $request)
{
    if($this->isLogin()){
            return redirect('auth/profile');
    }
    $remaining = $this->remainingOtpValid();
    if (Session::has('otp_phone') && $remaining <= 1 ) {
        Session::forget(['otp_code', 'otp_phone', 'otp_expired_at']);
            return redirect('auth?time='.time());
    }

    if ($request->isMethod('post')) {
        if ($request->request_otp) {
            $request->validate([
                'phone' => 'required|digits_between:9,13'
            ]);

            $otp = random_int(100000, 999999);

            Session::put('otp_code', $otp);
            Session::put('otp_phone', '62' . $request->phone);
            Session::put('otp_expired_at', now()->addSeconds(90));

                defer(fn() =>
                    $this->sendWhatasapp(
                        '62' . $request->phone,
                        "KODE OTP ANDA $otp\n\nJangan membagikan kode ini."
                    ));
        }
        if($otp = $request->otp){
                return $this->verifyOtp($otp);
        }

        return redirect('auth?time='.time());
    }
    return view(get_view('page.masuk-mitra'), [
        'remainingValidOtp' => max(0, $remaining),
        'hasOtp' => Session::has('otp_phone'),
    ]);
}

    function remainingOtpValid() {
        $expiredAt = Session::get('otp_expired_at');
        if (!$expiredAt) {
            $remainingSeconds = 0;
        } else {
            $remainingSeconds = round(max(0, Carbon::now()->diffInSeconds($expiredAt, false)));
        }
        return $remainingSeconds;
    }
    public function verifyOtp($otp) {

        // Cek apakah OTP ada
        if (!Session::has('otp_code')) {
            return back()->withErrors(['otp' => 'OTP tidak ditemukan atau sudah kadaluarsa']);
        }

        // Cek expired
        if (now()->greaterThan(Session::get('otp_expired_at'))) {
            Session::forget(['otp_code', 'otp_phone', 'otp_expired_at']);
            return back()->withErrors(['otp' => 'OTP sudah kadaluarsa']);
        }

        // Cek kode
        if ($otp != Session::get('otp_code')) {
            return back()->withErrors(['otp' => 'OTP salah']);
        }   

        // ✅ OTP VALID → LOGIN
        $phone = Session::get('otp_phone');

        // $user = User::firstOrCreate(['phone' => $phone]);
       $data = query()->createOrFirst([
'title'=>$phone,
'type'=>'lamaran'
        ]);
        // Hapus OTP session
        Session::put('applier_id', $data->id);
        Session::forget(['otp_code', 'otp_phone', 'otp_expired_at']);

        return redirect('auth/profile');
    }
    public function profile(Request $request) {
        $this->loggedOnly();
        $data = query()->find(Session::get('applier_id'));
        page_name(name: "Lengkapi Data Profile");

        return view(get_view('page.profile'),['data'=>$data]);

    }

    public function dashboard(Request $request) {

    }
    private function isLogin() {
        if (Session::has('applier_id')) {
            return true;
        }
        return false;
    }
    private function loggedOnly() {
        if (!$this->isLogin()) {
            return redirect('auth')->send()->with('login', 'Login terlebih dahulu');
        }
    }
    public  function sendWhatasapp($phone, $message) {

       Http::post(config('wabot.wa_host') . '/message/send-text', [
            'session' => config('wabot.wa_session'),
            'to' => $phone,
            'text' => str_replace('\n', "\r", $message),
            'is_group' => false,
        ]);
    }
}


