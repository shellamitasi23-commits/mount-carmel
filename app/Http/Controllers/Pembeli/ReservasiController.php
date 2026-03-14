<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Kavling; // Pastikan model Kavling di-import agar bisa ditarik datanya

class ReservasiController extends Controller
{
    /**
     * 1. Menampilkan halaman form reservasi
     */
    public function index(Request $request)
    {
        // Ambil data kavling yang statusnya 'Tersedia' untuk dimunculkan di form (dropdown)
        $kavlings = Kavling::where('status', 'Tersedia')->get();

        // Jika pembeli datang dari klik tombol "Pesan" di halaman Kavling tertentu
        $kavling_terpilih = $request->kavling_id;

        // Tampilkan halaman view reservasi
        return view('pembeli.reservasi.index', compact('kavlings', 'kavling_terpilih'));
    }

    /**
     * 2. Proses menyimpan data saat form disubmit
     */
    public function store(Request $request)
    {
        // Validasi inputan form
        $request->validate([
            'kavling_id' => 'required',
            'nama_jenazah' => 'required|string',
            'dokumen_ktp' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        // Proses upload file KTP/Dokumen
        $path = $request->file('dokumen_ktp')->store('dokumen_reservasi', 'public');

        // Simpan ke database
        Reservasi::create([
            'user_id' => auth()->id(),
            'kavling_id' => $request->kavling_id,
            'nama_jenazah' => $request->nama_jenazah,
            'file_dokumen' => $path,
            'status_reservasi' => 'Menunggu Verifikasi'
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('pembeli.reservasi.index')->with('success', 'Reservasi berhasil dikirim dan sedang menunggu verifikasi!');
    }
}