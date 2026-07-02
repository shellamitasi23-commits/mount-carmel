<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOtpVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Hanya berlaku untuk pembeli yang emailnya belum terverifikasi
            if ($user->role === 'pembeli' && is_null($user->email_verified_at)) {
                // Kecuali untuk rute verifikasi OTP dan logout
                if (!$request->routeIs('otp.*') && !$request->routeIs('logout')) {
                    return redirect()->route('otp.verify');
                }
            }
        }

        return $next($request);
    }
}
