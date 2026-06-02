<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use Illuminate\Support\Facades\Storage;

class SertifikatController extends Controller
{
    public function index()
    {
        $reservasis = Reservasi::with(['user', 'lahan.cluster'])
            ->where('status_reservasi', 'Selesai')
            ->latest()
            ->get();

        return view('marketing.sertifikat.index', compact('reservasis'));
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
