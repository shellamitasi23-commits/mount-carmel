@extends('layouts.master')
@section('title', 'Kelola Kavling - Mount Carmel')

@section('content')
<div class="pt-24 min-h-screen bg-gray-50 dark:bg-gray-950">

    <!-- Page Header -->
    <div class="px-8 xl:px-24 py-12 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-400 mb-3">
                    <a href="/" class="hover:text-gray-600">Beranda</a>
                    <span class="material-icons text-xs">chevron_right</span>
                    <span class="text-gray-900 dark:text-white font-medium">Kelola Kavling</span>
                </div>
                <h1 class="font-display text-4xl font-bold">Kelola Data Kavling</h1>
                <p class="text-gray-500 mt-2 text-sm">Lihat detail, ketersediaan, dan nomor kavling yang Anda miliki.</p>
            </div>
            <a href="/reservasi" class="btn-press btn-ripple inline-flex items-center gap-2 px-6 py-3 bg-primary text-white font-semibold rounded-full hover:bg-primary/90 transition-colors self-start md:self-auto">
                <span class="material-icons text-base">add</span> Buat Reservasi Baru
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="px-8 xl:px-24 py-8">
        <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach([
                ['icon' => 'grid_view', 'label' => 'Total Kavling Dimiliki', 'value' => '3', 'color' => 'blue'],
                ['icon' => 'check_circle', 'label' => 'Kavling Aktif', 'value' => '2', 'color' => 'emerald'],
                ['icon' => 'pending', 'label' => 'Proses Reservasi', 'value' => '1', 'color' => 'amber'],
                ['icon' => 'receipt_long', 'label' => 'Total Transaksi', 'value' => '3', 'color' => 'purple'],
            ] as $card)
            <div data-aos="fade-up" class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="material-icons text-{{ $card['color'] }}-500 text-2xl">{{ $card['icon'] }}</span>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $card['value'] }}</p>
                <p class="text-xs text-gray-400 mt-1 font-medium">{{ $card['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Sub-navigation -->
    <div class="px-8 xl:px-24 pb-6" x-data="{ tab: 'detail' }">
        <div class="max-w-7xl mx-auto">
            <div class="flex gap-1 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-1 mb-8 w-fit">
                @foreach([['key' => 'detail', 'label' => 'Detail Kavling', 'icon' => 'view_list'], ['key' => 'ketersediaan', 'label' => 'Cek Ketersediaan', 'icon' => 'fact_check'], ['key' => 'nomor', 'label' => 'Nomor Kavling', 'icon' => 'tag']] as $t)
                <button @click="tab = '{{ $t['key'] }}'"
                        :class="tab === '{{ $t['key'] }}' ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-900'"
                        class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all">
                    <span class="material-icons text-base">{{ $t['icon'] }}</span>
                    <span class="hidden md:inline">{{ $t['label'] }}</span>
                </button>
                @endforeach
            </div>

            <!-- TAB: Lihat Detail Kavling -->
            <div x-show="tab === 'detail'" x-transition>
                <div class="space-y-4">
                    @php
                    $kavlings = [
                        ['nomor' => 'A-001', 'cluster' => 'Cluster Madinah', 'tipe' => 'Tipe Sakinah', 'ukuran' => '7m × 8m', 'status' => 'Aktif', 'tanggal' => '15 Jan 2024'],
                        ['nomor' => 'A-015', 'cluster' => 'Cluster Madinah', 'tipe' => 'Tipe Barokah', 'ukuran' => '1.5m × 2.5m', 'status' => 'Aktif', 'tanggal' => '22 Mar 2024'],
                        ['nomor' => 'B-007', 'cluster' => 'Cluster Carmel Hijau', 'tipe' => 'Family', 'ukuran' => '8m × 5m', 'status' => 'Proses', 'tanggal' => '10 Okt 2024'],
                    ];
                    @endphp

                    @foreach($kavlings as $kavling)
                    <div data-aos="fade-up" class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-6 flex flex-col md:flex-row md:items-center gap-4">
                        <!-- Nomor Kavling Badge -->
                        <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center shrink-0">
                            <span class="font-display font-bold text-primary text-lg">{{ explode('-', $kavling['nomor'])[0] }}</span>
                        </div>

                        <div class="flex-grow">
                            <div class="flex flex-wrap items-center gap-3 mb-1">
                                <h3 class="font-bold text-gray-900 dark:text-white">Kavling {{ $kavling['nomor'] }}</h3>
                                <span class="text-xs font-bold px-2 py-1 rounded-full {{ $kavling['status'] === 'Aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $kavling['status'] }}
                                </span>
                            </div>
                            <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                                <span class="flex items-center gap-1"><span class="material-icons text-xs">location_on</span>{{ $kavling['cluster'] }}</span>
                                <span class="flex items-center gap-1"><span class="material-icons text-xs">category</span>{{ $kavling['tipe'] }}</span>
                                <span class="flex items-center gap-1"><span class="material-icons text-xs">square_foot</span>{{ $kavling['ukuran'] }}</span>
                                <span class="flex items-center gap-1"><span class="material-icons text-xs">calendar_today</span>{{ $kavling['tanggal'] }}</span>
                            </div>
                        </div>

                        <div class="flex gap-2 shrink-0">
                            <a href="/cluster/1" class="btn-press px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors flex items-center gap-1">
                                <span class="material-icons text-sm">visibility</span> Detail
                            </a>
                            <a href="/reservasi" class="btn-press px-4 py-2 bg-primary text-white rounded-xl text-sm font-medium hover:bg-primary/90 transition-colors flex items-center gap-1">
                                <span class="material-icons text-sm">bookmark_add</span> Reservasi
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- TAB: Cek Ketersediaan -->
            <div x-show="tab === 'ketersediaan'" style="display:none" x-transition>
                <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-8">
                    <h2 class="font-display text-2xl font-bold mb-6">Cek Ketersediaan Kavling</h2>

                    <!-- Filter Form -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 p-6 bg-gray-50 dark:bg-gray-800 rounded-2xl">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Cluster</label>
                            <select class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                                <option>Semua Cluster</option>
                                <option>Cluster Madinah (Muslim)</option>
                                <option>Cluster Carmel Hijau (Non-Muslim)</option>
                                <option>Cluster Sakura (Non-Muslim)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Tipe Kavling</label>
                            <select class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                                <option>Semua Tipe</option>
                                <option>Tipe Barokah / Single</option>
                                <option>Tipe Fitrah / Double</option>
                                <option>Tipe Sakinah / Family</option>
                                <option>Tipe Khalifah / VIP</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button class="btn-press btn-ripple w-full px-6 py-3 bg-primary text-white font-semibold rounded-xl hover:bg-primary/90 transition-colors">
                                Cek Sekarang
                            </button>
                        </div>
                    </div>

                    <!-- Availability Grid -->
                    <div class="grid grid-cols-4 md:grid-cols-8 lg:grid-cols-12 gap-2 mb-6">
                        @php
                        $kavlingGrid = array_merge(
                            array_fill(0, 24, 'tersedia'),
                            array_fill(0, 68, 'terisi'),
                            array_fill(0, 8, 'proses'),
                            array_fill(0, 20, 'tersedia')
                        );
                        shuffle($kavlingGrid);
                        @endphp
                        @foreach(array_slice($kavlingGrid, 0, 60) as $i => $status)
                        <div title="{{ sprintf('Kavling %03d', $i+1) }}"
                             class="aspect-square rounded-lg cursor-pointer transition-all hover:scale-110 hover:shadow-md
                             {{ $status === 'tersedia' ? 'bg-emerald-400' : ($status === 'proses' ? 'bg-amber-400' : 'bg-gray-200 dark:bg-gray-700') }}">
                        </div>
                        @endforeach
                    </div>

                    <!-- Legend -->
                    <div class="flex flex-wrap gap-6 text-sm">
                        <div class="flex items-center gap-2"><div class="w-4 h-4 rounded bg-emerald-400"></div> Tersedia</div>
                        <div class="flex items-center gap-2"><div class="w-4 h-4 rounded bg-amber-400"></div> Dalam Proses</div>
                        <div class="flex items-center gap-2"><div class="w-4 h-4 rounded bg-gray-200 dark:bg-gray-700"></div> Terisi / Tidak Tersedia</div>
                    </div>
                </div>
            </div>

            <!-- TAB: Nomor Kavling -->
            <div x-show="tab === 'nomor'" style="display:none" x-transition>
                <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-8">
                    <h2 class="font-display text-2xl font-bold mb-2">Nomor Kavling Anda</h2>
                    <p class="text-gray-500 text-sm mb-8">Informasi nomor dan lokasi kavling yang terdaftar atas nama Anda.</p>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <th class="text-left py-3 px-4 font-bold uppercase tracking-wider text-xs text-gray-400">No. Kavling</th>
                                    <th class="text-left py-3 px-4 font-bold uppercase tracking-wider text-xs text-gray-400">Cluster</th>
                                    <th class="text-left py-3 px-4 font-bold uppercase tracking-wider text-xs text-gray-400">Tipe</th>
                                    <th class="text-left py-3 px-4 font-bold uppercase tracking-wider text-xs text-gray-400">Zona</th>
                                    <th class="text-left py-3 px-4 font-bold uppercase tracking-wider text-xs text-gray-400">Status</th>
                                    <th class="text-left py-3 px-4 font-bold uppercase tracking-wider text-xs text-gray-400">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                                @foreach($kavlings as $kavling)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="py-4 px-4">
                                        <span class="font-bold font-display text-primary text-base">{{ $kavling['nomor'] }}</span>
                                    </td>
                                    <td class="py-4 px-4 text-gray-700 dark:text-gray-300">{{ $kavling['cluster'] }}</td>
                                    <td class="py-4 px-4 text-gray-700 dark:text-gray-300">{{ $kavling['tipe'] }}</td>
                                    <td class="py-4 px-4 text-gray-500">{{ explode('-', $kavling['nomor'])[0] }}</td>
                                    <td class="py-4 px-4">
                                        <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $kavling['status'] === 'Aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                            {{ $kavling['status'] }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <a href="/cluster/1" class="text-primary hover:underline text-xs font-semibold">Lihat Peta</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection