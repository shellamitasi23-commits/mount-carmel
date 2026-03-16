<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Pembayaran;

class SertifikatController extends Controller
{
    /**
     * Daftar reservasi yang sudah Lunas — siap diterbitkan sertifikat
     * URL: GET /admin/sertifikat
     */
    public function index()
    {
        // Ambil semua reservasi yang pembayarannya sudah Lunas
        $reservasis = Reservasi::with(['user', 'kavling.cluster', 'pembayaran'])
            ->whereHas('pembayaran', function ($q) {
                $q->where('status_pembayaran', 'Lunas');
            })
            ->latest()
            ->get();

        return view('admin.sertifikat.index', compact('reservasis'));
    }

    /**
     * Upload file sertifikat untuk reservasi tertentu
     * URL: POST /admin/sertifikat/{id}/upload
     */
    public function upload(Request $request, $id)
    {
        $request->validate([
            'file_sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'file_sertifikat.required' => 'File sertifikat wajib diunggah.',
            'file_sertifikat.mimes' => 'Format file harus PDF, JPG, atau PNG.',
            'file_sertifikat.max' => 'Ukuran file maksimal 5MB.',
        ]);

        $reservasi = Reservasi::with('pembayaran')->findOrFail($id);

        // Pastikan pembayaran sudah Lunas
        if (!$reservasi->pembayaran || $reservasi->pembayaran->status_pembayaran !== 'Lunas') {
            return back()->with('error', 'Sertifikat hanya bisa diterbitkan untuk reservasi yang sudah Lunas.');
        }

        // Hapus file lama kalau ada
        if ($reservasi->file_sertifikat) {
            \Storage::disk('public')->delete('sertifikat/' . $reservasi->file_sertifikat);
        }

        // Upload file baru
        $file = $request->file('file_sertifikat');
        $fileName = 'SRTF-' . strtoupper(substr(md5($id . time()), 0, 8)) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('sertifikat', $fileName, 'public');

        // Simpan nama file ke kolom file_sertifikat di tabel reservasis
        $reservasi->update(['file_sertifikat' => $fileName]);

        return back()->with('success', 'Sertifikat untuk kavling #' . $reservasi->kavling->nomor_kavling . ' berhasil diunggah!');
    }

    /**
     * Hapus sertifikat
     * URL: DELETE /admin/sertifikat/{id}
     */
    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        if ($reservasi->file_sertifikat) {
            \Storage::disk('public')->delete('sertifikat/' . $reservasi->file_sertifikat);
            $reservasi->update(['file_sertifikat' => null]);
        }

        return back()->with('success', 'Sertifikat berhasil dihapus.');
    }
}