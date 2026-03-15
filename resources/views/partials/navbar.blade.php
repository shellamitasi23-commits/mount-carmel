<nav class="absolute top-6 left-0 w-full z-50">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border border-gray-200 dark:border-gray-700 rounded-full px-6 py-3 flex items-center justify-between shadow-md transition-all duration-300">
            
            <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0 mr-8">
                <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-gray-100 font-display">
                    Mount Carmel
                </span>
            </a>

            {{-- Desktop Nav Links --}}
            <div class="hidden md:flex flex-1 justify-center">
                <ul class="flex items-center space-x-1 lg:space-x-2 bg-gray-100/50 dark:bg-gray-800/50 rounded-full px-2 py-1">
                    <li>
                        <a href="{{ route('home') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-white dark:hover:bg-gray-700 rounded-full transition-all">Home</a>
                    </li>
                    {{-- Menu Cluster --}}
                    <li>
                        <a href="{{ route('cluster.index') }}" class="flex items-center gap-1 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-white dark:hover:bg-gray-700 rounded-full transition-all">
                            Cluster
                        </a>
                    </li>
                    @auth
                    {{-- Menu Kavling --}}
                    <li x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-1 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-white dark:hover:bg-gray-700 rounded-full transition-all">
                            Kavling
                            <span class="material-icons text-xs" :class="open ? 'rotate-180' : ''" style="font-size:14px; transition: transform .2s">expand_more</span>
                        </button>
                        <div x-show="open" x-transition
                             class="absolute top-full left-1/2 -translate-x-1/2 mt-3 w-52 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-xl py-2 z-50">
                            <a href="{{ route('pembeli.kavling.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons text-primary" style="font-size:18px">grid_view</span> Kelola Kavling
                            </a>
                            <a href="{{ route('pembeli.kavling.index', ['tab' => 'ketersediaan']) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons text-primary" style="font-size:18px">fact_check</span> Cek Ketersediaan
                            </a>
                            <a href="{{ route('pembeli.kavling.index', ['tab' => 'nomor']) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons text-primary" style="font-size:18px">tag</span> Nomor Kavling
                            </a>
                        </div>
                    </li>
                    
                    {{-- Menu Reservasi --}}
                    <li x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-1 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-white dark:hover:bg-gray-700 rounded-full transition-all">
                            Reservasi
                            <span class="material-icons" :class="open ? 'rotate-180' : ''" style="font-size:14px; transition: transform .2s">expand_more</span>
                        </button>
                        <div x-show="open" x-transition
                             class="absolute top-full left-1/2 -translate-x-1/2 mt-3 w-52 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-xl py-2 z-50">
                            <a href="{{ route('pembeli.reservasi.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons text-primary" style="font-size:18px">edit_note</span> Buat Reservasi
                            </a>
                            <a href="{{ route('pembeli.reservasi.index', ['tab' => 'status']) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons text-primary" style="font-size:18px">pending_actions</span> Status Reservasi
                            </a>
                            <a href="{{ route('pembeli.reservasi.index', ['tab' => 'dokumen']) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons text-primary" style="font-size:18px">upload_file</span> Upload Dokumen
                            </a>
                        </div>
                    </li>
                    
                    {{-- Menu Pembayaran --}}
                    <li x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-1 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-white dark:hover:bg-gray-700 rounded-full transition-all">
                            Pembayaran
                            <span class="material-icons" :class="open ? 'rotate-180' : ''" style="font-size:14px; transition: transform .2s">expand_more</span>
                        </button>
                        <div x-show="open" x-transition
                             class="absolute top-full left-1/2 -translate-x-1/2 mt-3 w-52 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-xl py-2 z-50">
                            <a href="{{ route('pembeli.pembayaran.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons text-primary" style="font-size:18px">payments</span> Input Pembayaran
                            </a>
                            <a href="{{ route('pembeli.pembayaran.index', ['tab' => 'status']) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons text-primary" style="font-size:18px">receipt_long</span> Status Pembayaran
                            </a>
                            <a href="{{ route('pembeli.pembayaran.index', ['tab' => 'invoice']) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons text-primary" style="font-size:18px">print</span> Cetak Invoice
                            </a>
                        </div>
                    </li>
                    @endauth
                    
                    <li>
                        <a href="#kontak" class="block px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-white dark:hover:bg-gray-700 rounded-full transition-all">Kontak</a>
                    </li>
                </ul>
            </div>

            {{-- Desktop Right Side --}}
            <div class="hidden md:flex items-center gap-3 shrink-0 ml-4">
                @guest
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors px-3">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-900 text-white dark:bg-white dark:text-gray-900 text-sm font-semibold rounded-full hover:bg-gray-800 dark:hover:bg-gray-200 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Pesan Sekarang
                    </a>
                @endguest

                @auth
                    {{-- User dropdown setelah login --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-2 pl-3 pr-4 py-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <div class="w-7 h-7 bg-primary/20 rounded-full flex items-center justify-center">
                                <span class="material-icons text-primary" style="font-size:16px">person</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ Auth::user()->name }}</span>
                            <span class="material-icons text-gray-400" style="font-size:16px">expand_more</span>
                        </button>
                        <div x-show="open" x-transition
                             class="absolute top-full right-0 mt-3 w-44 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-xl py-2 z-50">
                            <a href="{{ route('profil.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons" style="font-size:18px">manage_accounts</span> Profil
                            </a>
                            <hr class="my-1 border-gray-100 dark:border-gray-800" />
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <span class="material-icons" style="font-size:18px">logout</span> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>

            {{-- Mobile Hamburger --}}
            <button id="nav-toggle" class="md:hidden p-2 text-gray-600 dark:text-gray-300 focus:outline-none">
                <span class="material-icons">menu</span>
            </button>
        </div>
    </div>
</nav>

{{-- Mobile Menu --}}
<div id="mobile-menu" class="hidden md:hidden fixed inset-0 z-40 bg-white dark:bg-gray-900 pt-24 px-6 pb-6 overflow-y-auto">
    <div class="flex flex-col space-y-4 text-center">
        <a href="{{ route('home') }}" class="text-lg font-medium text-gray-900 dark:text-white py-2 border-b border-gray-100 dark:border-gray-800">Beranda</a>
        <a href="{{ route('cluster.index') }}" class="text-lg font-medium text-gray-900 dark:text-white py-2 border-b border-gray-100 dark:border-gray-800">Cluster</a>

        @auth
            {{-- Kavling Mobile --}}
            <div x-data="{ openMenu: false }" class="border-b border-gray-100 dark:border-gray-800">
                <button @click="openMenu = !openMenu" class="flex items-center justify-between w-full text-lg font-medium text-gray-900 dark:text-white py-2">
                    Kavling
                    <span class="material-icons" :class="openMenu ? 'rotate-180' : ''" style="transition: transform .2s">expand_more</span>
                </button>
                <div x-show="openMenu" x-transition class="flex flex-col space-y-2 pb-3 text-left">
                    <a href="{{ route('pembeli.kavling.index') }}" class="text-base text-gray-600 dark:text-gray-400 py-1">Kelola Kavling</a>
                    <a href="{{ route('pembeli.kavling.index', ['tab' => 'ketersediaan']) }}" class="text-base text-gray-600 dark:text-gray-400 py-1">Cek Ketersediaan</a>
                </div>
            </div>

            {{-- Reservasi Mobile --}}
            <div x-data="{ openMenu: false }" class="border-b border-gray-100 dark:border-gray-800">
                <button @click="openMenu = !openMenu" class="flex items-center justify-between w-full text-lg font-medium text-gray-900 dark:text-white py-2">
                    Reservasi
                    <span class="material-icons" :class="openMenu ? 'rotate-180' : ''" style="transition: transform .2s">expand_more</span>
                </button>
                <div x-show="openMenu" x-transition class="flex flex-col space-y-2 pb-3 text-left">
                    <a href="{{ route('pembeli.reservasi.index') }}" class="text-base text-gray-600 dark:text-gray-400 py-1">Buat Reservasi</a>
                    <a href="{{ route('pembeli.reservasi.index', ['tab' => 'status']) }}" class="text-base text-gray-600 dark:text-gray-400 py-1">Status Reservasi</a>
                    <a href="{{ route('pembeli.reservasi.index', ['tab' => 'dokumen']) }}" class="text-base text-gray-600 dark:text-gray-400 py-1">Upload Dokumen</a>
                </div>
            </div>

            {{-- Pembayaran Mobile --}}
            <div x-data="{ openMenu: false }" class="border-b border-gray-100 dark:border-gray-800">
                <button @click="openMenu = !openMenu" class="flex items-center justify-between w-full text-lg font-medium text-gray-900 dark:text-white py-2">
                    Pembayaran
                    <span class="material-icons" :class="openMenu ? 'rotate-180' : ''" style="transition: transform .2s">expand_more</span>
                </button>
                <div x-show="openMenu" x-transition class="flex flex-col space-y-2 pb-3 text-left">
                    <a href="{{ route('pembeli.pembayaran.index') }}" class="text-base text-gray-600 dark:text-gray-400 py-1">Input Pembayaran</a>
                    <a href="{{ route('pembeli.pembayaran.index', ['tab' => 'invoice']) }}" class="text-base text-gray-600 dark:text-gray-400 py-1">Cetak Invoice</a>
                </div>
            </div>
        @endauth

        <a href="#kontak" class="text-lg font-medium text-gray-900 dark:text-white py-2">Kontak</a>

        @guest
            <div class="pt-6 flex flex-col gap-3 mt-auto">
                <a href="{{ route('login') }}" class="font-semibold text-gray-600 dark:text-gray-400 py-3 border border-gray-200 rounded-full w-full">Masuk Akun</a>
                <a href="{{ route('register') }}" class="bg-gray-900 text-white dark:bg-white dark:text-gray-900 py-3 rounded-full font-bold shadow-lg w-full">Pesan Sekarang</a>
            </div>
        @endguest

        @auth
            <div class="pt-6 mt-auto">
                <p class="font-semibold text-gray-700 dark:text-gray-300 py-2">{{ Auth::user()->name }}</p>
                <a href="{{ route('profil.index') }}" class="block font-semibold text-primary py-2 border border-primary/20 bg-primary/5 rounded-full mb-3">Profil Saya</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-50 text-red-600 border border-red-100 py-3 rounded-full font-bold shadow-sm">
                        Keluar
                    </button>
                </form>
            </div>
        @endauth
    </div>
</div>

{{-- Script untuk mengaktifkan Mobile Menu Toggle --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navToggle = document.getElementById('nav-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        if (navToggle && mobileMenu) {
            navToggle.addEventListener('click', function() {
                // Toggle tampilan menu (menyembunyikan/menampilkan)
                mobileMenu.classList.toggle('hidden');
                
                // Ganti icon dari garis tiga (menu) ke silang (close)
                const icon = navToggle.querySelector('.material-icons');
                if (icon.textContent === 'menu') {
                    icon.textContent = 'close';
                } else {
                    icon.textContent = 'menu';
                }
            });
        }
    });
</script>