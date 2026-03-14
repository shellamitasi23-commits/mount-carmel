<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClusterController extends Controller
{
    public function index()
    {
        // Mengembalikan tampilan halaman cluster premium yang tadi kita buat
        return view('pembeli.cluster.index');
    }
}