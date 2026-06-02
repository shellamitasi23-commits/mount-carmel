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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservasi_id')->constrained('reservasis')->onDelete('cascade');
            $table->string('no_invoice')->unique();
            $table->string('nama_bank')->nullable();
            $table->string('rekening_tujuan')->nullable();
            $table->string('atas_nama_rekening')->nullable();
            $table->decimal('jumlah_bayar', 15, 2);
            $table->date('tanggal_bayar');
            $table->string('bukti_pembayaran'); // Berdasarkan use case "Upload Bukti Pembayaran"
            $table->text('catatan')->nullable();
            $table->enum('status_pembayaran', ['Menunggu Konfirmasi', 'Lunas', 'Ditolak'])->default('Menunggu Konfirmasi');
            $table->integer('cicilan_ke')->nullable();
            $table->integer('total_cicilan')->nullable();
            $table->date('jatuh_tempo')->nullable();
            $table->string('dibayar_oleh')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
