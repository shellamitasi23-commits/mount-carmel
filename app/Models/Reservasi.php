<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::created(function ($reservasi) {
            if (!empty($reservasi->nama_jenazah)) {
                $status = in_array($reservasi->status_reservasi, ['Disetujui', 'Selesai']) ? 'Disetujui' : 'Menunggu Validasi';
                \App\Models\DetailJenazah::updateOrCreate(
                    [
                        'reservasi_id' => $reservasi->id,
                        'nomor_slot' => 1,
                    ],
                    [
                        'nama_jenazah' => $reservasi->nama_jenazah,
                        'tanggal_dimakamkan' => $reservasi->tanggal_dimakamkan,
                        'status' => $status,
                    ]
                );
            }
        });

        static::updated(function ($reservasi) {
            // Sync nama_jenazah and tanggal_dimakamkan to Slot 1 if they were changed and not null
            if ($reservasi->isDirty('nama_jenazah') || $reservasi->isDirty('tanggal_dimakamkan')) {
                if (!empty($reservasi->nama_jenazah)) {
                    $status = in_array($reservasi->status_reservasi, ['Disetujui', 'Selesai']) ? 'Disetujui' : 'Menunggu Validasi';
                    \App\Models\DetailJenazah::updateOrCreate(
                        [
                            'reservasi_id' => $reservasi->id,
                            'nomor_slot' => 1,
                        ],
                        [
                            'nama_jenazah' => $reservasi->nama_jenazah,
                            'tanggal_dimakamkan' => $reservasi->tanggal_dimakamkan,
                            'status' => $status,
                        ]
                    );
                }
            }

            // Sync status approval to Slot 1 when status_reservasi becomes Disetujui or Selesai
            if ($reservasi->isDirty('status_reservasi') && in_array($reservasi->status_reservasi, ['Disetujui', 'Selesai'])) {
                if (!empty($reservasi->nama_jenazah)) {
                    \App\Models\DetailJenazah::updateOrCreate(
                        [
                            'reservasi_id' => $reservasi->id,
                            'nomor_slot' => 1,
                        ],
                        [
                            'nama_jenazah' => $reservasi->nama_jenazah,
                            'tanggal_dimakamkan' => $reservasi->tanggal_dimakamkan,
                            'status' => 'Disetujui'
                        ]
                    );
                }
            }
        });
    }

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

    /**
     * Relasi: Reservasi memiliki banyak DetailJenazah (slot)
     */
    public function detailJenazahs()
    {
        return $this->hasMany(DetailJenazah::class, 'reservasi_id');
    }

    /**
     * Helper: Dapatkan list nama jenazah digabungkan dengan koma
     */
    public function getNamaSemuaJenazahAttribute()
    {
        if ($this->detailJenazahs->isEmpty()) {
            return $this->nama_jenazah ?: '—';
        }
        return $this->detailJenazahs->sortBy('nomor_slot')->pluck('nama_jenazah')->implode(', ');
    }
}