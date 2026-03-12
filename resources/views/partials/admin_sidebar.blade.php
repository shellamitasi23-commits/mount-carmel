<div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-20 bg-black/50 lg:hidden" @click="sidebarOpen = false" x-cloak></div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-card border-r border-gray-100 transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-auto flex flex-col h-full shadow-sm lg:shadow-none">
    
    <div class="p-6 pb-2">
        <p class="text-xs text-textMuted mb-1">Welcome Back!</p>
        <h2 class="text-lg font-bold text-textMain">Super Admin</h2>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-white border border-primary text-primary shadow-sm font-semibold' : 'text-textMuted hover:bg-gray-50 hover:text-textMain border border-transparent' }}">
            <span class="material-icons-outlined text-xl">grid_view</span>
            Dashboard
        </a>

        <a href="{{ route('admin.kavling.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.kavling.*') ? 'bg-white border border-primary text-primary shadow-sm font-semibold' : 'text-textMuted hover:bg-gray-50 hover:text-textMain border border-transparent' }}">
            <span class="material-icons-outlined text-xl">domain</span>
            Manajemen Kavling
        </a>

        <a href="{{ route('admin.transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.transaksi.*') ? 'bg-white border border-primary text-primary shadow-sm font-semibold' : 'text-textMuted hover:bg-gray-50 hover:text-textMain border border-transparent' }}">
            <span class="material-icons-outlined text-xl">receipt_long</span>
            Transaksi
        </a>
<a href="{{ route('admin.pelanggan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.pelanggan.*') ? 'bg-white border border-primary text-primary shadow-sm font-semibold' : 'text-textMuted hover:bg-gray-50 hover:text-textMain border border-transparent' }}">
            <span class="material-icons-outlined text-xl">group</span>
            Pelanggan
        </a>

        <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.laporan.*') ? 'bg-white border border-primary text-primary shadow-sm font-semibold' : 'text-textMuted hover:bg-gray-50 hover:text-textMain border border-transparent' }}">
            <span class="material-icons-outlined text-xl">analytics</span>
            Laporan
        </a>

        <a href="#" class="flex items-center gap-3 px-4 py-3 text-textMuted hover:bg-gray-50 hover:text-textMain rounded-xl font-medium transition-colors">
            <span class="material-icons-outlined text-xl">settings</span>
            Pengaturan
        </a>
    </nav>

    <div class="p-4 mt-auto">
        <a href="#" class="flex items-center gap-3 px-4 py-3 text-textMuted hover:text-red-600 hover:bg-red-50 rounded-xl font-medium transition-colors">
            <span class="material-icons-outlined text-xl">logout</span>
            Keluar
        </a>
    </div>
</aside>