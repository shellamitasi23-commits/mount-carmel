<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'Mount Carmel Cluster')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#73b7d4", 
                        secondary: "#FAFAFA",
                        dark: "#121212",
                    },
                    fontFamily: {
                        display: ["Montserrat", "sans-serif"],
                        body: ["Inter", "sans-serif"],
                    },
                },
            },
        };
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Montserrat', sans-serif; }
        
        /* --- ANIMASI KLIK (RIPPLE EFFECT) --- */
        .btn-ripple {
            position: relative;
            overflow: hidden;
            transform: translate3d(0, 0, 0);
        }
        .btn-ripple:after {
            content: "";
            display: block;
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
            background-repeat: no-repeat;
            background-position: 50%;
            transform: scale(10, 10);
            opacity: 0;
            transition: transform .5s, opacity 1s;
        }
        .btn-ripple:active:after {
            transform: scale(0, 0);
            opacity: 0.3;
            transition: 0s;
        }
        /* Efek Tekan */
        .btn-press:active {
            transform: scale(0.95);
        }
    </style>
</head>

<body class="bg-[#F3F4F6] text-gray-900 antialiased overflow-x-hidden relative">
    
    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
            easing: 'ease-out-cubic',
        });

        // Mobile Menu Script
        const navToggle = document.getElementById('nav-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        if (navToggle && mobileMenu) {
            navToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>
</body>
</html>