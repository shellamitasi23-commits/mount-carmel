@extends('layouts.admin')
@section('title', 'Persetujuan Sertifikat Lahan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Persetujuan & TTD Sertifikat</h1>
    <p class="text-sm text-slate-500 mt-1">Daftar sertifikat hak guna lahan pemakaman yang memerlukan tanda tangan manajer operasional.</p>
</div>


<div class="bg-white border border-slate-100 rounded-xl shadow-sm p-4 mb-6">
    <form action="{{ route('manajer.sertifikat.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div class="md:col-span-2">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Cari Sertifikat / Pembeli</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pemilik, nomor sertifikat..." 
                   class="w-full px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
        </div>
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status Sertifikat</label>
            <select name="status" onchange="this.form.submit()" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2 text-sm font-bold outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all cursor-pointer">
                <option value="">Menunggu & Terbit</option>
                <option value="Menunggu TTD Pemilik" {{ request('status') == 'Menunggu TTD Pemilik' ? 'selected' : '' }}>Menunggu TTD Pemilik</option>
                <option value="Menunggu TTD Manajer" {{ request('status') == 'Menunggu TTD Manajer' ? 'selected' : '' }}>Menunggu TTD Manajer</option>
                <option value="Terbit" {{ request('status') == 'Terbit' ? 'selected' : '' }}>Terbit (Selesai)</option>
            </select>
        </div>
        <div>
            @if(request('search') || request('status'))
            <a href="{{ route('manajer.sertifikat.index') }}" 
               class="w-full bg-slate-100 text-slate-500 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-slate-200 transition-all text-center flex items-center justify-center h-[38px]">
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

@if($sertifikats->isEmpty())
<div class="py-12 text-center bg-white rounded-xl border border-slate-100 shadow-sm">
    <span class="material-icons-outlined text-5xl text-slate-200 block mb-3">workspace_premium</span>
    <p class="font-medium text-slate-500">Tidak ada sertifikat lahan yang ditemukan.</p>
</div>
@else

<div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <th class="px-6 py-4">Nomor & Lahan</th>
                    <th class="px-6 py-4">Pemilik & Jenazah</th>
                    <th class="px-6 py-4">Tanggal Terbit</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @foreach($sertifikats as $s)
                <tr class="hover:bg-slate-55/20 transition-all duration-150">
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800">{{ $s->nomor_sertifikat }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">{{ $s->lokasi_lahan }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-slate-700">{{ $s->nama_pemilik }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">
                            {{ $s->nama_jenazah ? 'Alm. ' . $s->nama_jenazah : 'Pre-Need' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-500">
                        {{ \Carbon\Carbon::parse($s->tanggal_terbit)->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($s->status_sertifikat === 'Terbit')
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-emerald-50 text-emerald-700 border border-emerald-100">
                                Terbit
                            </span>
                        @elseif($s->status_sertifikat === 'Menunggu TTD Manajer')
                            @if(is_null($s->ttd_manajer))
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-amber-50 text-amber-700 border border-amber-100">
                                    Menunggu TTD Anda
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-blue-50 text-blue-700 border border-blue-100">
                                    Sudah TTD (Menunggu Penerbitan)
                                </span>
                            @endif
                        @else
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-slate-100 text-slate-655 border border-slate-200">
                                {{ $s->status_sertifikat }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($s->status_sertifikat === 'Menunggu TTD Manajer')
                            @if(is_null($s->ttd_manajer))
                                <button onclick="openSignModal({{ $s->id }}, '{{ $s->nomor_sertifikat }}')"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#800000] text-white hover:bg-[#800000]/90 rounded-xl text-xs font-bold transition-all shadow-sm">
                                    <span class="material-icons-outlined text-sm">draw</span> Tanda Tangani
                                </button>
                            @else
                                <span class="text-xs text-slate-400 italic">Sudah TTD (Menunggu Marketing)</span>
                            @endif
                        @elseif($s->status_sertifikat === 'Terbit' && $s->file_sertifikat)
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('document.sertifikat', $s->reservasi_id) }}" target="_blank"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-100 hover:bg-emerald-100 rounded-xl text-xs font-bold transition-colors">
                                    <span class="material-icons-outlined text-sm">open_in_new</span> Lihat PNG
                                </a>
                            </div>
                        @else
                            <span class="text-xs text-slate-400 italic">Menunggu TTD Pemilik</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $sertifikats->links() }}
</div>

@endif


<div id="signModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg overflow-hidden shadow-2xl border border-slate-100 transform scale-95 opacity-0 transition-all duration-300" id="signModalContent">
        
        <div class="px-6 py-5 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
            <div>
                <h3 class="text-base font-bold text-slate-800">Tanda Tangan Manajer</h3>
                <p class="text-[10px] text-slate-400 mt-0.5" id="modalSertifikatNo">Sertifikat Nomor</p>
            </div>
            <button onclick="closeSignModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <span class="material-icons-outlined">close</span>
            </button>
        </div>

        <div class="p-6 space-y-6">
            @if($user->tanda_tangan)
                <div class="bg-emerald-50/50 border border-emerald-100 rounded-2xl p-4 flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold text-emerald-800">Tanda Tangan Terdaftar</p>
                        <p class="text-[10px] text-emerald-600 mt-0.5">Gunakan tanda tangan default yang tersimpan di profil Anda.</p>
                    </div>
                    <button onclick="signWithDefault()" class="shrink-0 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-sm transition-all">
                        Gunakan Default
                    </button>
                </div>
                
                <div class="flex items-center gap-3 my-4">
                    <div class="h-px bg-slate-100 flex-grow"></div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Atau Gambar Baru</span>
                    <div class="h-px bg-slate-100 flex-grow"></div>
                </div>
            @endif

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Gambar Tanda Tangan Anda</label>
                <div class="border border-slate-200 rounded-2xl overflow-hidden bg-slate-50 relative">
                    <canvas id="signatureCanvas" class="w-full h-44 cursor-crosshair block bg-slate-50"></canvas>
                    <button type="button" onclick="clearCanvas()" class="absolute right-3 bottom-3 bg-white border border-slate-200 hover:bg-slate-50 text-slate-500 rounded-lg p-1.5 shadow-sm transition-all" title="Clear Canvas">
                        <span class="material-icons-outlined text-sm block">delete</span>
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" id="saveAsDefault" class="rounded border-slate-200 text-[#800000] focus:ring-[#800000]/10 cursor-pointer">
                <label for="saveAsDefault" class="text-xs font-semibold text-slate-500 cursor-pointer">Simpan sebagai tanda tangan default saya</label>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-slate-50 flex justify-end gap-3 bg-slate-50/50">
            <button onclick="closeSignModal()" class="px-4 py-2 border border-slate-200 text-slate-500 hover:bg-slate-100 rounded-xl text-xs font-bold transition-all">Batal</button>
            <button onclick="signWithNew()" class="px-5 py-2 bg-[#800000] hover:bg-[#800000]/90 text-white rounded-xl text-xs font-bold shadow-sm transition-all">Bubuhkan TTD & Terbitkan</button>
        </div>

    </div>
</div>


<div id="loadingOverlay" class="fixed inset-0 bg-slate-900/80 backdrop-blur-md z-[60] hidden flex flex-col items-center justify-center text-white">
    <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-white mb-4"></div>
    <p class="font-bold text-sm tracking-wide" id="loadingText">Sedang memproses...</p>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    let activeSertifikatId = null;
    let activePreviewUrl = '';
    let activeCompileUrl = '';
    
    // Canvas Drawing Logic
    const canvas = document.getElementById('signatureCanvas');
    const ctx = canvas.getContext('2d');
    let drawing = false;

    // Adjust canvas dimensions inside canvas wrapper
    function resizeCanvas() {
        const rect = canvas.parentNode.getBoundingClientRect();
        canvas.width = rect.width;
        canvas.height = 176; // Match h-44 (176px)
        
        ctx.strokeStyle = '#1E1A16'; // Near black ink color
        ctx.lineWidth = 3;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
    }

    // Touch and mouse events for Canvas drawing
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

    function clearCanvas() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    // Modal Control
    function openSignModal(id, nomor, previewUrl, compileUrl) {
        activeSertifikatId = id;
        activePreviewUrl = previewUrl;
        activeCompileUrl = compileUrl;
        document.getElementById('modalSertifikatNo').textContent = 'Sertifikat Nomor ' + nomor;
        
        const modal = document.getElementById('signModal');
        const modalContent = document.getElementById('signModalContent');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
            resizeCanvas();
            clearCanvas();
        }, 10);
    }

    function closeSignModal() {
        const modal = document.getElementById('signModal');
        const modalContent = document.getElementById('signModalContent');
        
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            activeSertifikatId = null;
        }, 300);
    }

    // Sign with existing default signature
    function signWithDefault() {
        if (!activeSertifikatId) return;
        submitSignature({ use_default: 1 });
    }

    // Sign with new signature from Canvas
    function signWithNew() {
        if (!activeSertifikatId) return;

        // Check if canvas is empty
        const blank = document.createElement('canvas');
        blank.width = canvas.width;
        blank.height = canvas.height;
        if (canvas.toDataURL() === blank.toDataURL()) {
            alert('Silakan coret tanda tangan Anda terlebih dahulu.');
            return;
        }

        const dataUrl = canvas.toDataURL('image/png');
        const saveAsDefault = document.getElementById('saveAsDefault').checked ? 1 : 0;

        submitSignature({
            signature: dataUrl,
            save_as_default: saveAsDefault
        });
    }

    // Submit signature to database
    function submitSignature(payload) {
        showLoadingOverlay("Menyimpan tanda tangan...");
        closeSignModal();

        fetch(`/manajer/sertifikat/${activeSertifikatId}/sign`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            hideLoadingOverlay();
            if (data.success) {
                window.location.reload();
            } else {
                alert('Persetujuan gagal: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan koneksi.');
            hideLoadingOverlay();
        });
    }

    // Loading Overlay Helpers
    function showLoadingOverlay(text) {
        document.getElementById('loadingText').textContent = text;
        document.getElementById('loadingOverlay').classList.remove('hidden');
    }

    function hideLoadingOverlay() {
        document.getElementById('loadingOverlay').classList.add('hidden');
    }
</script>
@endsection
