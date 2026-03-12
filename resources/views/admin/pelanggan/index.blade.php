@extends('layouts.admin')

@section('title', 'Data Pelanggan - Mount Carmel')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Data Pelanggan</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola data pembeli dan prospek (leads) Mount Carmel.</p>
    </div>
    <div class="flex gap-3 w-full md:w-auto">
        <button class="bg-white border border-gray-200 text-gray-700 px-4 py-2.5 rounded-xl font-semibold flex items-center gap-2 hover:bg-gray-50 transition-all shadow-sm text-sm">
            <span class="material-icons-outlined text-sm">download</span>
            Export Data
        </button>
        <button class="bg-primary hover:bg-opacity-90 text-white px-5 py-2.5 rounded-xl font-semibold flex items-center gap-2 transition-all shadow-md text-sm">
            <span class="material-icons-outlined text-sm">add</span>
            Tambah Pelanggan
        </button>
    </div>
</div>

<div class="bg-card rounded-2xl shadow-sm border border-gray-100 p-4 mb-6 flex flex-col md:flex-row gap-4 justify-between items-center">
    <div class="flex items-center bg-gray-50 rounded-lg px-4 py-2 w-full md:w-96 border border-gray-200">
        <span class="material-icons-outlined text-gray-400 text-lg mr-2">search</span>
        <input type="text" placeholder="Cari nama, email, atau telepon..." class="bg-transparent border-none focus:outline-none text-sm w-full text-gray-700">
    </div>
    
    <div class="flex gap-3 w-full md:w-auto">
        <select class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 outline-none">
            <option selected>Semua Status</option>
            <option value="aktif">Pemilik Kavling</option>
            <option value="prospek">Prospek Baru</option>
        </select>
        <select class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 outline-none">
            <option selected>Urutkan Terkini</option>
            <option value="lama">Paling Lama</option>
            <option value="abjad">A-Z</option>
        </select>
    </div>
</div>

<div class="bg-card rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-textMuted font-semibold bg-gray-50/80 border-b border-gray-100">
                    <th class="px-6 py-4">Informasi Pelanggan</th>
                    <th class="px-6 py-4">Kontak</th>
                    <th class="px-6 py-4">Alamat Asal</th>
                    <th class="px-6 py-4">Kavling Dimiliki</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-gray-700">
                
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=eef2ff&color=1e1b4b" class="w-10 h-10 rounded-full" alt="avatar">
                            <div>
                                <p class="font-bold text-textMain">Budi Santoso</p>
                                <p class="text-xs text-textMuted">Bergabung: 12 Okt 2023</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm">budi.santo@gmail.com</p>
                        <p class="text-xs text-textMuted">+62 812-3456-7890</p>
                    </td>
                    <td class="px-6 py-4 text-textMuted">Jakarta Selatan</td>
                    <td class="px-6 py-4">
                        <span class="font-medium text-navy">1 Unit</span> <span class="text-xs text-gray-400">(Fitrah)</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[11px] font-bold uppercase tracking-wide">Pemilik</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button class="text-blue-500 hover:text-blue-700 mx-1" title="Edit Profil"><span class="material-icons-outlined text-xl">edit</span></button>
                        <button class="text-primary hover:text-indigo-700 mx-1" title="Lihat Detail"><span class="material-icons-outlined text-xl">chevron_right</span></button>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Keluarga+Lee&background=f0fdf4&color=166534" class="w-10 h-10 rounded-full" alt="avatar">
                            <div>
                                <p class="font-bold text-textMain">Keluarga Lee</p>
                                <p class="text-xs text-textMuted">Bergabung: 05 Nov 2023</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm">leefamily@yahoo.com</p>
                        <p class="text-xs text-textMuted">+62 899-1111-2222</p>
                    </td>
                    <td class="px-6 py-4 text-textMuted">Bandung</td>
                    <td class="px-6 py-4">
                        <span class="font-medium text-navy">2 Unit</span> <span class="text-xs text-gray-400">(VIP, Family)</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[11px] font-bold uppercase tracking-wide">Pemilik</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button class="text-blue-500 hover:text-blue-700 mx-1" title="Edit Profil"><span class="material-icons-outlined text-xl">edit</span></button>
                        <button class="text-primary hover:text-indigo-700 mx-1" title="Lihat Detail"><span class="material-icons-outlined text-xl">chevron_right</span></button>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=fffbeb&color=991b1b" class="w-10 h-10 rounded-full" alt="avatar">
                            <div>
                                <p class="font-bold text-textMain">Siti Aminah</p>
                                <p class="text-xs text-textMuted">Bergabung: Hari ini</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm">siti.am@outlook.com</p>
                        <p class="text-xs text-textMuted">+62 855-9876-5432</p>
                    </td>
                    <td class="px-6 py-4 text-textMuted">Cirebon</td>
                    <td class="px-6 py-4">
                        <span class="text-gray-400 italic">Belum ada</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-[11px] font-bold uppercase tracking-wide">Prospek</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button class="text-blue-500 hover:text-blue-700 mx-1" title="Edit Profil"><span class="material-icons-outlined text-xl">edit</span></button>
                        <button class="text-primary hover:text-indigo-700 mx-1" title="Lihat Detail"><span class="material-icons-outlined text-xl">chevron_right</span></button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <div class="p-4 border-t border-gray-100 flex flex-col md:flex-row items-center justify-between text-sm text-gray-500 gap-4">
        <span>Menampilkan 1 hingga 10 dari 89 pelanggan</span>
        <div class="flex gap-1">
            <button class="px-3 py-1 border border-gray-200 rounded hover:bg-gray-50 transition-colors">Sebelumnya</button>
            <button class="px-3 py-1 border border-gray-200 bg-primary text-white rounded shadow-sm">1</button>
            <button class="px-3 py-1 border border-gray-200 rounded hover:bg-gray-50 transition-colors">2</button>
            <button class="px-3 py-1 border border-gray-200 rounded hover:bg-gray-50 transition-colors">3</button>
            <button class="px-3 py-1 border border-gray-200 rounded hover:bg-gray-50 transition-colors">Selanjutnya</button>
        </div>
    </div>
</div>
@endsection