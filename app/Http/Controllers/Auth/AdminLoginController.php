<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    // Menampilkan view marketing-login.blade.php secara dinamis sesuai role
    public function showLoginForm(Request $request)
    {
        $role = 'Manajemen';
        $postUrl = route('marketing.login.submit');
        
        if ($request->is('marketing*')) {
            $role = 'Marketing';
            $postUrl = route('marketing.login.submit');
        } elseif ($request->is('accounting*')) {
            $role = 'Accounting';
            $postUrl = route('accounting.login.submit');
        } elseif ($request->is('koordinator-lapangan*')) {
            $role = 'Koordinator Lapangan';
            $postUrl = route('koordinator_lapangan.login.submit');
        } elseif ($request->is('manajer*')) {
            $role = 'Manajer';
            $postUrl = route('manajer.login.submit');
        }

        return view('auth.marketing-login', compact('role', 'postUrl'));
    }

    // Memproses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $expectedRole = null;
        $roleLabel = 'Staf/Administrator';
        if ($request->is('marketing*')) {
            $expectedRole = 'marketing';
            $roleLabel = 'Marketing';
        } elseif ($request->is('accounting*')) {
            $expectedRole = 'accounting';
            $roleLabel = 'Accounting';
        } elseif ($request->is('koordinator-lapangan*')) {
            $expectedRole = 'koordinator_lapangan';
            $roleLabel = 'Koordinator Lapangan';
        } elseif ($request->is('manajer*')) {
            $expectedRole = 'manajer';
            $roleLabel = 'Manajer';
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($expectedRole && $user->role !== $expectedRole) {
                Auth::logout();
                return back()->withErrors([
                    'email' => "Akses ditolak! Akun ini bukan staf {$roleLabel}.",
                ]);
            }

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
        $role = Auth::user() ? Auth::user()->role : null;

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Jika pembeli, kembalikan ke landing page utama
        if ($role === 'pembeli') {
            return redirect('/');
        }

        // Kembalikan ke halaman login portal masing-masing role
        if ($role === 'marketing') {
            return redirect('/marketing/login');
        } elseif ($role === 'accounting') {
            return redirect('/accounting/login');
        } elseif ($role === 'koordinator_lapangan') {
            return redirect('/koordinator-lapangan/login');
        } elseif ($role === 'manajer') {
            return redirect('/manajer/login');
        }

        // Kembalikan ke halaman login portal default
        return redirect('/marketing/login');
    }
}