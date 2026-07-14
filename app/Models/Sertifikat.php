<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservasi_id',
        'nomor_sertifikat',
        'serial_number',
        'nama_pemilik',
        'nama_jenazah',
        'lokasi_lahan',
        'tanggal_terbit',
        'file_sertifikat',
        'ttd_pemilik',
        'ttd_manajer',
        'status_sertifikat',
    ];

    /**
     * Relasi: Sertifikat dimiliki oleh satu Reservasi
     */
    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class);
    }

    /**
     * Auto-create missing Sertifikat records for Selesai reservations
     */
    public static function syncReservasis()
    {
        $selesaiReservasis = Reservasi::where('status_reservasi', 'Selesai')
            ->whereDoesntHave('sertifikat')
            ->get();
            
        if ($selesaiReservasis->isEmpty()) {
            return;
        }

        $year = now()->year;
        $latestSertifikat = self::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        $nextNum = 1;
        if ($latestSertifikat) {
            $parts = explode('-', $latestSertifikat->nomor_sertifikat);
            if (count($parts) === 3) {
                $nextNum = ((int)$parts[2]) + 1;
            }
        }
            
        foreach ($selesaiReservasis as $res) {
            $nomorSertifikat = 'MCM-' . $year . '-' . str_pad($nextNum, 6, '0', STR_PAD_LEFT);
            $nextNum++; // Increment local counter for the next iteration

            $serialNumber = 'SN-' . strtoupper(substr(md5(uniqid()), 0, 10));
            
            $lahan = $res->lahan;
            $lokasiLahan = '—';
            if ($lahan) {
                $clusterName = $lahan->cluster ? $lahan->cluster->nama_cluster : '—';
                $lokasiLahan = $clusterName . ', ' . $lahan->nomor_lahan;
            }
            
            $namaPemilik = $res->user ? $res->user->name : '—';
            $namaJenazah = $res->nama_jenazah ?: null;
            
            if ($res->file_sertifikat) {
                $statusSertifikat = 'Terbit';
            } else {
                $buyerSignature = $res->user ? $res->user->tanda_tangan : null;
                $statusSertifikat = $buyerSignature ? 'Menunggu TTD Manajer' : 'Menunggu TTD Pemilik';
            }
            
            self::create([
                'reservasi_id' => $res->id,
                'nomor_sertifikat' => $nomorSertifikat,
                'serial_number' => $serialNumber,
                'nama_pemilik' => $namaPemilik,
                'nama_jenazah' => $namaJenazah,
                'lokasi_lahan' => $lokasiLahan,
                'tanggal_terbit' => now()->toDateString(),
                'file_sertifikat' => $res->file_sertifikat,
                'ttd_pemilik' => $res->user ? $res->user->tanda_tangan : null,
                'status_sertifikat' => $statusSertifikat,
            ]);
        }
    }
}
