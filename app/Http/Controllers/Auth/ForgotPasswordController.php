<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Menampilkan halaman form lupa password.
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Memvalidasi email dan mengirimkan link reset password.
     */
    public function sendResetLinkEmail(Request $request)
    {
        // 1. Validasi input: Pastikan email diisi, formatnya benar, dan ada di database
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Alamat email ini belum terdaftar di sistem kami.',
        ]);

        // 2. Proses pengiriman link reset password bawaan Laravel
        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        // 3. Berikan response kembali ke halaman (Berhasil / Gagal)
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Tautan reset kata sandi telah dikirim ke email Anda!');
        }

        return back()->withErrors(['email' => 'Gagal mengirim email reset. Silakan coba lagi.']);
    }
}