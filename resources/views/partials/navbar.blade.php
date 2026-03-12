<nav class="absolute top-6 left-0 w-full z-50">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border border-gray-200 dark:border-gray-700 rounded-full px-6 py-3 flex items-center justify-between shadow-md transition-all duration-300">
            
            <a href="{{ url('/') }}" class="flex items-center gap-2 shrink-0 mr-8">
                <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-gray-100 font-display">
                    Mount Carmel
                </span>
            </a>

            <div class="hidden md:flex flex-1 justify-center">
                <ul class="flex items-center space-x-1 lg:space-x-2 bg-gray-100/50 dark:bg-gray-800/50 rounded-full px-2 py-1">
                    <li>
                        <a href="{{ url('/') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-white dark:hover:bg-gray-700 rounded-full transition-all">Home</a>
                    </li>
                    <li>
                        <a href="{{ url('/cluster') }}" class="block px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-white dark:hover:bg-gray-700 rounded-full transition-all">Cluster</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-white dark:hover:bg-gray-700 rounded-full transition-all">Reservasi</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary hover:bg-white dark:hover:bg-gray-700 rounded-full transition-all">Kontak</a>
                    </li>
                </ul>
            </div>

            <div class="hidden md:flex items-center gap-3 shrink-0 ml-4">
                <a href="{{ url('/login') }}" class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors px-3">
                    Masuk
                </a>
                
                <a href="{{ url('/register') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-900 text-white dark:bg-white dark:text-gray-900 text-sm font-semibold rounded-full hover:bg-gray-800 dark:hover:bg-gray-200 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 btn-press btn-ripple">
                    Pesan Sekarang
                </a>
            </div>

            <button id="nav-toggle" class="md:hidden p-2 text-gray-600 dark:text-gray-300 focus:outline-none">
                <span class="material-icons">menu</span>
            </button>
        </div>
    </div>
</nav>

<div id="mobile-menu" class="hidden md:hidden fixed inset-0 z-40 bg-white dark:bg-gray-900 pt-24 px-6 pb-6 overflow-y-auto">
    <div class="flex flex-col space-y-4 text-center">
        <a href="{{ url('/') }}" class="text-lg font-medium text-gray-900 dark:text-white py-2">Beranda</a>
        <a href="{{ url('/cluster') }}" class="text-lg font-medium text-gray-900 dark:text-white py-2">Cluster</a>
        <a href="#" class="text-lg font-medium text-gray-900 dark:text-white py-2">Galeri</a>
        <a href="#" class="text-lg font-medium text-gray-900 dark:text-white py-2">Kontak</a>
        <hr class="border-gray-200 dark:border-gray-700 my-4">
        <a href="{{ url('/login') }}" class="font-semibold text-gray-600 dark:text-gray-400 py-2">Masuk Akun</a>
        <a href="{{ url('/register') }}" class="bg-gray-900 text-white dark:bg-white dark:text-gray-900 py-4 rounded-full font-bold shadow-lg mt-4 btn-press btn-ripple">Pesan Sekarang</a>
    </div>
</div>