<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kavling extends Model
{
    use HasFactory;

    protected $fillable = [
        'cluster_id',
        'nomor_kavling',
        'tipe_kavling',
        'ukuran',
        'kapasitas',
        'harga',
        'status',
    ];

    /**
     * Relasi: Kavling dimiliki oleh satu Cluster
     */
    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }

    /**
     * Relasi: Kavling memiliki banyak Reservasi
     */
    public function reservasis()
    {
        return $this->hasMany(Reservasi::class);
    }
}