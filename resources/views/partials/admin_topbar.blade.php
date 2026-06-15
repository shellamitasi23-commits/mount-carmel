<header class="lg:hidden flex items-center justify-between px-4 py-3 bg-card border-b border-gray-100">
    <div class="flex items-center gap-3">
        <button @click="sidebarOpen = true" class="text-textMuted hover:text-[#800000] focus:outline-none">
            <span class="material-icons-outlined text-2xl">menu</span>
        </button>
        <span class="font-bold text-lg text-primary">Mount Carmel</span>
    </div>
    
    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=800000&color=fff" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full">
</header>