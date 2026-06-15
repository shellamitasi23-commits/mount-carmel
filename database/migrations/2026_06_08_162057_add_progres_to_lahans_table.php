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
            $table->string('foto_progres')->nullable()->after('status');
            $table->text('catatan_progres')->nullable()->after('foto_progres');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lahans', function (Blueprint $table) {
            $table->dropColumn(['foto_progres', 'catatan_progres']);
        });
    }
};
