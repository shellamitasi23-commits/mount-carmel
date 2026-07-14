@extends('layouts.admin')

@section('title', 'Sertifikat Lahan - Mount Carmel')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-xl font-bold text-slate-800 tracking-tight">Sertifikat Lahan</h1>
        <p class="text-xs text-slate-400 mt-0.5">Kelola dan unggah berkas sertifikat untuk reservasi lahan yang sudah Lunas.</p>
    </div>
</div>


<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-[0_10px_30px_rgba(0,0,0,0.015)]">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Lunas</p>
        <h3 class="text-xl font-black text-slate-800 mt-1">{{ $countSudah + $countBelum }}</h3>
    </div>
    <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-[0_10px_30px_rgba(0,0,0,0.015)]">
        <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Sertifikat Terbit</p>
        <h3 class="text-xl font-black text-emerald-600 mt-1">{{ $countSudah }}</h3>
    </div>
    <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-[0_10px_30px_rgba(0,0,0,0.015)]">
        <p class="text-[10px] font-bold text-amber-600 uppercase tracking-wider">Belum Terbit</p>
        <h3 class="text-xl font-black text-amber-600 mt-1">{{ $countBelum }}</h3>
    </div>
</div>


<div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-[0_10px_30px_rgba(0,0,0,0.015)] mb-6">
    <form action="{{ route('marketing.sertifikat.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pembeli atau nomor lahan..."
                   class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-4 py-2.5 text-xs text-slate-700 outline-none focus:bg-white focus:border-[#800000] transition-colors">
        </div>
        <div class="w-full md:w-48">
            <select name="status" onchange="this.form.submit()"
                    class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-4 py-2.5 text-xs text-slate-600 outline-none focus:bg-white focus:border-[#800000] cursor-pointer">
                <option value="">Semua Status</option>
                <option value="terbit" {{ request('status') === 'terbit' ? 'selected' : '' }}>Terbit</option>
                <option value="belum_terbit" {{ request('status') === 'belum_terbit' ? 'selected' : '' }}>Belum Terbit</option>
            </select>
        </div>
        <button type="submit" class="px-5 py-2.5 bg-[#800000] text-white font-bold rounded-2xl text-xs hover:bg-[#800000]/90 transition-colors">Cari</button>
        @if(request()->anyFilled(['search', 'status']))
            <a href="{{ route('marketing.sertifikat.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-2xl text-xs transition-colors text-center">Reset</a>
        @endif
    </form>
</div>


@if($reservasis->isEmpty())
<div class="bg-white rounded-3xl border border-slate-100 p-16 text-center shadow-[0_10px_30px_rgba(0,0,0,0.015)]">
    <span class="material-icons-outlined text-5xl text-slate-200 mb-2">workspace_premium</span>
    <h3 class="text-sm font-bold text-slate-400">Tidak ada data ditemukan</h3>
    <p class="text-xs text-slate-400 mt-1">Data reservasi lunas belum tersedia atau pencarian tidak cocok.</p>
</div>
@else
<div class="space-y-4">
    @foreach($reservasis as $res)
    @php
        $sudahTerbit = !is_null($res->file_sertifikat);
        $statusText = $sudahTerbit ? 'Terbit' : 'Belum Terbit';
        $badgeClass = $sudahTerbit ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-amber-50 text-amber-700 border border-amber-100';
    @endphp
    <div class="bg-white rounded-3xl border border-slate-100 p-5 md:p-6 shadow-[0_10px_30px_rgba(0,0,0,0.015)] hover:shadow-md transition-shadow">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="flex-grow">
                <div class="flex flex-wrap items-center gap-2 mb-2">
                    <h3 class="font-bold text-slate-900 text-base">
                        Lahan #{{ $res->lahan->nomor_lahan }}
                    </h3>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $badgeClass }}">
                        {{ $statusText }}
                    </span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-blue-50 text-blue-700 border border-blue-100">
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
                        <p class="font-semibold text-slate-800">{{ $res->lahan->cluster->nama_cluster }}</p>
                        <p class="text-xs text-slate-400">{{ $res->lahan->tipe_lahan }}</p>
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
                            Rp {{ number_format($res->lahan->harga, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            
            <div class="shrink-0 flex flex-col gap-3 lg:items-end">
                @if($sudahTerbit)
                
                <div class="flex items-center gap-2">
                    <a href="{{ route('document.sertifikat', $res->id) }}" target="_blank"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-250 rounded-xl text-xs font-bold hover:bg-emerald-100 transition-colors">
                        <span class="material-icons-outlined text-sm">open_in_new</span> Lihat Sertifikat
                    </a>
                    <a href="{{ route('document.sertifikat', $res->id) }}?download=1"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-700 rounded-xl text-xs font-bold hover:bg-slate-200 transition-colors">
                        <span class="material-icons-outlined text-sm">download</span>
                    </a>
                    
                    <div x-data="{ gantiOpen: false }" class="relative">
                        <button @click="gantiOpen = !gantiOpen" 
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl text-xs font-bold transition-all shadow-sm">
                            <span class="material-icons-outlined text-sm">edit</span> Ganti
                        </button>
                        <div x-show="gantiOpen" x-transition class="absolute right-0 mt-2 bg-white border border-slate-100 shadow-xl rounded-2xl p-4 z-50 w-72">
                            <form action="{{ route('marketing.sertifikat.upload', $res->id) }}" method="POST"
                                  enctype="multipart/form-data"
                                  class="space-y-3">
                                @csrf
                                <p class="text-xs font-bold text-slate-700">Ganti Berkas Sertifikat</p>
                                <input type="file" name="file_sertifikat" accept=".pdf,.jpg,.jpeg,.png" required
                                       class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer w-full">
                                <button type="submit"
                                        class="w-full py-2 bg-[#800000] text-white rounded-xl text-xs font-bold hover:bg-[#800000]/90 transition-colors">
                                    Upload & Ganti
                                </button>
                            </form>
                        </div>
                    </div>

                    <form action="{{ route('marketing.sertifikat.destroy', $res->id) }}" method="POST"
                           onsubmit="return confirm('Hapus sertifikat ini? Pembeli tidak bisa lagi mengunduhnya.')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-red-50 text-red-500 border border-red-100 rounded-xl text-xs font-bold hover:bg-red-100 transition-colors">
                            <span class="material-icons-outlined text-sm">delete</span>
                        </button>
                    </form>
                </div>
                @else
                
                <form action="{{ route('marketing.sertifikat.upload', $res->id) }}" method="POST"
                      enctype="multipart/form-data"
                      class="flex flex-col gap-2 w-full sm:w-80">
                    @csrf
                    <div class="border border-dashed border-slate-200 rounded-xl bg-slate-50 hover:border-slate-400 transition-colors">
                        <label class="flex items-center gap-3 px-4 py-2.5 cursor-pointer">
                            <span class="material-icons-outlined text-slate-400 text-xl">upload_file</span>
                            <div>
                                <p class="text-[11px] font-bold text-slate-600">Upload File Sertifikat</p>
                                <p class="text-[9px] text-slate-400">PDF, JPG, PNG — Maks. 5MB</p>
                            </div>
                            <input type="file" name="file_sertifikat" accept=".pdf,.jpg,.jpeg,.png" required
                                   class="hidden"
                                   onchange="this.closest('form').querySelector('.file-name').textContent = this.files[0]?.name || ''">
                        </label>
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="file-name text-[9px] text-slate-400 truncate max-w-[160px]"></span>
                        <button type="submit"
                                class="px-4 py-1.5 bg-[#800000] hover:bg-[#800000]/90 text-white rounded-xl text-xs font-bold transition-colors flex items-center gap-1.5 whitespace-nowrap">
                            <span class="material-icons-outlined text-sm">send</span> Kirim
                        </button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

@if(method_exists($reservasis, 'hasPages') && $reservasis->hasPages())
<div class="mt-6 px-4 py-3 bg-white border border-slate-100 rounded-xl shadow-sm">
    {{ $reservasis->appends(request()->query())->links() }}
</div>
@endif

@endif

@endsection
