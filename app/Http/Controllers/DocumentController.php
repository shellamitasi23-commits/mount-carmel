<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use App\Models\Sertifikat;
use App\Models\User;

class DocumentController extends Controller
{
    /**
     * Uji hak akses pengguna apakah merupakan admin (marketing, manajer, accounting).
     */
    private function isAdmin()
    {
        $user = auth()->user();
        return $user && in_array($user->role, ['marketing', 'manajer', 'accounting']);
    }

    /**
     * Download / View KTP.
     */
    public function viewKtp($reservasiId)
    {
        $reservasi = Reservasi::findOrFail($reservasiId);

        // Hanya pemilik reservasi atau admin yang boleh melihat KTP
        if (auth()->id() !== $reservasi->user_id && !$this->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        $path = $reservasi->dokumen_ktp;

        if (!Storage::disk('local')->exists($path)) {
            abort(404, 'File KTP tidak ditemukan.');
        }

        return response()->file(storage_path('app/' . $path));
    }

    /**
     * Download / View Bukti Pembayaran.
     */
    public function viewBuktiBayar($pembayaranId)
    {
        $pembayaran = Pembayaran::with('reservasi')->findOrFail($pembayaranId);

        // Hanya pemilik pembayaran atau admin yang boleh melihat bukti pembayaran
        if (auth()->id() !== $pembayaran->reservasi->user_id && !$this->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        $path = $pembayaran->bukti_pembayaran;

        if (!Storage::disk('local')->exists($path)) {
            abort(404, 'File bukti pembayaran tidak ditemukan.');
        }

        return response()->file(storage_path('app/' . $path));
    }

    /**
     * Download / View Sertifikat.
     */
    public function viewSertifikat(Request $request, $reservasiId)
    {
        $reservasi = Reservasi::findOrFail($reservasiId);

        // Hanya pemilik sertifikat atau admin yang boleh melihat sertifikat
        if (auth()->id() !== $reservasi->user_id && !$this->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        $path = 'sertifikat/' . $reservasi->file_sertifikat;

        if (!Storage::disk('local')->exists($path)) {
            abort(404, 'File sertifikat tidak ditemukan.');
        }

        if ($request->has('download')) {
            return response()->download(storage_path('app/' . $path), $reservasi->file_sertifikat);
        }

        return response()->file(storage_path('app/' . $path));
    }

    /**
     * Download / View Signature.
     */
    public function viewSignature($userId)
    {
        $targetUser = User::findOrFail($userId);

        // Hanya user itu sendiri atau admin yang boleh melihat tanda tangannya
        if (auth()->id() !== $targetUser->id && !$this->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        $path = $targetUser->tanda_tangan;

        if (!$path || !Storage::disk('local')->exists($path)) {
            abort(404, 'Tanda tangan tidak ditemukan.');
        }

        return response()->file(storage_path('app/' . $path));
    }
}
