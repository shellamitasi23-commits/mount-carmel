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
        Schema::create('detail_jenazahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservasi_id')->constrained('reservasis')->onDelete('cascade');
            $table->integer('nomor_slot');
            $table->string('nama_jenazah');
            $table->date('tanggal_dimakamkan')->nullable();
            $table->string('status')->default('Menunggu Validasi');
            $table->timestamps();
        });

        // Copy existing data from reservasis to detail_jenazahs (Slot 1)
        $existing = \Illuminate\Support\Facades\DB::table('reservasis')
            ->whereNotNull('nama_jenazah')
            ->where('nama_jenazah', '<>', '')
            ->get();

        foreach ($existing as $row) {
            \Illuminate\Support\Facades\DB::table('detail_jenazahs')->insert([
                'reservasi_id' => $row->id,
                'nomor_slot' => 1,
                'nama_jenazah' => $row->nama_jenazah,
                'tanggal_dimakamkan' => $row->tanggal_dimakamkan,
                'status' => 'Disetujui', // Old records are automatically approved
                'created_at' => $row->created_at ?? now(),
                'updated_at' => $row->updated_at ?? now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_jenazahs');
    }
};
