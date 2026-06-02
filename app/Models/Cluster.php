<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_cluster',
        'kategori',
        'deskripsi',
    ];

    /**
     * Relasi: Cluster memiliki banyak Lahan
     */
    public function lahans()
    {
        return $this->hasMany(Lahan::class);
    }
}