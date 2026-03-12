<?php

namespace App\Http\Controllers\Auth; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Auth; 
class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi Input sesuai kebutuhan proposal (nama, email, password, telp, alamat)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        // 2. Simpan Data ke Database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'role' => 'pembeli', 
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        // 3. Otomatis Login setelah berhasil mendaftar (opsional, tapi disarankan)
        Auth::login($user);

        // 4. Redirect ke dashboard pembeli
        return redirect()->route('pembeli.dashboard')->with('success', 'Pendaftaran berhasil!');
    }
}