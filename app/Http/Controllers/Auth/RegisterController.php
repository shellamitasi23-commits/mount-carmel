<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);
        return redirect('/');
    }
}
