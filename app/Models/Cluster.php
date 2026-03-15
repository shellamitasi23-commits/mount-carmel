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
     * Relasi: Cluster memiliki banyak Kavling
     */
    public function kavlings()
    {
        return $this->hasMany(Kavling::class);
    }
}