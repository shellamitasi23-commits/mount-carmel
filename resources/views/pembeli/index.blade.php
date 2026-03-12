@extends('layouts.master')

@section('title', 'Beranda - Mount Carmel Cluster')

@section('content')

<style>
    /* Animasi Tekan (Press) */
    .btn-press:active { transform: scale(0.95); }
    
    /* Animasi Riak Air (Ripple) */
    .btn-ripple { position: relative; overflow: hidden; transform: translate3d(0, 0, 0); }
    .btn-ripple:after {
        content: ""; display: block; position: absolute; width: 100%; height: 100%; top: 0; left: 0;
        pointer-events: none; background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
        background-repeat: no-repeat; background-position: 50%; transform: scale(10, 10); opacity: 0;
        transition: transform .5s, opacity 1s;
    }
    .btn-ripple:active:after { transform: scale(0, 0); opacity: 0.3; transition: 0s; }
</style>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<header class="relative overflow-hidden min-h-screen flex flex-col pt-40 px-8 xl:px-24">
    <div data-aos="fade-in" data-aos-duration="1500" class="absolute top-0 right-0 w-1/2 h-full bg-primary/20 rounded-bl-[200px] -z-10 dark:bg-primary/10"></div>
    <div data-aos="fade-in" data-aos-duration="2000" class="absolute -top-32 -left-32 w-96 h-96 bg-primary/30 rounded-full blur-3xl -z-10 dark:bg-primary/20"></div>
    
    <div class="flex-grow flex flex-col justify-center relative z-10 pb-20">
        <h1 data-aos="fade-up" data-aos-delay="0" class="text-6xl md:text-8xl font-bold max-w-4xl leading-tight tracking-tight mb-12">
            Mount Carmel Cluster Madinah
        </h1>

        <h4 data-aos="fade-up" data-aos-delay="100" class="text-xl md:text-2xl font-serif font-semibold italic text-gray-700 dark:text-gray-300 max-w-2xl mb-12">
            "Berikan yang terbaik untuk terakhir kalinya"
        </h4>
        
        <div data-aos="zoom-in" data-aos-delay="200" data-aos-duration="1000" class="relative w-full h-[500px] rounded-[2rem] overflow-hidden shadow-2xl group">
            <img alt="Pemandangan indah pemakaman" class="w-full h-full object-cover object-center transform transition-transform duration-700 group-hover:scale-105"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuC1NyIlZmBiYtT_kIu9sIln0H_-6RueC2Hhc_d6kZXH1IScjujHYPs6awIbu5dRMlY6nh3OHS1NSyx_fBcV7oOIg267GAnn0m7Dmy2SYQtQcbdLRfesZdEgbtNBETqCuWIVnqGkcdMwWMXj_pXaa-9yAZFgRqIMFAYsbtXSydiAp8yeFKTcA-sa0Emlh4YOvMdCaPtYTaF9zS1c7aKDxKlmU_zIPST46YbjjlfflaEwp9vViTnYZ990e-nAoVM2fkKAhJwzbhau-yI" />
            
            <div data-aos="fade-right" data-aos-delay="500" class="absolute bottom-8 left-8 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md p-6 rounded-2xl shadow-lg max-w-sm transition-transform hover:-translate-y-2 hidden md:block cursor-pointer btn-press">
                <img alt="Pratinjau cluster" class="w-full h-40 object-cover rounded-xl mb-4" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCKKlS1j_Zt3H2_tLdwUcZy3qankghtW1i1Z_CwZctvMaNAB6rj9WvYrHL3jwoPljnQjbwgX-wOB61mlkFoHUxqt_S0zV7NoHPF5t1gTcZ2wb4P0HKv7ripuN0rO5W71tkzxVnzxIqaQ7Dc8p0S0QKYT3crM1aj8H3wq0lQGPx-n4dJSc0DoENon9u9Nc60JG6ou2rOUQ8pD9s7UXqTxyMGomfOJ1FK5F3h_NAMcq3XGhEcG-GAfKcf3n8lzikz-kwhBLb0QNuLmLc" />
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-900 dark:text-white">Lihat Semua Cluster</span>
                    <span class="material-icons text-gray-500">arrow_forward</span>
                </div>
            </div>
            
            <div data-aos="fade-left" data-aos-delay="700" class="absolute bottom-32 right-8 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md p-6 rounded-2xl shadow-lg max-w-sm transition-transform hover:-translate-y-2 hidden md:block cursor-pointer btn-press">
                <img alt="Pratinjau layanan" class="w-full h-40 object-cover rounded-xl mb-4" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDOy1Fohlq_qivWE2tkM433deJqLAQ3UogU5-WSqG19mRZNu9OmlEuPQ1U06tbq0gdMbF0Ck-PAYzTBMlskj5DAkT-uNDwHpskU1Dl1eoUeygiIidyS5eeHLFpz0zt2d1TIfYlbxRLfJx1o_DXE7pH0PxPeyGigVt9a_ryqk2-e_iNR8oUYCQxyFMTCES7kBIrLIOpYtrlVK4vi9pO0ZbGqRBYIW7YG7GGQuf_tf8GP3pXp_wb8cb0_x4OhwB-nGxmxFINL8LCrYYQ" />
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-900 dark:text-white">Layanan Kami</span>
                    <span class="material-icons text-gray-500">arrow_forward</span>
                </div>
            </div>
            
            <div data-aos="fade-up" data-aos-delay="900" class="absolute bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-6 bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm py-3 px-8 rounded-full">
                <span class="text-sm font-medium uppercase tracking-wider text-gray-800 dark:text-gray-200">Watch a video</span>
                <button class="btn-ripple btn-press w-16 h-16 bg-primary text-gray-900 rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
                    <span class="material-icons text-3xl">play_arrow</span>
                </button>
                <span class="text-sm font-medium uppercase tracking-wider text-gray-800 dark:text-gray-200">Tentang Kami</span>
            </div>
        </div>
    </div>
</header>

<section class="py-24 px-8 xl:px-24 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-16">
        <div class="md:w-1/2 flex flex-col justify-between">
            <div data-aos="fade-right">
                <h2 class="text-5xl font-bold mb-8 leading-tight">Keindahan Hening dan Ketentraman Mendalam</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-8">
                    Cluster dirancang menggunakan metode desain berdampak rendah yang memeluk kontur alami tanah.
                </p>
            </div>
            <div class="flex gap-6">
                <img data-aos="fade-up" data-aos-delay="100" alt="Jalur penuh ketenangan" class="w-1/2 h-64 object-cover rounded-2xl shadow-md" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCSeV8r5vTKVZson8x8U7XKosDU4OBIVwZCPNZOGiv7g8lL5mQYOegvqR47c2dPLgGFWhnrnslq9ErpprziLGhdeyqqystblfmKjcXSYUs3Ex5arOXBjjL80xf80mRmXZS6gCg9ShL7wBZ09_YS6GYhWfYN8ngIMMJKxo-PMrFVAhpyGaPNnDwhj0B12HdNVsq6MbUvK0TVpR3IYfH2whIB76pNLxyD6Zc2Asd_nuvAYJufsHTjqWMGi_EKBGJGKb7I688tdFK_1Qw" />
                <img data-aos="fade-up" data-aos-delay="200" alt="Alam tenang" class="w-1/2 h-64 object-cover rounded-2xl shadow-md" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC84fEtfZb8hWa8DG2uJJfLUZGCaLm5oOnQI0MHj2S6K5kwbfoCHJseJ0nNLKVR_yh8U1W9MSn7c9b1uZeAWC3mjLXJHYtd4R7_oQcvB0nZeBHp2-33dtHJPAdie6SAHmyx2wWFg6PDA7K7Cio3YuEF2GfixpWADifW8iIZGvnYnuDU0DHY_nNJVwJZPUEJjX_OAFnbE7VCZuUlC-ufcD-_1rp5Olu60H67Ih9XH2AZSPPvqiVWhtGOGGCjSDWO_tBe89VFeTumpjk" />
            </div>
        </div>
        <div class="md:w-1/2 flex flex-col items-end">
            <a data-aos="fade-left" class="btn-ripple btn-press px-8 py-4 bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 font-semibold rounded-full hover:bg-gray-800 dark:hover:bg-white transition-colors mb-16 shadow-md inline-block" href="#">
                Pelajari Lebih Lanjut
            </a>
            <p data-aos="fade-left" data-aos-delay="100" class="text-gray-600 dark:text-gray-400 leading-relaxed max-w-md text-right mb-12">
                Lanskap dibentuk dengan metode berdampak rendah yang memeluk kontur alami tanah.
            </p>
            <img data-aos="zoom-in-up" data-aos-delay="200" alt="Taman damai" class="w-full h-80 object-cover rounded-2xl shadow-lg mt-auto" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA2MjBzlOb1Xtp-slKDXU-ymQdqBY3DBvmaPs-yG7PM8xWCw3Cs_jfc_lXkDC8sM5fk5Z4KR03A9B3UsbY5gqp5KpPKJukm9TjaZfFpAilL9XT-qVOY9uC9FFyyRLWPmEguiKFajZUbGA3kwYyih3DAgCkgKpW3Hqjl0nHQrzo80r878DfsvpYBLB5Yw4qAnJ30FpDYd-78LnX8zVPRO5B3PFWosU_d6g5-WrjDnlNmIDoTPdVYecEUFhZmQYXXCCZapMRsxt8baCo" />
        </div>
    </div>
    <hr class="mt-32 border-gray-200 dark:border-gray-800 max-w-7xl mx-auto" />
</section>

<section class="py-24 px-8 xl:px-24 bg-background-light dark:bg-background-dark">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start mb-16">
            <h2 data-aos="fade-right" class="text-5xl font-bold max-w-sm leading-tight">Kehidupan di Taman Perdamaian</h2>
            <div data-aos="fade-left" class="flex flex-col items-end max-w-lg text-right mt-8 md:mt-0">
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-6">
                    Ruang-ruang dibuat dengan metode bangunan berdampak rendah yang memeluk kontur alami tanah.
                </p>
                <a class="btn-ripple btn-press px-8 py-4 bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 font-semibold rounded-full hover:bg-gray-800 dark:hover:bg-white transition-colors shadow-md inline-block" href="#">
                    Lihat Semua Area
                </a>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row gap-16">
            <div class="lg:w-1/4 flex flex-col gap-6" data-aos="fade-up">
                <button data-aos="fade-up" data-aos-delay="0" class="text-left text-2xl font-bold text-gray-900 dark:text-white border-b-2 border-gray-900 dark:border-white pb-2 w-max">Muslim Cluster</button>
                <button data-aos="fade-up" data-aos-delay="100" class="text-left text-2xl font-medium text-gray-400 dark:text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors w-max">Cluster Non-Muslim</button>
                <button data-aos="fade-up" data-aos-delay="200" class="text-left text-2xl font-medium text-gray-400 dark:text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors w-max">Kavling Keluarga</button>
                <button data-aos="fade-up" data-aos-delay="300" class="text-left text-2xl font-medium text-gray-400 dark:text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors w-max">Kavling Tunggal</button>
                
                <a data-aos="fade-in" data-aos-delay="400" class="mt-auto inline-flex items-center text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors pt-12" href="#">
                    Detail Akomodasi <span class="material-icons ml-2 text-sm">arrow_forward</span>
                </a>
            </div>
            <div class="lg:w-3/4 relative">
                <div data-aos="fade-left" data-aos-duration="1000" class="w-full h-[600px] rounded-3xl overflow-hidden shadow-2xl relative">
                    <img alt="Pemandangan indah sebuah cluster" class="w-full h-full object-cover object-center" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA6rqI9PeXcrrGEttejmy2Cel3avh8VDbuuLZ9znSeQ0Gw8_f3nDIPA5daXuk1lNSAm-tWxpJ6GMjkfk9Tp4ugchXR-TAxa51kf5RD--deEWZYCqfHqwdgP2haxZx3xe7cTs56uTS0TFSEdFgax5uGIbYCrGwAW6cxENUzjoD6JXr0AiwuyMq0RGnXuNAwZgLJIJ_7ohB4P4zHoRvO2BfqUnDNpU9LpoqSZub_tqXvtwDa3MXakwPvYeN3NT97N3pe77_3ygdwuIsc" />
                </div>
            </div>
        </div>
    </div>
</section>

<section id="tipe-kavling" class="py-24 px-8 xl:px-24 bg-white dark:bg-gray-900 relative">
    <div class="max-w-7xl mx-auto">
        
        <div class="text-center mb-16">
            <span data-aos="fade-up" class="text-primary font-bold tracking-widest uppercase text-sm">Pilihan Kavling</span>
            <h2 data-aos="fade-up" data-aos-delay="100" class="text-4xl md:text-5xl font-bold mt-2 leading-tight">Spesifikasi & Ukuran</h2>
            <p data-aos="fade-up" data-aos-delay="200" class="text-gray-500 mt-4 max-w-2xl mx-auto">Tersedia berbagai pilihan tipe kavling untuk kenyamanan peristirahatan keluarga Anda.</p>
        </div>

        <div x-data="{ activeTab: 'muslim' }" class="w-full">
            
            <div data-aos="fade-up" data-aos-delay="200" class="flex justify-center mb-12">
                <div class="bg-gray-100 dark:bg-gray-800 p-1 rounded-full inline-flex relative shadow-sm border border-gray-200 dark:border-gray-700">
                    <button @click="activeTab = 'muslim'" 
                            :class="{ 'bg-primary text-gray-900 shadow-md': activeTab === 'muslim', 'text-gray-500 hover:text-gray-900 dark:hover:text-white': activeTab !== 'muslim' }"
                            class="btn-press px-6 md:px-10 py-3 rounded-full text-sm font-bold transition-all duration-300">
                        Cluster Muslim
                    </button>
                    <button @click="activeTab = 'non_muslim'" 
                            :class="{ 'bg-gray-900 text-white shadow-md': activeTab === 'non_muslim', 'text-gray-500 hover:text-gray-900 dark:hover:text-white': activeTab !== 'non_muslim' }"
                            class="btn-press px-6 md:px-10 py-3 rounded-full text-sm font-bold transition-all duration-300">
                        Cluster Non-Muslim
                    </button>
                </div>
            </div>

            <div class="relative min-h-[500px]">
                
                <div x-show="activeTab === 'muslim'" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    @php
                        $muslimTypes = [
                            ['name' => 'Tipe Barokah', 'size' => '1.5m x 2.5m', 'max' => 1],
                            ['name' => 'Tipe Fitrah', 'size' => '4m x 3m', 'max' => 2],
                            ['name' => 'Tipe Sakinah', 'size' => '7m x 8m', 'max' => 6],
                            ['name' => 'Tipe Khalifah', 'size' => '7m x 15m', 'max' => 12],
                        ];
                    @endphp

                    @foreach($muslimTypes as $item)
                    <div class="group relative bg-white dark:bg-gray-800 border border-emerald-100 dark:border-gray-700 rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 flex flex-col">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                            <span class="material-icons text-6xl text-emerald-600">mosque</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ $item['name'] }}</h3>
                        
                        <div class="w-full h-32 bg-emerald-50 dark:bg-emerald-900/20 border-2 border-dashed border-emerald-200 dark:border-emerald-700 rounded-lg flex flex-col items-center justify-center mb-4 relative overflow-hidden">
                            <span class="text-[10px] uppercase font-bold text-emerald-400 absolute top-2 left-2">Denah</span>
                            <span class="text-lg font-bold text-emerald-700 dark:text-emerald-300">{{ $item['size'] }}</span>
                        </div>

                        <div class="mt-auto border-t border-gray-100 dark:border-gray-700 pt-4 flex justify-between items-center">
                            <span class="text-xs font-bold uppercase text-gray-400">Max Isi</span>
                            <span class="flex items-center gap-1 font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 px-3 py-1 rounded-full text-sm">
                                <span class="material-icons text-sm">person</span> {{ $item['max'] }}
                            </span>
                        </div>
                        <button class="btn-ripple btn-press mt-4 w-full py-2 bg-emerald-600 text-white rounded-lg text-sm font-bold hover:bg-emerald-700 transition-colors">
                            Pilih Tipe Ini
                        </button>
                    </div>
                    @endforeach
                </div>

                <div x-show="activeTab === 'non_muslim'" style="display: none;"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    @php
                        $nonMuslimTypes = [
                            ['name' => 'Single', 'size' => '1.5m x 4m', 'max' => 1],
                            ['name' => 'Double', 'size' => '3m x 4m', 'max' => 2],
                            ['name' => 'Double Deluxe', 'size' => '4m x 4.5m', 'max' => 2],
                            ['name' => 'Double Special', 'size' => '8m x 4.5m', 'max' => 4],
                            ['name' => 'Family', 'size' => '8m x 5m', 'max' => 4],
                            ['name' => 'Super Family', 'size' => '8m x 10m', 'max' => 6],
                            ['name' => 'Royal Family', 'size' => '16m x 20m', 'max' => 10],
                            ['name' => 'VIP', 'size' => '26m x 36m', 'max' => 18],
                        ];
                    @endphp

                    @foreach($nonMuslimTypes as $item)
                    <div class="group relative bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 flex flex-col">
                         <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <span class="material-icons text-6xl text-gray-900 dark:text-white">church</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 truncate">{{ $item['name'] }}</h3>

                        <div class="w-full h-24 bg-gray-50 dark:bg-gray-700/30 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg flex flex-col items-center justify-center mb-4">
                            <span class="text-sm font-bold text-gray-600 dark:text-gray-300">{{ $item['size'] }}</span>
                        </div>

                        <div class="mt-auto border-t border-gray-100 dark:border-gray-700 pt-4 flex justify-between items-center">
                            <span class="text-xs font-bold uppercase text-gray-400">Max Isi</span>
                            <span class="flex items-center gap-1 font-bold text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full text-sm">
                                <span class="material-icons text-sm">groups</span> {{ $item['max'] }}
                            </span>
                        </div>
                         <button class="btn-ripple btn-press mt-4 w-full py-2 border border-gray-900 dark:border-white text-gray-900 dark:text-white hover:bg-gray-900 hover:text-white dark:hover:bg-white dark:hover:text-gray-900 rounded-lg text-sm font-bold transition-colors">
                            Lihat Detail
                        </button>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</section>
<section class="relative bg-[#E8EEF2] dark:bg-gray-800 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" preserveAspectRatio="none" viewBox="0 0 100 100">
            <polygon fill="currentColor" points="0,0 100,0 50,100"></polygon>
        </svg>
    </div>
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center relative z-10">
        <div class="md:w-1/2 p-12 md:p-24 flex flex-col justify-center">
            <span data-aos="fade-down" class="text-6xl text-primary font-serif leading-none mb-6">"</span>
            <p data-aos="fade-right" data-aos-delay="100" class="text-2xl font-medium italic text-gray-800 dark:text-gray-200 leading-relaxed mb-12">
                Menemukan tempat peristirahatan di sini seperti memasuki dunia lain. Setiap area menceritakan kisahnya sendiri.
            </p>
            <div data-aos="fade-up" data-aos-delay="200" class="flex justify-between items-end border-t border-gray-300 dark:border-gray-600 pt-8">
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white">Keluarga Lee</h4>
                    <p class="text-sm text-gray-500">Jakarta</p>
                </div>
            </div>
        </div>
        <div data-aos="fade-left" class="md:w-1/2 h-full min-h-[500px] bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuC3I2CHNiF3TYUXpoG8iu9-vLap7F1U4TBu_LmtLP2y-mmB4Om_mKa2hJFdKYGZpYohYYztH82qkY8iC4O_fV1x0r3XagqVTEK2Cpx5p6XuP40-6m1fCrMX1YpnL4JeWD2IWnF_bLl88rpISIucKfB5_D32F8WffiNiSIv8CjiWb-uSo6fHJgVQJTMH2JM5kVbaJyky6lYauNngTmKKsZGaLsZzyi_A1mGkujVgFlF8tIA7IrVyEjnJz8kg51m_c0YDGUwQIOt0qvQ');"></div>
    </div>
</section>

<section class="px-8 xl:px-24 py-24 bg-white dark:bg-gray-900">
    <div data-aos="zoom-in" data-aos-duration="1000" class="max-w-7xl mx-auto bg-gray-500 dark:bg-gray-800 rounded-3xl overflow-hidden relative flex flex-col justify-center p-16 md:p-24 min-h-[500px]">
        <div class="relative z-10 max-w-2xl text-white">
            <p class="text-sm font-bold tracking-widest uppercase mb-6 text-primary">We Are Waiting For You</p>
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-12">
                Come Find the Place Your Soul Already Knows
            </h2>
            <a class="btn-ripple btn-press inline-block px-8 py-4 bg-white text-gray-900 font-bold rounded-full hover:bg-gray-100 transition-colors shadow-lg hover:scale-105 transform duration-300" href="#">
                Pesan Kunjungan
            </a>
        </div>
    </div>
</section>
@endsection