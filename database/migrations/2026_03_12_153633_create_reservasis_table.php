<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke pembeli
            $table->foreignId('lahan_id')->constrained('lahans')->onDelete('cascade');
            $table->string('nama_jenazah')->nullable(); // Karena ini pemakaman
            $table->date('tanggal_reservasi');
            $table->text('alamat_pemesan')->nullable();
            $table->date('tanggal_dimakamkan')->nullable();
            $table->string('dokumen_ktp')->nullable(); // Berdasarkan use case "Upload Dokumen"
            $table->string('dokumen_kk')->nullable();
            $table->string('status_pembayaran')->default('Belum Bayar');
            $table->string('file_sertifikat')->nullable();
            $table->enum('status_reservasi', ['Menunggu Validasi', 'Disetujui', 'Ditolak', 'Selesai'])->default('Menunggu Validasi');
            $table->enum('jenis_pembayaran', ['tunai', 'cicilan'])->default('tunai');
            $table->integer('tenor_cicilan')->nullable();
            $table->decimal('biaya_reservasi', 15, 2)->nullable();
            $table->decimal('biaya_penuh', 15, 2)->nullable();
            $table->string('pembayar_akhir')->nullable();
            $table->text('catatan_kerabat')->nullable();
            $table->string('kontak_kerabat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
