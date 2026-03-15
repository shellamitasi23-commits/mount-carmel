<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservasi_id',
        'no_invoice',
        'jumlah_bayar',
        'tanggal_bayar',
        'bukti_pembayaran',
        'status_pembayaran',
    ];

    /**
     * Relasi: Pembayaran dimiliki oleh satu Reservasi
     */
    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class);
    }

    /**
     * Akses user melalui relasi reservasi (shortcut)
     */
    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            Reservasi::class,
            'id',        // Foreign key di Reservasi
            'id',        // Foreign key di User
            'reservasi_id',
            'user_id'
        );
    }
}