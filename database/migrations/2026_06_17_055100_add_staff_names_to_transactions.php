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
        Schema::table('reservasis', function (Blueprint $table) {
            $table->string('disetujui_oleh')->nullable();
        });

        Schema::table('pembayarans', function (Blueprint $table) {
            $table->string('dikonfirmasi_oleh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->dropColumn('disetujui_oleh');
        });

        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn('dikonfirmasi_oleh');
        });
    }
};
