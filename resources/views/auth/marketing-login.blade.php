<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal {{ $role }} - Mount Carmel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Roboto"', 'sans-serif'] },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.5s ease-out forwards',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Overrides excessive bold/black weights for cleaner look */
        .font-black, .font-extrabold {
            font-weight: 600 !important;
        }
        .font-bold {
            font-weight: 500 !important;
        }
        .font-semibold {
            font-weight: 500 !important;
        }
        /* Disable automatic capitalization of elements using Tailwind's uppercase */
        .uppercase {
            text-transform: none !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <div class="absolute top-[-10%] left-[-10%] w-[40rem] h-[40rem] bg-blue-50 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40rem] h-[40rem] bg-teal-50 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-[380px] bg-white rounded-[1.5rem] shadow-2xl shadow-slate-100/70 overflow-hidden relative z-10 border border-white animate-fade-in-up">
        
        <div class="px-8 pt-8 pb-5 text-center border-b border-slate-50 bg-slate-50/50 relative overflow-hidden">
            <div class="absolute inset-0 bg-white/40 backdrop-blur-sm"></div>
            
            <div class="relative z-10">
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Login {{ $role }}</h1>
                <h4 class="text-xs text-slate-400 mt-1 font-bold uppercase tracking-widest leading-none">Sistem Mount Carmel</h2>
            </div>
        </div>

        <div class="p-7">
            <form action="{{ $postUrl }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Alamat Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-slate-900 transition-colors">
                            <i class="bi bi-envelope text-xs"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" 
                            class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-100 rounded-xl focus:ring-4 focus:ring-[#800000]/5 focus:border-[#800000] transition-all outline-none text-slate-700 font-medium text-xs placeholder:text-slate-300 shadow-sm" 
                            placeholder="example@mountcarmel.id" required autofocus>
                    </div>
                </div>

                <div class="mb-5">
                    <div class="flex justify-between items-center mb-1.5 ml-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Password</label>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-slate-900 transition-colors">
                            <i class="bi bi-lock text-xs"></i>
                        </div>
                        
                        <input type="password" id="password" name="password" 
                            class="w-full pl-10 pr-10 py-2.5 bg-white border border-slate-100 rounded-xl focus:ring-4 focus:ring-[#800000]/5 focus:border-[#800000] transition-all outline-none text-slate-700 font-medium text-xs placeholder:text-slate-300 shadow-sm" 
                            placeholder="••••••••" required>
                        
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-300 hover:text-slate-900 transition-colors focus:outline-none">
                            <i id="eye-icon" class="bi bi-eye text-xs"></i>
                        </button>
                    </div>
                </div>

                @error('email')
                <div class="mb-5 flex items-center gap-2 bg-red-50 border border-red-100 px-3 py-2 rounded-lg text-red-600">
                    <i class="bi bi-exclamation-circle text-[10px]"></i>
                    <span class="text-[10px] font-bold uppercase tracking-wide leading-none">{{ $message }}</span>
                </div>
                @enderror

                <button type="submit" class="w-full bg-[#800000] hover:bg-[#800000]/90 text-white py-3 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 shadow-xl shadow-slate-200 hover:shadow-2xl hover:-translate-y-0.5 active:scale-[0.98]">
                    <span class="text-xs uppercase font-bold tracking-widest">Login Sistem</span>
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
</body>
</html>