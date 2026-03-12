@extends('layouts.admin')

@section('title', 'Manajemen Kavling - Mount Carmel')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-textMain">Manajemen Kavling</h1>
        <p class="text-sm text-textMuted mt-1">Kelola data, tipe, dan ketersediaan kavling cluster.</p>
    </div>
    <button class="bg-primary hover:bg-opacity-90 text-white px-5 py-2.5 rounded-xl font-semibold text-sm flex items-center gap-2 transition-all shadow-sm">
        <span class="material-icons-outlined text-lg">add</span>
        Tambah Kavling
    </button>
</div>

<div class="bg-card rounded-t-2xl p-6 border border-gray-100 border-b-0 shadow-sm flex flex-col md:flex-row gap-4 justify-between items-center mt-4">
    <div class="flex items-center bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 w-full md:w-80">
        <span class="material-icons-outlined text-gray-400 text-sm mr-2">search</span>
        <input type="text" placeholder="Cari ID atau Tipe Kavling..." class="bg-transparent border-none focus:outline-none text-sm w-full text-gray-700">
    </div>
    <div class="flex gap-2 w-full md:w-auto">
        <select class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg px-4 py-2 focus:outline-none w-full md:w-auto cursor-pointer">
            <option value="">Semua Cluster</option>
            <option value="muslim">Muslim</option>
            <option value="non_muslim">Non-Muslim</option>
        </select>
        <select class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg px-4 py-2 focus:outline-none w-full md:w-auto cursor-pointer">
            <option value="">Semua Status</option>
            <option value="tersedia">Tersedia</option>
            <option value="terjual">Terjual</option>
            <option value="booking">Booking</option>
        </select>
    </div>
</div>

<div class="bg-card rounded-b-2xl border border-gray-100 shadow-sm overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-textMuted font-semibold bg-gray-50/80 border-b border-gray-100">
                    <th class="px-6 py-4">ID Kavling</th>
                    <th class="px-6 py-4">Tipe & Cluster</th>
                    <th class="px-6 py-4">Ukuran</th>
                    <th class="px-6 py-4">Harga</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-bold text-primary">#KV-M01</td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-textMain">Tipe Barokah</p>
                        <p class="text-xs text-textMuted">Cluster Muslim</p>
                    </td>
                    <td class="px-6 py-4 text-textMuted">1.5m x 2.5m</td>
                    <td class="px-6 py-4 font-medium text-textMain">Rp 150.000.000</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-green-50 text-green-600 rounded-md text-xs font-bold tracking-wide">Tersedia</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button class="text-blue-500 hover:bg-blue-50 p-1.5 rounded-lg transition-colors"><span class="material-icons-outlined text-lg">edit</span></button>
                        <button class="text-red-500 hover:bg-red-50 p-1.5 rounded-lg transition-colors"><span class="material-icons-outlined text-lg">delete</span></button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-bold text-primary">#KV-NM05</td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-textMain">Family</p>
                        <p class="text-xs text-textMuted">Cluster Non-Muslim</p>
                    </td>
                    <td class="px-6 py-4 text-textMuted">8m x 5m</td>
                    <td class="px-6 py-4 font-medium text-textMain">Rp 450.000.000</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-md text-xs font-bold tracking-wide">Terjual</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button class="text-blue-500 hover:bg-blue-50 p-1.5 rounded-lg transition-colors"><span class="material-icons-outlined text-lg">edit</span></button>
                        <button class="text-red-500 hover:bg-red-50 p-1.5 rounded-lg transition-colors"><span class="material-icons-outlined text-lg">delete</span></button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-bold text-primary">#KV-M12</td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-textMain">Tipe Khalifah</p>
                        <p class="text-xs text-textMuted">Cluster Muslim</p>
                    </td>
                    <td class="px-6 py-4 text-textMuted">7m x 15m</td>
                    <td class="px-6 py-4 font-medium text-textMain">Rp 650.000.000</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-yellow-50 text-yellow-600 rounded-md text-xs font-bold tracking-wide">Booking</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button class="text-blue-500 hover:bg-blue-50 p-1.5 rounded-lg transition-colors"><span class="material-icons-outlined text-lg">edit</span></button>
                        <button class="text-red-500 hover:bg-red-50 p-1.5 rounded-lg transition-colors"><span class="material-icons-outlined text-lg">delete</span></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-50 flex items-center justify-between text-sm text-textMuted">
        <span>Menampilkan 1-10 dari 120 Kavling</span>
        <div class="flex gap-1">
            <button class="px-3 py-1 border border-gray-200 rounded hover:bg-gray-50">Prev</button>
            <button class="px-3 py-1 bg-primary text-white rounded">1</button>
            <button class="px-3 py-1 border border-gray-200 rounded hover:bg-gray-50">2</button>
            <button class="px-3 py-1 border border-gray-200 rounded hover:bg-gray-50">Next</button>
        </div>
    </div>
</div>
@endsection