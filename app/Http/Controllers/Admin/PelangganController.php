<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    public function index()
    {
        // Ambil HANYA user yang memiliki role 'pembeli'
        $pembelis = User::where('role', 'pembeli')->latest()->get();
        return view('admin.pelanggan.index', compact('pembelis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password wajib di-hash
            'role' => 'pembeli', // Otomatis set role sebagai pembeli
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.pembeli.index')->with('success', 'Data Pembeli berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $pembeli = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string'
        ]);

        // Update data dasar
        $pembeli->name = $request->name;
        $pembeli->email = $request->email;
        $pembeli->no_telepon = $request->no_telepon;
        $pembeli->alamat = $request->alamat;

        // Update password HANYA JIKA kolom password diisi (tidak kosong)
        if ($request->filled('password')) {
            $pembeli->password = Hash::make($request->password);
        }

        $pembeli->save();

        return redirect()->route('admin.pembeli.index')->with('success', 'Data Pembeli berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pembeli = User::findOrFail($id);
        $pembeli->delete();

        return redirect()->route('admin.pembeli.index')->with('success', 'Data Pembeli berhasil dihapus!');
    }
}