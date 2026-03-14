<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Storage};

class ProfilController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Mengambil data user yang sedang login

        // Data tambahan untuk tab lain
        $riwayat = $user->reservasis()->with('kavling')->latest()->get();
        $sertifikats = $user->reservasis()->whereNotNull('file_sertifikat')->get();

        return view('pembeli.profil.index', compact('user', 'riwayat', 'sertifikats'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'no_telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);
        Auth::user()->update($request->all());
        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);
        Auth::user()->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password berhasil diganti!');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate(['avatar' => 'required|image|max:2048']);
        if (Auth::user()->avatar) {
            Storage::delete('public/avatars/' . Auth::user()->avatar);
        }
        $fileName = time() . '.' . $request->avatar->extension();
        $request->avatar->storeAs('public/avatars', $fileName);
        Auth::user()->update(['avatar' => $fileName]);
        return back()->with('success', 'Foto profil diperbarui!');
    }
}