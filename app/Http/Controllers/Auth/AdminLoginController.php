<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    // Menampilkan view marketing-login.blade.php
    public function showLoginForm()
    {
        return view('auth.marketing-login');
    }

    // Memproses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // CEK ROLE SETELAH BERHASIL LOGIN
            if ($user->role === 'marketing') {
                return redirect()->route('marketing.dashboard');
            } elseif ($user->role === 'manajer') {
                return redirect()->route('manajer.dashboard');
            } elseif ($user->role === 'accounting') {
                return redirect()->route('accounting.dashboard');
            } elseif ($user->role === 'koordinator_lapangan') {
                return redirect()->route('koordinator_lapangan.dashboard');
            } else {
                // Jika pembeli biasa nyasar login di portal admin, tendang keluar
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akses ditolak! Akun ini bukan staf/administrator.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Memproses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Kembalikan ke halaman login portal
        return redirect('/marketing/login');
    }
}