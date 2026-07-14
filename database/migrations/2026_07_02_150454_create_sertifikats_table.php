<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sertifikats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservasi_id')->constrained('reservasis')->onDelete('cascade');
            $table->string('nomor_sertifikat')->unique();
            $table->string('serial_number')->unique();
            $table->string('nama_pemilik');
            $table->string('nama_jenazah')->nullable();
            $table->string('lokasi_lahan');
            $table->date('tanggal_terbit');
            $table->string('file_sertifikat')->nullable();
            $table->string('ttd_pemilik')->nullable();
            $table->string('ttd_manajer')->nullable();
            $table->enum('status_sertifikat', [
                'Draft',
                'Menunggu TTD Pemilik',
                'Menunggu TTD Manajer',
                'Terbit'
            ])->default('Draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikats');
    }
};
