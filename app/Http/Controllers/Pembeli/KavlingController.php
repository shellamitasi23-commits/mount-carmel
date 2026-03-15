<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kavling;

class KavlingController extends Controller
{
    public function index()
    {
        // Ambil data kavling yang statusnya 'Tersedia'
        $kavlings = Kavling::with('cluster')->where('status', 'Tersedia');

        // Filter berdasarkan cluster jika ada
        if (request('cluster')) {
            $kavlings = $kavlings->where('cluster_id', request('cluster'));
        }

        $kavlings = $kavlings->get();
        return view('pembeli.kavling.index', compact('kavlings'));
    }
}
