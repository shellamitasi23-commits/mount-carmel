@extends('layouts.master')
@section('title')
Lahan — {{ $cluster->nama_cluster }}
@endsection

@section('content')
<div class="min-h-screen bg-white pt-28 pb-20">
    <div class="max-w-7xl mx-auto px-10">

        {{-- Minimalist Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-gray-400 mb-8">
            <a href="{{ route('home') }}" class="hover:text-slate-900 transition-colors">Beranda</a>
            <span>/</span>
            <a href="{{ route('cluster.index') }}" class="hover:text-slate-900 transition-colors">Cluster</a>
            <span>/</span>
            <span class="text-slate-900 font-medium">{{ $cluster->nama_cluster }}</span>
        </nav>

        {{-- Header Section --}}
        <div class="max-w-4xl mb-12">
            <span class="inline-block text-xs font-bold text-slate-400 mb-2">
                {{ $cluster->kategori === 'Muslim' ? 'Kawasan Syariat Islam' : 'Kawasan Umum' }}
            </span>
            
            <h1 class="text-3xl md:text-4xl font-bold text-slate-900 tracking-tight mb-4">
                {{ $cluster->nama_cluster }}
            </h1>
            
            <p class="text-slate-500 text-sm leading-relaxed max-w-2xl">
                @if($cluster->kategori === 'Muslim')
                    Kawasan peristirahatan khusus Muslim yang asri, tenang, dan terawat abadi. Tata letak makam dirancang rapi dengan jaminan presisi arah kiblat yang sempurna.
                @else
                    Kawasan peristirahatan terakhir yang tenang, indah, dan terawat dengan penuh rasa hormat di tengah lanskap alam terbuka yang damai.
                @endif
            </p>
        </div>

        {{-- Navigation Switcher --}}
        <div class="flex flex-wrap justify-center gap-2.5 mb-12">
            @foreach($clusters as $cl)
                <a href="{{ route('pembeli.lahan.index', ['cluster_id' => $cl->id]) }}"
                   class="px-5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-300
                       {{ $cl->id === $cluster->id 
                           ? 'bg-[#800000] text-white shadow-md shadow-[#800000]/10' 
                           : 'bg-slate-50 text-slate-555 hover:text-slate-900 border border-slate-100' }}">
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10 justify-center">
            @foreach($tipeLahans as $i => $tipe)

            <div class="group flex flex-col w-full max-w-md mx-auto bg-white dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800 rounded-3xl p-5 shadow-[0_10px_30px_rgba(0,0,0,0.02)] hover:shadow-[0_20px_40px_rgba(128,0,0,0.06)] dark:hover:shadow-[0_20px_40px_rgba(0,0,0,0.25)] transition-all duration-500 hover:-translate-y-2">
                
                {{-- Premium Image --}}
                <div class="relative aspect-[4/3] overflow-hidden bg-slate-50 dark:bg-gray-800 rounded-2xl mb-6 shadow-sm">
                    @php
                        $tipeLower = strtolower($tipe['tipe_lahan']);
                        $imgPosition = 'object-center';
                        
                        if (str_contains($tipeLower, 'barokah')) {
                            $placeholderImg = asset('storage/assets/tipe/barokah.png');
                        } elseif (str_contains($tipeLower, 'fitrah')) {
                            $placeholderImg = asset('storage/assets/tipe/Fitrah.png');
                        } elseif (str_contains($tipeLower, 'shakinah')) {
                            $placeholderImg = asset('storage/assets/tipe/shakinah.png');
                        } elseif (str_contains($tipeLower, 'khalifah')) {
                            $placeholderImg = asset('storage/assets/tipe/khalifah.png');
                        } elseif (str_contains($tipeLower, 'single')) {
                            $placeholderImg = asset('storage/assets/tipe/single.jpeg');
                        } elseif (str_contains($tipeLower, 'double deluxe') || str_contains($tipeLower, 'd. deluxe')) {
                            $placeholderImg = asset('storage/assets/tipe/double-deluxe.jpeg');
                        } elseif (str_contains($tipeLower, 'double special') || str_contains($tipeLower, 'd. special') || str_contains($tipeLower, 'db-special')) {
                            $placeholderImg = asset('storage/assets/tipe/db-special.jpeg');
                        } elseif (str_contains($tipeLower, 'deluxe')) {
                            $placeholderImg = asset('storage/assets/tipe/deluxe.png');
                        } elseif (str_contains($tipeLower, 'double')) {
                            $placeholderImg = asset('storage/assets/tipe/double(2).png');
                            $imgPosition = 'object-top';
                        } elseif (str_contains($tipeLower, 'super family') || str_contains($tipeLower, 'super-family') || str_contains($tipeLower, 's. family')) {
                            $placeholderImg = asset('storage/assets/tipe/super-family.png');
                        } elseif (str_contains($tipeLower, 'royal family') || str_contains($tipeLower, 'royal-family') || str_contains($tipeLower, 'royal')) {
                            $placeholderImg = asset('storage/assets/tipe/royal-family.png');
                        } elseif (str_contains($tipeLower, 'vip ')) {
                            $placeholderImg = asset('storage/assets/tipe/vip.png');
                        } elseif (str_contains($tipeLower, 'vip special')) {
                            $placeholderImg = asset('storage/assets/tipe/vip.png');
                        } elseif (str_contains($tipeLower, 'family')) {
                            $placeholderImg = asset('storage/assets/tipe/family.png');
                        } else {
                            $placeholderImg = $cluster->kategori === 'Muslim' 
                                ? asset('storage/assets/tipe/barokah.png')
                                : asset('storage/assets/tipe/non-muslim.png');
                        }
                    @endphp
                    <img src="{{ $placeholderImg }}" alt="{{ $tipe['tipe_lahan'] }}"
                         class="w-full h-full object-cover {{ $imgPosition }} transition-transform duration-1000 group-hover:scale-105" />
                    <div class="absolute inset-0 bg-slate-900/10 group-hover:bg-transparent transition-colors duration-700"></div>
                    
                    {{-- Badges on top of image --}}
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 bg-[#800000] text-[9px] font-black uppercase tracking-[0.2em] text-white rounded-full shadow-sm">
                            {{ $tipe['tersedia'] }} Unit Tersedia
                        </span>
                    </div>
                </div>

                {{-- Content --}}
                <div class="flex flex-col flex-grow px-2">
                    <h3 class="font-bold text-slate-900 dark:text-white text-2xl tracking-tight mb-4 group-hover:text-[#800000] dark:group-hover:text-red-400 transition-colors duration-300">
                        {{ $tipe['tipe_lahan'] }}
                    </h3>

                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center py-2.5 border-b border-slate-100 dark:border-gray-800">
                            <span class="font-semibold text-slate-400 dark:text-gray-500 uppercase tracking-widest text-[9px]">Luas Dimensi</span>
                            <span class="font-bold text-slate-800 dark:text-gray-200 text-xs">{{ $tipe['ukuran'] }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2.5 border-b border-slate-100 dark:border-gray-800">
                            <span class="font-semibold text-slate-400 dark:text-gray-500 uppercase tracking-widest text-[9px]">Kapasitas</span>
                            <span class="font-bold text-slate-800 dark:text-gray-200 text-xs">{{ $tipe['kapasitas'] }} Slot</span>
                        </div>

                        <div class="pt-4">
                            <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400 dark:text-gray-500 block mb-1">Harga Lahan</span>
                            <span class="text-2xl font-black text-[#800000] dark:text-red-400 tracking-tight leading-none">
                                Rp {{ number_format($tipe['harga_min'],0,',','.') }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-auto pt-4 border-t border-slate-100 dark:border-gray-850">
                        <a href="{{ route('pembeli.lahan.nomor', ['cluster_id' => $cluster->id, 'tipe_lahan' => $tipe['tipe_lahan']]) }}"
                           class="w-full inline-flex justify-center items-center gap-2 bg-[#800000] text-white text-center py-4 rounded-xl text-xs font-black uppercase tracking-[0.2em] hover:bg-[#800000]/90 transition-all shadow-md hover:shadow-lg hover:shadow-[#800000]/10 duration-300 group/btn">
                            <span>Pilih Nomor Kavling</span>
                            <svg class="w-4 h-4 transform group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</div>
@endsection
