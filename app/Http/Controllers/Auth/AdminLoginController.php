<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Menampilkan form login admin
     */
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    /**
     * Memproses data login admin
     */
    public function login(Request $request)
    {
        // 1. Validasi inputan
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Proses Autentikasi (Cek email & password)
        // Catatan: Saat ini kita menggunakan default Auth. 
        // Nanti jika ingin dipisah total, kita bisa ubah menjadi Auth::guard('admin')->attempt(...)
        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            // Jika berhasil, perbarui sesi untuk keamanan
            $request->session()->regenerate();

            // Arahkan ke dashboard admin
            return redirect()->intended('/admin');
        }

        // 3. Jika gagal login, kembalikan ke halaman login beserta error
        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email'); // Tetap pertahankan isian email agar tidak perlu mengetik ulang
    }

    /**
     * Memproses logout admin
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Hapus sesi pengguna dan buat ulang token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan kembali ke halaman login admin
        return redirect('/admin/login');
    }
}