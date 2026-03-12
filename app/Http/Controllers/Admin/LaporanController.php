<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        // Nanti di sini kamu bisa mengambil data dari database (Sum pendapatan, dll)
        return view('admin.laporan.index');
    }
}