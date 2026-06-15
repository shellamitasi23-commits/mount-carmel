@extends('layouts.master')
@section('title')
Lahan — {{ $cluster->nama_cluster }}
@endsection

@section('content')
<div class="min-h-screen bg-white pt-40 pb-32">
    <div class="max-w-7xl mx-auto px-10">

        {{-- Editorial Breadcrumb --}}
        <nav class="flex items-center gap-4 text-[11px] font-black uppercase tracking-[0.3em] text-slate-300 mb-16">
            <a href="{{ route('home') }}" class="hover:text-slate-900 transition-colors">Beranda</a>
            <span>/</span>
            <a href="{{ route('cluster.index') }}" class="hover:text-slate-900 transition-colors">Cluster</a>
            <span>/</span>
            <span class="text-slate-900">{{ $cluster->nama_cluster }}</span>
        </nav>

        {{-- Header Section --}}
        <div class="max-w-4xl mb-24">
            <span class="inline-block text-slate-400 font-black tracking-[0.4em] uppercase text-[10px] mb-6">
                {{ $cluster->kategori === 'Muslim' ? 'Kawasan Syariat Islam' : 'Kawasan Umum' }}
            </span>
            
            <h1 class="text-7xl md:text-8xl font-black text-slate-900 tracking-tighter mb-10 leading-[0.85] italic">
                {{ $cluster->nama_cluster }}
            </h1>
            
            <p class="text-slate-500 text-xl leading-relaxed font-medium max-w-2xl">
                @if($cluster->kategori === 'Muslim')
                    Kawasan peristirahatan khusus Muslim yang asri, tenang, dan terawat abadi. Tata letak makam dirancang rapi dengan jaminan presisi arah kiblat yang sempurna.
                @else
                    Kawasan peristirahatan terakhir yang tenang, indah, dan terawat dengan penuh rasa hormat di tengah lanskap alam terbuka yang damai.
                @endif
            </p>
        </div>

        {{-- Navigation Switcher --}}
        <div class="flex flex-wrap gap-4 mb-20">
            @foreach($clusters as $cl)
                <a href="{{ route('pembeli.lahan.index', ['cluster_id' => $cl->id]) }}"
                   class="px-8 py-4 rounded-full text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300
                       {{ $cl->id === $cluster->id 
                           ? 'bg-[#800000] text-white shadow-2xl shadow-slate-200' 
                           : 'bg-slate-50 text-slate-400 hover:text-slate-900 border border-slate-100' }}">
                    {{ $cl->nama_cluster }}
                </a>
            @endforeach
        </div>

        {{-- Tipe Lahan Grid --}}
        @if($tipeLahans->isEmpty())
        <div class="py-32 text-center border-t border-gray-50 dark:border-gray-900">
            <h3 class="text-2xl font-light text-gray-300 italic mb-4">Tidak ada lahan tersedia saat ini</h3>
            <a href="{{ route('cluster.index') }}" class="text-[10px] font-black uppercase tracking-[0.3em] text-primary border-b border-primary pb-1">
                Kembali ke Koleksi Cluster
            </a>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-16 lg:gap-24">
            @foreach($tipeLahans as $i => $tipe)

            <div class="group flex flex-col">
                
                {{-- Premium Image --}}
                <div class="relative aspect-[4/5] overflow-hidden bg-slate-100 rounded-[2rem] mb-10 shadow-2xl shadow-slate-200/50">
                    @php
                        $placeholderImg = $cluster->kategori === 'Muslim' 
                            ? 'https://images.unsplash.com/photo-1590076215667-873d32788e0b?q=80&w=1000&auto=format&fit=crop'
                            : 'https://images.unsplash.com/photo-1542662565-7e4b66bae529?q=80&w=1000&auto=format&fit=crop';
                    @endphp
                    <img src="{{ $placeholderImg }}" alt="{{ $tipe['tipe_lahan'] }}"
                         class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" />
                    <div class="absolute inset-0 bg-slate-900/10 group-hover:bg-transparent transition-colors duration-700"></div>
                </div>

                <div class="flex justify-between items-baseline mb-6 border-b-4 border-slate-900 pb-4">
                    <h3 class="font-black text-slate-900 text-4xl tracking-tighter leading-none">
                        {{ $tipe['tipe_lahan'] }}
                    </h3>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                        {{ $tipe['tersedia'] }} Sisa
                    </span>
                </div>

                <div class="space-y-6 mb-12">
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-black text-slate-300 uppercase tracking-widest text-[10px]">Luas Dimensi</span>
                        <span class="font-black text-slate-900 uppercase tracking-widest text-xs">{{ $tipe['ukuran'] }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-black text-slate-300 uppercase tracking-widest text-[10px]">Kapasitas</span>
                        <span class="font-black text-slate-900 uppercase tracking-widest text-xs">{{ $tipe['kapasitas'] }} Slot</span>
                    </div>

                    <div class="pt-4 border-t border-slate-50">
                        <span class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-300 block mb-2">Nilai Investasi</span>
                        <span class="text-3xl font-black text-slate-900 tracking-tight leading-none">
                            Rp {{ number_format($tipe['harga_min'],0,',','.') }}
                        </span>
                    </div>
                </div>

                <div class="mt-auto pt-4">
                    <a href="{{ route('pembeli.lahan.nomor', ['cluster_id' => $cluster->id, 'tipe_lahan' => $tipe['tipe_lahan']]) }}"
                       class="w-full block bg-[#800000] text-white text-center py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.3em] hover:bg-[#800000]/90 transition-all shadow-2xl shadow-[#800000]/10">
                        Pilih Nomor Kavling
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</div>
@endsection
