<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kavling extends Model
{
    use HasFactory;

    // Tambahkan semua nama kolom ke sini agar diizinkan oleh Laravel
    protected $fillable = [
        'cluster_id',
        'nomor_kavling',
        'tipe_kavling',
        'ukuran',
        'kapasitas',
        'harga',
        'status'
    ];

    // Relasi ke tabel clusters
    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }
}