<div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-20 bg-black/40 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false" x-cloak></div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-60 bg-white border-r border-slate-100 transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-auto flex flex-col h-full shadow-sm">

    <div class="p-5 pb-4 border-b border-slate-50 mb-2">
        <p class="text-[10px] text-slate-400 mb-0.5 font-bold uppercase tracking-widest italic">
            @php
                $role = auth()->user()->role;
                $roleLabel = str_replace('_', ' ', $role);
            @endphp
            {{ $roleLabel }} Space
        </p>
        <h2 class="text-base font-black text-slate-800 tracking-tight">MOUNT CARMEL</h2>
    </div>

    <nav class="flex-1 px-3 pb-4 space-y-0.5 overflow-y-auto custom-scrollbar">

        @php
            $dashboardRoute = 'home';
            if ($role === 'marketing') {
                $dashboardRoute = 'marketing.dashboard';
            } elseif ($role === 'manajer') {
                $dashboardRoute = 'manajer.dashboard';
            } elseif ($role === 'accounting') {
                $dashboardRoute = 'accounting.dashboard';
            } elseif ($role === 'koordinator_lapangan') {
                $dashboardRoute = 'koordinator_lapangan.dashboard';
            }
        @endphp

        <a href="{{ route($dashboardRoute) }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('*.dashboard') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
            <span class="material-icons-outlined text-[18px]">grid_view</span>
            Dashboard
        </a>

        {{-- ─── MASTER DATA / LAHAN ────────────────────────────────── --}}
        @if(in_array($role, ['marketing', 'manajer', 'koordinator_lapangan']))
            <div class="pt-4 pb-1">
                <p class="px-3 text-[9px] font-black tracking-widest text-slate-400 uppercase leading-none">
                    {{ in_array($role, ['marketing', 'koordinator_lapangan']) ? 'Kelola Lahan' : 'Monitoring Lahan' }}
                </p>
            </div>

            <a href="{{ route($role . '.cluster.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('*.cluster.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                <span class="material-icons-outlined text-[18px]">map</span>
                {{ in_array($role, ['marketing', 'koordinator_lapangan']) ? 'Data Cluster' : 'View Cluster' }}
            </a>

            <a href="{{ route($role . '.kavling.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('*.kavling.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                <span class="material-icons-outlined text-[18px]">crop_square</span>
                {{ in_array($role, ['marketing', 'koordinator_lapangan']) ? 'Data Lahan' : 'View Lahan' }}
            </a>
        @endif

        {{-- ─── KELOLA HARGA (ACCOUNTING ONLY) ────────────────────────── --}}
        @if($role === 'accounting')
            <div class="pt-4 pb-1">
                <p class="px-3 text-[9px] font-black tracking-widest text-slate-400 uppercase leading-none">Keuangan</p>
            </div>

            <a href="{{ route('accounting.harga.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('*.harga.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                <span class="material-icons-outlined text-[18px]">sell</span>
                Kelola Harga Lahan
            </a>
        @endif

        {{-- ─── TRANSAKSI ────────────────────────────────────────── --}}
        @if(in_array($role, ['marketing', 'manajer', 'accounting']))
            <div class="pt-4 pb-1">
                <p class="px-3 text-[9px] font-black tracking-widest text-slate-400 uppercase leading-none">
                    {{ $role === 'manajer' ? 'Monitoring Transaksi' : 'Transaksi' }}
                </p>
            </div>

            <a href="{{ route($role . '.pembeli.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('*.pembeli.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                <span class="material-icons-outlined text-[18px]">group</span>
                {{ $role === 'manajer' ? 'View Pembeli' : ($role === 'accounting' ? 'View Data Pembeli' : 'Data Pembeli') }}
            </a>

            @if(in_array($role, ['marketing', 'manajer']))
                <a href="{{ route($role . '.reservasi.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('*.reservasi.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                    <span class="material-icons-outlined text-[18px]">book_online</span>
                    {{ $role === 'manajer' ? 'View Reservasi' : 'Data Reservasi' }}
                </a>
            @endif

            <a href="{{ route($role . '.pembayaran.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('*.pembayaran.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                <span class="material-icons-outlined text-[18px]">payments</span>
                {{ $role === 'accounting' ? 'Kelola Pembayaran' : ($role === 'marketing' ? 'Data Pembayaran' : 'View Pembayaran') }}
            </a>
        @endif

        {{-- ─── REPORTING ────────────────────────────────────────── --}}
        @if(in_array($role, ['marketing', 'manajer']))
            <div class="pt-4 pb-1">
                <p class="px-3 text-[9px] font-black tracking-widest text-slate-400 uppercase leading-none">Reporting</p>
            </div>

            <a href="{{ route($role . '.laporan.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('*.laporan.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                <span class="material-icons-outlined text-[18px]">analytics</span>
                Laporan Penjualan
            </a>
        @endif

        {{-- ─── DOKUMEN (MARKETING ONLY) ─────────────────────────── --}}
        @if($role === 'marketing')
            <div class="pt-4 pb-1">
                <p class="px-3 text-[9px] font-black tracking-widest text-slate-400 uppercase leading-none">Dokumen</p>
            </div>

            <a href="{{ route('marketing.sertifikat.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('*.sertifikat.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                <span class="material-icons-outlined text-[18px]">workspace_premium</span>
                Sertifikat Lahan
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