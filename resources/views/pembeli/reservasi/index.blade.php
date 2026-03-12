@extends('layouts.master')
@section('title', 'Kelola Reservasi - Mount Carmel')

@section('content')
<div class="pt-24 min-h-screen bg-gray-50 dark:bg-gray-950">

    <!-- Header -->
    <div class="px-8 xl:px-24 py-12 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center gap-2 text-sm text-gray-400 mb-3">
                <a href="/" class="hover:text-gray-600">Beranda</a>
                <span class="material-icons text-xs">chevron_right</span>
                <span class="text-gray-900 dark:text-white font-medium">Kelola Reservasi</span>
            </div>
            <h1 class="font-display text-4xl font-bold">Kelola Reservasi</h1>
            <p class="text-gray-500 mt-2 text-sm">Isi form, upload dokumen, dan pantau status reservasi kavling Anda.</p>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="px-8 xl:px-24 py-8" x-data="{ tab: 'form' }">
        <div class="max-w-7xl mx-auto">

            <div class="flex gap-1 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-1 mb-8 w-fit">
                @foreach([
                    ['key' => 'form', 'label' => 'Mengisi Form', 'icon' => 'edit_note'],
                    ['key' => 'dokumen', 'label' => 'Upload Dokumen', 'icon' => 'upload_file'],
                    ['key' => 'status', 'label' => 'Status Reservasi', 'icon' => 'pending_actions'],
                    ['key' => 'konfirmasi', 'label' => 'Konfirmasi', 'icon' => 'verified'],
                ] as $t)
                <button @click="tab = '{{ $t['key'] }}'"
                        :class="tab === '{{ $t['key'] }}' ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-900'"
                        class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all">
                    <span class="material-icons text-base">{{ $t['icon'] }}</span>
                    <span class="hidden md:inline">{{ $t['label'] }}</span>
                </button>
                @endforeach
            </div>

            <!-- Progress Indicator -->
            <div class="flex items-center gap-3 mb-8 overflow-x-auto pb-2">
                @php $steps = ['Form Reservasi', 'Upload Dokumen', 'Review Admin', 'Konfirmasi Pembelian']; @endphp
                @foreach($steps as $i => $step)
                <div class="flex items-center gap-3 shrink-0">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold {{ $i === 0 ? 'bg-primary text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500' }}">
                            {{ $i + 1 }}
                        </div>
                        <span class="text-sm font-medium {{ $i === 0 ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">{{ $step }}</span>
                    </div>
                    @if(!$loop->last)
                    <span class="material-icons text-gray-300 dark:text-gray-700">arrow_forward</span>
                    @endif
                </div>
                @endforeach
            </div>

            <!-- TAB: Form Reservasi -->
            <div x-show="tab === 'form'" x-transition>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-8">
                            <h2 class="font-display text-2xl font-bold mb-6">Form Reservasi Kavling</h2>
                            <form class="space-y-6">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Nama Lengkap Almarhum/ah</label>
                                        <input type="text" placeholder="Masukkan nama lengkap"
                                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Tanggal Lahir</label>
                                        <input type="date"
                                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Tanggal Wafat</label>
                                        <input type="date"
                                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Agama</label>
                                        <select class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                                            <option>Islam</option>
                                            <option>Kristen</option>
                                            <option>Katolik</option>
                                            <option>Buddha</option>
                                            <option>Hindu</option>
                                            <option>Konghucu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Pilih Cluster</label>
                                        <select class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                                            <option>Cluster Madinah (Muslim)</option>
                                            <option>Cluster Carmel Hijau (Non-Muslim)</option>
                                            <option>Cluster Sakura (Non-Muslim)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Tipe Kavling</label>
                                        <select class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                                            <option>Tipe Barokah (1.5m × 2.5m)</option>
                                            <option>Tipe Fitrah (4m × 3m)</option>
                                            <option>Tipe Sakinah (7m × 8m)</option>
                                            <option>Tipe Khalifah (7m × 15m)</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Nama Kontak / Penanggung Jawab</label>
                                    <input type="text" placeholder="Nama penanggung jawab keluarga"
                                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Nomor Telepon</label>
                                    <input type="tel" placeholder="+62 8xx xxxx xxxx"
                                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Catatan Tambahan</label>
                                    <textarea rows="3" placeholder="Informasi tambahan yang perlu diketahui..."
                                              class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none"></textarea>
                                </div>
                                <div class="flex gap-3">
                                    <button type="submit" class="btn-press btn-ripple flex-1 py-3.5 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-colors">
                                        Simpan & Lanjut Upload Dokumen
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Sidebar Info -->
                    <div class="space-y-4">
                        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-6">
                            <h3 class="font-bold mb-4 flex items-center gap-2"><span class="material-icons text-primary text-base">info</span> Informasi Penting</h3>
                            <ul class="space-y-3 text-sm text-gray-500">
                                <li class="flex items-start gap-2"><span class="material-icons text-emerald-500 text-sm mt-0.5">check</span> Reservasi akan dikonfirmasi dalam 1x24 jam kerja</li>
                                <li class="flex items-start gap-2"><span class="material-icons text-emerald-500 text-sm mt-0.5">check</span> Dokumen identitas asli diperlukan saat kunjungan</li>
                                <li class="flex items-start gap-2"><span class="material-icons text-emerald-500 text-sm mt-0.5">check</span> Pilihan kavling sesuai ketersediaan saat konfirmasi</li>
                                <li class="flex items-start gap-2"><span class="material-icons text-amber-500 text-sm mt-0.5">schedule</span> Form yang tidak dilengkapi dokumen dalam 3 hari akan dibatalkan</li>
                            </ul>
                        </div>
                        <div class="bg-primary/5 border border-primary/20 rounded-2xl p-6">
                            <h3 class="font-bold mb-2 text-primary">Butuh Bantuan?</h3>
                            <p class="text-sm text-gray-500 mb-4">Tim kami siap membantu proses reservasi Anda.</p>
                            <a href="tel:+6280000000000" class="flex items-center gap-2 text-sm font-semibold text-primary">
                                <span class="material-icons text-base">phone</span> +62 800 0000 0000
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: Upload Dokumen -->
            <div x-show="tab === 'dokumen'" style="display:none" x-transition>
                <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-8 max-w-3xl">
                    <h2 class="font-display text-2xl font-bold mb-2">Upload Dokumen</h2>
                    <p class="text-gray-500 text-sm mb-8">Upload dokumen yang diperlukan untuk melengkapi proses reservasi.</p>

                    <div class="space-y-4">
                        @php
                        $docs = [
                            ['label' => 'KTP Penanggung Jawab', 'desc' => 'Scan/foto KTP yang masih berlaku', 'required' => true, 'status' => 'belum'],
                            ['label' => 'Surat Kematian', 'desc' => 'Surat kematian resmi dari instansi berwenang', 'required' => true, 'status' => 'uploaded'],
                            ['label' => 'Kartu Keluarga', 'desc' => 'KK terbaru untuk verifikasi hubungan keluarga', 'required' => true, 'status' => 'belum'],
                            ['label' => 'Surat Keterangan Agama', 'desc' => 'Diperlukan untuk cluster Muslim', 'required' => false, 'status' => 'belum'],
                        ];
                        @endphp

                        @foreach($docs as $doc)
                        <div class="border border-gray-100 dark:border-gray-800 rounded-2xl p-5 flex items-center gap-5">
                            <div class="w-12 h-12 rounded-xl {{ $doc['status'] === 'uploaded' ? 'bg-emerald-100' : 'bg-gray-100 dark:bg-gray-800' }} flex items-center justify-center shrink-0">
                                <span class="material-icons {{ $doc['status'] === 'uploaded' ? 'text-emerald-600' : 'text-gray-400' }}">
                                    {{ $doc['status'] === 'uploaded' ? 'check_circle' : 'description' }}
                                </span>
                            </div>
                            <div class="flex-grow">
                                <div class="flex items-center gap-2 mb-1">
                                    <h4 class="font-semibold text-sm">{{ $doc['label'] }}</h4>
                                    @if($doc['required']) <span class="text-xs text-red-500 font-bold">*Wajib</span> @endif
                                    @if($doc['status'] === 'uploaded') <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-bold">Terupload</span> @endif
                                </div>
                                <p class="text-xs text-gray-400">{{ $doc['desc'] }}</p>
                            </div>
                            <label class="btn-press shrink-0 px-4 py-2 {{ $doc['status'] === 'uploaded' ? 'border border-gray-200 dark:border-gray-700 text-gray-500' : 'bg-primary text-white' }} rounded-xl text-sm font-semibold cursor-pointer hover:opacity-90 transition-opacity">
                                {{ $doc['status'] === 'uploaded' ? 'Ganti' : 'Upload' }}
                                <input type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png" />
                            </label>
                        </div>
                        @endforeach

                        <button class="btn-press btn-ripple w-full py-3.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-bold rounded-xl hover:bg-gray-800 transition-colors mt-4">
                            Kirim Dokumen untuk Direview
                        </button>
                    </div>
                </div>
            </div>

            <!-- TAB: Status Reservasi -->
            <div x-show="tab === 'status'" style="display:none" x-transition>
                <div class="space-y-4">
                    @php
                    $reservasis = [
                        ['id' => 'RSV-2024-001', 'nama' => 'Bpk. Ahmad Santoso', 'cluster' => 'Cluster Madinah', 'tipe' => 'Tipe Sakinah', 'status' => 'confirmed', 'tanggal' => '15 Jan 2024'],
                        ['id' => 'RSV-2024-002', 'nama' => 'Ibu Sari Wulandari', 'cluster' => 'Cluster Carmel Hijau', 'tipe' => 'Family', 'status' => 'review', 'tanggal' => '10 Okt 2024'],
                        ['id' => 'RSV-2024-003', 'nama' => 'Bpk. Darmawan', 'cluster' => 'Cluster Madinah', 'tipe' => 'Tipe Barokah', 'status' => 'pending', 'tanggal' => '01 Nov 2024'],
                    ];
                    $statusMap = [
                        'confirmed' => ['label' => 'Dikonfirmasi', 'color' => 'emerald', 'icon' => 'verified'],
                        'review' => ['label' => 'Sedang Direview', 'color' => 'blue', 'icon' => 'manage_search'],
                        'pending' => ['label' => 'Menunggu Dokumen', 'color' => 'amber', 'icon' => 'pending'],
                    ];
                    @endphp

                    @foreach($reservasis as $rsv)
                    @php $s = $statusMap[$rsv['status']]; @endphp
                    <div data-aos="fade-up" class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-6">
                        <div class="flex flex-col md:flex-row md:items-center gap-4">
                            <div class="flex-grow">
                                <div class="flex flex-wrap items-center gap-3 mb-2">
                                    <span class="font-bold text-primary font-display">{{ $rsv['id'] }}</span>
                                    <span class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1 rounded-full bg-{{ $s['color'] }}-100 text-{{ $s['color'] }}-700">
                                        <span class="material-icons text-xs">{{ $s['icon'] }}</span> {{ $s['label'] }}
                                    </span>
                                </div>
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $rsv['nama'] }}</h3>
                                <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                                    <span><span class="material-icons text-xs mr-1">location_on</span>{{ $rsv['cluster'] }}</span>
                                    <span><span class="material-icons text-xs mr-1">category</span>{{ $rsv['tipe'] }}</span>
                                    <span><span class="material-icons text-xs mr-1">calendar_today</span>{{ $rsv['tanggal'] }}</span>
                                </div>
                            </div>
                            <div class="flex gap-2 shrink-0">
                                @if($rsv['status'] === 'pending')
                                <a href="#" x-data @click.prevent="$dispatch('change-tab', 'dokumen')" class="btn-press px-4 py-2 bg-amber-500 text-white rounded-xl text-sm font-semibold">Upload Dokumen</a>
                                @endif
                                @if($rsv['status'] === 'confirmed')
                                <a href="/pembayaran" class="btn-press px-4 py-2 bg-primary text-white rounded-xl text-sm font-semibold">Bayar Sekarang</a>
                                @endif
                                <button class="btn-press px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors">Detail</button>
                            </div>
                        </div>

                        <!-- Progress Bar Status -->
                        <div class="mt-5 pt-4 border-t border-gray-50 dark:border-gray-800">
                            <div class="flex items-center gap-2">
                                @foreach(['Form', 'Dokumen', 'Review', 'Konfirmasi'] as $si => $step)
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full
                                        {{ ($rsv['status'] === 'confirmed' && $si <= 3) || ($rsv['status'] === 'review' && $si <= 2) || ($rsv['status'] === 'pending' && $si <= 0) ? 'bg-primary' : 'bg-gray-200 dark:bg-gray-700' }}">
                                    </div>
                                    <span class="text-xs text-gray-400 hidden md:inline">{{ $step }}</span>
                                    @if(!$loop->last) <div class="h-px w-8 bg-gray-200 dark:bg-gray-700"></div> @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- TAB: Konfirmasi Pembelian -->
            <div x-show="tab === 'konfirmasi'" style="display:none" x-transition>
                <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-8 max-w-2xl">
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="material-icons text-3xl text-emerald-600">verified</span>
                        </div>
                        <h2 class="font-display text-2xl font-bold">Konfirmasi Pembelian</h2>
                        <p class="text-gray-500 text-sm mt-2">Reservasi RSV-2024-001 telah disetujui. Lanjutkan ke pembayaran.</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-6 mb-6 space-y-3">
                        @foreach([
                            ['label' => 'Nomor Reservasi', 'value' => 'RSV-2024-001'],
                            ['label' => 'Almarhum/ah', 'value' => 'Bpk. Ahmad Santoso'],
                            ['label' => 'Cluster', 'value' => 'Cluster Madinah'],
                            ['label' => 'Tipe Kavling', 'value' => 'Tipe Sakinah (7m × 8m)'],
                            ['label' => 'Nomor Kavling', 'value' => 'A-001'],
                            ['label' => 'Harga', 'value' => 'Rp 120.000.000'],
                        ] as $row)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">{{ $row['label'] }}</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $row['value'] }}</span>
                        </div>
                        @endforeach
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-3 flex justify-between font-bold">
                            <span>Total</span>
                            <span class="text-primary text-lg">Rp 120.000.000</span>
                        </div>
                    </div>

                    <a href="/pembayaran" class="btn-press btn-ripple w-full py-4 bg-primary text-white font-bold rounded-xl text-center block hover:bg-primary/90 transition-colors">
                        Lanjut ke Pembayaran
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection