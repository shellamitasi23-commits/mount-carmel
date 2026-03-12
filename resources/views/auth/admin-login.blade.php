<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Mount Carmel</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 
                        sans: ['Inter', 'sans-serif'],
                        display: ['Poppins', 'sans-serif']
                    },
                    colors: {
                        navy: '#1a2332',
                        'navy-soft': '#2d3f55',
                        teal: '#4a9fb5',
                        'teal-dark': '#357f96',
                        bg: '#f3f4f6'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-navy min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-teal rounded-full mix-blend-multiply filter blur-[100px] opacity-20"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-[100px] opacity-20"></div>
    </div>

    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 relative z-10">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-navy rounded-2xl mb-4 shadow-lg">
                <span class="material-icons text-white text-3xl">admin_panel_settings</span>
            </div>
            <h1 class="text-2xl font-display font-bold text-gray-900">Admin </h1>
            <p class="text-sm text-gray-500 mt-1">Sistem Manajemen Mount Carmel</p>
        </div>

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <span class="material-icons text-lg">email</span>
                    </span>
                    <input type="email" name="email" class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal focus:border-transparent transition-all text-sm text-gray-900" placeholder="admin@mountcarmel.id" required autofocus>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <span class="material-icons text-lg">lock</span>
                    </span>
                    <input type="password" name="password" class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal focus:border-transparent transition-all text-sm text-gray-900" placeholder="••••••••" required>
                </div>
            </div>
            <div class="mb-6">
                </div>

            @error('email')
                <div class="mb-4 text-sm text-red-600 bg-red-50 p-3 rounded-lg border border-red-100">
                    {{ $message }}
                </div>
            @enderror

            <div class="flex items-center justify-between mb-8"></div>

            <button type="submit" class="w-full bg-teal hover:bg-teal-dark text-white font-semibold py-3 rounded-xl transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 duration-200">
                Masuk ke Dashboard
            </button>
        </form>

        <div class="mt-8 text-center border-t border-gray-100 pt-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-navy transition-colors">
                <span class="material-icons text-sm">arrow_back</span>
                Kembali ke Halaman Utama
            </a>
        </div>

    </div>

</body>
</html>