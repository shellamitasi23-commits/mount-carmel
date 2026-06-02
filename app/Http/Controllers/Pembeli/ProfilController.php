<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Storage};

use App\Models\Pembayaran;
use App\Models\Reservasi;

class ProfilController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Mengambil data user yang sedang login

        // Data tambahan untuk tab lain
        $riwayat = $user->reservasis()->with(['lahan', 'pembayaran'])->latest()->get();
        $sertifikats = $user->reservasis()->whereNotNull('file_sertifikat')->get();

        // Data Pembayaran Saya (dipindah dari PembayaranController)
        $userReservasiIds = $riwayat->pluck('id');

        $pembayarans = Pembayaran::with(['reservasi.lahan.cluster'])
            ->whereIn('reservasi_id', $userReservasiIds)
            ->latest()
            ->get();

        $sudahDibayarIds = $pembayarans->pluck('reservasi_id');
        $reservasiSiapBayar = Reservasi::with(['lahan.cluster'])
            ->where('user_id', $user->id)
            ->where('status_reservasi', 'Disetujui')
            ->whereNotIn('id', $sudahDibayarIds)
            ->get();

        return view('pembeli.profil.index', compact('user', 'riwayat', 'sertifikats', 'pembayarans', 'reservasiSiapBayar'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'no_telepon' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
        ]);

        $user = \App\Models\User::find(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_telepon = $request->no_telepon;
        $user->alamat = $request->alamat;
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'password' => 'required|min:8|confirmed',
        ];

        // Jika user memiliki password di database, current_password wajib diisi
        if ($user->password) {
            $rules['current_password'] = 'required';
        }

        $request->validate($rules);

        // 1. Cek apakah password lama benar (hanya jika ada password lama)
        if ($user->password) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok.']);
            }

            // 2. Cek apakah password baru sama dengan password lama
            if (Hash::check($request->password, $user->password)) {
                return back()->withErrors(['password' => 'Kata sandi baru tidak boleh sama dengan kata sandi saat ini.']);
            }
        }

        $user->update(['password' => Hash::make($request->password)]);
        
        return back()->with('success', 'Password berhasil diganti!');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate(['avatar' => 'required|image|max:2048']);
        
        $user = \App\Models\User::find(Auth::id());
        
        if ($user->avatar) {
            Storage::disk('public')->delete('avatars/' . $user->avatar);
        }
        
        $fileName = time() . '.' . $request->avatar->extension();
        $request->avatar->storeAs('avatars', $fileName, 'public');
        
        $user->avatar = $fileName;
        $user->save();
        
        return back()->with('success', 'Foto profil diperbarui!');
    }
}