@extends('layouts.admin')
@section('title', 'Penerbitan Sertifikat')

@section('content')

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined text-sm">check_circle</span>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined text-sm">error</span>
    <span class="font-medium text-sm">{{ session('error') }}</span>
</div>
@endif

<div class="flex justify-between items-start mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Penerbitan Sertifikat</h1>
        <p class="text-sm text-slate-500 mt-1">Upload sertifikat hak guna lahan untuk pembeli yang sudah melunasi pembayaran.</p>
    </div>

    {{-- Statistik kecil --}}
    <div class="flex gap-3">
        <div class="bg-white border border-slate-100 rounded-xl px-4 py-3 text-center shadow-sm">
            <p class="text-xl font-bold text-slate-900">{{ $reservasis->whereNotNull('file_sertifikat')->count() }}</p>
            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Sudah Terbit</p>
        </div>
        <div class="bg-white border border-slate-100 rounded-xl px-4 py-3 text-center shadow-sm">
            <p class="text-xl font-bold text-amber-600">{{ $reservasis->whereNull('file_sertifikat')->count() }}</p>
            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">Belum Terbit</p>
        </div>
    </div>
</div>

@if($reservasis->isEmpty())
<div class="py-20 text-center bg-white rounded-2xl border border-slate-100 shadow-sm">
    <span class="material-icons-outlined text-5xl text-slate-200 block mb-3">workspace_premium</span>
    <p class="font-medium text-slate-500">Belum ada pembayaran yang lunas.</p>
    <p class="text-xs text-slate-400 mt-1">Sertifikat bisa diterbitkan setelah pembayaran dikonfirmasi Lunas.</p>
</div>
@else

<div class="space-y-4">
    @foreach($reservasis as $res)
    @php
        $sudahTerbit = !is_null($res->file_sertifikat);
    @endphp

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

        {{-- Bar status --}}
        <div class="h-1 w-full {{ $sudahTerbit ? 'bg-emerald-500' : 'bg-amber-400' }}"></div>

        <div class="p-6">
            <div class="flex flex-col lg:flex-row lg:items-center gap-6">

                {{-- Info Reservasi --}}
                <div class="flex-grow">
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <h3 class="font-bold text-slate-900 text-base">
                            Kavling #{{ $res->kavling->nomor_kavling }}
                        </h3>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                            {{ $sudahTerbit ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $sudahTerbit ? 'Sertifikat Terbit' : 'Belum Terbit' }}
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-blue-100 text-blue-700">
                            Lunas
                        </span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-1 text-sm">
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold mb-0.5">Pembeli</p>
                            <p class="font-semibold text-slate-800">{{ $res->user->name }}</p>
                            <p class="text-xs text-slate-400">{{ $res->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold mb-0.5">Cluster</p>
                            <p class="font-semibold text-slate-800">{{ $res->kavling->cluster->nama_cluster }}</p>
                            <p class="text-xs text-slate-400">{{ $res->kavling->tipe_kavling }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold mb-0.5">Jenazah</p>
                            <p class="font-semibold text-slate-800">
                                {{ $res->nama_jenazah ? 'Alm. '.$res->nama_jenazah : 'Pre-Need' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold mb-0.5">Invoice</p>
                            <p class="font-semibold text-slate-800">{{ $res->pembayaran->no_invoice ?? '-' }}</p>
                            <p class="text-xs text-slate-400">
                                Rp {{ number_format($res->kavling->harga, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Aksi Upload / Lihat --}}
                <div class="shrink-0 flex flex-col gap-3 lg:items-end">

                    @if($sudahTerbit)
                    {{-- Sudah ada sertifikat --}}
                    <div class="flex items-center gap-2">
                        <a href="{{ asset('storage/sertifikat/' . $res->file_sertifikat) }}" target="_blank"
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl text-xs font-bold hover:bg-emerald-100 transition-colors">
                            <span class="material-icons-outlined text-sm">open_in_new</span> Lihat Sertifikat
                        </a>
                        <a href="{{ asset('storage/sertifikat/' . $res->file_sertifikat) }}" download
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 text-slate-700 rounded-xl text-xs font-bold hover:bg-slate-200 transition-colors">
                            <span class="material-icons-outlined text-sm">download</span>
                        </a>
                        @if(auth()->user()->role == 'admin')
                        <form action="{{ route('admin.sertifikat.destroy', $res->id) }}" method="POST"
                              onsubmit="return confirm('Hapus sertifikat ini? Pembeli tidak bisa lagi mengunduhnya.')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 bg-red-50 text-red-500 border border-red-100 rounded-xl text-xs font-bold hover:bg-red-100 transition-colors">
                                <span class="material-icons-outlined text-sm">delete</span>
                            </button>
                        </form>
                        @endif
                    </div>

                    {{-- Ganti sertifikat --}}
                    @if(auth()->user()->role == 'admin')
                    <div x-data="{ gantiOpen: false }">
                        <button @click="gantiOpen = !gantiOpen"
                                class="text-xs text-slate-400 hover:text-slate-700 flex items-center gap-1 transition-colors">
                            <span class="material-icons-outlined text-sm">edit</span> Ganti Sertifikat
                        </button>
                        <div x-show="gantiOpen" x-transition class="mt-2">
                            <form action="{{ route('admin.sertifikat.upload', $res->id) }}" method="POST"
                                  enctype="multipart/form-data"
                                  class="flex items-center gap-2">
                                @csrf
                                <input type="file" name="file_sertifikat" accept=".pdf,.jpg,.jpeg,.png"
                                       required
                                       class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer">
                                <button type="submit"
                                        class="px-3 py-1.5 bg-slate-900 text-white rounded-lg text-xs font-bold hover:bg-black transition-colors whitespace-nowrap">
                                    Upload
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    @else
                    {{-- Belum ada sertifikat — form upload --}}
                    @if(auth()->user()->role == 'admin')
                    <form action="{{ route('admin.sertifikat.upload', $res->id) }}" method="POST"
                          enctype="multipart/form-data"
                          class="flex flex-col gap-2">
                        @csrf
                        <div class="border-2 border-dashed border-slate-200 rounded-xl bg-slate-50 hover:border-slate-400 transition-colors">
                            <label class="flex items-center gap-3 px-4 py-3 cursor-pointer">
                                <span class="material-icons-outlined text-slate-400 text-xl">upload_file</span>
                                <div>
                                    <p class="text-xs font-bold text-slate-600">Upload Sertifikat</p>
                                    <p class="text-[10px] text-slate-400">PDF, JPG, PNG — Maks. 5MB</p>
                                </div>
                                <input type="file" name="file_sertifikat" accept=".pdf,.jpg,.jpeg,.png" required
                                       class="hidden"
                                       onchange="this.closest('form').querySelector('.file-name').textContent = this.files[0]?.name || ''">
                            </label>
                        </div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="file-name text-[10px] text-slate-400 truncate max-w-[160px]"></span>
                            <button type="submit"
                                    class="px-4 py-2 bg-slate-900 hover:bg-black text-white rounded-xl text-xs font-bold transition-colors flex items-center gap-1.5 whitespace-nowrap">
                                <span class="material-icons-outlined text-sm">send</span> Terbitkan Sertifikat
                            </button>
                        </div>
                    </form>
                    @else
                    <span class="text-slate-400 text-xs italic">Belum ada sertifikat</span>
                    @endif

                    @endif

                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endif

@endsection