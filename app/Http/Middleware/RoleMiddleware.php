<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // Cek apakah role user di database sesuai dengan role di Route
        if (Auth::user()->role !== $role) {
            // Jika salah masuk kamar, tendang ke dashboard masing-masing
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role === 'pimpinan') {
                return redirect()->route('pimpinan.dashboard');
            } else {
                return redirect()->route('pembeli.dashboard');
            }
        }

        return $next($request);
    }
}