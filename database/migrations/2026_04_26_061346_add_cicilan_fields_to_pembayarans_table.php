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
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->integer('cicilan_ke')->nullable()->after('status_pembayaran');
            $table->integer('total_cicilan')->nullable()->after('cicilan_ke');
            $table->date('jatuh_tempo')->nullable()->after('total_cicilan');
            $table->string('dibayar_oleh')->nullable()->after('jatuh_tempo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn(['cicilan_ke', 'total_cicilan', 'jatuh_tempo', 'dibayar_oleh']);
        });
    }
};
