<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ appProfile()->app_name }} - {{ appProfile()->tagline ?? 'Pelayanan Profesional' }}</title>
    @if(appProfile()->logo_path)
        <link rel="icon" href="{{ asset('storage/' . appProfile()->logo_path) }}" type="image/png">
    @endif

    <!-- Tailwind CSS + DaisyUI -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts - Poppins (lebih mirip referensi) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Voice Guide Fallback */
        #voice-guide-fallback {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            animation: slideInUp 0.3s ease-out;
        }

        .vg-fallback-card {
            max-width: 320px;
            background: #ffffff;
            color: #1e293b;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #f97316;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            font-size: 14px;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-slate-50">

    <!-- Navbar -->
    <div class="navbar bg-white shadow-md px-6 py-3 sticky top-0 z-50 border-b border-gray-200">
        <div class="navbar-start">
            <a href="/" class="flex items-center gap-3">
                @if(appProfile()->logo_path)
                    <img src="{{ asset('storage/' . appProfile()->logo_path) }}" alt="Logo"
                        class="w-12 h-12 object-contain rounded-lg bg-white shadow-sm p-1"
                        style="max-height: 48px; width: auto;">
                @else
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fas fa-landmark text-white text-lg"></i>
                    </div>
                @endif
                <div>
                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide">
                        {{ strtoupper(appProfile()->region_name) }}
                    </div>
                    <div class="text-[10px] text-gray-500">{{ appProfile()->app_name }}</div>
                </div>
            </a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1 gap-1">
                <li><a href="#layanan"
                        class="text-sm font-medium text-gray-600 hover:text-teal-600 hover:bg-teal-50 rounded-lg">Layanan</a>
                </li>
                <li><a href="#wilayah"
                        class="text-sm font-medium text-gray-600 hover:text-teal-600 hover:bg-teal-50 rounded-lg">Pariwisata</a>
                </li>
                <li><a href="#berita"
                        class="text-sm font-medium text-gray-600 hover:text-teal-600 hover:bg-teal-50 rounded-lg">Berita</a>
                </li>
            </ul>
        </div>
        <div class="navbar-end">
            <a href="{{ route('login') }}"
                class="btn btn-sm bg-teal-600 hover:bg-teal-700 text-white border-0 rounded-lg px-5 font-medium shadow-sm">Masuk</a>
        </div>
    </div>

    @if(isset($publicAnnouncements) && $publicAnnouncements->count() > 0)
        <div class="bg-white border-b border-gray-100 overflow-hidden py-2 relative group">
            <div class="flex items-center">
                <div
                    class="bg-white pl-6 pr-4 z-10 flex items-center gap-2 text-teal-600 font-bold text-xs uppercase tracking-widest border-r border-gray-100">
                    <i class="fas fa-bullhorn animate-pulse"></i> <span>Info</span>
                </div>
                <div class="ticker-wrap flex-1 overflow-hidden whitespace-nowrap">
                    <div class="ticker-move inline-block hover:pause-animation">
                        @foreach($publicAnnouncements as $ann)
                            <span class="inline-block px-8 text-sm text-slate-600 font-medium">
                                <span class="text-teal-500 mr-2">•</span> {{ $ann->content }}
                            </span>
                        @endforeach
                        @foreach($publicAnnouncements as $ann)
                            <span class="inline-block px-8 text-sm text-slate-600 font-medium">
                                <span class="text-teal-500 mr-2">•</span> {{ $ann->content }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <style>
            .ticker-wrap {
                width: 100%;
            }

            .ticker-move {
                display: inline-block;
                white-space: nowrap;
                padding-right: 100%;
                animation: ticker 60s linear infinite;
            }

            .hover\:pause-animation:hover {
                animation-play-state: paused;
            }

            @keyframes ticker {
                0% {
                    transform: translateX(0);
                }

                100% {
                    transform: translateX(-100%);
                }
            }
        </style>
    @endif

    <!-- Hero Section -->
    <div
        class="hero min-h-[65vh] bg-gradient-to-br from-slate-50 via-white to-teal-50/30 relative overflow-hidden group">
        <!-- Decorative Leader Image (Dynamic from Admin) -->
        @if(app(\App\Services\ApplicationProfileService::class)->isHeroImageActive() && app(\App\Services\ApplicationProfileService::class)->getHeroImage())
            <div
                class="absolute right-0 bottom-0 z-0 hidden lg:block pointer-events-none select-none translate-x-10 translate-y-5 transition-transform duration-700 group-hover:translate-x-5">
                <img src="{{ app(\App\Services\ApplicationProfileService::class)->getHeroImage() }}"
                    onerror="this.style.display='none'"
                    alt="{{ app(\App\Services\ApplicationProfileService::class)->getHeroImageAlt() }}"
                    class="h-[450px] w-auto object-contain drop-shadow-2xl opacity-90"
                    style="mask-image: linear-gradient(to bottom, black 85%, transparent 100%); -webkit-mask-image: linear-gradient(to bottom, black 85%, transparent 100%);">
            </div>
        @endif

        <div class="hero-content text-center py-16 relative z-10">
            <div class="max-w-4xl">
                <div
                    class="inline-flex items-center gap-2 bg-teal-50 text-teal-700 border border-teal-200 px-4 py-2 rounded-full mb-6 text-sm font-medium">
                    <i class="fas fa-certificate text-xs"></i>
                    <span>Sistem Administrasi Pemerintah Resmi</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-5 leading-tight">
                    Transformasi <span class="text-teal-600">Pelayanan</span><br class="hidden md:block">
                    {{ appProfile()->app_name }}
                </h1>
                <p class="text-base md:text-lg text-gray-600 mb-8 max-w-2xl mx-auto leading-relaxed">
                    {{ appProfile()->tagline ?? 'Mewujudkan tata kelola wilayah yang profesional, transparan, dan terintegrasi.' }}
                </p>
                <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                    <button onclick="document.getElementById('publicServiceModal').showModal()"
                        class="btn bg-teal-600 hover:bg-teal-700 text-white border-0 btn-lg rounded-2xl px-10 font-bold shadow-xl hover:shadow-2xl hover:scale-105 transition-all py-4 h-auto relative z-20">
                        Sampaikan Layanan / Pengaduan <i class="fas fa-hand-holding-heart ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- INTERNAL ACCESS: Method A (Quick Access Strip) -->
    <!-- Isolated Container: Low Z-Index, Relative Position, No Overlap with Global ID -->
    @auth
        @if(auth()->user()->hasRole('Operator Kecamatan') || auth()->user()->hasRole('Super Admin'))
            <div
                style="background-color: #f8fafc; border-bottom: 1px dashed #cbd5e1; padding: 10px 0; position: relative; z-index: 10;">
                <div class="container mx-auto px-6 flex justify-center md:justify-end">
                    <a href="{{ route('kecamatan.pelayanan.visitor.index') }}"
                        class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-teal-600 transition-colors px-4 py-1.5 rounded-full border border-slate-200 bg-white hover:border-teal-200 hover:bg-teal-50 hover:shadow-sm no-underline decoration-0">
                        <i class="fas fa-book-open text-teal-500"></i>
                        <span>Akses Internal: Buku Tamu Digital</span>
                        <i class="fas fa-external-link-alt text-[10px] ml-1 opacity-50"></i>
                    </a>
                </div>
            </div>
        @endif
    @endauth
    <!-- END INTERNAL ACCESS -->

    <!-- Layanan Kami Section -->
    <div id="layanan" class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-800 mb-3">Layanan Kami</h2>
                <p class="text-sm text-gray-500 max-w-2xl mx-auto">
                    Berbagai fasilitas kemudahan administrasi yang dirancang khusus untuk kenyamanan Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 max-w-5xl mx-auto">
                <!-- Card 1: Bebas Biaya -->
                <div
                    class="card bg-white hover:shadow-lg transition-all duration-300 border border-gray-200 rounded-xl">
                    <div class="card-body items-center text-center p-6">
                        <div class="w-14 h-14 bg-emerald-50 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-wallet text-emerald-600 text-2xl"></i>
                        </div>
                        <h3 class="text-base font-semibold text-gray-800 mb-2">Bebas Biaya</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Seluruh proses administrasi bersifat resmi dan tidak dipungut biaya apapun sesuai regulasi.
                        </p>
                    </div>
                </div>

                <!-- Card 2: Privasi Terjaga -->
                <div
                    class="card bg-white hover:shadow-lg transition-all duration-300 border border-gray-200 rounded-xl">
                    <div class="card-body items-center text-center p-6">
                        <div class="w-14 h-14 bg-blue-50 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-user-shield text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="text-base font-semibold text-gray-800 mb-2">Privasi Terjaga</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Data Anda aman terlindungi dalam sistem terenkripsi untuk mencegah penyalahgunaan informasi.
                        </p>
                    </div>
                </div>

                <!-- Card 3: Proses Terukur -->
                <div
                    class="card bg-white hover:shadow-lg transition-all duration-300 border border-gray-200 rounded-xl">
                    <div class="card-body items-center text-center p-6">
                        <div class="w-14 h-14 bg-amber-50 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-bolt text-amber-600 text-2xl"></i>
                        </div>
                        <h3 class="text-base font-semibold text-gray-800 mb-2">Proses Terukur</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Workflow yang jelas memastikan setiap pengajuan memiliki estimasi waktu penyelesaian yang
                            pasti.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Eksplorasi Wilayah Section -->
    <div id="wilayah" class="py-16 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-800 mb-3">Eksplorasi Wilayah</h2>
                <p class="text-sm text-gray-500 max-w-2xl mx-auto">
                    Mengenal lebih dekat potensi dan kearifan lokal yang menjadi kebanggaan warga.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 max-w-5xl mx-auto">
                <!-- Card 1: UMKM Mandiri -->
                <div
                    class="card bg-white hover:shadow-lg transition-all duration-300 overflow-hidden rounded-xl border border-gray-200">
                    <figure class="h-48 overflow-hidden">
                        <img src="{{ app(\App\Services\ApplicationProfileService::class)->getUmkmImage() ?? 'https://images.unsplash.com/photo-1558449028-b53a39d100fc?auto=format&fit=crop&q=80&w=800' }}"
                            alt="UMKM"
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </figure>
                    <div class="card-body p-5">
                        <h3 class="text-base font-semibold text-gray-800 mb-1">UMKM Mandiri</h3>
                        <p class="text-xs text-gray-500">Pembinaan produk ekonomi kreatif desa.</p>
                    </div>
                </div>

                <!-- Card 2: Pesona Alam -->
                <div
                    class="card bg-white hover:shadow-lg transition-all duration-300 overflow-hidden rounded-xl border border-gray-200">
                    <figure class="h-48 overflow-hidden">
                        <img src="{{ app(\App\Services\ApplicationProfileService::class)->getPariwisataImage() ?? 'https://images.unsplash.com/photo-1590059235ef9-22a84976c66d?auto=format&fit=crop&q=80&w=800' }}"
                            alt="Wisata"
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </figure>
                    <div class="card-body p-5">
                        <h3 class="text-base font-semibold text-gray-800 mb-1">Pesona Alam</h3>
                        <p class="text-xs text-gray-500">Destinasi wisata lokal yang asri dan terjaga.</p>
                    </div>
                </div>

                <!-- Card 3: Festival Budaya -->
                <div
                    class="card bg-white hover:shadow-lg transition-all duration-300 overflow-hidden rounded-xl border border-gray-200">
                    <figure class="h-48 overflow-hidden">
                        <img src="{{ app(\App\Services\ApplicationProfileService::class)->getFestivalImage() ?? 'https://images.unsplash.com/photo-1544911835-343542289c03?auto=format&fit=crop&q=80&w=800' }}"
                            alt="Kebudayaan"
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </figure>
                    <div class="card-body p-5">
                        <h3 class="text-base font-semibold text-gray-800 mb-1">Festival Budaya</h3>
                        <p class="text-xs text-gray-500">Melestarikan tradisi luhur turun temurun.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Berita & Informasi Section -->
    <div id="berita" class="py-20 bg-white border-t border-slate-100">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Warta Kecamatan</h2>
                <a href="{{ route('public.berita.index') }}"
                    class="group flex items-center text-sm font-semibold text-rose-600 hover:text-rose-700 transition-colors">
                    Lihat Semua
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($latestBerita as $item)
                    <div class="group cursor-pointer">
                        <div class="relative overflow-hidden rounded-2xl mb-4 aspect-[4/3]">
                            @if($item->thumbnail)
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->judul }}"
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-in-out">
                            @else
                                <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                                    <i class="fas fa-image text-slate-300 text-3xl"></i>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3">
                                @php
                                    $catColors = [
                                        'Pemerintahan' => 'bg-blue-600',
                                        'Pembangunan' => 'bg-emerald-600',
                                        'Sosial' => 'bg-purple-600',
                                        'Ekonomi' => 'bg-amber-600',
                                        'default' => 'bg-rose-600'
                                    ];
                                    $color = $catColors[$item->kategori] ?? $catColors['default'];
                                @endphp
                                <span
                                    class="{{ $color }} text-white text-[10px] font-bold px-2.5 py-1 rounded-md shadow-sm uppercase tracking-wider">
                                    {{ $item->kategori }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div
                                class="flex items-center text-[11px] font-medium text-slate-500 uppercase tracking-wide gap-2">
                                <span class="text-rose-600">{{ $item->author->nama_lengkap ?? 'Admin' }}</span>
                                <span>•</span>
                                <span>{{ $item->published_at ? $item->published_at->diffForHumans() : '-' }}</span>
                            </div>

                            <h3
                                class="text-lg font-bold text-gray-900 leading-snug group-hover:text-rose-600 transition-colors line-clamp-2">
                                <a href="{{ route('public.berita.show', $item->slug) }}">
                                    {{ $item->judul }}
                                </a>
                            </h3>

                            <p class="text-sm text-slate-600 line-clamp-2 leading-relaxed">
                                {{ Str::limit($item->ringkasan, 90) }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full py-16 text-center bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                        <div
                            class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                            <i class="far fa-newspaper text-slate-400 text-2xl"></i>
                        </div>
                        <h3 class="text-slate-900 font-medium mb-1">Belum ada berita</h3>
                        <p class="text-slate-500 text-sm">Nantikan informasi terbaru dari kami.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Informasi Operasional Section -->
    <div id="operasional" class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div
                class="card bg-gradient-to-br from-teal-50/50 to-blue-50/50 shadow-md border border-gray-200 rounded-2xl">
                <div class="card-body p-10">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                        <!-- Left Column -->
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-3">Informasi Operasional</h2>
                            <p class="text-sm text-gray-600 mb-6">
                                Kami siap melayani kebutuhan administrasi Anda selama jam kerja sebagai berikut:
                            </p>

                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-11 h-11 bg-teal-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-clock text-teal-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800 text-sm">Senin - Kamis</div>
                                        <div class="text-xs text-gray-500">08:00 WIB - 15:30 WIB</div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-11 h-11 bg-teal-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-calendar-day text-teal-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800 text-sm">Jumat</div>
                                        <div class="text-xs text-gray-500">08:00 WIB - 14:30 WIB</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="bg-white rounded-xl p-7 shadow-sm border border-gray-200 text-center">
                            <i class="fas fa-bullhorn text-teal-600 text-4xl mb-5"></i>
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Komitmen Kami</h3>
                            <p class="text-sm text-gray-600 mb-5 leading-relaxed">
                                "Melayani dengan Integritas, Menjaga Setiap Amanah untuk Kemajuan Bersama."
                            </p>
                            <div class="divider my-4"></div>
                            <div
                                class="inline-flex items-center gap-2 bg-emerald-50 text-emerald-700 border border-emerald-200 px-5 py-2 rounded-full text-xs font-semibold">
                                <i class="fas fa-shield-alt"></i>
                                <span>Petugas Bebas Pungutan Liar</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-slate-800 text-gray-300 py-8">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="text-center md:text-left">
                    <h4 class="text-white text-lg font-bold mb-1">
                        {{ appProfile()->region_name }}
                    </h4>
                    <p class="text-xs text-gray-400">{{ appProfile()->app_name }} • {{ appProfile()->tagline }}</p>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-xs text-gray-400">Copyright © {{ date('Y') }} All Rights Reserved.</p>
                    <p class="text-[10px] text-gray-500 mt-1">Platform ini adalah portal internal resmi ASN/Petugas
                        Kecamatan.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Accessibility Assets -->
    <link rel="stylesheet" href="{{ asset('css/accessibility.css') }}">
    <script src="{{ asset('js/accessibility.js') }}" defer></script>

    <!-- Accessibility & Voice Floating Buttons -->
    <div class="fixed bottom-5 left-5 z-40 flex items-center gap-3">
        <!-- Voice Guide Toggle -->
        <button id="btnVoiceGuideToggle" onclick="activateVoiceGuide()"
            class="btn btn-circle bg-blue-600 hover:bg-blue-700 border-0 shadow-lg w-14 h-14 relative group transition-all duration-300"
            aria-label="Aktifkan Pemandu Suara" title="Bantuan Suara">
            <img src="{{ asset('img/voice-guide-icon.png') }}" alt="Suara"
                class="w-8 h-8 object-contain transition-transform group-hover:scale-110">
            <span class="absolute -top-1 -right-1 flex h-3 w-3">
                <span id="voice-ping"
                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75 hidden"></span>
                <span id="voice-dot" class="relative inline-flex rounded-full h-3 w-3 bg-red-500 hidden"></span>
            </span>
        </button>

        <!-- Accessibility Toggle -->
        <button id="accessibility-toggle"
            class="btn btn-circle bg-blue-600 hover:bg-blue-700 border-0 shadow-lg w-14 h-14"
            aria-label="Buka Menu Aksesibilitas">
            <i class="fas fa-wheelchair text-white text-xl"></i>
        </button>
    </div>

    <!-- Floating Action Button -->
    <div class="fixed bottom-5 right-5 z-40 group">
        <div class="absolute bottom-full right-0 mb-3 hidden group-hover:block transition-all animate-bounce">
            <span
                class="bg-teal-600 text-white text-xs px-3 py-1 rounded-full shadow-lg whitespace-nowrap italic">Hubungi
                Kami</span>
        </div>
        <button onclick="document.getElementById('publicServiceModal').showModal()"
            class="btn btn-circle bg-teal-600 hover:bg-teal-700 border-0 shadow-xl w-16 h-16 transform transition-transform hover:scale-110">
            <i class="fas fa-message text-white text-2xl"></i>
        </button>
    </div>

    <!-- Administrative Bot Portal (REPLACEMENT FOR MODAL) -->
    <dialog id="publicServiceModal" class="modal">
        <div
            class="modal-box max-w-md rounded-3xl bg-white p-0 overflow-hidden shadow-2xl flex flex-col h-[600px] border border-slate-100">
            <!-- Header Bot -->
            <div
                class="bg-gradient-to-r from-teal-600 to-teal-700 p-5 text-white flex justify-between items-center shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-robot text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-base leading-tight">Asisten Digital Administrasi</h3>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                            <p class="text-[10px] text-teal-100 font-medium">Online & Siap Membantu</p>
                        </div>
                    </div>
                </div>
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost text-teal-100 hover:text-white"><i
                            class="fas fa-times"></i></button>
                </form>
            </div>

            <!-- Chat Area -->
            <div id="chatMessages" class="flex-grow p-4 overflow-y-auto bg-slate-50 space-y-4">
                <!-- Welcome Message -->
                <div class="flex items-start gap-2.5">
                    <div
                        class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center shrink-0 shadow-sm border border-teal-200">
                        <i class="fas fa-robot text-teal-600 text-xs"></i>
                    </div>
                    <div class="space-y-3 max-w-[85%]">
                        <div
                            class="bg-white border border-slate-200 text-slate-700 p-4 rounded-2xl rounded-tl-none text-xs leading-relaxed shadow-sm">
                            <p class="font-bold text-teal-700 mb-1">Halo! Saya Asisten Digital Kecamatan.</p>
                            <p>Saya siap membantu Anda memberikan informasi resmi terkait persyaratan administrasi.</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button onclick="sendQuickChip('KTP')"
                                class="btn btn-xs bg-white hover:bg-teal-50 text-teal-600 border-teal-200 rounded-full font-medium px-3 normal-case shadow-sm">📦
                                Cek Syarat KTP</button>
                            <button onclick="sendQuickChip('KK')"
                                class="btn btn-xs bg-white hover:bg-teal-50 text-teal-600 border-teal-200 rounded-full font-medium px-3 normal-case shadow-sm">👨‍👩‍👧‍👦
                                Cek Syarat KK</button>
                            <button onclick="sendQuickChip('Akte')"
                                class="btn btn-xs bg-white hover:bg-teal-50 text-teal-600 border-teal-200 rounded-full font-medium px-3 normal-case shadow-sm">📄
                                Syarat Akte</button>
                            <button onclick="sendQuickChip('Jam Layanan')"
                                class="btn btn-xs bg-white hover:bg-teal-50 text-teal-600 border-teal-200 rounded-full font-medium px-3 normal-case shadow-sm">⏰
                                Jam Layanan</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="p-4 bg-white border-t border-slate-100 shrink-0 shadow-[0_-4px_15px_-5px_rgba(0,0,0,0.05)]">
                <form id="publicFaqForm" class="relative">
                    <input type="text" id="botQuery"
                        class="input input-bordered w-full bg-slate-50 border-slate-200 focus:border-teal-500 rounded-2xl pr-20 text-sm text-slate-700 transition-all focus:shadow-md"
                        placeholder="Ketik atau bicara..." autocomplete="off" required>

                    <!-- Mic Button -->
                    <button type="button" id="btnMic" onclick="toggleVoiceInput()"
                        class="absolute right-10 top-1/2 -translate-y-1/2 btn btn-sm btn-circle btn-ghost text-slate-400 hover:text-teal-600 transition-colors"
                        title="Dikte Suara">
                        <i class="fas fa-microphone"></i>
                    </button>

                    <button type="submit" id="btnSendBot"
                        class="absolute right-2 top-1/2 -translate-y-1/2 btn btn-sm btn-circle bg-teal-600 hover:bg-teal-700 border-0 text-white shadow-md transition-all active:scale-95">
                        <i class="fas fa-paper-plane text-xs"></i>
                    </button>
                </form>
                <div class="flex justify-between items-center mt-3 px-1">
                    <p class="text-[9px] text-slate-400 italic">Informasi Resmi Database FAQ.</p>
                    <button onclick="startClarification()"
                        class="text-[9px] font-bold text-teal-600 hover:underline">Butuh Tindak Lanjut Petugas?</button>
                </div>
            </div>
        </div>
    </dialog>

    <script>
        const chatMessages = document.getElementById('chatMessages');
        const botForm = document.getElementById('publicFaqForm');
        const botInput = document.getElementById('botQuery');
        const btnMic = document.getElementById('btnMic');
        let chatState = 'FAQ'; // 'FAQ' or 'CAPTURE_WA'
        let lastUserQuery = '';
        let isVoiceInteraction = false;
        let hasPlayedWelcome = false;

        // --- CONTINUOUS VOICE CONFIGURATION ---
        let isContinuousMode = false;
        let voiceIdleTimer = null;
        const IDLE_LIMIT_MS = 10000; // 10 Detik
        // --------------------------------------

        // Speech Recognition Setup
        let recognition = null;
        let isRecording = false;

        if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            recognition = new SpeechRecognition();
            recognition.lang = 'id-ID';
            recognition.interimResults = false;
            recognition.maxAlternatives = 1;

            recognition.onstart = function () {
                isRecording = true;
                // Visual: Ear Icon
                const btnMic = document.getElementById('btnMic');
                if (btnMic) {
                    btnMic.innerHTML = `<img src="{{ asset('img/listening-ear.png') }}" class="w-8 h-8 object-contain animate-pulse">`;
                    btnMic.classList.remove('text-slate-400');
                    btnMic.title = "Sedang Mendengarkan...";
                }
                const botInput = document.getElementById('botQuery'); // Changed from botInput to botQuery
                if (botInput) botInput.placeholder = "Silakan bicara...";

                // Start Idle Timer (10s limit)
                startIdleTimer();
            };

            recognition.onend = function () {
                isRecording = false;
                clearIdleTimer();

                // Visual: Revert to Mic
                const btnMic = document.getElementById('btnMic');
                if (btnMic) {
                    btnMic.innerHTML = `<i class="fas fa-microphone"></i>`;
                    btnMic.classList.add('text-slate-400');
                    btnMic.title = "Dikte Suara";
                }
                const botInput = document.getElementById('botQuery'); // Changed from botInput to botQuery
                if (botInput) botInput.placeholder = "Ketik atau bicara...";

                // AUTO-RESTART LOOP if Continuous Mode is ON and System is NOT speaking
                if (isContinuousMode && !window.speechSynthesis.speaking) {
                    setTimeout(() => {
                        try { recognition.start(); } catch (e) { }
                    }, 500);
                }
            };

            recognition.onresult = function (event) {
                clearIdleTimer(); // valid input received
                const transcript = event.results[0][0].transcript;

                const botInput = document.getElementById('botQuery'); // Changed from botInput to botQuery
                const botForm = document.getElementById('publicFaqForm');

                if (botInput && botForm) {
                    botInput.value = transcript;
                    isVoiceInteraction = true;
                    botForm.dispatchEvent(new Event('submit'));
                }
            };

            recognition.onerror = function (event) {
                console.error('Speech error:', event.error);
                isRecording = false;
                clearIdleTimer();

                // If 'no-speech' error in continuous mode, we just restart (handled by onend)
                // If it's a real error, maybe stop? For now, we keep trying unless user turns off.
            };
        } else {
            // Hide mic if not supported
            if (btnMic) btnMic.style.display = 'none';
        }

        // --- IDLE TIMER LOGIC ---
        function startIdleTimer() {
            clearIdleTimer();
            if (!isContinuousMode) return;

            voiceIdleTimer = setTimeout(() => {
                // Timeout Reached (10s Silence)
                recognition.stop(); // Stop listening to speak

                // Speak Prompt
                speakResponse("Halo? Apakah Anda masih di sana? Katakan sesuatu jika butuh bantuan.", true);
                // param 'true' indicates this is a prompt, will resume listening after.
            }, IDLE_LIMIT_MS);
        }

        function clearIdleTimer() {
            if (voiceIdleTimer) clearTimeout(voiceIdleTimer);
        }

        // --- VOICE ENGINE SETUP ---
        let availableVoices = [];

        function loadVoices() {
            if (!window.speechSynthesis) return;
            availableVoices = window.speechSynthesis.getVoices();
        }

        if (window.speechSynthesis) {
            window.speechSynthesis.onvoiceschanged = loadVoices;
            loadVoices(); // Try immediately
        }

        // --- VISUAL FEEDBACK UTILS ---
        function showToast(message, type = 'info') {
            const toastId = 'toast-' + Date.now();
            const colors = type === 'success' ? 'bg-emerald-600' : 'bg-slate-700';

            const toast = document.createElement('div');
            toast.id = toastId;
            toast.className = `fixed top-20 right-5 z-50 ${colors} text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-[slideIn_0.3s_ease-out]`;
            toast.innerHTML = `
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-info-circle'}"></i>
                <span class="text-sm font-medium">${message}</span>
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-x-full', 'transition-all', 'duration-500');
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }

        function updateVoiceButtonVisuals(isActive) {
            const btn = document.getElementById('btnVoiceGuideToggle');
            const ping = document.getElementById('voice-ping');
            const dot = document.getElementById('voice-dot');

            if (!btn) return;

            if (isActive) {
                // Active State: Green, Pulse
                btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                btn.classList.add('bg-emerald-500', 'hover:bg-emerald-600', 'ring-4', 'ring-emerald-200');
                if (ping) ping.classList.remove('hidden');
                if (dot) dot.classList.remove('hidden', 'bg-red-500');
                if (dot) dot.classList.add('bg-emerald-200');
            } else {
                // Inactive State: Default Blue
                btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                btn.classList.remove('bg-emerald-500', 'hover:bg-emerald-600', 'ring-4', 'ring-emerald-200');
                if (ping) ping.classList.add('hidden');
                if (dot) dot.classList.add('hidden');
            }
        }

        // --- MAIN TOGGLE ---
        function toggleVoiceGuide() {
            try {
                if (!window.speechSynthesis) {
                    showToast("Browser tidak mendukung suara", "info");
                    return;
                }

                const modal = document.getElementById('publicServiceModal');

                // 1. Toggle OFF
                if (isContinuousMode) {
                    isContinuousMode = false;
                    localStorage.setItem('voiceGuideActive', 'false'); // SAVE STATE
                    
                    clearIdleTimer();
                    if (recognition) recognition.stop();
                    window.speechSynthesis.cancel();

                    speakResponse("Mode Suara Nonaktif.");
                    showToast("Suara Panduan Nonaktif", "info");
                    updateVoiceButtonVisuals(false);
                    return;
                }

                // 2. Toggle ON
                isContinuousMode = true;
                localStorage.setItem('voiceGuideActive', 'true'); // SAVE STATE (ALWAYS ON)
                
                updateVoiceButtonVisuals(true);
                showToast("Suara Panduan Aktif", "success");

                // Open Modal if closed
                if (modal && !modal.open) {
                    modal.showModal();
                }

                // Direct call without delay
                if (!hasPlayedWelcome) {
                    console.log("Starting Welcome Sequence...");
                    // Ensure silence before starting
                    window.speechSynthesis.cancel();

                    // Small delay to allow 'cancel' to process and Toast to appear
                    setTimeout(() => {
                        readLandingMenus();
                    }, 300);
                } else {
                    speakResponse("Mode Suara Aktif. Silakan bicara.");
                }

            } catch (error) {
                console.error("Toggle Error:", error);
                showToast("Terjadi kesalahan sistem", "info");
            }
        }

        function activateVoiceGuide() {
            toggleVoiceGuide();
        }

        function toggleVoiceInput() {
            if (isContinuousMode) {
                if (isRecording && recognition) recognition.stop();
                else if (recognition) recognition.start();
            } else {
                if (!recognition) return;
                if (isRecording) recognition.stop();
                else recognition.start();
            }
        }

        // --- SKELETON IMPLEMENTATION (USER REQUEST) ---

        // Global Config from Blade
        window.APP_WILAYAH_NAMA = {!! json_encode(optional(appProfile())->region_name ?? 'Wilayah') !!};

        function readLandingMenus() {
            if (!window.speechSynthesis) return;

            // Ambil nama wilayah dari config global
            const wilayah = window.APP_WILAYAH_NAMA || 'Wilayah Ini';

            // Selector yang lebih luas untuk menangkap DaisyUI navbar
            const selectors = [
                'nav a', 'nav button',
                '.navbar a', '.navbar button',
                '.menu a', '.menu button'
            ];

            // Filter menu elements
            const menuElements = Array.from(
                document.querySelectorAll(selectors.join(', '))
            ).filter(el => {
                const text = el.innerText.trim();
                const isVisible = el.offsetParent !== null; // Cek visibilitas layout
                const isNotHidden = el.getAttribute('aria-hidden') !== 'true';
                const isNotAccess = !el.classList.contains('accessibility-toggle') && !el.classList.contains('btn-voice-guide');
                const isNotModal = !el.closest('#publicServiceModal'); // Kecuali modal terbuka (tapi biasanya baca background dulu)

                // Exclude logo links or icon-only links if they have no readable text
                // Check if text suggests it's a real menu

                return isVisible &&
                    isNotHidden &&
                    text.length > 0 &&
                    isNotAccess &&
                    isNotModal;
            });

            // Deduplicate based on text (karena desktop & mobile menu sering duplikat di DOM)
            const uniqueMenus = [];
            const seenTexts = new Set();

            menuElements.forEach(el => {
                const txt = el.innerText.trim();
                // Normalisasi: Hapus angka notifikasi jika ada (misal: "Pengaduan 5")
                // Atau biarkan apa adanya agar user tahu status.

                if (!seenTexts.has(txt) && txt.length > 1) { // Min 2 chars
                    seenTexts.add(txt);
                    uniqueMenus.push(txt);
                }
            });

            // Susun kalimat
            const sentences = [];
            sentences.push(`Selamat datang di ${wilayah}.`);
            sentences.push('Berikut adalah menu yang tersedia pada halaman ini.');

            uniqueMenus.forEach(text => {
                sentences.push(`Menu ${text}.`);
            });

            sentences.push('Silakan pilih menu yang Anda inginkan, atau katakan keperluan Anda.');

            speakSequence(sentences);
        }

        // --- FALLBACK UX IMPLEMENTATION ---

        let voiceFallbackShown = false;
        let speechStarted = false;

        function showVoiceFallback() {
            if (voiceFallbackShown) return;
            voiceFallbackShown = true;

            const fallback = document.createElement('div');
            fallback.id = 'voice-guide-fallback';
            fallback.setAttribute('role', 'status');
            fallback.setAttribute('aria-live', 'polite');

            fallback.innerHTML = `
                <div class="vg-fallback-card">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-volume-xmark text-orange-500 mt-1"></i>
                        <div>
                            <strong>Panduan Suara Aktif</strong>
                            <p class="text-sm mt-1 text-slate-600">
                                Audio tidak tersedia di perangkat ini.
                                Silakan gunakan menu visual pada halaman ini.
                            </p>
                            <button class="text-xs font-semibold text-blue-600 mt-2 hover:underline focus:outline-none" aria-label="Tutup panduan suara">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(fallback);

            const btn = fallback.querySelector('button');
            if (btn) {
                btn.onclick = () => {
                    fallback.remove();
                    voiceFallbackShown = false; // Allow showing again if needed later
                };
            }

            // Auto hide after 10s if ignored
            setTimeout(() => {
                if (document.body.contains(fallback)) fallback.remove();
            }, 10000);
        }

        function speakWithFallback(utterance) {
            speechStarted = false;

            utterance.onstart = () => {
                speechStarted = true;
            };

            const originalOnError = utterance.onerror;
            utterance.onerror = (e) => {
                console.error("TTS Error:", e);
                showVoiceFallback();
                if (originalOnError) originalOnError(e);
            };

            window.speechSynthesis.speak(utterance);

            // Soft failure detector (2 seconds)
            setTimeout(() => {
                if (!speechStarted && isContinuousMode) {
                    showVoiceFallback();
                }
            }, 2000);
        }

        // Fungsi Chaining (Anti Tumpang Tindih)
        function speakSequence(sentences, index = 0) {
            // Stop condition
            if (!isContinuousMode || index >= sentences.length) {
                if (isContinuousMode && index >= sentences.length) {
                    // Sequence finished, enable listening
                    hasPlayedWelcome = true;
                    setTimeout(() => {
                        speakResponse("Saya siap mendengarkan.", true);
                    }, 500);
                }
                return;
            }

            const utterance = createUtterance(sentences[index]);

            utterance.onend = () => {
                speakSequence(sentences, index + 1);
            };

            utterance.onerror = (e) => {
                console.error("Utterance Error:", e);
                // If error, show fallback but try to proceed textually if possible (or just stop)
                showVoiceFallback();
                speakSequence(sentences, index + 1);
            };

            // Stability for Windows
            requestAnimationFrame(() => {
                speakWithFallback(utterance);
            });
        }

        // Factory Utterance (Stabil di Windows)
        function createUtterance(text) {
            const utterance = new SpeechSynthesisUtterance(text);

            const voice =
                availableVoices.find(v => v.lang === 'id-ID') ||
                availableVoices.find(v => v.lang.startsWith('id')) ||
                availableVoices.find(v => v.default) ||
                availableVoices[0];

            utterance.voice = voice;
            utterance.lang = voice?.lang || 'id-ID';
            utterance.rate = 1;

            return utterance;
        }

        // --- END SKELETON ---

        function speakSystemMessage(text) {
            speakResponse(text);
        }

        function speakResponse(text, isPrompt = false) {
            if (!window.speechSynthesis) {
                showVoiceFallback();
                return;
            }

            if (isRecording && recognition) {
                recognition.stop();
            }

            window.speechSynthesis.cancel();

            // Clean Text
            let cleanText = text
                .replace(/\*\*/g, '')
                .replace(/\[.*?\]\(.*?\)/g, '')
                .replace(/\[.*?\]/g, '')
                .replace(/<[^>]*>/g, '')
                .replace(/^[#\-*]\s+/gm, '')
                .replace(/`/g, '')
                .replace(/&nbsp;/g, ' ');

            const utterance = new SpeechSynthesisUtterance(cleanText);

            // VOICE SELECTION (Detailed Logic)
            // 1. Try exact ID match
            let selectedVoice = availableVoices.find(v => v.lang === 'id-ID');
            // 2. Try partial ID match
            if (!selectedVoice) selectedVoice = availableVoices.find(v => v.lang.includes('id'));
            // 3. Fallback to default (don't set voice, let browser decide)

            if (selectedVoice) {
                utterance.voice = selectedVoice;
                utterance.lang = 'id-ID';
            }

            utterance.rate = 1;

            // Visual Feedback
            const btnMic = document.getElementById('btnMic');
            if (btnMic) {
                btnMic.innerHTML = `<i class="fas fa-volume-up animate-pulse text-teal-600"></i>`;
            }

            utterance.onend = function () {
                if (isContinuousMode) {
                    setTimeout(() => {
                        try { recognition.start(); } catch (e) { }
                    }, 200);
                }
            };

            // Error handling for synthesis itself
            utterance.onerror = function (e) {
                console.error("TTS Utterance Error", e);
            };

            speakWithFallback(utterance);
        }

        function navigateToSection(sectionId, speechText) {
            const modal = document.getElementById('publicServiceModal');
            if (modal) modal.close();

            const target = document.getElementById(sectionId);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                // Highlight section temporarily
                target.classList.add('bg-blue-50', 'transition-colors', 'duration-500');
                setTimeout(() => target.classList.remove('bg-blue-50'), 2000);
            }

            // Speak after a short delay to account for scrolling
            setTimeout(() => {
                speakResponse(speechText);
            }, 800);
        }



        function sendQuickChip(text) {
            botInput.value = text;
            isVoiceInteraction = false; // Chips are manual buttons
            botForm.dispatchEvent(new Event('submit'));
        }

        function startClarification() {
            chatState = 'CAPTURE_WA';
            appendMessage('bot', 'Baik, untuk bantuan lebih lanjut atau klarifikasi petugas, mohon masukkan **Nomor WhatsApp** Anda di bawah ini.');
            botInput.placeholder = "Contoh: 08123456789";
            botInput.type = "tel";
            botInput.focus();
        }

        function appendMessage(role, text, isSOP = false) {
            const container = document.createElement('div');
            container.className = role === 'user' ? 'flex justify-end' : 'flex items-start gap-2.5 animate-[slideUp_0.3s_ease-out]';

            if (role === 'bot') {
                let messageHtml = '';
                if (isSOP) {
                    // SOP-style Card UI
                    messageHtml = `
                        <div class="bg-white border border-teal-100 rounded-2xl shadow-md overflow-hidden max-w-[90%]">
                            <div class="bg-teal-600 px-4 py-2 text-white flex justify-between items-center">
                                <span class="text-[10px] font-bold uppercase tracking-wider">Informasi Layanan Resmi</span>
                                <i class="fas fa-check-circle text-xs text-teal-200"></i>
                            </div>
                            <div class="p-4 space-y-3">
                                <div class="text-xs text-slate-700 leading-relaxed">
                                    ${text.replace(/\n/g, '<br>')}
                                </div>
                                <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                                    <p class="text-[10px] text-slate-400 font-medium">Apakah informasi ini membantu?</p>
                                    <div class="flex gap-2">
                                        <button onclick="appendMessage('bot', 'Terima kasih atas feedback Anda! Terus tingkatkan pelayanan kami.')" class="btn btn-xs btn-outline btn-success rounded-lg lowercase text-[9px]">Ya, Jelas</button>
                                        <button onclick="startClarification()" class="btn btn-xs btn-outline btn-warning rounded-lg lowercase text-[9px]">Ingin Bertanya Petugas</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    messageHtml = `
                        <div class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center shrink-0 shadow-sm border border-teal-200">
                            <i class="fas fa-robot text-teal-600 text-xs"></i>
                        </div>
                        <div class="bg-white border border-slate-200 text-slate-700 p-3 rounded-2xl rounded-tl-none text-xs leading-relaxed shadow-sm max-w-[85%] font-medium">
                            ${text.replace(/\n/g, '<br>')}
                        </div>
                    `;
                }
                container.innerHTML = messageHtml;
            } else {
                container.innerHTML = `
                    <div class="bg-teal-600 text-white p-3 rounded-2xl rounded-tr-none text-xs leading-relaxed shadow-md max-w-[85%] font-medium">
                        ${text}
                    </div>
                `;
            }

            chatMessages.appendChild(container);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        botForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const inputVal = botInput.value.trim();
            if (!inputVal) return;

            // Pattern detection for Phone Numbers (Citizen ease of use)
            const isPhoneNumber = /^[0-9\+\-\s]{10,15}$/.test(inputVal);

            // --- VOICE COMMANDS (Accessibility Overlay) ---
            const lowerInput = inputVal.toLowerCase();

            // 0. SHUTDOWN COMMAND (Matikan Suara)
            if (lowerInput.includes('matikan') || lowerInput.includes('stop') || lowerInput.includes('nonaktifkan')) {
                if (lowerInput.includes('suara') || lowerInput.includes('voice') || lowerInput.includes('panduan')) {
                    
                    // Logic to turn off
                    if (isContinuousMode) {
                        isContinuousMode = false;
                        localStorage.setItem('voiceGuideActive', 'false'); // PERSISTENCE
                        
                        clearIdleTimer();
                        if (recognition) recognition.stop();
                        window.speechSynthesis.cancel();
                        
                        speakResponse("Baik, suara panduan dinonaktifkan.");
                        showToast("Suara Panduan Nonaktif", "info");
                        updateVoiceButtonVisuals(false);
                        
                        botInput.value = '';
                        return;
                    } else {
                         speakResponse("Mode suara sudah nonaktif.");
                         return;
                    }
                }
            }

            // 1. Berita / Warta
            if (lowerInput.includes('berita') || lowerInput.includes('warta') || lowerInput.includes('kabar')) {
                // Scrape Content
                const newsItems = document.querySelectorAll('#berita h3 a');
                let readText = "Menampilkan Warta Kecamatan Terbaru. ";
                if (newsItems.length > 0) {
                    newsItems.forEach((item, index) => {
                        readText += `Berita ke-${index + 1}: ${item.innerText}. `;
                    });
                } else {
                    readText += "Saat ini belum ada berita terbaru.";
                }

                navigateToSection('berita', readText);
                return;
            }

            // 2. Layanan
            if (lowerInput.includes('layanan')) {
                // Scrape Content
                const serviceItems = document.querySelectorAll('#layanan h3');
                let readText = "Menampilkan Layanan Publik. Kami menyediakan: ";
                serviceItems.forEach((item) => {
                    readText += `${item.innerText}, `;
                });
                readText += ". Silakan pilih layanan yang Anda butuhkan.";

                navigateToSection('layanan', readText);
                return;
            }

            // 3. Beranda / Kembali ke Awal
            if (lowerInput.includes('beranda') || lowerInput.includes('home') || lowerInput.includes('depan') || (lowerInput.includes('menu') && lowerInput.includes('utama')) || lowerInput.includes('awal')) {
                const modal = document.getElementById('publicServiceModal');
                if (modal) modal.close();

                window.scrollTo({ top: 0, behavior: 'smooth' });
                speakResponse("Kembali ke halaman utama.");
                return;
            }

            // 3. Pariwisata / Wilayah
            if (lowerInput.includes('wisata') || lowerInput.includes('pariwisata') || lowerInput.includes('wilayah') || lowerInput.includes('umkm')) {
                let readText = "Menampilkan Potensi Wilayah dan Pariwisata. Jelajahi UMKM Mandiri, Pesona Alam, dan Festival Budaya kami.";
                navigateToSection('wilayah', readText);
                return;
            }

            // 4. Jam Kerja
            if ((lowerInput.includes('jam') || lowerInput.includes('buka') || lowerInput.includes('tutup')) && (lowerInput.includes('kerja') || lowerInput.includes('layanan') || lowerInput.includes('kantor'))) {
                const text = "Kami buka Senin sampai Kamis pukul 08.00 sampai 15.30, dan Jumat pukul 08.00 sampai 14.30 WIB.";
                botInput.value = '';
                appendMessage('user', inputVal);
                appendMessage('bot', text);
                speakResponse(text);
                return;
            }

            // 5. Login / Masuk
            if (lowerInput.includes('login') || lowerInput.includes('masuk') || lowerInput.includes('admin')) {
                speakResponse("Mengarahkan ke halaman Login Petugas.");
                setTimeout(() => {
                    window.location.href = "{{ route('login') }}";
                }, 1500);
                return;
            }

            // 6. Contextual Selection: Selecting News by Title (Improved Fuzzy Match)
            const newsLinks = document.querySelectorAll('#berita h3 a');
            let matchedLink = null;

            // Normalize input for comparison
            const cleanInput = lowerInput.replace(/baca/g, '').replace(/berita/g, '').replace(/buka/g, '').trim();

            if (cleanInput.length > 2) { // Only search if we have actual keywords
                for (let link of newsLinks) {
                    const title = link.innerText.toLowerCase();

                    // Match Logic:
                    // 1. Title contains the user input (e.g. User: "Posyandu" -> Title: "Jadwal Posyandu")
                    // 2. User input contains the Title (rare, usually input is shorter)
                    // 3. Word-by-word match count for higher accuracy?

                    if (title.includes(cleanInput) || cleanInput.includes(title)) {
                        matchedLink = link;
                        break;
                    }
                }
            }

            if (matchedLink) {
                botInput.value = '';
                // Show command
                appendMessage('user', inputVal);

                const actionText = `Membuka berita: ${matchedLink.innerText}`;
                appendMessage('bot', actionText);
                speakResponse(actionText);

                // Navigate
                setTimeout(() => {
                    matchedLink.click();
                    // If continuous mode, we might want to stop it or let it run. 
                    // Usually navigating away reloads page, so JS state resets.
                }, 1500);
                return;
            }

            // ----------------------------------------------------

            if (chatState === 'CAPTURE_WA' || (chatState === 'FAQ' && isPhoneNumber)) {
                if (chatState === 'FAQ' && isPhoneNumber) {
                    // Auto-detect number and confirm
                    appendMessage('user', inputVal);
                    chatState = 'CAPTURE_WA';
                    handleWaCapture(inputVal);
                } else {
                    handleWaCapture(inputVal);
                }
                return;
            }

            // Normal FAQ Search (Default Fallback)
            lastUserQuery = inputVal;
            botInput.value = '';

            // Only show user text if not navigation command (handled above)
            appendMessage('user', inputVal);

            // Typing indicator
            const typingId = 'typing-' + Date.now();
            const typingDiv = document.createElement('div');
            typingDiv.id = typingId;
            typingDiv.className = 'flex items-start gap-2.5 animate-pulse';
            typingDiv.innerHTML = `
                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center shrink-0">
                    <i class="fas fa-robot text-slate-400 text-xs"></i>
                </div>
                <div class="bg-slate-100 text-slate-400 p-3 rounded-2xl rounded-tl-none text-[10px] italic">Memeriksa Database Resmi...</div>
            `;
            chatMessages.appendChild(typingDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;

            try {
                const url = new URL("{{ route('api.faq.search') }}", window.location.origin);
                url.searchParams.append('q', inputVal);

                const response = await fetch(url);
                const data = await response.json();

                const indicator = document.getElementById(typingId);
                if (indicator) indicator.remove();

                if (data.answer) {
                    if (data.found) {
                        appendMessage('bot', data.answer, true); // true = Use SOP UI
                    } else {
                        appendMessage('bot', data.answer);
                    }

                    // Auto-reply with voice if input was voice
                    if (isVoiceInteraction) {
                        speakResponse(data.answer);
                        isVoiceInteraction = false; // Reset
                    }
                } else {
                    appendMessage('bot', 'Mohon maaf, sistem sedang sibuk.');
                }
            } catch (error) {
                const indicator = document.getElementById(typingId);
                if (indicator) indicator.remove();
                appendMessage('bot', 'Koneksi database terputus. Sila coba kembali.');
            }
        });

        async function handleWaCapture(wa) {
            botInput.value = '';
            appendMessage('user', wa);

            appendMessage('bot', 'Sedang mencatat permintaan Anda untuk petugas...');

            try {
                const response = await fetch("{{ route('public.service.submit') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        jenis_layanan: 'Konsultasi Administratif',
                        uraian: `[Diteruskan dari Bot FAQ] Pertanyaan: "${lastUserQuery}"`,
                        whatsapp: wa,
                        is_agreed: true
                    })
                });

                const data = await response.json();
                if (response.ok) {
                    appendMessage('bot', '✅ **Permintaan Berhasil Dicatat!**\n\nNomor Anda sudah tersimpan. Petugas akan menghubungi Anda maksimal dalam 1x24 jam kerja.\n\nTerima kasih atas kesabarannya.');
                } else {
                    appendMessage('bot', 'Gagal menyimpan data. Pastikan nomor WhatsApp benar.');
                }
            } catch (error) {
                appendMessage('bot', 'Terjadi kendala saat mengirim data ke petugas.');
            } finally {
                // Reset to FAQ state
                chatState = 'FAQ';
                botInput.placeholder = "Ketik pertanyaan Anda...";
                botInput.type = "text";
            }
        }

        // Slide-up animation
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes slideInUp {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            @keyframes slideIn {
                from { opacity: 0; transform: translateX(100%); }
                to { opacity: 1; transform: translateX(0); }
            }
        `;
        document.head.appendChild(style);

        // Autofocus on open
        document.getElementById('publicServiceModal').addEventListener('show', () => {
            setTimeout(() => botInput.focus(), 100);
        });

        // --- ALWAYS ON: AUTO-START ON LOAD ---
        document.addEventListener('DOMContentLoaded', () => {
            const wasActive = localStorage.getItem('voiceGuideActive') === 'true';
            
            if (wasActive) {
                console.log("Restoring Voice Guide State: ACTIVE");
                // We use a small delay to ensure DOM is ready and not block initial render
                setTimeout(() => {
                    // Activate without full toggle logic to avoid double-toast in some cases, 
                    // or just call toggle if it's currently false.
                    if (!isContinuousMode) {
                        // Manually set state to avoid the 'toggle' flipping it back if logic was simpler
                        // But since toggle checks isContinuousMode, we can just force it ON.
                        
                        // NOTE: Browser Autoplay Policy might block immediate audio.
                        // We will try to activate. If blocked, fallback UX will show.
                        try {
                            isContinuousMode = true;
                            updateVoiceButtonVisuals(true);
                            // Do NOT play welcome sequence on reload? Or should we?
                            // User said "selalu on", arguably they want to know it's on.
                            // But full welcome might be annoying. Let's do a short cue.
                            
                            hasPlayedWelcome = true; // Skip full menu reading on reload
                            
                            // Try to start listening
                            if(recognition) {
                                try { recognition.start(); } catch(e){}
                            }
                            
                            showToast("Suara Panduan Dipulihkan", "success");
                            
                            // Optional: Short beep or "Siap"
                            // speakResponse("Siap."); 
                        } catch (e) {
                            console.log("Auto-start blocked:", e);
                        }
                    }
                }, 1000);
            }
        });
    </script>
</body>

</html>