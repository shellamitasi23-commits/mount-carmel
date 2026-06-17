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
        'nama_bank',
        'rekening_tujuan',
        'atas_nama_rekening',
        'catatan',
        'cicilan_ke',
        'total_cicilan',
        'jatuh_tempo',
        'dibayar_oleh',
        'dikonfirmasi_oleh',
    ];

    /**
     * Get human-readable status label for payments (especially DP/Installments)
     */
    public function getStatusLabelAttribute()
    {
        if ($this->status_pembayaran === 'Lunas') {
            if ($this->reservasi && $this->reservasi->jenis_pembayaran === 'cicilan') {
                if ($this->cicilan_ke === 0) {
                    return 'DP Terbayar';
                } elseif ($this->cicilan_ke < $this->total_cicilan) {
                    return "Cicilan Ke-{$this->cicilan_ke} Terbayar";
                }
            }
        }
        return $this->status_pembayaran;
    }
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