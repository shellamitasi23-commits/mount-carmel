<div x-data="{ mobileMenuOpen: false }">
    <nav class="absolute top-6 left-0 w-full z-40">
        <div class="max-w-7xl mx-auto px-4 md:px-6">
            <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border border-gray-200 dark:border-gray-700 rounded-full px-6 py-3 flex items-center justify-between shadow-md transition-all duration-300">

                <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0 mr-8">
                    <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-gray-100">Mount Carmel</span>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex flex-1 justify-center">
                    <ul class="flex items-center space-x-1 lg:space-x-2 bg-gray-100/50 dark:bg-gray-800/50 rounded-full px-2 py-1">

                        <li>
                            <a href="{{ route('home') }}"
                               class="block px-4 py-2 text-sm font-medium rounded-full transition-all {{ request()->routeIs('home') ? 'bg-white text-primary shadow-sm' : 'text-gray-700 hover:text-primary hover:bg-white' }}">
                                Home
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('cluster.index') }}"
                               class="block px-4 py-2 text-sm font-medium rounded-full transition-all {{ request()->routeIs('cluster.*') ? 'bg-white text-primary shadow-sm' : 'text-gray-700 hover:text-primary hover:bg-white' }}">
                                Cluster
                            </a>
                        </li>

                        @auth
                        {{-- Kavling Dropdown --}}
                        <li x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.away="open = false"
                                    class="flex items-center gap-1 px-4 py-2 text-sm font-medium rounded-full transition-all {{ request()->routeIs('pembeli.kavling.*') ? 'bg-white text-primary shadow-sm' : 'text-gray-700 hover:text-primary hover:bg-white' }}">
                                Kavling
                                <span class="material-icons text-xs" :class="open ? 'rotate-180' : ''" style="transition: transform .2s">expand_more</span>
                            </button>
                            <div x-show="open" x-transition style="display:none"
                                 class="absolute top-full left-1/2 -translate-x-1/2 mt-3 w-52 bg-white border border-gray-100 rounded-2xl shadow-xl py-2 z-50">
                                {{-- Arahkan ke cluster.index dulu karena kavling.index butuh cluster_id --}}
                                <a href="{{ route('cluster.index') }}"
                                   class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                    <span class="material-icons text-primary" style="font-size:18px">search</span> Cari Kavling
                                </a>
                                <a href="{{ route('pembeli.kavling.index') }}"
                                   class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('pembeli.kavling.index') ? 'bg-primary/5 text-primary font-semibold' : '' }}">
                                    <span class="material-icons text-primary" style="font-size:18px">layers</span> Semua Tipe
                                </a>
                            </div>
                        </li>

                        {{-- Reservasi Dropdown --}}
                        <li x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.away="open = false"
                                    class="flex items-center gap-1 px-4 py-2 text-sm font-medium rounded-full transition-all {{ request()->routeIs('pembeli.reservasi.*') ? 'bg-white text-primary shadow-sm' : 'text-gray-700 hover:text-primary hover:bg-white' }}">
                                Reservasi
                                <span class="material-icons text-xs" :class="open ? 'rotate-180' : ''" style="transition: transform .2s">expand_more</span>
                            </button>
                            <div x-show="open" x-transition style="display:none"
                                 class="absolute top-full left-1/2 -translate-x-1/2 mt-3 w-52 bg-white border border-gray-100 rounded-2xl shadow-xl py-2 z-50">
                                {{-- index = riwayat, TANPA parameter, langsung bisa diklik --}}
                                <a href="{{ route('pembeli.reservasi.index') }}"
                                   class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('pembeli.reservasi.index') ? 'bg-primary/5 text-primary font-semibold' : '' }}">
                                    <span class="material-icons text-primary" style="font-size:18px">list_alt</span> Riwayat Reservasi
                                </a>
                                <a href="{{ route('cluster.index') }}"
                                   class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                    <span class="material-icons text-primary" style="font-size:18px">add_circle</span> Pesan Baru
                                </a>
                            </div>
                        </li>

                        {{-- Pembayaran Dropdown --}}
                        <li x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.away="open = false"
                                    class="flex items-center gap-1 px-4 py-2 text-sm font-medium rounded-full transition-all {{ request()->routeIs('pembeli.pembayaran.*') ? 'bg-white text-primary shadow-sm' : 'text-gray-700 hover:text-primary hover:bg-white' }}">
                                Pembayaran
                                <span class="material-icons text-xs" :class="open ? 'rotate-180' : ''" style="transition: transform .2s">expand_more</span>
                            </button>
                            <div x-show="open" x-transition style="display:none"
                                 class="absolute top-full left-1/2 -translate-x-1/2 mt-3 w-52 bg-white border border-gray-100 rounded-2xl shadow-xl py-2 z-50">
                                {{-- index = riwayat + invoice, TANPA parameter, langsung bisa diklik --}}
                                <a href="{{ route('pembeli.pembayaran.index') }}"
                                   class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 {{ request()->routeIs('pembeli.pembayaran.index') ? 'bg-primary/5 text-primary font-semibold' : '' }}">
                                    <span class="material-icons text-primary" style="font-size:18px">receipt_long</span> Riwayat & Invoice
                                </a>
                            </div>
                        </li>
                        @endauth

                        <li>
                            <a href="{{ route('kontak') }}"
                               class="block px-4 py-2 text-sm font-medium rounded-full transition-all {{ request()->routeIs('kontak') ? 'bg-white text-primary shadow-sm' : 'text-gray-700 hover:text-primary hover:bg-white' }}">
                                Kontak
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Desktop Auth --}}
                <div class="hidden md:flex items-center gap-3 shrink-0 ml-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 transition-colors px-3">Masuk</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-full hover:bg-gray-800 transition-all shadow-lg hover:-translate-y-0.5">Pesan Sekarang</a>
                    @endguest
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.away="open = false"
                                    class="flex items-center gap-2 pl-3 pr-4 py-2 rounded-full hover:bg-gray-100 transition-colors">
                                <div class="w-7 h-7 bg-primary/20 rounded-full flex items-center justify-center">
                                    <span class="material-icons text-primary" style="font-size:16px">person</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</span>
                                <span class="material-icons text-gray-400" style="font-size:16px">expand_more</span>
                            </button>
                            <div x-show="open" x-transition style="display:none"
                                 class="absolute top-full right-0 mt-3 w-44 bg-white border border-gray-100 rounded-2xl shadow-xl py-2 z-50">
                                <a href="{{ route('profil.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                    <span class="material-icons" style="font-size:18px">manage_accounts</span> Profil
                                </a>
                                <hr class="my-1 border-gray-100" />
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50">
                                        <span class="material-icons" style="font-size:18px">logout</span> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>

                {{-- Hamburger Mobile --}}
                <button @click="mobileMenuOpen = true" class="md:hidden p-2 text-gray-600 focus:outline-none">
                    <span class="material-icons">menu</span>
                </button>
            </div>
        </div>
    </nav>

    {{-- Mobile Drawer --}}
    <div x-show="mobileMenuOpen" x-cloak style="display:none" class="md:hidden relative z-50">

        <div x-show="mobileMenuOpen" x-cloak
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"
             @click="mobileMenuOpen = false"></div>

        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
             class="fixed inset-y-0 right-0 w-[85%] max-w-[320px] bg-white shadow-2xl flex flex-col rounded-l-2xl overflow-hidden">

            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 shrink-0">
                <span class="text-xl font-bold text-gray-900">Mount Carmel</span>
                <button @click="mobileMenuOpen = false" class="p-2 bg-gray-50 text-gray-500 hover:text-gray-800 rounded-full transition-colors focus:outline-none">
                    <span class="material-icons text-sm block">close</span>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-4 py-5 flex flex-col space-y-1">

                <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-[15px] font-medium transition-colors {{ request()->routeIs('home') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50' }}">
                    <span class="material-icons text-[20px] {{ request()->routeIs('home') ? 'text-primary' : 'text-gray-400' }}">home</span>
                    Beranda
                </a>

                <a href="{{ route('cluster.index') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-[15px] font-medium transition-colors {{ request()->routeIs('cluster.*') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50' }}">
                    <span class="material-icons text-[20px] {{ request()->routeIs('cluster.*') ? 'text-primary' : 'text-gray-400' }}">map</span>
                    Cluster
                </a>

                @auth
                    {{-- Kavling --}}
                    <div x-data="{ sub: false }">
                        <button @click="sub = !sub" class="w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-[15px] font-medium transition-colors {{ request()->routeIs('pembeli.kavling.*') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50' }}">
                            <div class="flex items-center gap-3">
                                <span class="material-icons text-[20px] {{ request()->routeIs('pembeli.kavling.*') ? 'text-primary' : 'text-gray-400' }}">layers</span>
                                Kavling
                            </div>
                            <span class="material-icons text-[20px] transition-transform duration-300" :class="sub ? 'rotate-180' : ''">expand_more</span>
                        </button>
                        <div x-show="sub" x-transition class="flex flex-col space-y-1 pl-12 pr-4 pt-1 pb-2">
                            <a href="{{ route('cluster.index') }}" class="block py-2 text-sm text-gray-500 hover:text-gray-800">Cari Kavling</a>
                            <a href="{{ route('pembeli.kavling.index') }}" class="block py-2 text-sm {{ request()->routeIs('pembeli.kavling.index') ? 'text-primary font-bold' : 'text-gray-500 hover:text-gray-800' }}">Semua Tipe</a>
                        </div>
                    </div>

                    {{-- Reservasi --}}
                    <div x-data="{ sub: {{ request()->routeIs('pembeli.reservasi.*') ? 'true' : 'false' }} }">
                        <button @click="sub = !sub" class="w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-[15px] font-medium transition-colors {{ request()->routeIs('pembeli.reservasi.*') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50' }}">
                            <div class="flex items-center gap-3">
                                <span class="material-icons text-[20px] {{ request()->routeIs('pembeli.reservasi.*') ? 'text-primary' : 'text-gray-400' }}">event_note</span>
                                Reservasi
                            </div>
                            <span class="material-icons text-[20px] transition-transform duration-300" :class="sub ? 'rotate-180' : ''">expand_more</span>
                        </button>
                        <div x-show="sub" x-transition class="flex flex-col space-y-1 pl-12 pr-4 pt-1 pb-2">
                            {{-- index TANPA parameter → aman diklik --}}
                            <a href="{{ route('pembeli.reservasi.index') }}" class="block py-2 text-sm {{ request()->routeIs('pembeli.reservasi.index') ? 'text-primary font-bold' : 'text-gray-500 hover:text-gray-800' }}">
                                Riwayat Reservasi
                            </a>
                            <a href="{{ route('cluster.index') }}" class="block py-2 text-sm text-gray-500 hover:text-gray-800">
                                Pesan Baru
                            </a>
                        </div>
                    </div>

                    {{-- Pembayaran --}}
                    <div x-data="{ sub: {{ request()->routeIs('pembeli.pembayaran.*') ? 'true' : 'false' }} }">
                        <button @click="sub = !sub" class="w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-[15px] font-medium transition-colors {{ request()->routeIs('pembeli.pembayaran.*') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50' }}">
                            <div class="flex items-center gap-3">
                                <span class="material-icons text-[20px] {{ request()->routeIs('pembeli.pembayaran.*') ? 'text-primary' : 'text-gray-400' }}">payments</span>
                                Pembayaran
                            </div>
                            <span class="material-icons text-[20px] transition-transform duration-300" :class="sub ? 'rotate-180' : ''">expand_more</span>
                        </button>
                        <div x-show="sub" x-transition class="flex flex-col space-y-1 pl-12 pr-4 pt-1 pb-2">
                            {{-- index TANPA parameter → aman diklik --}}
                            <a href="{{ route('pembeli.pembayaran.index') }}" class="block py-2 text-sm {{ request()->routeIs('pembeli.pembayaran.index') ? 'text-primary font-bold' : 'text-gray-500 hover:text-gray-800' }}">
                                Riwayat & Invoice
                            </a>
                        </div>
                    </div>
                @endauth

                <a href="{{ route('kontak') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-[15px] font-medium transition-colors {{ request()->routeIs('kontak') ? 'bg-primary/10 text-primary' : 'text-gray-600 hover:bg-gray-50' }}">
                    <span class="material-icons text-[20px] {{ request()->routeIs('kontak') ? 'text-primary' : 'text-gray-400' }}">support_agent</span>
                    Kontak
                </a>
            </div>

            <div class="shrink-0 p-5 border-t border-gray-100 bg-gray-50/50">
                @guest
                    <div class="flex flex-col gap-3">
                        <p class="text-[11px] text-center text-gray-500 uppercase tracking-wider font-bold mb-1">Akun Saya</p>
                        <a href="{{ route('login') }}" class="text-center font-bold text-gray-700 bg-white border border-gray-200 py-3 rounded-xl w-full shadow-sm hover:bg-gray-50">Masuk</a>
                        <a href="{{ route('register') }}" class="text-center font-bold bg-gray-900 text-white py-3 rounded-xl w-full shadow-md hover:bg-gray-800">Daftar Akun</a>
                    </div>
                @endguest
                @auth
                    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center shrink-0">
                                <span class="material-icons text-primary">person</span>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Masuk sebagai</p>
                                <p class="font-bold text-gray-900 truncate text-sm">{{ Auth::user()->name }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('profil.index') }}" class="flex-1 text-center font-bold text-primary bg-primary/10 py-2.5 rounded-xl text-xs hover:bg-primary/20 transition-colors">Profil</a>
                            <form method="POST" action="{{ route('logout') }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full text-center font-bold text-red-600 bg-red-50 border border-red-100 py-2.5 rounded-xl text-xs hover:bg-red-100 transition-colors">Keluar</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>