<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lahan extends Model
{
    use HasFactory, Searchable;

    protected $table = 'lahans';

    protected $fillable = [
        'cluster_id',
        'nomor_lahan',
        'tipe_lahan',
        'hadap',
        'ukuran',
        'kapasitas',
        'harga',
        'status',
    ];

    /**
     * Relasi: Lahan dimiliki oleh satu Cluster
     */
    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }

    /**
     * Relasi: Lahan memiliki banyak Reservasi
     */
    public function reservasis()
    {
        return $this->hasMany(Reservasi::class, 'lahan_id');
    }
}
