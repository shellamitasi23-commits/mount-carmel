@extends('layouts.master')
@section('title', 'Kelola Pembayaran - Mount Carmel')

@section('content')
<div class="pt-24 min-h-screen bg-gray-50 dark:bg-gray-950">

    <!-- Header -->
    <div class="px-8 xl:px-24 py-12 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center gap-2 text-sm text-gray-400 mb-3">
                <a href="/" class="hover:text-gray-600">Beranda</a>
                <span class="material-icons text-xs">chevron_right</span>
                <span class="text-gray-900 dark:text-white font-medium">Kelola Pembayaran</span>
            </div>
            <h1 class="font-display text-4xl font-bold">Kelola Pembayaran</h1>
            <p class="text-gray-500 mt-2 text-sm">Input pembayaran, pantau status, dan cetak invoice kavling Anda.</p>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="px-8 xl:px-24 py-8" x-data="{ tab: 'input' }">
        <div class="max-w-7xl mx-auto">

            <div class="flex gap-1 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-1 mb-8 w-fit">
                @foreach([
                    ['key' => 'input', 'label' => 'Input Pembayaran', 'icon' => 'payments'],
                    ['key' => 'status', 'label' => 'Status Pembayaran', 'icon' => 'receipt_long'],
                    ['key' => 'invoice', 'label' => 'Cetak Invoice', 'icon' => 'print'],
                ] as $t)
                <button @click="tab = '{{ $t['key'] }}'"
                        :class="tab === '{{ $t['key'] }}' ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-900'"
                        class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all">
                    <span class="material-icons text-base">{{ $t['icon'] }}</span>
                    <span class="hidden md:inline">{{ $t['label'] }}</span>
                </button>
                @endforeach
            </div>

            <!-- TAB: Input Pembayaran -->
            <div x-show="tab === 'input'" x-transition>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-8">
                            <h2 class="font-display text-2xl font-bold mb-2">Input Pembayaran</h2>
                            <p class="text-sm text-gray-500 mb-8">Lengkapi detail pembayaran untuk reservasi yang sudah dikonfirmasi.</p>

                            <form class="space-y-6">
                                @csrf
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Pilih Reservasi</label>
                                    <select class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                                        <option>RSV-2024-001 - Bpk. Ahmad Santoso - Rp 120.000.000</option>
                                    </select>
                                </div>

                                <!-- Ringkasan Tagihan -->
                                <div class="bg-primary/5 border border-primary/20 rounded-2xl p-5">
                                    <h3 class="font-bold text-sm mb-4 text-primary uppercase tracking-wider">Ringkasan Tagihan</h3>
                                    <div class="space-y-2">
                                        @foreach([
                                            ['label' => 'Harga Kavling', 'value' => 'Rp 120.000.000'],
                                            ['label' => 'Biaya Administrasi', 'value' => 'Rp 500.000'],
                                            ['label' => 'Biaya Perawatan (1 Tahun)', 'value' => 'Rp 2.000.000'],
                                        ] as $row)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-500">{{ $row['label'] }}</span>
                                            <span class="font-medium">{{ $row['value'] }}</span>
                                        </div>
                                        @endforeach
                                        <div class="border-t border-primary/20 pt-2 flex justify-between font-bold">
                                            <span>Total Pembayaran</span>
                                            <span class="text-primary text-lg">Rp 122.500.000</span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Metode Pembayaran</label>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        @foreach([
                                            ['label' => 'Transfer Bank', 'icon' => 'account_balance', 'value' => 'transfer'],
                                            ['label' => 'Virtual Account', 'icon' => 'credit_card', 'value' => 'va'],
                                            ['label' => 'Tunai', 'icon' => 'payments', 'value' => 'cash'],
                                        ] as $method)
                                        <label class="flex items-center gap-3 p-4 border-2 border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer hover:border-primary transition-colors has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                                            <input type="radio" name="metode" value="{{ $method['value'] }}" class="accent-primary" {{ $loop->first ? 'checked' : '' }} />
                                            <span class="material-icons text-primary">{{ $method['icon'] }}</span>
                                            <span class="text-sm font-semibold">{{ $method['label'] }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Tanggal Transfer</label>
                                        <input type="date" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Jumlah Dibayarkan (Rp)</label>
                                        <input type="number" placeholder="122500000" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary" />
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Upload Bukti Transfer</label>
                                    <label class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer hover:border-primary hover:bg-primary/5 transition-all">
                                        <span class="material-icons text-3xl text-gray-300 mb-2">cloud_upload</span>
                                        <span class="text-sm text-gray-400">Klik untuk upload atau drag & drop</span>
                                        <span class="text-xs text-gray-300 mt-1">PNG, JPG, PDF (maks 5MB)</span>
                                        <input type="file" class="hidden" accept=".png,.jpg,.jpeg,.pdf" />
                                    </label>
                                </div>

                                <button type="submit" class="btn-press btn-ripple w-full py-4 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-colors">
                                    Kirim Bukti Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Sidebar Info Rekening -->
                    <div class="space-y-4">
                        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-6">
                            <h3 class="font-bold mb-4">Rekening Tujuan</h3>
                            <div class="space-y-4">
                                @foreach([
                                    ['bank' => 'Bank BCA', 'no' => '1234 5678 9012', 'atas' => 'PT Mount Carmel Madinah'],
                                    ['bank' => 'Bank Mandiri', 'no' => '9876 5432 1098', 'atas' => 'PT Mount Carmel Madinah'],
                                    ['bank' => 'Bank BRI', 'no' => '0001 0102 1234 567', 'atas' => 'PT Mount Carmel Madinah'],
                                ] as $rek)
                                <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ $rek['bank'] }}</p>
                                    <p class="font-bold text-gray-900 dark:text-white tracking-wider">{{ $rek['no'] }}</p>
                                    <p class="text-xs text-gray-500 mt-1">a.n. {{ $rek['atas'] }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-2xl p-5">
                            <h3 class="font-bold text-amber-800 dark:text-amber-400 mb-2 flex items-center gap-2">
                                <span class="material-icons text-base">warning</span> Perhatian
                            </h3>
                            <p class="text-xs text-amber-700 dark:text-amber-400 leading-relaxed">Transfer sesuai nominal tagihan. Pembayaran kurang tidak akan diproses. Konfirmasi dalam waktu 1x24 jam setelah transfer.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: Status Pembayaran -->
            <div x-show="tab === 'status'" style="display:none" x-transition>
                @php
                $payments = [
                    ['id' => 'PAY-2024-001', 'rsv' => 'RSV-2024-001', 'nama' => 'Bpk. Ahmad Santoso', 'jumlah' => 'Rp 122.500.000', 'metode' => 'Transfer BCA', 'status' => 'lunas', 'tanggal' => '20 Jan 2024'],
                    ['id' => 'PAY-2024-002', 'rsv' => 'RSV-2024-002', 'nama' => 'Ibu Sari Wulandari', 'jumlah' => 'Rp 61.250.000', 'metode' => 'Transfer Mandiri', 'status' => 'dp', 'tanggal' => '12 Okt 2024'],
                    ['id' => 'PAY-2024-003', 'rsv' => 'RSV-2024-003', 'nama' => 'Bpk. Darmawan', 'jumlah' => 'Rp 15.000.000', 'metode' => '-', 'status' => 'belum', 'tanggal' => '-'],
                ];
                $statusPay = [
                    'lunas' => ['label' => 'Lunas', 'color' => 'emerald', 'icon' => 'check_circle'],
                    'dp' => ['label' => 'DP Dibayar', 'color' => 'blue', 'icon' => 'schedule'],
                    'belum' => ['label' => 'Belum Bayar', 'color' => 'red', 'icon' => 'cancel'],
                ];
                @endphp

                <div class="space-y-4">
                    @foreach($payments as $pay)
                    @php $s = $statusPay[$pay['status']]; @endphp
                    <div data-aos="fade-up" class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-6">
                        <div class="flex flex-col md:flex-row md:items-center gap-4">
                            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                                <span class="material-icons text-primary">receipt</span>
                            </div>
                            <div class="flex-grow">
                                <div class="flex flex-wrap items-center gap-3 mb-2">
                                    <span class="font-bold font-display text-primary">{{ $pay['id'] }}</span>
                                    <span class="text-xs text-gray-400">{{ $pay['rsv'] }}</span>
                                    <span class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1 rounded-full bg-{{ $s['color'] }}-100 text-{{ $s['color'] }}-700">
                                        <span class="material-icons text-xs">{{ $s['icon'] }}</span> {{ $s['label'] }}
                                    </span>
                                </div>
                                <p class="font-semibold text-gray-900 dark:text-white text-sm mb-1">{{ $pay['nama'] }}</p>
                                <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                                    <span><span class="material-icons text-xs mr-1">payments</span>{{ $pay['jumlah'] }}</span>
                                    <span><span class="material-icons text-xs mr-1">credit_card</span>{{ $pay['metode'] }}</span>
                                    @if($pay['tanggal'] !== '-') <span><span class="material-icons text-xs mr-1">calendar_today</span>{{ $pay['tanggal'] }}</span> @endif
                                </div>
                            </div>
                            <div class="flex gap-2 shrink-0">
                                @if($pay['status'] === 'lunas')
                                <button @click="tab = 'invoice'" class="btn-press px-4 py-2 bg-primary text-white rounded-xl text-sm font-semibold flex items-center gap-1">
                                    <span class="material-icons text-sm">print</span> Invoice
                                </button>
                                @elseif($pay['status'] === 'belum')
                                <button @click="tab = 'input'" class="btn-press px-4 py-2 bg-amber-500 text-white rounded-xl text-sm font-semibold">Bayar Sekarang</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- TAB: Cetak Invoice -->
            <div x-show="tab === 'invoice'" style="display:none" x-transition>
                <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl overflow-hidden max-w-3xl">
                    <!-- Invoice Header -->
                    <div class="bg-gray-900 dark:bg-gray-950 p-8 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center">
                                <span class="material-icons text-white text-sm">park</span>
                            </div>
                            <div>
                                <p class="font-display text-white font-bold text-lg">Mount Carmel</p>
                                <p class="text-gray-400 text-xs">Cluster Madinah, Indonesia</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-primary font-bold text-xl font-display">INVOICE</p>
                            <p class="text-gray-400 text-sm">#PAY-2024-001</p>
                        </div>
                    </div>

                    <!-- Invoice Body -->
                    <div class="p-8">
                        <div class="grid grid-cols-2 gap-8 mb-8">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Ditagihkan Kepada</p>
                                <p class="font-semibold text-gray-900 dark:text-white">Keluarga Ahmad Santoso</p>
                                <p class="text-sm text-gray-500">Jl. Merpati No. 12, Jakarta Selatan</p>
                                <p class="text-sm text-gray-500">+62 812 3456 7890</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Detail Invoice</p>
                                <div class="space-y-1 text-sm">
                                    <div class="flex justify-end gap-4"><span class="text-gray-400">Tgl. Invoice:</span><span class="font-medium">20 Jan 2024</span></div>
                                    <div class="flex justify-end gap-4"><span class="text-gray-400">Tgl. Jatuh Tempo:</span><span class="font-medium">27 Jan 2024</span></div>
                                    <div class="flex justify-end gap-4"><span class="text-gray-400">Status:</span><span class="font-bold text-emerald-600">LUNAS</span></div>
                                </div>
                            </div>
                        </div>

                        <!-- Item Table -->
                        <table class="w-full text-sm mb-8">
                            <thead>
                                <tr class="border-b-2 border-gray-900 dark:border-white">
                                    <th class="text-left py-3 font-bold text-xs uppercase tracking-wider">Deskripsi</th>
                                    <th class="text-right py-3 font-bold text-xs uppercase tracking-wider">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach([
                                    ['desc' => 'Kavling A-001 - Tipe Sakinah (7m × 8m)', 'sub' => 'Cluster Madinah, Zona A', 'amount' => 'Rp 120.000.000'],
                                    ['desc' => 'Biaya Administrasi', 'sub' => 'Satu kali bayar', 'amount' => 'Rp 500.000'],
                                    ['desc' => 'Biaya Perawatan Tahunan', 'sub' => 'Periode Jan 2024 - Jan 2025', 'amount' => 'Rp 2.000.000'],
                                ] as $item)
                                <tr>
                                    <td class="py-4">
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $item['desc'] }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $item['sub'] }}</p>
                                    </td>
                                    <td class="py-4 text-right font-semibold">{{ $item['amount'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="border-t-2 border-gray-900 dark:border-white">
                                    <td class="pt-4 font-bold text-base">Total</td>
                                    <td class="pt-4 text-right font-bold text-primary text-xl">Rp 122.500.000</td>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Payment Info -->
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-5 mb-8 flex items-center gap-4">
                            <span class="material-icons text-emerald-500 text-3xl">check_circle</span>
                            <div>
                                <p class="font-bold text-sm">Pembayaran Diterima</p>
                                <p class="text-xs text-gray-500">Transfer BCA · 20 Januari 2024 · Rp 122.500.000</p>
                            </div>
                        </div>

                        <!-- Footer Note -->
                        <p class="text-xs text-gray-400 text-center mb-6">Terima kasih atas kepercayaan Anda kepada Mount Carmel Cluster Madinah. Dokumen ini adalah bukti pembayaran yang sah.</p>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <button onclick="window.print()" class="btn-press btn-ripple flex-1 py-3.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-bold rounded-xl flex items-center justify-center gap-2 hover:bg-gray-800 transition-colors">
                                <span class="material-icons">print</span> Cetak Invoice
                            </button>
                            <button class="btn-press px-6 py-3.5 border border-gray-200 dark:border-gray-700 rounded-xl font-bold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors flex items-center gap-2">
                                <span class="material-icons text-sm">download</span> Unduh PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection