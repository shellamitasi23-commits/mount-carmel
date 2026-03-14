<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservasis', function (Blueprint $table) {
            // Menambah kolom status pembayaran (defaultnya 'Belum Bayar')
            $table->string('status_pembayaran')->default('Belum Bayar')->after('user_id');

            // Menambah kolom untuk menyimpan nama file sertifikat (boleh kosong/nullable)
            $table->string('file_sertifikat')->nullable()->after('status_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->dropColumn(['status_pembayaran', 'file_sertifikat']);
        });
    }
};