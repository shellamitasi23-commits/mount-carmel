<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /**
     * Menampilkan form pengaturan ulang kata sandi.
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Memproses pengaturan ulang kata sandi pengguna.
     */
    public function reset(Request $request)
    {
        // 1. Validasi input form
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'token.required' => 'Token pengaturan ulang kata sandi wajib disertakan.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal harus terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        // 2. Eksekusi reset password menggunakan broker bawaan Laravel
        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Simpan password baru yang sudah di-hash
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                // Picu event password reset
                event(new PasswordReset($user));
            }
        );

        // 3. Tangani hasil status
        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Kata sandi Anda berhasil diatur ulang. Silakan masuk menggunakan kata sandi baru.');
        }

        // Terjemahan pesan kesalahan agar ramah pengguna
        $errorMessage = match ($status) {
            Password::INVALID_TOKEN => 'Tautan atur ulang kata sandi ini tidak valid atau sudah kedaluwarsa.',
            Password::INVALID_USER => 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.',
            Password::INVALID_PASSWORD => 'Kata sandi baru harus minimal 8 karakter dan cocok dengan konfirmasi.',
            default => 'Gagal mengatur ulang kata sandi. Silakan coba lagi.',
        };

        return back()->withErrors(['email' => $errorMessage]);
    }
}
