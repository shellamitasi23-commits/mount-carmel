<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Mount Carmel')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
 
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: {
                        background: '#f8f9fc',
                        card: '#ffffff',
                        primary: '#800000',
                        accent: '#eef2ff',
                        textMain: '#111827',
                        textMuted: '#6b7280',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-background text-textMain font-sans antialiased overflow-hidden"
      x-data="{ 
        sidebarOpen: false,
        confirmModal: {
            show: false,
            title: '',
            message: '',
            action: null,
            confirmText: 'Ya, Lanjutkan',
            cancelText: 'Batal',
            type: 'primary',
            confirm() {
                if (this.action) this.action();
                this.show = false;
            }
        }
      }"
      @confirm-modal.window="
        confirmModal.show = true;
        confirmModal.title = $event.detail.title;
        confirmModal.message = $event.detail.message;
        confirmModal.action = $event.detail.action;
        confirmModal.confirmText = $event.detail.confirmText || 'Ya, Lanjutkan';
        confirmModal.cancelText = $event.detail.cancelText || 'Batal';
        confirmModal.type = $event.detail.type || 'primary';
      ">
 
    <div class="flex h-screen w-full">
 
        @include('partials.admin_sidebar')
 
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            @include('partials.admin_topbar')
            
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-6 lg:p-8">
                @yield('content')
            </main>
            
        </div>
        
    </div>
 
    {{-- Global Confirmation Modal --}}
    <div x-show="confirmModal.show" class="fixed inset-0 z-[9999] flex items-center justify-center p-4" x-cloak>
        <div x-show="confirmModal.show" class="absolute inset-0 bg-slate-900/60 backdrop-blur-md" @click="confirmModal.show = false"></div>
        <div x-show="confirmModal.show" class="relative bg-white rounded-3xl w-full max-w-md overflow-hidden shadow-2xl p-8">
            <h3 class="text-xl font-bold text-slate-800 mb-2" x-text="confirmModal.title"></h3>
            <p class="text-slate-500 mb-8 text-sm" x-html="confirmModal.message"></p>
            <div class="flex flex-col gap-2">
                <button @click="confirmModal.confirm()"
                        class="w-full py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all active:scale-95 shadow-lg"
                        :class="{
                            'bg-[#800000] text-white hover:bg-[#800000]/90': confirmModal.type === 'primary',
                            'bg-emerald-600 text-white': confirmModal.type === 'success',
                            'bg-rose-600 text-white': confirmModal.type === 'danger'
                        }"
                        x-text="confirmModal.confirmText">
                </button>
                <button @click="confirmModal.show = false"
                        class="w-full py-3 text-xs font-bold text-slate-400 hover:text-slate-600 transition-colors"
                        x-text="confirmModal.cancelText">
                </button>
            </div>
        </div>
    </div>
 
    <style>[x-cloak] { display: none !important; }</style>
</body>
</html>