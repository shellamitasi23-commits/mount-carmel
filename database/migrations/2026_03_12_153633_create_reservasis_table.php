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
            $table->foreignId('kavling_id')->constrained('kavlings')->onDelete('cascade');
            $table->string('nama_jenazah')->nullable(); // Karena ini pemakaman
            $table->date('tanggal_reservasi');
            $table->string('dokumen_ktp')->nullable(); // Berdasarkan use case "Upload Dokumen"
            $table->string('dokumen_kk')->nullable();
            $table->enum('status_reservasi', ['Menunggu Validasi', 'Disetujui', 'Ditolak', 'Selesai'])->default('Menunggu Validasi');
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
