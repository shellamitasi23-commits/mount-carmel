<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $fillable = [
        'user_id',
        'kavling_id',
        'nama_jenazah',
        'tanggal_reservasi',
        'dokumen_ktp',
        'dokumen_kk',
        'status_reservasi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kavling()
    {
        return $this->belongsTo(Kavling::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }
}
