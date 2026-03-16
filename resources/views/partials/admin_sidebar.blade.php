<div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-20 bg-black/40 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false" x-cloak></div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-60 bg-white border-r border-slate-100 transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-auto flex flex-col h-full shadow-sm">

    <div class="p-5 pb-4 border-b border-slate-50 mb-2">
        <p class="text-[10px] text-slate-400 mb-0.5 font-bold uppercase tracking-widest italic">
            {{ auth()->user()->role }} Space
        </p>
        <h2 class="text-base font-black text-slate-800 tracking-tight">MOUNT CARMEL</h2>
    </div>

    <nav class="flex-1 px-3 pb-4 space-y-0.5 overflow-y-auto custom-scrollbar">

        @php $role = auth()->user()->role; @endphp

        @php $dashboardRoute = ($role == 'admin') ? 'admin.dashboard' : 'pimpinan.dashboard'; @endphp
        <a href="{{ route($dashboardRoute) }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('*.dashboard') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
            <span class="material-icons-outlined text-[18px]">grid_view</span>
            Dashboard
        </a>

        <div class="pt-4 pb-1">
            <p class="px-3 text-[9px] font-black tracking-widest text-slate-400 uppercase leading-none">{{ $role == 'admin' ? 'Master Data' : 'Monitoring' }}</p>
        </div>

        <a href="{{ route($role . '.cluster.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('*.cluster.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
            <span class="material-icons-outlined text-[18px]">map</span>
            {{ $role == 'admin' ? 'Data Cluster' : 'View Cluster' }}
        </a>

        <a href="{{ route($role . '.kavling.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('*.kavling.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
            <span class="material-icons-outlined text-[18px]">crop_square</span>
            {{ $role == 'admin' ? 'Data Kavling' : 'View Kavling' }}
        </a>

        <div class="pt-4 pb-1">
            <p class="px-3 text-[9px] font-black tracking-widest text-slate-400 uppercase leading-none">Transaksi</p>
        </div>

        <a href="{{ route($role . '.pembeli.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('*.pembeli.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
            <span class="material-icons-outlined text-[18px]">group</span>
            {{ $role == 'admin' ? 'Data Pembeli' : 'View Pembeli' }}
        </a>

        <a href="{{ route($role . '.reservasi.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('*.reservasi.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
            <span class="material-icons-outlined text-[18px]">book_online</span>
            {{ $role == 'admin' ? 'Data Reservasi' : 'View Reservasi' }}
        </a>

        <a href="{{ route($role . '.pembayaran.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('*.pembayaran.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
            <span class="material-icons-outlined text-[18px]">payments</span>
            {{ $role == 'admin' ? 'Data Pembayaran' : 'View Pembayaran' }}
        </a>

        <div class="pt-4 pb-1">
            <p class="px-3 text-[9px] font-black tracking-widest text-slate-400 uppercase leading-none">Reporting</p>
        </div>

        <a href="{{ route($role . '.laporan.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('*.laporan.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
            <span class="material-icons-outlined text-[18px]">analytics</span>
            Laporan Penjualan
        </a>

        {{-- Menu Sertifikat — hanya untuk admin --}}
        @if($role == 'admin')
        <div class="pt-4 pb-1">
            <p class="px-3 text-[9px] font-black tracking-widest text-slate-400 uppercase leading-none">Dokumen</p>
        </div>

        <a href="{{ route('admin.sertifikat.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('admin.sertifikat.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
            <span class="material-icons-outlined text-[18px]">workspace_premium</span>
            Sertifikat
        </a>
        @endif

    </nav>

    <div class="p-3 border-t border-slate-50">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-2.5 px-3 py-2 text-xs font-bold text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all group">
            <span class="material-icons-outlined text-[18px] group-hover:rotate-12 transition-transform">logout</span>
            Logout System
        </a>
    </div>
</aside>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #f1f5f9; border-radius: 10px; }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: #e2e8f0; }
</style>