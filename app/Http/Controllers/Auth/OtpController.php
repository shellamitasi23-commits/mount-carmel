<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\SendOtpMail;

class OtpController extends Controller
{
    /**
     * Tampilkan halaman verifikasi OTP.
     */
    public function showVerifyForm()
    {
        $user = Auth::user();
        if ($user && !is_null($user->email_verified_at)) {
            return redirect()->route('home');
        }
        return view('auth.otp-verify');
    }

    /**
     * Verifikasi kode OTP yang dimasukkan user.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Cek kecocokan OTP dan batas waktu berlaku (atau kode dummy 123456 di lingkungan lokal)
        $isDummyOtp = config('app.env') === 'local' && $request->otp === '123456';
        if ($isDummyOtp || ($user->otp_code === $request->otp && $user->otp_expires_at && $user->otp_expires_at->isFuture())) {
            $user->update([
                'email_verified_at' => now(),
                'otp_code' => null,
                'otp_expires_at' => null,
            ]);

            // Bersihkan session preview di lingkungan lokal
            session()->forget('otp_code');

            return redirect()->route('home')->with('success', 'Akun Anda berhasil diverifikasi! Selamat menjelajah.');
        }

        return back()->withErrors([
            'otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.',
        ]);
    }

    /**
     * Kirim ulang kode OTP.
     */
    public function resend(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Batasi pengiriman ulang (rate limiting sederhana: minimal jeda 1 menit)
        if ($user->otp_expires_at && now()->diffInSeconds($user->otp_expires_at->subMinutes(10)) < 60) {
            return back()->with('error', 'Silakan tunggu 1 menit sebelum meminta kode OTP kembali.');
        }

        $otp_code = config('app.env') === 'local' ? '123456' : (string) rand(100000, 999999);

        $user->update([
            'otp_code' => $otp_code,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        try {
            Mail::to($user->email)->send(new SendOtpMail($otp_code));
        } catch (\Exception $e) {
            Log::error('Gagal mengirim ulang email OTP: ' . $e->getMessage());
        }

        if (config('app.env') === 'local') {
            session(['otp_code' => $otp_code]);
        }

        return back()->with('success', 'Kode OTP baru telah dikirimkan ke email Anda.');
    }
}
