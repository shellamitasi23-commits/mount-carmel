@extends('layouts.admin')

@section('title', 'Data Transaksi - Mount Carmel')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Data Transaksi</h1>
        <p class="text-sm text-gray-500 mt-1">Pantau seluruh riwayat pembelian dan pembayaran.</p>
    </div>
    <button class="bg-white border border-gray-200 text-gray-700 px-5 py-2.5 rounded-xl font-semibold flex items-center gap-2 hover:bg-gray-50 transition-all shadow-sm">
        <span class="material-icons-outlined text-sm">download</span>
        Export Laporan
    </button>
</div>

<div class="bg-card rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-textMuted font-semibold bg-gray-50/80 border-b border-gray-100">
                    <th class="px-6 py-4">No. Invoice</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Pembeli</th>
                    <th class="px-6 py-4">Kavling</th>
                    <th class="px-6 py-4">Total Harga</th>
                    <th class="px-6 py-4">Status Bayar</th>
                    <th class="px-6 py-4 text-center">Detail</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-bold text-primary">#INV-20231015-01</td>
                    <td class="px-6 py-4 text-textMuted">15 Okt 2023</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-textMain">Budi Santoso</p>
                        <p class="text-xs text-textMuted">0812-3456-7890</p>
                    </td>
                    <td class="px-6 py-4 text-textMuted">Tipe Fitrah (#KV-M01)</td>
                    <td class="px-6 py-4 font-bold text-textMain">Rp 150.000.000</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase tracking-wide">Lunas</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button class="text-primary hover:text-blue-600 bg-gray-100 p-2 rounded-lg transition-colors">
                            <span class="material-icons-outlined text-lg block">visibility</span>
                        </button>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-bold text-primary">#INV-20231016-02</td>
                    <td class="px-6 py-4 text-textMuted">16 Okt 2023</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-textMain">Keluarga Lee</p>
                        <p class="text-xs text-textMuted">0899-1111-2222</p>
                    </td>
                    <td class="px-6 py-4 text-textMuted">Tipe VIP (#KV-NM12)</td>
                    <td class="px-6 py-4 font-bold text-textMain">Rp 1.250.000.000</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold uppercase tracking-wide">Pending</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button class="text-primary hover:text-blue-600 bg-gray-100 p-2 rounded-lg transition-colors">
                            <span class="material-icons-outlined text-lg block">visibility</span>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection