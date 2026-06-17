<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lahan_id',
        'nama_jenazah',
        'tanggal_reservasi',
        'dokumen_ktp',
        'dokumen_kk',
        'status_reservasi',
        'status_pembayaran',
        'file_sertifikat',
        'alamat_pemesan',
        'tanggal_dimakamkan',
        'kategori_kebutuhan',
        'jenis_pembayaran',
        'tenor_cicilan',
        'biaya_reservasi',
        'biaya_penuh',
        'pembayar_akhir',
        'catatan_kerabat',
        'kontak_kerabat',
        'request_tambahan',
        'biaya_tambahan',
        'disetujui_oleh',
        'marketing_oleh',
    ];

    /**
     * Relasi: Reservasi dimiliki oleh satu User (Pembeli)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Reservasi terhubung ke satu Lahan
     */
    public function lahan()
    {
        return $this->belongsTo(Lahan::class, 'lahan_id');
    }

    /**
     * Relasi: Reservasi memiliki satu Pembayaran
     */
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    /**
     * Relasi: Reservasi memiliki banyak Pembayaran
     */
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}