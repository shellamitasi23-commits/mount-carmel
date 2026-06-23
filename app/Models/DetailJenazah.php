<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailJenazah extends Model
{
    use HasFactory;

    protected $table = 'detail_jenazahs';

    protected $fillable = [
        'reservasi_id',
        'nomor_slot',
        'nama_jenazah',
        'tanggal_dimakamkan',
        'status',
    ];

    /**
     * Relasi: DetailJenazah dimiliki oleh satu Reservasi
     */
    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'reservasi_id');
    }
}
