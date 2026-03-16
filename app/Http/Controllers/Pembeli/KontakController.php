<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        return view('pembeli.kontak');
    }

    public function send(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string|min:10',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'subjek.required' => 'Subjek wajib diisi.',
            'pesan.required' => 'Pesan wajib diisi.',
            'pesan.min' => 'Pesan minimal 10 karakter.',
        ]);

        // Di sini bisa tambahkan Mail::send() kalau sudah setup SMTP
        // Untuk sekarang redirect dengan pesan sukses

        return redirect()->route('kontak')->with(
            'success',
            'Pesan Anda berhasil dikirim! Tim kami akan menghubungi Anda dalam 1×24 jam kerja.'
        );
    }
}