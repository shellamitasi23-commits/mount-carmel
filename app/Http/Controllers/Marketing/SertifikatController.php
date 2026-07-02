<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use Illuminate\Support\Facades\Storage;

class SertifikatController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservasi::with(['user', 'lahan.cluster'])
            ->where('status_reservasi', 'Selesai');

        // Filter status sertifikat
        if ($request->filled('status')) {
            if ($request->status === 'terbit') {
                $query->whereNotNull('file_sertifikat');
            } elseif ($request->status === 'belum_terbit') {
                $query->whereNull('file_sertifikat');
            }
        }

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('lahan', function ($lq) use ($search) {
                    $lq->where('nomor_lahan', 'like', "%{$search}%");
                });
            });
        }

        $reservasis = $query->latest()->paginate(25);

        $countSudah = Reservasi::where('status_reservasi', 'Selesai')->whereNotNull('file_sertifikat')->count();
        $countBelum = Reservasi::where('status_reservasi', 'Selesai')->whereNull('file_sertifikat')->count();

        return view('marketing.sertifikat.index', compact('reservasis', 'countSudah', 'countBelum'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'file_sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $reservasi = Reservasi::findOrFail($id);

        if ($request->hasFile('file_sertifikat')) {
            if ($reservasi->file_sertifikat) {
                Storage::delete('public/sertifikat/' . $reservasi->file_sertifikat);
            }

            $file = $request->file('file_sertifikat');
            $filename = 'sertifikat_' . $id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/sertifikat', $filename);

            $reservasi->update([
                'file_sertifikat' => $filename
            ]);
        }

        return redirect()->back()->with('success', 'Sertifikat berhasil diunggah!');
    }

    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        if ($reservasi->file_sertifikat) {
            Storage::delete('public/sertifikat/' . $reservasi->file_sertifikat);
            $reservasi->update(['file_sertifikat' => null]);
        }

        return redirect()->back()->with('success', 'Sertifikat berhasil dihapus!');
    }
}
