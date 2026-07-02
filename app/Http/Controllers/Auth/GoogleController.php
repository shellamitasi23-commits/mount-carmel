<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            
            $finduser = User::where('google_id', $user->id)
                            ->orWhere('email', $user->email)
                            ->first();
       
            if($finduser){
                // Jika user sudah ada, update google_id jika belum ada
                $updateData = [];
                if(!$finduser->google_id) {
                    $updateData['google_id'] = $user->id;
                }
                if(is_null($finduser->email_verified_at)) {
                    $updateData['email_verified_at'] = now();
                }
                if(!empty($updateData)) {
                    $finduser->update($updateData);
                }
                
                Auth::login($finduser);
                return redirect()->intended('/');
            }else{
                // Jika domain email @mountcarmel.id, tolak pendaftaran sebagai pembeli
                if (str_ends_with(strtolower($user->email), '@mountcarmel.id')) {
                    return redirect('login')->withErrors(['email' => 'Pendaftaran dengan domain email @mountcarmel.id tidak diperbolehkan untuk pembeli.']);
                }

                // Jika user belum ada, buat user baru
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'role' => 'pembeli',
                    'password' => null, // Password dikosongkan karena login via google
                    'email_verified_at' => now(),
                ]);
      
                Auth::login($newUser);
                return redirect()->intended('/');
            }
      
        } catch (Exception $e) {
            return redirect('login')->withErrors(['email' => 'Gagal masuk menggunakan Google. Silakan coba lagi.']);
        }
    }
}
