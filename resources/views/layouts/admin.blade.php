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
                        primary: '#1e1b4b', // Warna ungu gelap dari referensi
                        accent: '#eef2ff',  // Warna highlight menu
                        textMain: '#111827',
                        textMuted: '#6b7280',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        /* Kustomisasi scrollbar agar lebih rapi */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
    </style>
</head>
<body class="bg-background text-textMain font-sans antialiased overflow-hidden">

    <div x-data="{ sidebarOpen: false }" class="flex h-screen w-full">

        @include('partials.admin_sidebar')

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            @include('partials.admin_topbar')

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-6 lg:p-8">
                @yield('content')
            </main>
            
        </div>
        
    </div>

</body>
</html>