<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    public function index()
    {
        $pembelis = User::where('role', 'pembeli')->latest()->get();
        return view('marketing.pelanggan.index', compact('pembelis'));
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
            'password' => Hash::make($request->password),
            'role' => 'pembeli',
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('marketing.pembeli.index')->with('success', 'Data Pembeli berhasil ditambahkan!');
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

        $pembeli->name = $request->name;
        $pembeli->email = $request->email;
        $pembeli->no_telepon = $request->no_telepon;
        $pembeli->alamat = $request->alamat;

        if ($request->filled('password')) {
            $pembeli->password = Hash::make($request->password);
        }

        $pembeli->save();

        return redirect()->route('marketing.pembeli.index')->with('success', 'Data Pembeli berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pembeli = User::findOrFail($id);
        $pembeli->delete();

        return redirect()->route('marketing.pembeli.index')->with('success', 'Data Pembeli berhasil dihapus!');
    }
}
