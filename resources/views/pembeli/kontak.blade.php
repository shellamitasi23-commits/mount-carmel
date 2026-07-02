@extends('layouts.master')
@section('title', 'Kontak — Mount Carmel')

@section('content')
<div class="min-h-screen bg-slate-50 pt-28 pb-20 font-inter">
<div class="max-w-6xl mx-auto px-4 md:px-6">

    {{-- Header --}}
    <div class="text-center mb-12" data-aos="fade-up">
        <p class="text-xs font-semibold tracking-wider text-[#800000] uppercase mb-2 block">Hubungi Kami</p>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">Kami Siap Membantu Anda</h1>
        <p class="text-gray-500 text-xs md:text-sm max-w-lg mx-auto leading-relaxed">
            Jangan ragu untuk menghubungi tim kami. Layanan tersedia 24 jam untuk membantu kebutuhan pemakaman keluarga Anda.
        </p>
    </div>

    {{-- Kartu Info Kontak --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto mb-12">

        {{-- Email --}}
        <div class="group bg-white rounded-3xl border border-slate-100/80 shadow-sm p-6 flex flex-col items-center text-center hover:shadow-md hover:border-slate-200/50 hover:-translate-y-0.5 transition-all duration-300"
             data-aos="fade-up" data-aos-delay="100">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mb-4 group-hover:scale-105 transition-transform duration-300">
                <span class="material-icons text-blue-600 text-xl">email</span>
            </div>
            <h3 class="font-semibold text-gray-900 text-base mb-1">Email</h3>
            <p class="text-gray-400 text-[10px] mb-3">Respon dalam 1×24 jam kerja</p>
            <a href="mailto:info@mountcarmel.id"
               class="font-medium text-gray-700 hover:text-[#800000] transition-colors text-xs block mb-0.5">
                info@mountcarmel.id
            </a>
            <a href="mailto:cs@mountcarmel.id"
               class="font-medium text-gray-700 hover:text-[#800000] transition-colors text-xs block">
                cs@mountcarmel.id
            </a>
        </div>

        {{-- Alamat --}}
        <div class="group bg-white rounded-3xl border border-slate-100/80 shadow-sm p-6 flex flex-col items-center text-center hover:shadow-md hover:border-slate-200/50 hover:-translate-y-0.5 transition-all duration-300"
             data-aos="fade-up" data-aos-delay="200">
            <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center mb-4 group-hover:scale-105 transition-transform duration-300">
                <span class="material-icons text-red-500 text-xl">location_on</span>
            </div>
            <h3 class="font-semibold text-gray-900 text-base mb-1">Lokasi</h3>
            <p class="text-gray-400 text-[10px] mb-3">Senin–Minggu, 08.00–17.00 WIB</p>
            <p class="text-xs text-gray-600 leading-relaxed mb-3">
                Jl. Raya Cirebon – Bandung Km. 12<br>
                Jawa Barat, Indonesia
            </p>
            <a href="https://maps.google.com/?q=Jl.+Raya+Cirebon+Bandung+Km.12+Jawa+Barat" target="_blank"
               class="inline-flex items-center gap-1 px-4 py-1.5 bg-red-50 text-red-600 rounded-lg text-[10px] font-semibold hover:bg-red-100 transition-colors shadow-sm">
                <span class="material-icons text-xs">map</span> Buka Maps
            </a>
        </div>

    </div>

    {{-- Grid: Form + Peta --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">

        {{-- Form Kirim Pesan --}}
        <div data-aos="fade-right">
            <div class="bg-white rounded-3xl border border-slate-100/80 shadow-sm p-8 md:p-10">
                <h2 class="text-2xl font-bold text-gray-900 font-poppins mb-2">Kirim Pesan</h2>
                <p class="text-gray-400 text-sm mb-8">Isi form di bawah dan tim kami akan segera menghubungi Anda.</p>

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

                <form action="{{ route('kontak.send') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-2">
                                Nama Lengkap <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg">person</span>
                                <input type="text" name="nama" value="{{ old('nama', auth()->user()?->name) }}"
                                    required placeholder="Nama Anda"
                                    class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 outline-none focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 transition-all placeholder:text-gray-400">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-2">
                                No. Telepon
                            </label>
                            <div class="relative">
                                <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg">phone</span>
                                <input type="text" name="telepon" value="{{ old('telepon', auth()->user()?->no_telepon) }}"
                                    placeholder="08xx-xxxx-xxxx"
                                    class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 outline-none focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 transition-all placeholder:text-gray-400">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-2">
                            Email <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg">email</span>
                            <input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}"
                                required placeholder="email@anda.com"
                                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 outline-none focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 transition-all placeholder:text-gray-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-2">
                            Subjek <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg">label</span>
                            <select name="subjek" required
                                class="w-full pl-11 pr-10 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 outline-none focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 transition-all appearance-none cursor-pointer">
                                <option value="" disabled {{ old('subjek') ? '' : 'selected' }}>Pilih Subjek</option>
                                <option value="Informasi Lahan" {{ old('subjek') === 'Informasi Lahan' ? 'selected' : '' }}>Informasi Lahan</option>
                                <option value="Informasi Harga" {{ old('subjek') === 'Informasi Harga' ? 'selected' : '' }}>Informasi Harga</option>
                                <option value="Proses Reservasi" {{ old('subjek') === 'Proses Reservasi' ? 'selected' : '' }}>Proses Reservasi</option>
                                <option value="Status Pembayaran" {{ old('subjek') === 'Status Pembayaran' ? 'selected' : '' }}>Status Pembayaran</option>
                                <option value="Kunjungan Lokasi" {{ old('subjek') === 'Kunjungan Lokasi' ? 'selected' : '' }}>Kunjungan Lokasi</option>
                                <option value="Lainnya" {{ old('subjek') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                                <span class="material-icons">expand_more</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-2">
                            Pesan <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-icons absolute left-4 top-4 text-gray-400 text-lg">message</span>
                            <textarea name="pesan" rows="5" required
                                placeholder="Tulis pesan atau pertanyaan Anda di sini..."
                                class="w-full pl-11 pr-4 pt-3.5 pb-4 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 outline-none focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 transition-all resize-none placeholder:text-gray-400">{{ old('pesan') }}</textarea>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-[#800000] hover:bg-[#800000]/90 text-white py-3 rounded-xl font-semibold text-sm transition-all flex items-center justify-center gap-2 shadow-sm hover:shadow">
                        <span class="material-icons text-sm">send</span>
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>

        {{-- Peta Embed --}}
        <div class="flex flex-col gap-6" data-aos="fade-left">
            <div class="bg-white rounded-3xl border border-slate-100/80 shadow-sm overflow-hidden flex flex-col h-full justify-between">
                <div class="p-6 border-b border-slate-50">
                    <h3 class="font-poppins font-bold text-gray-900 flex items-center gap-2">
                        <span class="material-icons text-red-500 text-base">location_on</span>
                        Lokasi Kami
                    </h3>
                </div>
                <div class="w-full flex-grow min-h-[280px]">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.5!2d108.5!3d-6.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f1f66a13ef021%3A0xdbec2f3c2b78e0d6!2sCirebon%2C+West+Java!5e0!3m2!1sen!2sid!4v1"
                        width="100%" height="100%" style="border:0; min-height: 280px;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="p-6 bg-slate-50/50">
                    <p class="text-sm text-gray-605 font-medium">Jl. Raya Cirebon – Bandung Km. 12</p>
                    <p class="text-xs text-gray-400 mt-0.5">Jawa Barat, Indonesia</p>
                    <a href="https://maps.app.goo.gl/1Fo5UK7722utuz2aA" target="_blank"
                       class="inline-flex items-center gap-1.5 mt-3 text-xs font-bold text-[#800000] hover:text-[#800000]/80 transition-colors">
                        <span class="material-icons text-sm">open_in_new</span> Buka di Google Maps
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- Jam Operasional di Bawah --}}
    <div class="bg-white rounded-3xl border border-slate-100/80 shadow-sm p-8 md:p-10 mb-12" data-aos="fade-up">
        <h3 class="font-semibold text-gray-800 text-base mb-8 flex items-center justify-center gap-2">
            <span class="material-icons text-[#800000] text-xl">schedule</span>
            Jadwal & Jam Operasional
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['hari' => 'Senin – Jumat',  'jam' => '08.00 – 17.00 WIB', 'status' => 'buka', 'icon' => 'calendar_today'],
                ['hari' => 'Sabtu',           'jam' => '08.00 – 15.00 WIB', 'status' => 'buka', 'icon' => 'calendar_today'],
                ['hari' => 'Minggu & Libur',  'jam' => '09.00 – 13.00 WIB', 'status' => 'buka', 'icon' => 'weekend'],
                ['hari' => 'Layanan Darurat', 'jam' => 'Layanan 24 Jam',      'status' => 'darurat', 'icon' => 'contact_support'],
            ] as $jadwal)
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100/80 flex flex-col items-center text-center transition-all hover:bg-white hover:shadow-md duration-300">
                <div class="w-10 h-10 rounded-xl {{ $jadwal['status'] === 'darurat' ? 'bg-[#800000]/10 text-[#800000]' : 'bg-emerald-50 text-emerald-600' }} flex items-center justify-center mb-3">
                    <span class="material-icons text-base">{{ $jadwal['icon'] }}</span>
                </div>
                <span class="text-xs text-gray-400 font-medium mb-1">{{ $jadwal['hari'] }}</span>
                <span class="text-sm font-semibold text-gray-800">{{ $jadwal['jam'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

</div>
</div>
@endsection
