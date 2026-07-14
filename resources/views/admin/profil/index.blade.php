@extends('layouts.admin')

@section('title', 'Profil Saya - Mount Carmel')

@push('styles')
<style>
    body { font-family: 'Inter', sans-serif !important; }
</style>
@endpush

@section('content')
<div x-data="{ tab: '{{ request('tab', 'data') }}' }" class="max-w-5xl mx-auto font-inter">
    
    <div class="mb-8">
        <h1 class="text-xl font-bold text-slate-800 tracking-tight">Pengaturan Profil</h1>
        <p class="text-xs text-slate-400 mt-1">Kelola informasi akun dan preferensi keamanan Anda.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm">
        <p class="text-emerald-800 font-semibold text-xs">Berhasil</p>
        <p class="text-emerald-700 text-[11px] font-medium mt-0.5">{{ session('success') }}</p>
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl shadow-sm">
        <p class="text-rose-800 text-xs font-semibold">Terdapat Kesalahan</p>
        <ul class="text-[11px] text-rose-700 list-disc list-inside space-y-0.5 mt-1 font-medium">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Tab Sidebar -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-100 p-5 shadow-[0_10px_30px_rgba(0,0,0,0.015)] space-y-1">
                
                <button @click="tab = 'data'"
                        :class="tab === 'data' ? 'bg-[#800000]/5 text-[#800000]' : 'text-slate-500 hover:bg-slate-50'"
                        class="w-full flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 text-left">
                    <span class="material-icons-outlined text-xl" :class="tab === 'data' ? 'text-[#800000]' : 'text-slate-400'">person</span>
                    <div>
                        <p class="text-xs font-semibold">Informasi Akun</p>
                        <p class="text-[9px] text-slate-400 mt-0.5">Ubah detail profil & data diri</p>
                    </div>
                </button>

                <button @click="tab = 'password'"
                        :class="tab === 'password' ? 'bg-[#800000]/5 text-[#800000]' : 'text-slate-500 hover:bg-slate-50'"
                        class="w-full flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 text-left">
                    <span class="material-icons-outlined text-xl" :class="tab === 'password' ? 'text-[#800000]' : 'text-slate-400'">lock</span>
                    <div>
                        <p class="text-xs font-semibold">Keamanan</p>
                        <p class="text-[9px] text-slate-400 mt-0.5">Perbarui kata sandi akun Anda</p>
                    </div>
                </button>

                @if($user->role === 'manajer')
                <button @click="tab = 'signature'; setTimeout(() => resizeCanvas(), 100);"
                        :class="tab === 'signature' ? 'bg-[#800000]/5 text-[#800000]' : 'text-slate-500 hover:bg-slate-50'"
                        class="w-full flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 text-left">
                    <span class="material-icons-outlined text-xl" :class="tab === 'signature' ? 'text-[#800000]' : 'text-slate-400'">draw</span>
                    <div>
                        <p class="text-xs font-semibold">Tanda Tangan</p>
                        <p class="text-[9px] text-slate-400 mt-0.5">Tanda tangan default Anda</p>
                    </div>
                </button>
                @endif

            </div>
        </div>

        <!-- Right Content Area -->
        <div class="lg:col-span-8">
            
            <!-- Tab: Informasi Pribadi -->
            <div x-show="tab === 'data'" x-transition class="bg-white rounded-3xl border border-slate-100 p-6 md:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.015)]">
                <div class="flex items-center gap-2 mb-6">
                    <span class="material-icons-outlined text-slate-400">badge</span>
                    <h3 class="text-base font-bold text-slate-800">Informasi Pribadi</h3>
                </div>
                
                <!-- Avatar Upload Card -->
                <div class="flex flex-col sm:flex-row items-center gap-5 mb-8 border-b border-slate-50 pb-6">
                    <div class="relative w-20 h-20 shrink-0">
                        <button type="button" onclick="document.getElementById('avatar-input').click()" 
                                class="w-full h-full rounded-2xl overflow-hidden bg-[#800000] flex items-center justify-center font-bold text-3xl text-white shadow-sm relative group">
                            @if($user->avatar)
                                <img src="{{ asset('storage/avatars/' . $user->avatar) }}" class="w-full h-full object-cover" alt="Foto Profil">
                            @else
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            @endif
                            <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center rounded-2xl">
                                <span class="material-icons-outlined text-white text-base">photo_camera</span>
                            </div>
                        </button>
                    </div>
                    <div class="text-center sm:text-left space-y-2">
                        <h4 class="text-xs font-semibold text-slate-500">Foto Profil Utama</h4>
                        <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
                            <button type="button" onclick="document.getElementById('avatar-input').click()" class="px-3.5 py-2 bg-[#800000] hover:bg-[#800000]/90 text-white rounded-xl text-xs font-semibold transition-all">Upload foto baru</button>
                            @if($user->avatar)
                            <button type="button" onclick="document.getElementById('delete-avatar-submit').click()" class="px-3.5 py-2 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 rounded-xl text-xs font-semibold transition-all">Hapus</button>
                            @endif
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.profil.update') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PATCH')
                    
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-4 pr-12 py-3.5 text-xs text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                            <span class="material-icons-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-base">edit</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Alamat Email</label>
                        <div class="relative">
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-4 pr-12 py-3.5 text-xs text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                            <span class="material-icons-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-base">edit</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">No. Telepon / WhatsApp</label>
                        <div class="relative">
                            <input type="text" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" placeholder="Belum diisi"
                                   class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-4 pr-12 py-3.5 text-xs text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                            <span class="material-icons-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-base">edit</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Alamat Domisili</label>
                        <div class="relative">
                            <textarea name="alamat" rows="3" placeholder="Belum diisi"
                                      class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-4 pr-12 py-3.5 text-xs text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all resize-none">{{ old('alamat', $user->alamat) }}</textarea>
                            <span class="material-icons-outlined absolute right-4 top-6 text-slate-400 text-base">edit</span>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-[#800000] hover:bg-[#800000]/90 text-white py-3 rounded-2xl font-semibold text-xs transition-all shadow-sm">Perbarui Profil</button>
                    </div>
                </form>
            </div>

            <!-- Tab: Keamanan -->
            <div x-show="tab === 'password'" style="display:none" x-transition class="bg-white rounded-3xl border border-slate-100 p-6 md:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.015)]">
                <div class="flex items-center gap-2 mb-6">
                    <span class="material-icons-outlined text-slate-400">lock_reset</span>
                    <h3 class="text-base font-bold text-slate-800">Keamanan Akun</h3>
                </div>
                
                <form action="{{ route('admin.profil.password') }}" method="POST" class="space-y-5" x-data="{ showCurr: false, showNew: false, showConf: false }">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Password Saat Ini</label>
                        <div class="relative">
                            <input :type="showCurr ? 'text' : 'password'" name="current_password" required
                                   class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-4 pr-12 py-3.5 text-xs text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                            <button type="button" @click="showCurr = !showCurr" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-650 transition-colors">
                                <span class="material-icons-outlined text-sm" x-text="showCurr ? 'visibility_off' : 'visibility'"></span>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Password Baru</label>
                        <div class="relative">
                            <input :type="showNew ? 'text' : 'password'" name="password" required
                                   class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-4 pr-12 py-3.5 text-xs text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                            <button type="button" @click="showNew = !showNew" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-650 transition-colors">
                                <span class="material-icons-outlined text-sm" x-text="showNew ? 'visibility_off' : 'visibility'"></span>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input :type="showConf ? 'text' : 'password'" name="password_confirmation" required
                                   class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-4 pr-12 py-3.5 text-xs text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                            <button type="button" @click="showConf = !showConf" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-650 transition-colors">
                                <span class="material-icons-outlined text-sm" x-text="showConf ? 'visibility_off' : 'visibility'"></span>
                            </button>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-[#800000] hover:bg-[#800000]/90 text-white py-3 rounded-2xl font-semibold text-xs transition-all shadow-sm">Update Password</button>
                    </div>
                </form>
            </div>

            <!-- Tab: Tanda Tangan -->
            @if($user->role === 'manajer')
            <div x-show="tab === 'signature'" style="display:none" x-transition class="bg-white rounded-3xl border border-slate-100 p-6 md:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.015)]">
                <div class="flex items-center gap-2 mb-2">
                    <span class="material-icons-outlined text-slate-400">draw</span>
                    <h3 class="text-base font-bold text-slate-800">Tanda Tangan Default</h3>
                </div>
                <p class="text-[10px] text-slate-400 mb-6">Kelola tanda tangan default Anda untuk membubuhkan tanda tangan pada sertifikat secara instan.</p>
                
                @if($user->tanda_tangan)
                    <div class="mb-6">
                        <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Tanda Tangan Saat Ini</label>
                        <div class="border border-slate-100 rounded-2xl p-4 bg-slate-50 inline-block">
                            <img src="{{ route('document.signature', $user->id) }}" class="h-24 object-contain" alt="Tanda Tangan Default">
                        </div>
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Gambar Baru</label>
                        <div class="border border-slate-200 rounded-2xl overflow-hidden bg-slate-50 relative">
                            <canvas id="signatureCanvas" class="w-full h-44 cursor-crosshair block bg-slate-50"></canvas>
                            <button type="button" onclick="clearCanvas()" class="absolute right-3 bottom-3 bg-white border border-slate-200 hover:bg-slate-50 text-slate-500 rounded-lg p-1.5 shadow-sm transition-all" title="Clear Canvas">
                                <span class="material-icons-outlined text-sm block">delete</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="pt-4">
                        <button type="button" onclick="saveSignature()" class="w-full bg-[#800000] hover:bg-[#800000]/90 text-white py-3 rounded-2xl font-semibold text-xs transition-all shadow-sm">Simpan Tanda Tangan</button>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
    
    <!-- Hidden Forms for Upload/Delete Avatar & Save Signature -->
    <form action="{{ route('admin.profil.avatar.update') }}" method="POST" enctype="multipart/form-data" id="avatar-form" class="hidden">
        @csrf
        @method('PATCH')
        <input type="file" name="avatar" id="avatar-input" accept="image/*" onchange="document.getElementById('avatar-form').submit()">
    </form>
    
    @if($user->avatar)
    <form action="{{ route('admin.profil.avatar.update') }}" method="POST" id="delete-avatar-form" class="hidden">
        @csrf
        @method('PATCH')
        <input type="hidden" name="remove_avatar" value="1">
        <button type="submit" id="delete-avatar-submit"></button>
    </form>
    @endif

    @if($user->role === 'manajer')
    <form action="{{ route('admin.profil.signature.save') }}" method="POST" id="signature-form" class="hidden">
        @csrf
        <input type="hidden" name="signature" id="signature-data">
    </form>
    @endif
    
</div>

@push('scripts')
<script>
    const canvas = document.getElementById('signatureCanvas');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        let drawing = false;

        function resizeCanvas() {
            const rect = canvas.parentNode.getBoundingClientRect();
            canvas.width = rect.width;
            canvas.height = 176; // Match h-44 (176px)
            
            ctx.strokeStyle = '#1E1A16'; // Near black ink color
            ctx.lineWidth = 3;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';
        }

        // Adjust canvas on load & resize
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        function getMousePos(e) {
            const rect = canvas.getBoundingClientRect();
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            return {
                x: clientX - rect.left,
                y: clientY - rect.top
            };
        }

        function startDrawing(e) {
            drawing = true;
            const pos = getMousePos(e);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
            e.preventDefault();
        }

        function draw(e) {
            if (!drawing) return;
            const pos = getMousePos(e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
            e.preventDefault();
        }

        function stopDrawing() {
            drawing = false;
        }

        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        window.addEventListener('mouseup', stopDrawing);

        canvas.addEventListener('touchstart', startDrawing, { passive: false });
        canvas.addEventListener('touchmove', draw, { passive: false });
        window.addEventListener('touchend', stopDrawing);

        window.clearCanvas = function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        };

        window.saveSignature = function() {
            // Check if canvas is empty
            const blank = document.createElement('canvas');
            blank.width = canvas.width;
            blank.height = canvas.height;
            if (canvas.toDataURL() === blank.toDataURL()) {
                alert('Silakan gambar tanda tangan terlebih dahulu.');
                return;
            }
            
            const dataUrl = canvas.toDataURL('image/png');
            document.getElementById('signature-data').value = dataUrl;
            document.getElementById('signature-form').submit();
        };
        
        // Expose to window so we can trigger it inside Alpine when tab changes
        window.resizeCanvas = resizeCanvas;
    }
</script>
@endpush
@endsection
