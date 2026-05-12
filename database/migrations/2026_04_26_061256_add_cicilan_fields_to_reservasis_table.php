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
            $table->enum('jenis_pembayaran', ['cicilan'])->default('cicilan')->after('status_reservasi');
            $table->integer('tenor_cicilan')->nullable()->after('jenis_pembayaran');
            $table->decimal('biaya_reservasi', 15, 2)->nullable()->after('tenor_cicilan');
            $table->decimal('biaya_penuh', 15, 2)->nullable()->after('biaya_reservasi');
            $table->string('pembayar_akhir')->nullable()->after('biaya_penuh');
            $table->text('catatan_kerabat')->nullable()->after('pembayar_akhir');
            $table->string('kontak_kerabat')->nullable()->after('catatan_kerabat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->dropColumn(['jenis_pembayaran', 'tenor_cicilan', 'biaya_reservasi', 'biaya_penuh', 'pembayar_akhir', 'catatan_kerabat', 'kontak_kerabat']);
        });
    }
};
