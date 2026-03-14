<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'reservasi_id',
        'no_invoice',
        'jumlah_bayar',
        'tanggal_bayar',
        'bukti_pembayaran',
        'status_pembayaran'
    ];

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class);
    }
}
