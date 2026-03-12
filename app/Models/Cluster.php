<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika Laravel tidak bisa menebak otomatis (opsional)
    protected $table = 'clusters';

    // Kolom apa saja yang boleh diisi dari form
    protected $fillable = [
        'nama_cluster',
        'kategori',
        'deskripsi'
    ];
}