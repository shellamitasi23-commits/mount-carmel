@extends('layouts.admin')
@section('title', 'Data Lahan — Mount Carmel')

@section('content')

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined">check_circle</span>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Data Lahan</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola lahan per cluster. Madinah (Muslim) & Mount Carmel (Non-Muslim).</p>
    </div>

</div>

{{-- Filtering System --}}
<div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 mb-6">
    <form method="GET" action="{{ route('marketing.lahan.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        @if(request('cluster_id'))
        <input type="hidden" name="cluster_id" value="{{ request('cluster_id') }}">
        @endif
        
        <div class="md:col-span-2">
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1.5">Cari Data</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 material-icons-outlined text-slate-400 text-sm">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor lahan, tipe, cluster, atau status..."
                       class="w-full pl-11 pr-4 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300">
            </div>
        </div>
        <div>
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1.5">Status Lahan</label>
            <div class="relative">
                <select name="status" onchange="this.form.submit()" class="w-full px-4 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all appearance-none cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Reservasi (Lunas)" {{ request('status') == 'Reservasi (Lunas)' ? 'selected' : '' }}>Reservasi (Lunas)</option>
                    <option value="Reservasi Cicilan dengan DP" {{ request('status') == 'Reservasi Cicilan dengan DP' ? 'selected' : '' }}>Reservasi Cicilan dengan DP</option>
                    <option value="Digunakan" {{ request('status') == 'Digunakan' ? 'selected' : '' }}>Digunakan</option>
                </select>
                <span class="material-icons-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-sm">expand_more</span>
            </div>
        </div>
        <div class="flex">
            @if(request('search') || request('status') || request('cluster_id'))
            <a href="{{ route('marketing.lahan.index') }}" class="w-full px-5 py-2 bg-slate-100 text-slate-500 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all text-center flex items-center justify-center">
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

{{-- Tab per Cluster --}}
<div x-data="{ activeCluster: '{{ request('cluster_id', 'semua') }}' }">

    {{-- Tab Nav --}}
    <div class="flex items-center gap-1.5 mb-6 p-1.5 bg-white border border-slate-100 rounded-xl w-full shadow-sm overflow-x-auto whitespace-nowrap">
        <a href="{{ route('marketing.lahan.index', array_merge(request()->query(), ['cluster_id' => 'semua', 'page' => 1])) }}"
           class="flex-1 shrink-0 text-center px-4 py-2 rounded-lg text-xs font-bold transition-all {{ request('cluster_id', 'semua') === 'semua' ? 'bg-[#800000] text-white shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
            Semua ({{ \App\Models\Lahan::count() }})
        </a>
        @foreach($clusters as $cl)
        <a href="{{ route('marketing.lahan.index', array_merge(request()->query(), ['cluster_id' => $cl->id, 'page' => 1])) }}"
           class="flex-1 shrink-0 text-center px-4 py-2 rounded-lg text-xs font-bold transition-all {{ request('cluster_id') == $cl->id ? 'bg-[#800000] text-white shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
            {{ $cl->nama_cluster }}
            <span class="text-[10px] opacity-70">({{ $cl->lahans()->count() }})</span>
        </a>
        @endforeach
    </div>
    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-slate-500 font-semibold bg-slate-50/80 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                        <th class="px-4 py-2.5">Nomor</th>
                        <th class="px-4 py-2.5">Lahan & Cluster</th>
                        <th class="px-4 py-2.5">Hadap</th>
                        <th class="px-4 py-2.5">Ukuran & Kapasitas</th>
                        <th class="px-4 py-2.5">Harga</th>
                        <th class="px-4 py-2.5">Status</th>

                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    @forelse($lahans as $lahan)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-4 py-2.5 font-bold text-slate-900">#{{ $lahan->nomor_lahan }}</td>
                        <td class="px-4 py-2.5">
                            <p class="font-bold text-slate-900">{{ $lahan->tipe_lahan }}</p>
                            <p class="text-xs mt-0.5 flex items-center gap-1
                                {{ $lahan->cluster->kategori === 'Muslim' ? 'text-teal-600' : 'text-blue-600' }}">
                                {{ $lahan->cluster->nama_cluster ?? '—' }}
                            </p>
                        </td>
                        <td class="px-4 py-2.5">
                            <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-[10px] font-bold uppercase">{{ $lahan->hadap ?? '—' }}</span>
                        </td>
                        <td class="px-4 py-2.5">
                            <p class="font-medium text-slate-800">{{ $lahan->ukuran }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $lahan->kapasitas }} Orang</p>
                        </td>
                        <td class="px-4 py-2.5 font-bold text-slate-900">
                            Rp {{ number_format($lahan->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-2.5">
                            @if($lahan->status == 'Tersedia')
                                <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-md text-[11px] font-bold uppercase">Tersedia</span>
                            @elseif(str_contains($lahan->status, 'Reservasi'))
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-md text-[11px] font-bold uppercase">{{ $lahan->status }}</span>
                            @elseif($lahan->status == 'Terjual')
                                <span class="px-3 py-1 bg-slate-200 text-slate-600 rounded-md text-[11px] font-bold uppercase">Terjual</span>
                            @else
                                <span class="px-3 py-1 bg-[#800000] text-white rounded-md text-[11px] font-bold uppercase">Digunakan</span>
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                            <span class="material-icons-outlined text-4xl text-slate-200 block mb-2">crop_square</span>
                            <p class="font-medium">Belum ada Data Lahan.</p>
                            <p class="text-xs mt-1">
                                Tambah manual atau jalankan:
                                <code class="bg-slate-100 px-1.5 py-0.5 rounded text-slate-600">php artisan db:seed --class=ClusterLahanSeeder</code>
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($lahans,'hasPages') && $lahans->hasPages())
        <div class="px-4 py-3 border-t border-slate-50">{{ $lahans->appends(request()->query())->links() }}</div>
        @endif
    </div></div>

</div>{{-- end x-data --}}


@endsection
