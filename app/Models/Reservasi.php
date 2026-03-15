<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kavling_id',
        'nama_jenazah',
        'tanggal_reservasi',
        'dokumen_ktp',
        'dokumen_kk',
        'status_reservasi',
        'status_pembayaran',
        'file_sertifikat',
    ];

    /**
     * Relasi: Reservasi dimiliki oleh satu User (Pembeli)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Reservasi terhubung ke satu Kavling
     */
    public function kavling()
    {
        return $this->belongsTo(Kavling::class);
    }

    /**
     * Relasi: Reservasi memiliki satu Pembayaran
     */
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }
}