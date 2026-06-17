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
            $table->string('kategori_kebutuhan')->default('end_user')->after('lahan_id');
            $table->text('request_tambahan')->nullable()->after('kontak_kerabat');
            $table->decimal('biaya_tambahan', 15, 2)->default(0)->after('request_tambahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservasis', function (Blueprint $table) {
            $table->dropColumn(['kategori_kebutuhan', 'request_tambahan', 'biaya_tambahan']);
        });
    }
};
