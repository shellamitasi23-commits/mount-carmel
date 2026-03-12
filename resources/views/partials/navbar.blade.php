<nav class="absolute top-6 left-0 w-full z-50">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border border-gray-200 dark:border-gray-700 rounded-full px-6 py-3 flex items-center justify-between shadow-md transition-all duration-300">
            
            <a href="{{ url('/') }}" class="flex items-center gap-2 shrink-0 mr-8">
                <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-gray-100 font-display">
                    Mount Carmel
                </span>
            </a>

            {{-- Desktop Nav Links --}}
            <div class="hidden md:flex flex-1 justify-center">
                <ul class="flex items-center space-x-1 lg:space-x-2 bg-gray-100/50 dark:bg-gray-800/50 rounded-full px-2 py-1">
                    <li>
                        <a href="{{ url('/') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-white dark:hover:bg-gray-700 rounded-full transition-all">Home</a>
                    </li>
                    <li>
                        <a href="{{ url('/cluster') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-white dark:hover:bg-gray-700 rounded-full transition-all">Cluster</a>
                    </li>
                    @auth
                    {{-- Menu tambahan hanya muncul setelah login --}}
                    <li x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-1 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-white dark:hover:bg-gray-700 rounded-full transition-all">
                            Kavling
                            <span class="material-icons text-xs" :class="open ? 'rotate-180' : ''" style="font-size:14px; transition: transform .2s">expand_more</span>
                        </button>
                        <div x-show="open" x-transition
                             class="absolute top-full left-1/2 -translate-x-1/2 mt-3 w-52 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-xl py-2 z-50">
                            <a href="{{ url('/pembeli/kavling') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons text-primary" style="font-size:18px">grid_view</span> Kelola Kavling
                            </a>
                            <a href="{{ url('/pembeli/kavling?tab=ketersediaan') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons text-primary" style="font-size:18px">fact_check</span> Cek Ketersediaan
                            </a>
                            <a href="{{ url('/pembeli/kavling?tab=nomor') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons text-primary" style="font-size:18px">tag</span> Nomor Kavling
                            </a>
                        </div>
                    </li>
                    <li x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-1 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-white dark:hover:bg-gray-700 rounded-full transition-all">
                            Reservasi
                            <span class="material-icons" :class="open ? 'rotate-180' : ''" style="font-size:14px; transition: transform .2s">expand_more</span>
                        </button>
                        <div x-show="open" x-transition
                             class="absolute top-full left-1/2 -translate-x-1/2 mt-3 w-52 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-xl py-2 z-50">
                            <a href="{{ url('/pembeli/reservasi') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons text-primary" style="font-size:18px">edit_note</span> Buat Reservasi
                            </a>
                            <a href="{{ url('/pembeli/reservasi?tab=status') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons text-primary" style="font-size:18px">pending_actions</span> Status Reservasi
                            </a>
                            <a href="{{ url('/pembeli/reservasi?tab=dokumen') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons text-primary" style="font-size:18px">upload_file</span> Upload Dokumen
                            </a>
                        </div>
                    </li>
                    <li x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-1 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-white dark:hover:bg-gray-700 rounded-full transition-all">
                            Pembayaran
                            <span class="material-icons" :class="open ? 'rotate-180' : ''" style="font-size:14px; transition: transform .2s">expand_more</span>
                        </button>
                        <div x-show="open" x-transition
                             class="absolute top-full left-1/2 -translate-x-1/2 mt-3 w-52 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-xl py-2 z-50">
                            <a href="{{ url('/pembeli/pembayaran') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons text-primary" style="font-size:18px">payments</span> Input Pembayaran
                            </a>
                            <a href="{{ url('/pembeli/pembayaran?tab=status') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons text-primary" style="font-size:18px">receipt_long</span> Status Pembayaran
                            </a>
                            <a href="{{ url('/pembeli/pembayaran?tab=invoice') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
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
                    <a href="{{ url('/login') }}" class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors px-3">
                        Masuk
                    </a>
                    <a href="{{ url('/register') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-900 text-white dark:bg-white dark:text-gray-900 text-sm font-semibold rounded-full hover:bg-gray-800 dark:hover:bg-gray-200 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 btn-press btn-ripple">
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
                            <a href="{{ url('/profil') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="material-icons" style="font-size:18px">manage_accounts</span> Profil
                            </a>
                            <hr class="my-1 border-gray-100 dark:border-gray-800" />
                            <form method="POST" action="{{ url('/logout') }}">
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

{{-- Mobile Menu - struktur sama, konten sesuai auth --}}
<div id="mobile-menu" class="hidden md:hidden fixed inset-0 z-40 bg-white dark:bg-gray-900 pt-24 px-6 pb-6 overflow-y-auto">
    <div class="flex flex-col space-y-4 text-center">
        <a href="{{ url('/') }}" class="text-lg font-medium text-gray-900 dark:text-white py-2">Beranda</a>
        <a href="{{ url('/cluster') }}" class="text-lg font-medium text-gray-900 dark:text-white py-2">Cluster</a>

        @auth
            {{-- Menu yang hanya muncul setelah login (mobile) --}}
            <hr class="border-gray-200 dark:border-gray-700">
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Kavling</p>
            <a href="{{ url('/pembeli/kavling') }}" class="text-lg font-medium text-gray-900 dark:text-white py-2">Kelola Kavling</a>
            <a href="{{ url('/pembeli/kavling?tab=ketersediaan') }}" class="text-base font-medium text-gray-600 dark:text-gray-400 py-1">Cek Ketersediaan</a>
            <hr class="border-gray-200 dark:border-gray-700">
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Reservasi</p>
            <a href="{{ url('/pembeli/reservasi') }}" class="text-lg font-medium text-gray-900 dark:text-white py-2">Buat Reservasi</a>
            <a href="{{ url('/pembeli/reservasi?tab=status') }}" class="text-base font-medium text-gray-600 dark:text-gray-400 py-1">Status Reservasi</a>
            <hr class="border-gray-200 dark:border-gray-700">
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Pembayaran</p>
            <a href="{{ url('/pembeli/pembayaran') }}" class="text-lg font-medium text-gray-900 dark:text-white py-2">Input Pembayaran</a>
            <a href="{{ url('/pembeli/pembayaran?tab=invoice') }}" class="text-base font-medium text-gray-600 dark:text-gray-400 py-1">Cetak Invoice</a>
        @endauth

        <a href="#kontak" class="text-lg font-medium text-gray-900 dark:text-white py-2">Kontak</a>
        <hr class="border-gray-200 dark:border-gray-700 my-4">

        @guest
            <a href="{{ url('/login') }}" class="font-semibold text-gray-600 dark:text-gray-400 py-2">Masuk Akun</a>
            <a href="{{ url('/register') }}" class="bg-gray-900 text-white dark:bg-white dark:text-gray-900 py-4 rounded-full font-bold shadow-lg mt-4 btn-press btn-ripple">Pesan Sekarang</a>
        @endguest

        @auth
            <p class="font-semibold text-gray-700 dark:text-gray-300 py-2">{{ Auth::user()->name }}</p>
            <a href="{{ url('/profil') }}" class="font-semibold text-gray-600 dark:text-gray-400 py-2">Profil Saya</a>
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" class="w-full bg-red-500 text-white py-4 rounded-full font-bold shadow-lg mt-4 btn-press btn-ripple">
                    Keluar
                </button>
            </form>
        @endauth
    </div>
</div>