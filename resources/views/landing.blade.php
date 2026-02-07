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
        <!-- Voice Guide Toggle (Accessibility Orange) -->
        <button id="btnVoiceGuideToggle" onclick="activateVoiceGuide()"
            class="btn btn-circle bg-orange-600 hover:bg-orange-700 border-0 shadow-lg w-14 h-14 relative group transition-all duration-300"
            aria-label="Aktifkan Pemandu Suara" title="Bantuan Suara">
            <i class="fas fa-deaf text-white text-xl transition-transform group-hover:scale-110"></i>
            <span class="absolute -top-1 -right-1 flex h-3 w-3">
                <span id="voice-ping"
                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75 hidden"></span>
                <span id="voice-dot" class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500 hidden"></span>
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
        // --- CHATBOT FAQ LOGIC (Preserved) ---
        const chatMessages = document.getElementById('chatMessages');
        const botForm = document.getElementById('publicFaqForm');
        const botInput = document.getElementById('botQuery');
        const btnMic = document.getElementById('btnMic');
        let chatState = 'FAQ'; // 'FAQ' or 'CAPTURE_WA'
        let lastUserQuery = '';
        let isVoiceInteraction = false;

        // Visual Feedback Util
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

        function sendQuickChip(text) {
            botInput.value = text;
            isVoiceInteraction = false;
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

            if (chatState === 'CAPTURE_WA') {
                handleWaCapture(inputVal);
                return;
            }

            lastUserQuery = inputVal;
            appendMessage('user', inputVal);
            botInput.value = '';

            try {
                const response = await fetch(`{{ route('api.faq.search') }}?q=${encodeURIComponent(inputVal)}`);
                const data = await response.json();

                if (data.found && data.results && data.results.length > 0) {
                    const top = data.results[0];
                    const answerText = top.jawaban || top.answer || data.answer;
                    appendMessage('bot', answerText, !data.is_emergency);

                    // Trigger Voice Guide speak if modular JS is active
                    if (window.VoiceSpeech && window.VoiceState && window.VoiceState.isActive()) {
                        window.VoiceSpeech.speak(answerText);
                    }
                } else if (data.answer) {
                    // Fallback for direct answer field if results missing
                    appendMessage('bot', data.answer, !data.is_emergency);
                    if (window.VoiceSpeech && window.VoiceState && window.VoiceState.isActive()) {
                        window.VoiceSpeech.speak(data.answer);
                    }
                } else {
                    appendMessage('bot', 'Maaf, saya tidak menemukan jawaban pasti. Ingin bertanya langsung pada petugas?');
                }
            } catch (error) {
                appendMessage('bot', 'Sepertinya ada gangguan koneksi. Coba lagi nanti ya.');
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

                if (response.ok) {
                    appendMessage('bot', '✅ **Permintaan Berhasil Dicatat!**\n\nNomor Anda sudah tersimpan. Petugas akan menghubungi Anda maksimal dalam 1x24 jam kerja.');
                } else {
                    appendMessage('bot', 'Gagal menyimpan data. Pastikan nomor WhatsApp benar.');
                }
            } catch (error) {
                appendMessage('bot', 'Terjadi kendala saat mengirim data ke petugas.');
            } finally {
                chatState = 'FAQ';
                botInput.placeholder = "Ketik pertanyaan Anda...";
                botInput.type = "text";
            }
        }

        // Slide-up animation
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes slideInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
            @keyframes slideIn { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }
        `;
        document.head.appendChild(style);

        // Autofocus on open
        document.getElementById('publicServiceModal').addEventListener('show', () => {
            setTimeout(() => botInput.focus(), 100);
        });

        // --- MODULAR VOICE GUIDE INTEGRATION ---
        window.APP_WILAYAH_NAMA = {!! json_encode(optional(appProfile())->region_name ?? 'Wilayah') !!};
        window.APP_FAQ_KEYWORDS = {!! json_encode($faqKeywords ?? []) !!};
    </script>

    <script src="{{ asset('voice-guide/voice.bundle.js') }}?v=2.7"></script>

</body>

</html>