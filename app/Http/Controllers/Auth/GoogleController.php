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
                if(!$finduser->google_id) {
                    $finduser->update(['google_id' => $user->id]);
                }
                
                Auth::login($finduser);
                return redirect()->intended('/');
            }else{
                // Jika user belum ada, buat user baru
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'role' => 'pembeli',
                    'password' => null // Password dikosongkan karena login via google
                ]);
      
                Auth::login($newUser);
                return redirect()->intended('/');
            }
      
        } catch (Exception $e) {
            return redirect('login')->withErrors(['email' => 'Gagal masuk menggunakan Google. Silakan coba lagi.']);
        }
    }
}
