<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class EnsureApplierExists
{
    public function handle($request, Closure $next)
    {
        $id = Session::get('applier_id');

        if (!$id) {
            return redirect('auth')->with('login', 'Login terlebih dahulu');
        }

        $data = query()->whereType('lamaran')->find($id);

        if (!$data) {
            Session::flush();
            return redirect('auth')
                ->with('login', 'Session berakhir, silakan login ulang');
        }
        View::share('data', $data);

        return $next($request);
    }
}
