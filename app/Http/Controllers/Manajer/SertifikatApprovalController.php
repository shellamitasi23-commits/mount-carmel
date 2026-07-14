<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\{Auth, Storage};
use Barryvdh\DomPDF\Facade\Pdf;

class SertifikatApprovalController extends Controller
{
    public function index(Request $request)
    {
        Sertifikat::syncReservasis();
        $query = Sertifikat::with(['reservasi.user', 'reservasi.lahan.cluster']);

        if ($request->filled('status')) {
            $query->where('status_sertifikat', $request->status);
        } else {
            $query->whereIn('status_sertifikat', ['Menunggu TTD Manajer', 'Terbit']);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_sertifikat', 'like', "%{$search}%")
                    ->orWhere('nama_pemilik', 'like', "%{$search}%")
                    ->orWhereHas('reservasi.user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $sertifikats = $query->latest()->paginate(15);
        $user = Auth::user();

        return view('manajer.sertifikat.index', compact('sertifikats', 'user'));
    }

    public function sign(Request $request, $id)
    {
        $request->validate([
            'signature' => 'nullable|string',
            'use_default' => 'nullable|boolean',
            'save_as_default' => 'nullable|boolean',
        ]);

        $sertifikat = Sertifikat::findOrFail($id);
        $user = Auth::user();

        $signaturePath = null;

        if ($request->use_default) {
            if (!$user->tanda_tangan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum menyimpan tanda tangan default.',
                ], 422);
            }
            $signaturePath = $user->tanda_tangan;
        } else {
            if (!$request->filled('signature')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tanda tangan diperlukan.',
                ], 422);
            }

            $signatureData = $request->signature;
            $image = str_replace('data:image/png;base64,', '', $signatureData);
            $image = str_replace(' ', '+', $image);
            $imageName = 'sig_manajer_' . $id . '_' . time() . '.png';
            
            Storage::disk('local')->put('signatures/' . $imageName, base64_decode($image));
            $signaturePath = 'signatures/' . $imageName;

            if ($request->save_as_default) {
                if ($user->tanda_tangan) {
                    Storage::disk('local')->delete($user->tanda_tangan);
                }
                $user->tanda_tangan = $signaturePath;
                $user->save();
            }
        }

        $sertifikat->update([
            'ttd_manajer' => $signaturePath,
            'status_sertifikat' => 'Terbit',
        ]);

        // Generate PDF
        $pdf = Pdf::loadView('sertifikat.template', compact('sertifikat'))->setPaper('a4', 'landscape');
        $filename = 'sertifikat_' . $sertifikat->reservasi_id . '_' . time() . '.pdf';
        Storage::disk('local')->put('sertifikat/' . $filename, $pdf->output());

        // Update file path di kedua model
        $sertifikat->update([
            'file_sertifikat' => $filename,
        ]);
        
        $sertifikat->reservasi->update([
            'file_sertifikat' => $filename,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tanda tangan manajer berhasil dibubuhkan.',
        ]);
    }
}
