<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Manajemen - Mount Carmel</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
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
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <div class="absolute top-[-10%] left-[-10%] w-[40rem] h-[40rem] bg-blue-50 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40rem] h-[40rem] bg-teal-50 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-[380px] bg-white rounded-[1.5rem] shadow-2xl shadow-slate-100/70 overflow-hidden relative z-10 border border-white animate-fade-in-up">
        
        <div class="px-8 pt-8 pb-5 text-center border-b border-slate-50 bg-slate-50/50 relative overflow-hidden">
            <div class="absolute inset-0 bg-white/40 backdrop-blur-sm"></div>
            
            <div class="relative z-10">
                <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-xl shadow-slate-200 transform rotate-3 transition-transform hover:rotate-0 hover:scale-110 duration-300">
                    <i class="fa-solid fa-user-shield text-xl text-white -rotate-3"></i>
                </div>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Portal Manajemen</h1>
                <p class="text-[10px] text-slate-400 mt-1 font-bold uppercase tracking-widest leading-none">Mount Carmel System</p>
            </div>
        </div>

        <div class="p-7">
            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Alamat Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-slate-900 transition-colors">
                            <i class="fa-solid fa-envelope text-xs"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" 
                            class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-100 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 transition-all outline-none text-slate-700 font-medium text-xs placeholder:text-slate-300 shadow-sm" 
                            placeholder="example@mountcarmel.id" required autofocus>
                    </div>
                </div>

                <div class="mb-5">
                    <div class="flex justify-between items-center mb-1.5 ml-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Password</label>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-300 group-focus-within:text-slate-900 transition-colors">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </div>
                        
                        <input type="password" id="password" name="password" 
                            class="w-full pl-10 pr-10 py-2.5 bg-white border border-slate-100 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 transition-all outline-none text-slate-700 font-medium text-xs placeholder:text-slate-300 shadow-sm" 
                            placeholder="••••••••" required>
                        
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-300 hover:text-slate-900 transition-colors focus:outline-none">
                            <i id="eye-icon" class="fa-solid fa-eye text-xs"></i>
                        </button>
                    </div>
                </div>

                @error('email')
                <div class="mb-5 flex items-center gap-2 bg-red-50 border border-red-100 px-3 py-2 rounded-lg text-red-600">
                    <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                    <span class="text-[10px] font-bold uppercase tracking-wide leading-none">{{ $message }}</span>
                </div>
                @enderror

                <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white py-3 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 shadow-xl shadow-slate-200 hover:shadow-2xl hover:-translate-y-0.5 active:scale-[0.98]">
                    <span class="text-xs uppercase font-bold tracking-widest">Masuk Sistem</span>
                    <i class="fa-solid fa-arrow-right-to-bracket text-xs transition-transform group-hover:translate-x-1"></i>
                </button>
            </form>
        </div>

        <div class="px-8 py-4 bg-slate-50 border-t border-slate-100 text-center relative overflow-hidden">
             <div class="absolute inset-0 bg-white/40 backdrop-blur-sm"></div>
            
            <a href="{{ route('home') }}" class="relative z-10 text-[10px] font-black text-slate-400 hover:text-slate-900 transition-colors flex items-center justify-center gap-1.5 uppercase tracking-widest">
                <i class="fa-solid fa-house"></i> Beranda
            </a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>