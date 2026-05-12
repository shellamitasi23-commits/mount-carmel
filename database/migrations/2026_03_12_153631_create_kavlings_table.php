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
        Schema::create('kavlings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cluster_id')->constrained('clusters')->onDelete('cascade');
            $table->string('nomor_kavling')->unique();
            $table->string('tipe_kavling'); 
            $table->string('ukuran'); 
            $table->integer('kapasitas'); 
            $table->decimal('harga', 15, 2); 
            $table->enum('status', ['Tersedia', 'Dipesan', 'Terjual'])->default('Tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kavlings');
    }
};
