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
        Schema::table('lahans', function (Blueprint $table) {
            $table->enum('status', ['Tersedia', 'Reservasi (Lunas)', 'Reservasi Cicilan dengan DP', 'Terjual', 'Digunakan'])->default('Tersedia')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lahans', function (Blueprint $table) {
            $table->enum('status', ['Tersedia', 'Reservasi (Lunas)', 'Reservasi Cicilan dengan DP', 'Terjual', 'Digunakan'])->default('Tersedia')->change();
        });
    }
};
