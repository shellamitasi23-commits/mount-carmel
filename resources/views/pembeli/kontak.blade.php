@extends('layouts.master')
@section('title', 'Kontak — Mount Carmel')

@section('content')
<div class="min-h-screen bg-[#F3F4F6] pt-28 pb-20">
<div class="max-w-6xl mx-auto px-6">

    {{-- Header --}}
    <div class="text-center mb-14" data-aos="fade-up">
        <p class="text-xs font-bold tracking-[0.2em] text-amber-500 uppercase mb-3">Hubungi Kami</p>
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Kami Siap Membantu Anda</h1>
        <p class="text-gray-500 text-base max-w-xl mx-auto leading-relaxed">
            Jangan ragu untuk menghubungi tim kami. Layanan tersedia 24 jam untuk membantu kebutuhan pemakaman keluarga Anda.
        </p>
    </div>

    {{-- Kartu Info Kontak --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-12">

        {{-- Telepon & WhatsApp --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center text-center hover:shadow-md transition-all duration-300"
             data-aos="fade-up" data-aos-delay="0">
            <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center mb-4">
                <span class="material-icons text-green-600 text-2xl">phone</span>
            </div>
            <h3 class="font-bold text-gray-900 mb-2">Telepon & WhatsApp</h3>
            <p class="text-gray-400 text-xs mb-3">Tersedia 24 jam, 7 hari</p>
            <a href="tel:+628111234567"
               class="font-bold text-gray-900 hover:text-green-600 transition-colors text-sm block mb-1">
                +62 811 1234 567
            </a>
            <a href="https://wa.me/628111234567" target="_blank"
               class="inline-flex items-center gap-1.5 mt-2 px-4 py-2 bg-green-50 text-green-700 rounded-xl text-xs font-bold hover:bg-green-100 transition-colors">
                <span class="material-icons text-sm">chat</span> Chat WhatsApp
            </a>
        </div>

        {{-- Email --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center text-center hover:shadow-md transition-all duration-300"
             data-aos="fade-up" data-aos-delay="100">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center mb-4">
                <span class="material-icons text-blue-600 text-2xl">email</span>
            </div>
            <h3 class="font-bold text-gray-900 mb-2">Email</h3>
            <p class="text-gray-400 text-xs mb-3">Respon dalam 1×24 jam kerja</p>
            <a href="mailto:info@mountcarmel.id"
               class="font-bold text-gray-900 hover:text-blue-600 transition-colors text-sm block mb-1">
                info@mountcarmel.id
            </a>
            <a href="mailto:cs@mountcarmel.id"
               class="font-bold text-gray-900 hover:text-blue-600 transition-colors text-sm block">
                cs@mountcarmel.id
            </a>
        </div>

        {{-- Alamat --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center text-center hover:shadow-md transition-all duration-300"
             data-aos="fade-up" data-aos-delay="200">
            <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center mb-4">
                <span class="material-icons text-red-500 text-2xl">location_on</span>
            </div>
            <h3 class="font-bold text-gray-900 mb-2">Lokasi</h3>
            <p class="text-gray-400 text-xs mb-3">Senin–Minggu, 08.00–17.00 WIB</p>
            <p class="text-sm text-gray-700 font-medium leading-relaxed">
                Jl. Raya Cirebon – Bandung Km. 12<br>
                Jawa Barat, Indonesia
            </p>
            <a href="https://maps.google.com/?q=Jl.+Raya+Cirebon+Bandung+Km.12+Jawa+Barat" target="_blank"
               class="inline-flex items-center gap-1.5 mt-3 px-4 py-2 bg-red-50 text-red-600 rounded-xl text-xs font-bold hover:bg-red-100 transition-colors">
                <span class="material-icons text-sm">map</span> Buka Maps
            </a>
        </div>

    </div>

    {{-- Grid: Form + Peta --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">

        {{-- Form Kirim Pesan --}}
        <div data-aos="fade-right">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Kirim Pesan</h2>
                <p class="text-gray-400 text-sm mb-6">Isi form di bawah dan tim kami akan segera menghubungi Anda.</p>

                @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-4 rounded-xl text-sm font-medium flex items-start gap-3">
                    <span class="material-icons text-sm mt-0.5">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                    <ul class="text-red-700 text-sm space-y-1">
                        @foreach($errors->all() as $err)
                        <li class="flex items-center gap-2">
                            <span class="material-icons text-sm">error_outline</span>{{ $err }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('kontak.send') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                                Nama Lengkap <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="nama" value="{{ old('nama', auth()->user()?->name) }}"
                                required placeholder="Nama Anda"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 transition-all placeholder:text-gray-400">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                                No. Telepon
                            </label>
                            <input type="text" name="telepon" value="{{ old('telepon', auth()->user()?->no_telepon) }}"
                                placeholder="08xx-xxxx-xxxx"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 transition-all placeholder:text-gray-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Email <span class="text-red-400">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}"
                            required placeholder="email@anda.com"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 transition-all placeholder:text-gray-400">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Subjek <span class="text-red-400">*</span>
                        </label>
                        <select name="subjek"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 transition-all">
                            <option value="" disabled {{ old('subjek') ? '' : 'selected' }}>-- Pilih Subjek --</option>
                            <option value="Informasi Kavling" {{ old('subjek') === 'Informasi Kavling' ? 'selected' : '' }}>Informasi Kavling</option>
                            <option value="Informasi Harga" {{ old('subjek') === 'Informasi Harga' ? 'selected' : '' }}>Informasi Harga</option>
                            <option value="Proses Reservasi" {{ old('subjek') === 'Proses Reservasi' ? 'selected' : '' }}>Proses Reservasi</option>
                            <option value="Status Pembayaran" {{ old('subjek') === 'Status Pembayaran' ? 'selected' : '' }}>Status Pembayaran</option>
                            <option value="Kunjungan Lokasi" {{ old('subjek') === 'Kunjungan Lokasi' ? 'selected' : '' }}>Kunjungan Lokasi</option>
                            <option value="Lainnya" {{ old('subjek') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                            Pesan <span class="text-red-400">*</span>
                        </label>
                        <textarea name="pesan" rows="5" required
                            placeholder="Tulis pesan atau pertanyaan Anda di sini..."
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 transition-all resize-none placeholder:text-gray-400">{{ old('pesan') }}</textarea>
                    </div>

                    <button type="submit"
                        class="btn-press btn-ripple w-full bg-gray-900 hover:bg-gray-800 text-white py-3.5 rounded-xl font-bold text-sm transition-colors shadow-lg shadow-gray-900/20 flex items-center justify-center gap-2">
                        <span class="material-icons text-sm">send</span>
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>

        {{-- Peta + Info Jam Operasional --}}
        <div class="flex flex-col gap-5" data-aos="fade-left">

            {{-- Peta Embed --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-50">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <span class="material-icons text-red-500 text-base">location_on</span>
                        Lokasi Kami
                    </h3>
                </div>
                <div class="w-full" style="height: 280px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.5!2d108.5!3d-6.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f1f66a13ef021%3A0xdbec2f3c2b78e0d6!2sCirebon%2C+West+Java!5e0!3m2!1sen!2sid!4v1"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="p-5 border-t border-gray-50">
                    <p class="text-sm text-gray-600 font-medium">Jl. Raya Cirebon – Bandung Km. 12</p>
                    <p class="text-xs text-gray-400 mt-0.5">Jawa Barat, Indonesia</p>
                    <a href="https://maps.google.com/?q=Jl.+Raya+Cirebon+Bandung+Km.12+Jawa+Barat" target="_blank"
                       class="inline-flex items-center gap-1.5 mt-3 text-xs font-bold text-gray-500 hover:text-gray-900 transition-colors">
                        <span class="material-icons text-sm">open_in_new</span> Buka di Google Maps
                    </a>
                </div>
            </div>

            {{-- Jam Operasional --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-icons text-amber-500 text-base">schedule</span>
                    Jam Operasional
                </h3>
                <div class="space-y-3">
                    @foreach([
                        ['hari' => 'Senin – Jumat',  'jam' => '08.00 – 17.00 WIB', 'buka' => true],
                        ['hari' => 'Sabtu',           'jam' => '08.00 – 15.00 WIB', 'buka' => true],
                        ['hari' => 'Minggu & Hari Libur', 'jam' => '09.00 – 13.00 WIB', 'buka' => true],
                        ['hari' => 'Layanan Darurat', 'jam' => '24 Jam',             'buka' => true],
                    ] as $jadwal)
                    <div class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0">
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-1.5 rounded-full {{ $jadwal['buka'] ? 'bg-emerald-500' : 'bg-red-400' }}"></div>
                            <span class="text-sm text-gray-700 font-medium">{{ $jadwal['hari'] }}</span>
                        </div>
                        <span class="text-sm font-bold text-gray-900">{{ $jadwal['jam'] }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- Info layanan darurat --}}
                <div class="mt-4 bg-amber-50 border border-amber-100 rounded-xl px-4 py-3 flex items-start gap-2">
                    <span class="material-icons text-amber-500 text-sm mt-0.5">info</span>
                    <p class="text-xs text-amber-700">
                        Untuk kebutuhan pemakaman darurat di luar jam operasional, hubungi hotline 24 jam kami di
                        <a href="tel:+628111234567" class="font-bold hover:underline">+62 811 1234 567</a>
                    </p>
                </div>
            </div>

           
            </div>

        </div>
    </div>

</div>
</div>
@endsection