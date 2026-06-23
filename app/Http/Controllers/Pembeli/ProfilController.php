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
        $riwayat = $user->reservasis()->with(['lahan', 'pembayaran', 'detailJenazahs'])->latest()->get();
        $sertifikats = $user->reservasis()->whereNotNull('file_sertifikat')->get();

        // Data Pembayaran Saya (dipindah dari PembayaranController)
        $userReservasiIds = $riwayat->pluck('id');

        $pembayarans = Pembayaran::with(['reservasi.lahan.cluster'])
            ->whereIn('reservasi_id', $userReservasiIds)
            ->latest()
            ->get();

        // Ambil semua reservasi yang disetujui ATAU menunggu validasi untuk di-filter siap bayar
        $allReservasis = Reservasi::with(['lahan.cluster', 'pembayarans'])
            ->where('user_id', $user->id)
            ->whereIn('status_reservasi', ['Disetujui', 'Menunggu Validasi'])
            ->get();

        $reservasiSiapBayar = $allReservasis->filter(function ($res) {
            // Jika status reservasi masih Menunggu Validasi, hanya tampilkan jika pembayaran Belum Bayar
            if ($res->status_reservasi === 'Menunggu Validasi' && $res->status_pembayaran !== 'Belum Bayar') {
                return false;
            }

            // Cek jika ada pembayaran yang masih Menunggu Konfirmasi untuk reservasi ini
            $hasPending = $res->pembayarans->where('status_pembayaran', 'Menunggu Konfirmasi')->isNotEmpty();
            if ($hasPending) {
                return false; // tidak siap bayar karena ada yang pending
            }

            $isTunai = $res->jenis_pembayaran === 'tunai';
            $tenor = $res->tenor_cicilan ?? 1;

            if ($isTunai) {
                // Tunai siap bayar jika belum ada pembayaran Lunas
                $sudahLunas = $res->pembayarans->where('status_pembayaran', 'Lunas')->isNotEmpty();
                if (!$sudahLunas) {
                    $res->tipe_tagihan = 'Pembayaran Penuh';
                    $res->nominal_tagihan = $res->biaya_penuh;
                    return true;
                }
            } else {
                $menggunakanDP = $res->biaya_reservasi > 0;
                
                if ($menggunakanDP) {
                    // Cicilan siap bayar jika DP belum lunas
                    $dpLunas = $res->pembayarans->where('cicilan_ke', 0)->where('status_pembayaran', 'Lunas')->isNotEmpty();
                    if (!$dpLunas) {
                        $res->tipe_tagihan = 'Uang Muka / DP';
                        $res->nominal_tagihan = $res->biaya_reservasi;
                        return true;
                    } else {
                        // Cari cicilan tertinggi yang lunas
                        $highestLunas = $res->pembayarans->where('status_pembayaran', 'Lunas')
                            ->where('cicilan_ke', '>', 0)
                            ->max('cicilan_ke') ?? 0;

                        if ($highestLunas < $tenor) {
                            $nextCicilan = $highestLunas + 1;
                            $res->tipe_tagihan = "Cicilan Ke-{$nextCicilan} dari {$tenor}";
                            $res->nominal_tagihan = ($res->biaya_penuh - $res->biaya_reservasi) / $tenor;
                            return true;
                        }
                    }
                } else {
                    // Cicilan langsung (tanpa DP)
                    $highestLunas = $res->pembayarans->where('status_pembayaran', 'Lunas')
                        ->where('cicilan_ke', '>', 0)
                        ->max('cicilan_ke') ?? 0;

                    if ($highestLunas < $tenor) {
                        $nextCicilan = $highestLunas + 1;
                        $res->tipe_tagihan = "Cicilan Ke-{$nextCicilan} dari {$tenor}";
                        $res->nominal_tagihan = $res->biaya_penuh / $tenor;
                        return true;
                    }
                }
            }

            return false;
        });

        return view('pembeli.profil.index', compact('user', 'riwayat', 'sertifikats', 'pembayarans', 'reservasiSiapBayar'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:users,email,' . Auth::id(),
                function ($attribute, $value, $fail) {
                    if (str_ends_with(strtolower($value), '@mountcarmel.id')) {
                        $fail('Email dengan domain @mountcarmel.id tidak boleh digunakan untuk pembeli.');
                    }
                },
            ],
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