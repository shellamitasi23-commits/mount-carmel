<!DOCTYPE html>
<html lang="id" class="scroll-smooth overflow-x-hidden">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'Mount Carmel Cluster')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js']) 

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    {{-- External Master Layout CSS --}}
    <link rel="stylesheet" href="{{ asset('css/master.css') }}"/>
</head> 

<body class="bg-[#F3F4F6] text-gray-900 antialiased overflow-x-hidden relative">
    
    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- External Master Layout JS --}}
    <script src="{{ asset('js/master.js') }}"></script>
</body>
</html>