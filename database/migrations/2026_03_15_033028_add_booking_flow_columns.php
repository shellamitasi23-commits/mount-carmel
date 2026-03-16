<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// CARA PAKAI:
// 1. Copy file ini ke folder: database/migrations/
// 2. Jalankan di terminal: php artisan migrate
// 3. Selesai — 2 kolom baru masuk ke reservasis,
//              4 kolom baru masuk ke pembayarans
//
// TIDAK AKAN menghapus data lama.
// TIDAK PERLU hapus tabel dulu.
// ============================================================

return new class extends Migration {
    /**
     * Dijalankan saat: php artisan migrate
     * Fungsi: TAMBAH kolom baru ke tabel yang sudah ada
     */
    public function up(): void
    {
        // ── TABEL RESERVASIS ──────────────────────────────────────────
        // Schema::table() = modifikasi tabel YANG SUDAH ADA
        // Berbeda dengan Schema::create() yang membuat tabel BARU
        Schema::table('reservasis', function (Blueprint $table) {

            // Kolom 1: alamat lengkap pemesan
            // nullable() = boleh NULL, supaya data lama tidak error
            // after('dokumen_kk') = ditempatkan setelah kolom dokumen_kk
            $table->text('alamat_pemesan')
                ->nullable()
                ->after('dokumen_kk');

            // Kolom 2: rencana tanggal dimakamkan
            // nullable() = boleh NULL
            $table->date('tanggal_dimakamkan')
                ->nullable()
                ->after('alamat_pemesan');
        });

        // ── TABEL PEMBAYARANS ─────────────────────────────────────────
        Schema::table('pembayarans', function (Blueprint $table) {

            // Kolom 3: nama bank tujuan (BCA / BNI / Mandiri)
            $table->string('nama_bank')
                ->nullable()
                ->after('no_invoice');

            // Kolom 4: nomor rekening tujuan transfer
            $table->string('rekening_tujuan')
                ->nullable()
                ->after('nama_bank');

            // Kolom 5: nama pemilik rekening tujuan
            $table->string('atas_nama_rekening')
                ->nullable()
                ->after('rekening_tujuan');

            // Kolom 6: catatan opsional dari pembeli
            $table->text('catatan')
                ->nullable()
                ->after('bukti_pembayaran');
        });
    }

    /**
     * Dijalankan saat: php artisan migrate:rollback
     * Fungsi: HAPUS kolom yang ditambahkan di up()
     *         Mengembalikan database ke kondisi sebelumnya
     */
    public function down(): void
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->dropColumn(['alamat_pemesan', 'tanggal_dimakamkan']);
        });

        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn(['nama_bank', 'rekening_tujuan', 'atas_nama_rekening', 'catatan']);
        });
    }
};