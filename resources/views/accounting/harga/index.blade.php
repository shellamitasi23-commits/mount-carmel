@extends('layouts.admin')
@section('title', 'Kelola Harga Lahan')

@section('content')

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined text-sm">check_circle</span>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="flex justify-between items-start mb-6">
    <div>
        <h1 class="text-xl font-bold text-slate-800">Kelola Harga Lahan</h1>
        <p class="text-xs text-slate-500 mt-1">Ubah dan sesuaikan harga unit Lahan berdasarkan Cluster & tipe.</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden" x-data="{ openEditModal: null, editHarga: 0 }">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 text-slate-400 font-bold uppercase tracking-widest text-[10px] border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4">Lahan</th>
                    <th class="px-6 py-4">Cluster</th>
                    <th class="px-6 py-4">Tipe Lahan</th>
                    <th class="px-6 py-4">Dimensi / Kapasitas</th>
                    <th class="px-6 py-4">Harga Unit</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($kavlings as $kavling)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 font-bold text-slate-800">Lahan #{{ $kavling->nomor_kavling }}</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-slate-700">{{ $kavling->cluster?->nama_cluster ?? '-' }}</p>
                        <span class="inline-block mt-0.5 px-1.5 py-0.5 rounded text-[8px] font-black uppercase
                            {{ ($kavling->cluster?->kategori === 'Muslim') ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                            {{ $kavling->cluster?->kategori ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-semibold text-slate-600">{{ $kavling->tipe_kavling }}</td>
                    <td class="px-6 py-4 text-slate-500 font-medium">
                        {{ $kavling->ukuran }} • {{ $kavling->kapasitas }} Saringan
                    </td>
                    <td class="px-6 py-4 font-extrabold text-slate-900 text-sm">
                        Rp {{ number_format($kavling->harga, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-md text-[9px] font-black uppercase
                            {{ $kavling->status === 'Tersedia' ? 'bg-emerald-50 text-emerald-700' :
                               ($kavling->status === 'Dipesan' ? 'bg-amber-50 text-amber-700' : 'bg-slate-50 text-slate-500') }}">
                            {{ $kavling->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button @click="openEditModal = {{ $kavling->id }}; editHarga = {{ $kavling->harga }}"
                                class="inline-flex items-center gap-1.5 bg-slate-900 hover:bg-black text-white px-3 py-1.5 rounded-lg text-[10px] font-bold transition-all shadow-sm">
                            <span class="material-icons-outlined text-[13px]">edit</span> Ubah Harga
                        </button>
                    </td>
                </tr>

                {{-- Edit Price Modal (Tailwind CSS dynamic popup) --}}
                <div x-show="openEditModal === {{ $kavling->id }}"
                     class="fixed inset-0 z-50 overflow-y-auto"
                     x-cloak>
                    {{-- Backdrop --}}
                    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="openEditModal = null"></div>

                    {{-- Modal Body --}}
                    <div class="flex items-center justify-center min-h-screen p-4">
                        <div class="bg-white rounded-2xl max-w-sm w-full p-6 relative shadow-2xl border border-slate-100 z-10"
                             @click.stop>
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-sm font-black text-slate-800">Ubah Harga Unit</h3>
                                <button @click="openEditModal = null" class="text-slate-400 hover:text-slate-900">
                                    <span class="material-icons-outlined text-sm">close</span>
                                </button>
                            </div>

                            <p class="text-xs text-slate-400 leading-relaxed mb-4">
                                Silakan sesuaikan harga baru untuk <strong class="text-slate-700">Lahan #{{ $kavling->nomor_kavling }}</strong>.
                            </p>

                            <form action="{{ route('accounting.harga.update', $kavling->id) }}" method="POST" class="space-y-4">
                                @csrf @method('PUT')
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Harga Baru (Rupiah)</label>
                                    <input type="number" name="harga" x-model="editHarga" required min="0" step="1000"
                                           class="w-full px-4 py-3 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-slate-300">
                                </div>

                                <div class="flex justify-end gap-2 pt-2">
                                    <button type="button" @click="openEditModal = null"
                                            class="px-4 py-2.5 rounded-xl border border-slate-100 hover:bg-slate-50 text-slate-500 font-bold text-xs transition-colors">
                                        Batal
                                    </button>
                                    <button type="submit"
                                            class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-black text-white font-bold text-xs transition-all shadow-md">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-14 text-center text-slate-400 italic">
                        <span class="material-icons-outlined text-4xl text-slate-200 block mb-2">sell</span>
                        Belum ada unit Lahan tersedia untuk kelola harga.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
