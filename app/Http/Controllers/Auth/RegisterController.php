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
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                function ($attribute, $value, $fail) {
                    if (str_ends_with(strtolower($value), '@mountcarmel.id')) {
                        $fail('Pendaftaran dengan domain email @mountcarmel.id tidak diperbolehkan untuk pembeli.');
                    }
                },
            ],
            'password' => 'required|min:6|confirmed',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        // 2. Generate OTP (default ke 123456 di lokal agar mudah diuji)
        $otp_code = config('app.env') === 'local' ? '123456' : (string) rand(100000, 999999);

        // 3. Simpan Data ke Database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'role' => 'pembeli', 
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
            'otp_code' => $otp_code,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // 4. Kirim Email OTP
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\SendOtpMail($otp_code));
        } catch (\Exception $e) {
            // Log error tapi lanjutkan registrasi agar tidak crash di lokal jika mailer belum terkonfigurasi
            \Illuminate\Support\Facades\Log::error('Gagal mengirim email OTP: ' . $e->getMessage());
        }

        // Simpan di session untuk preview di lingkungan lokal
        if (config('app.env') === 'local') {
            session(['otp_code' => $otp_code]);
        }

        // 5. Otomatis Login setelah berhasil mendaftar (opsional, tapi disarankan)
        Auth::login($user);

        // 6. Redirect ke halaman verifikasi OTP
        return redirect()->route('otp.verify')->with('success', 'Registrasi berhasil! Silakan masukkan kode OTP yang telah dikirim ke email Anda.');
    }
}