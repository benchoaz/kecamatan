<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ appProfile()->region_name }} - {{ appProfile()->tagline ?? 'Pelayanan Profesional' }}</title>
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

    <!-- Leaflet.js -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        a,
        a:hover,
        a:focus,
        a:active,
        .underline,
        .hover\:underline,
        .menu a,
        .navbar a,
        .navbar span,
        .navbar div {
            text-decoration: none !important;
            border-bottom-width: 0 !important;
            border-bottom-style: none !important;
            box-shadow: none !important;
        }

        * {
            text-decoration: none !important;
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
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
                <li><a href="#jelajah"
                        class="text-sm font-medium text-gray-600 hover:text-teal-600 hover:bg-teal-50 rounded-lg">Wilayah</a>
                </li>
                <li class="dropdown dropdown-hovergroup">
                    <label tabindex="0"
                        class="text-sm font-bold text-slate-600 group-hover:text-amber-600 group-hover:bg-amber-50/50 rounded-full px-4 py-2 transition-all cursor-pointer flex items-center gap-1.5">
                        <i class="fas fa-store text-amber-500 opacity-80 group-hover:opacity-100"></i>
                        <span>UMKM Rakyat</span>
                        <i
                            class="fas fa-chevron-down text-[9px] opacity-40 group-hover:translate-y-0.5 transition-transform duration-300"></i>
                    </label>
                    <ul tabindex="0"
                        class="dropdown-content z-[200] menu p-3 shadow-[0_20px_40px_-10px_rgba(0,0,0,0.1)] bg-white/95 backdrop-blur-xl border border-white/60 rounded-[1.5rem] w-64 mt-2 animate-[slideUp_0.2s_ease-out]">
                        <li class="mb-1"><a href="{{ route('umkm_rakyat.index') }}"
                                class="py-3 px-4 text-xs font-bold text-slate-600 hover:text-amber-600 hover:bg-amber-50 rounded-xl flex gap-3 group/item">
                                <span
                                    class="w-6 h-6 rounded-lg bg-amber-100/50 flex items-center justify-center text-amber-500 group-hover/item:bg-amber-500 group-hover/item:text-white transition-all"><i
                                        class="fas fa-search text-[10px]"></i></span>
                                Jelajah UMKM
                            </a></li>

                        <li class="mb-1"><a href="{{ route('umkm_rakyat.create') }}"
                                class="py-3 px-4 text-xs font-bold text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl flex gap-3 group/item">
                                <span
                                    class="w-6 h-6 rounded-lg bg-emerald-100/50 flex items-center justify-center text-emerald-500 group-hover/item:bg-emerald-500 group-hover/item:text-white transition-all"><i
                                        class="fas fa-plus text-[10px]"></i></span>
                                Buka Etalase UMKM
                            </a></li>

                        <li class="mb-1"><a href="{{ route('umkm_rakyat.products') }}"
                                class="py-3 px-4 text-xs font-bold text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-xl flex gap-3 group/item">
                                <span
                                    class="w-6 h-6 rounded-lg bg-blue-100/50 flex items-center justify-center text-blue-500 group-hover/item:bg-blue-500 group-hover/item:text-white transition-all"><i
                                        class="fas fa-box-open text-[10px]"></i></span>
                                Katalog Produk
                            </a></li>

                        <li><a href="{{ route('umkm_rakyat.nearby') }}"
                                class="py-3 px-4 text-xs font-bold text-slate-600 hover:text-purple-600 hover:bg-purple-50 rounded-xl flex gap-3 group/item">
                                <span
                                    class="w-6 h-6 rounded-lg bg-purple-100/50 flex items-center justify-center text-purple-500 group-hover/item:bg-purple-500 group-hover/item:text-white transition-all"><i
                                        class="fas fa-map-marked-alt text-[10px]"></i></span>
                                Peta Sebaran
                            </a></li>

                        <div class="h-px bg-slate-100 my-2 mx-2"></div>

                        <li><a href="{{ route('umkm_rakyat.login') }}"
                                class="py-3 px-4 text-xs font-black text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-xl flex gap-3 group/item">
                                <span
                                    class="w-6 h-6 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 group-hover/item:bg-rose-500 group-hover/item:text-white transition-all"><i
                                        class="fas fa-sign-in-alt text-[10px]"></i></span>
                                Masuk Dashboard
                            </a></li>
                    </ul>
                </li>
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

    </div>

    <!-- Premium Announcement Slider -->
    @if(isset($publicAnnouncements) && $publicAnnouncements->count() > 0)
        <div
            class="relative bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 border-b border-slate-700 overflow-hidden z-40">
            <div
                class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10">
            </div>
            <div class="container mx-auto max-w-7xl flex items-center h-10">
                <!-- Label -->
                <div
                    class="relative z-10 flex items-center h-full bg-rose-600 px-6 transform -skew-x-12 -ml-4 shadow-lg shadow-rose-900/50">
                    <div
                        class="transform skew-x-12 flex items-center gap-2 text-white font-black text-[10px] uppercase tracking-widest">
                        <span class="animate-pulse w-2 h-2 bg-white rounded-full"></span>
                        Info
                    </div>
                </div>

                <!-- Ticker Content -->
                <div class="flex-1 overflow-hidden relative h-full flex items-center pl-6">
                    <div class="ticker-wrap w-full">
                        <div class="ticker-move inline-block whitespace-nowrap hover:pause-animation">
                            @foreach($publicAnnouncements as $ann)
                                <div class="inline-flex items-center mx-8 group cursor-pointer"
                                    onclick="openBotWithQuery('{{ $ann->content }}')">
                                    <span class="text-rose-400 mr-2 text-xs"><i class="fas fa-chevron-right"></i></span>
                                    <span class="text-xs font-bold text-slate-300 group-hover:text-white transition-colors">
                                        {{ $ann->content }}
                                    </span>
                                    <span
                                        class="ml-3 text-[9px] font-bold text-slate-500 border border-slate-700 px-1.5 rounded bg-slate-800/50">{{ $ann->created_at->diffForHumans() }}</span>
                                </div>
                            @endforeach
                            <!-- Duplicate for infinite scroll -->
                            @foreach($publicAnnouncements as $ann)
                                <div class="inline-flex items-center mx-8 group cursor-pointer"
                                    onclick="openBotWithQuery('{{ $ann->content }}')">
                                    <span class="text-rose-400 mr-2 text-xs"><i class="fas fa-chevron-right"></i></span>
                                    <span class="text-xs font-bold text-slate-300 group-hover:text-white transition-colors">
                                        {{ $ann->content }}
                                    </span>
                                    <span
                                        class="ml-3 text-[9px] font-bold text-slate-500 border border-slate-700 px-1.5 rounded bg-slate-800/50">{{ $ann->created_at->diffForHumans() }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Close Button (Optional UX) -->
                <button onclick="this.parentElement.parentElement.remove()"
                    class="z-10 px-4 text-slate-500 hover:text-white transition-colors">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        </div>
        <style>
            .ticker-wrap {
                width: 100%;
                overflow: hidden;
            }

            .ticker-move {
                display: inline-block;
                white-space: nowrap;
                padding-right: 100%;
                animation: ticker 40s linear infinite;
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

    <!-- Hero Section Settings Integration -->
    @if($heroBg)
        <style>
            .hero-dynamic-bg {
                position: absolute;
                inset: 0;
                background-image: url('{{ $heroBg }}');
                background-size: cover;
                background-position: center;
                /* Logic: 14% Transparansi = 86% Intensity */
                opacity:
                    {{ 1 - (($bgOpacity ?? 0) / 100) }}
                ;
                filter: blur({{ $bgBlur ?? 0 }}px);
                z-index: 10;
                /* Fade effect: Scenery strictly on the left (behind text), fully clean on the right */
                -webkit-mask-image: linear-gradient(to right, black 5%, rgba(0, 0, 0, 0.4) 35%, transparent 55%);
                mask-image: linear-gradient(to right, black 5%, rgba(0, 0, 0, 0.4) 35%, transparent 55%);
            }

            .hero-text-reveal {
                animation: heroFocusReveal 1.5s cubic-bezier(0.16, 1, 0.3, 1) both;
                animation-delay: 0.8s;
            }

            @keyframes heroFocusReveal {
                from {
                    opacity: 0;
                    filter: blur(10px);
                }

                to {
                    opacity: 1;
                    filter: blur(0);
                }
            }
        </style>
    @endif

    <!-- Hero Section -->
    <div class="hero min-h-[75vh] relative overflow-hidden bg-white">
        <!-- Layer 0: Base Body Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#e0f7f6] via-white to-white z-0"></div>

        @if($heroBg)
            <!-- Layer 1: Dynamic Scenery (Centered) -->
            <div class="hero-dynamic-bg"></div>
            <!-- Extra Overlay for Emotional Connection & Context -->
            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/80 to-transparent z-15"></div>
        @else
            <!-- Fallback Scenery Backdrop -->
            <div class="absolute inset-0 z-10 opacity-15"
                style="background-image: url('https://images.unsplash.com/photo-1596328330776-6d9b4b0e503b?q=80&w=1600&auto=format&fit=crop'); background-size: cover; background-position: center;">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/40 to-transparent z-15"></div>
        @endif

        <!-- Layer 2: Decorative Blobs -->
        <div
            class="absolute top-0 right-0 w-[500px] h-[500px] bg-teal-50/50 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 z-15 opacity-60">
        </div>

        <div class="container mx-auto px-6 relative z-20 py-12">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <!-- Left: Content -->
                <div class="w-full lg:w-1/2 text-left hero-text-reveal">
                    <div
                        class="inline-flex items-center gap-2 bg-[#dcfce7] text-[#166534] px-4 py-1.5 rounded-full mb-6 shadow-sm border border-emerald-100">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                        <span class="text-xs font-bold uppercase tracking-wide">Sistem Administrasi Terpadu untuk
                            Masyarakat</span>
                    </div>

                    <h1 class="text-5xl md:text-7xl font-black text-[#1e293b] mb-6 leading-[1.1] tracking-tight"
                        style="text-shadow: 0 1px 2px rgba(255,255,255,0.5);">
                        Pelayanan<br>
                        Kecamatan Besuk,<br>
                        <span class="text-[#0f766e]">Mudah & Terbuka</span>
                    </h1>

                    <p class="text-lg md:text-xl text-[#475569] mb-10 leading-relaxed font-medium max-w-xl"
                        style="text-shadow: 0 1px 1px rgba(255,255,255,0.8);">
                        Informasi, layanan, dan pengaduan masyarakat dalam satu pintu. Komitmen kami untuk melayani
                        dengan integritas dan transparansi.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <button onclick="document.getElementById('publicServiceModal').showModal()"
                            class="btn bg-[#0d9488] hover:bg-[#0f766e] text-white border-0 rounded-2xl px-10 font-bold shadow-xl transition-all h-14">
                            Sampaikan Layanan / Pengaduan
                        </button>
                    </div>

                </div>

                <!-- Right: Visionary Leaders (Dynamic from Admin) -->
                @if($isHeroActive)
                    <div class="w-full lg:w-1/2 relative flex justify-center lg:justify-end gap-0">
                        @if($heroImage)
                            <!-- Leadership Image from Admin -->
                            <div class="relative group">
                                <div class="relative transition-transform duration-500 group-hover:-translate-y-2">
                                    <img src="{{ $heroImage }}" class="max-w-full h-auto object-contain drop-shadow-2xl"
                                        alt="{{ $heroImageAlt }}">
                                </div>
                            </div>
                        @else
                            <!-- Fallback default leaders if no image uploaded but active -->
                            <div class="relative group mt-10">
                                <div
                                    class="w-64 md:w-80 h-auto overflow-hidden rounded-[2.5rem] relative transition-transform duration-500 group-hover:-translate-y-2">
                                    <img src="https://kecamatanklasik.probolinggokab.go.id/wp-content/uploads/2024/11/Bupati-Probolinggo-Haris.png"
                                        class="w-full h-full object-cover grayscale-0 group-hover:scale-110 transition-transform duration-700"
                                        alt="dr. Mohammad Haris">
                                </div>
                                <div
                                    class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-[85%] bg-white/95 backdrop-blur-sm p-3 rounded-2xl shadow-xl border border-slate-100 text-center">
                                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-tighter">dr. Mohammad Haris
                                    </h4>
                                    <p class="text-[9px] font-bold text-teal-600 uppercase tracking-widest mt-0.5">Bupati</p>
                                </div>
                            </div>
                            <div class="relative group -ml-12 md:-ml-20">
                                <div
                                    class="w-64 md:w-80 h-auto overflow-hidden rounded-[2.5rem] relative transition-transform duration-500 group-hover:-translate-y-2 delay-75">
                                    <img src="https://kecamatanklasik.probolinggokab.go.id/wp-content/uploads/2024/11/Wakil-Bupati-Probolinggo-Fahmi.png"
                                        class="w-full h-full object-cover grayscale-0 group-hover:scale-110 transition-transform duration-700"
                                        alt="Fahmi AHZ">
                                </div>
                                <div
                                    class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-[85%] bg-white/95 backdrop-blur-sm p-3 rounded-2xl shadow-xl border border-slate-100 text-center">
                                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-tighter">Fahmi AHZ</h4>
                                    <p class="text-[9px] font-bold text-teal-600 uppercase tracking-widest mt-0.5">Wakil Bupati
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <!-- Elegant Wave Divider -->
        <div class="absolute bottom-0 left-0 w-full leading-[0] z-10 translate-y-px">
            <svg class="relative block w-full h-[50px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path
                    d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5,73.84-4.36,147.54,16.88,218.32,35.26,69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113,2,1200,34.19V0Z"
                    fill="#f8fafc" opacity=".5"></path>
                <path
                    d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5V0Z"
                    fill="#f1f5f9"></path>
            </svg>
        </div>
    </div>

    <!-- Section: Layanan Paling Dicari (NEW) -->
    <div class="relative z-30 -mt-20">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div onclick="openSubmissionModal('Kependudukan', 'KTP, KK, Akte Kelahiran')"
                    class="bg-white/90 backdrop-blur-xl p-6 rounded-[2rem] shadow-xl border border-white hover:scale-105 transition-all cursor-pointer group">
                    <div
                        class="w-12 h-12 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-teal-600 group-hover:text-white transition-colors">
                        <i class="fas fa-id-card text-xl"></i>
                    </div>
                    <h3 class="font-black text-slate-800 text-sm mb-1">Kependudukan</h3>
                    <p class="text-[10px] text-slate-500 font-medium">KTP, KK, Akte & Surat Pindah</p>
                </div>

                <div onclick="openSubmissionModal('Bantuan Sosial', 'Surat Keterangan Tidak Mampu')"
                    class="bg-white/90 backdrop-blur-xl p-6 rounded-[2rem] shadow-xl border border-white hover:scale-105 transition-all cursor-pointer group">
                    <div
                        class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <i class="fas fa-hand-holding-heart text-xl"></i>
                    </div>
                    <h3 class="font-black text-slate-800 text-sm mb-1">Bantuan Sosial</h3>
                    <p class="text-[10px] text-slate-500 font-medium">DTKS, SKTM & Hibah</p>
                </div>

                <div onclick="openSubmissionModal('Bantuan UMKM', 'Saya ingin dibantu mendaftarkan produk UMKM saya agar tampil di website.')"
                    class="bg-white/90 backdrop-blur-xl p-6 rounded-[2rem] shadow-xl border border-white hover:scale-105 transition-all cursor-pointer group">
                    <div
                        class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                        <i class="fas fa-store-alt text-xl"></i>
                    </div>
                    <h3 class="font-black text-slate-800 text-sm mb-1">Bantuan Daftar UMKM</h3>
                    <p class="text-[10px] text-slate-500 font-medium">Dibantu Kecamatan Gratis</p>
                </div>

                <div onclick="openBotWithQuery('Jam Layanan')"
                    class="bg-white/90 backdrop-blur-xl p-6 rounded-[2rem] shadow-xl border border-white hover:scale-105 transition-all cursor-pointer group">
                    <div
                        class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <h3 class="font-black text-slate-800 text-sm mb-1">Jam Operasional</h3>
                    <p class="text-[10px] text-slate-500 font-medium">Cek jadwal pelayanan hari ini</p>
                </div>
            </div>

            <!-- Section: Lacak Berkas (NEW) -->
            <div class="mt-8 max-w-2xl mx-auto">
                <div
                    class="bg-white/80 backdrop-blur-xl p-2 rounded-3xl shadow-xl border border-white flex flex-col md:flex-row items-center gap-2">
                    <div class="flex-grow flex items-center px-4 gap-3 w-full">
                        <i class="fas fa-search text-teal-500"></i>
                        <input type="text" id="trackingInput" name="q"
                            placeholder="Cek Status Berkas? Masukkan No. WA atau ID..."
                            class="bg-transparent border-none focus:ring-0 text-sm font-medium w-full text-slate-700 h-12">
                    </div>
                    <button onclick="handleTracking()"
                        class="btn bg-teal-600 hover:bg-teal-700 text-white border-0 rounded-2xl px-8 h-12 w-full md:w-auto font-black shadow-lg">
                        Lacak Berkas
                    </button>
                </div>
                <p class="text-center text-[10px] text-slate-400 mt-3 font-medium italic">
                    <i class="fas fa-info-circle mr-1"></i> Masukkan nomor WhatsApp yang digunakan saat mendaftar untuk
                    melihat update terbaru.
                </p>
            </div>
        </div>
    </div>

    <!-- Section: Info Hari Ini (Restored & Spaced) -->
    <div class="container mx-auto px-6 relative z-10 mt-12 mb-12">
        <div
            class="bg-white/80 backdrop-blur-md py-8 rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.08)] border border-white/50">
            <div class="px-6 md:px-10">
                <div class="flex flex-col md:flex-row items-center justify-between mb-8 gap-4">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center shadow-sm">
                            <i class="fas fa-bolt text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-slate-800 leading-none">Info Hari Ini</h2>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Update
                                Terkini Kecamatan</p>
                        </div>
                    </div>
                    <div class="h-px flex-grow bg-slate-100 mx-6 hidden md:block"></div>
                    <a href="#pengumuman" class="text-xs font-bold text-teal-600">Lihat Semua Info</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($publicAnnouncements->take(3) as $ann)
                        <div
                            class="bg-slate-50 p-5 rounded-2xl border border-slate-200/50 hover:bg-white hover:border-teal-200 transition-all flex flex-col h-full">
                            <div class="flex justify-between items-start mb-3">
                                <span
                                    class="bg-amber-50 text-amber-700 text-[9px] font-black px-2 py-0.5 rounded uppercase tracking-tighter">Penting</span>
                                <span
                                    class="text-[10px] text-slate-400 font-bold tracking-tight">{{ $ann->created_at->diffForHumans() }}</span>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800 mb-2 line-clamp-2">Agenda Kecamatan</h3>
                            <p class="text-xs text-slate-500 leading-relaxed mb-4 flex-grow">
                                {{ Str::limit($ann->content, 120) }}
                            </p>
                            <hr class="border-slate-100 mb-3">
                            <button onclick="openBotWithQuery('{{ $ann->content }}')"
                                class="text-xs font-black text-teal-600 hover:text-teal-700 flex items-center gap-2">
                                Pelajari Selengkapnya <i class="fas fa-chevron-right text-[8px]"></i>
                            </button>
                        </div>
                    @empty
                        <div class="col-span-full py-8 text-center text-slate-400 italic">
                            Belum ada pengumuman khusus hari ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <!-- Isolated Container: Low Z-Index, Relative Position, No Overlap with Global ID -->
    @auth
        @if(auth()->user()->hasRole('Operator Kecamatan') || auth()->user()->hasRole('Super Admin'))
            <div class="py-4 relative z-10">
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

    <!-- Section: Statistik & Kepercayaan (NEW) -->
    <div class="py-16 bg-white relative overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center group">
                    <div
                        class="text-4xl md:text-5xl font-black text-teal-600 mb-2 group-hover:scale-110 transition-transform">
                        1.2k+</div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Layanan Selesai</p>
                    <div class="w-8 h-1 bg-teal-100 mx-auto mt-4 rounded-full"></div>
                </div>
                <div class="text-center group">
                    <div
                        class="text-4xl md:text-5xl font-black text-amber-500 mb-2 group-hover:scale-110 transition-transform">
                        17</div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Desa Terintegrasi</p>
                    <div class="w-8 h-1 bg-amber-100 mx-auto mt-4 rounded-full"></div>
                </div>
                <div class="text-center group">
                    <div
                        class="text-4xl md:text-5xl font-black text-blue-600 mb-2 group-hover:scale-110 transition-transform">
                        24h</div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Respon Cepat</p>
                    <div class="w-8 h-1 bg-blue-100 mx-auto mt-4 rounded-full"></div>
                </div>
                <div class="text-center group">
                    <div
                        class="text-4xl md:text-5xl font-black text-emerald-600 mb-2 group-hover:scale-110 transition-transform">
                        98%</div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kepuasan Warga</p>
                    <div class="w-8 h-1 bg-emerald-100 mx-auto mt-4 rounded-full"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Jelajah Wilayah (NEW) -->
    <div class="w-full h-24 bg-gradient-to-b from-white to-slate-50"></div>
    <div id="jelajah" class="py-24 bg-slate-50 overflow-hidden relative">
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <div
                    class="inline-flex items-center gap-2 bg-teal-50 text-teal-700 px-4 py-2 rounded-full mb-4 text-[10px] font-black uppercase tracking-widest">
                    <i class="fas fa-map-marked-alt"></i>
                    <span>Eksplorasi Wilayah</span>
                </div>
                <h2 class="text-3xl md:text-5xl font-black text-slate-800 mb-4">Jelajah Desa di Kecamatan</h2>
                <p class="text-slate-500 max-w-2xl mx-auto font-medium leading-relaxed">
                    Klik pada area desa untuk mengunjungi portal resmi masing-masing wilayah.
                </p>
            </div>

            <div class="relative group mt-8">
                <!-- Map Container -->
                <div id="mapContainer"
                    class="w-full h-[500px] md:h-[650px] rounded-[3rem] shadow-2xl border-8 border-white overflow-hidden relative">
                </div>

                <!-- Map Legend/Overlay -->
                <div class="absolute bottom-10 left-10 z-30 hidden md:block">
                    <div
                        class="bg-white/90 backdrop-blur-xl p-6 rounded-[2rem] shadow-2xl border border-white max-w-xs">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-teal-600 rounded-xl flex items-center justify-center text-white">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <div>
                                <h4 class="font-black text-slate-800 text-sm">Peta Interaktif</h4>
                                <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">Kecamatan Besuk
                                </p>
                            </div>
                        </div>
                        <p class="text-[11px] text-slate-600 leading-relaxed mb-4">
                            Warna pada peta menunjukkan batasan wilayah masing-masing desa. Klik area desa untuk info
                            lebih lanjut.
                        </p>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2 text-[10px] font-bold text-slate-700">
                                <span class="w-3 h-3 rounded-sm bg-teal-500/50 border border-teal-600"></span> Batas
                                Desa
                            </div>
                            <div class="flex items-center gap-2 text-[10px] font-bold text-slate-700">
                                <span class="w-3 h-3 rounded-full bg-teal-600"></span> Pusat Desa
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fallback for Small Mobile / Data Loading -->
            <div id="mapFallback" class="hidden mt-8 grid grid-cols-2 gap-3">
                @foreach($desas as $desa)
                    <a href="{{ $desa->website ?? '#' }}" target="_blank"
                        class="bg-white p-4 rounded-2xl border border-slate-200 text-center">
                        <span class="text-[10px] font-black text-slate-700">{{ $desa->nama_desa }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Background Ornaments -->
        <div
            class="absolute top-1/2 left-0 -translate-y-1/2 -translate-x-1/2 w-64 h-64 bg-teal-200/20 rounded-full blur-3xl">
        </div>
        <div
            class="absolute bottom-0 right-0 translate-y-1/2 translate-x-1/2 w-96 h-96 bg-blue-200/20 rounded-full blur-3xl">
        </div>
    </div>


    <!-- Section: Layanan Terpadu (REFINED) -->
    <div class="w-full h-24 bg-gradient-to-b from-slate-50 to-white"></div>
    <div id="layanan" class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20">
                <div
                    class="inline-flex items-center gap-2 bg-teal-50 text-teal-700 px-4 py-2 rounded-full mb-4 text-[10px] font-black uppercase tracking-widest">
                    <i class="fas fa-magic"></i>
                    <span>Layanan Lintas Desa</span>
                </div>
                <h2 class="text-3xl md:text-5xl font-black text-slate-800 mb-4">Layanan Kecamatan Terpadu</h2>
                <p class="text-slate-500 max-w-2xl mx-auto font-medium leading-relaxed">
                    Proses administrasi cepat untuk rekomendasi, validasi, dan koordinasi publik tingkat kecamatan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($masterLayanan as $svc)
                    <div
                        class="group bg-white rounded-[2.5rem] p-8 border border-slate-100 hover:border-teal-100 transition-all duration-500 hover:shadow-[0_20px_50px_-12px_rgba(13,148,136,0.12)] relative overflow-hidden flex flex-col h-full">
                        <!-- Top Accent -->
                        <div
                            class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r {{ $svc->warna_bg ?? 'from-teal-500 to-teal-600' }} opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>

                        <div class="flex items-start gap-6 mb-6">
                            <div
                                class="w-16 h-16 rounded-2xl {{ $svc->warna_bg ?? 'bg-teal-50' }} {{ $svc->warna_text ?? 'text-teal-600' }} flex items-center justify-center shrink-0 shadow-sm group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                                <i class="fas {{ $svc->ikon ?? 'fa-file-alt' }} text-2xl"></i>
                            </div>
                            <div>
                                <h3
                                    class="text-xl font-black text-slate-800 mb-1 group-hover:text-teal-700 transition-colors leading-tight">
                                    {{ $svc->nama_layanan }}
                                </h3>
                                <div
                                    class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    <i class="far fa-clock text-teal-500"></i>
                                    <span>Estimasi: {{ $svc->estimasi_waktu ?? '15 Menit' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 mb-8 flex-grow">
                            <div
                                class="bg-slate-50 rounded-2xl p-4 border border-slate-100 group-hover:bg-white group-hover:border-teal-50 transition-colors">
                                <p
                                    class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-2">
                                    <i class="fas fa-list-check text-[10px]"></i> Persyaratan
                                </p>
                                <p class="text-xs text-slate-600 leading-relaxed font-medium">
                                    {{ $svc->deskripsi_syarat }}
                                </p>
                            </div>
                        </div>

                        <button
                            onclick="openSubmissionModal('{{ $svc->nama_layanan }}', '{{ str_replace(["\r", "\n"], ' ', addslashes($svc->deskripsi_syarat)) }}')"
                            class="btn btn-sm bg-teal-600 hover:bg-teal-700 border-none text-white rounded-xl px-6 w-full group-hover:shadow-md transition-all py-3 h-auto font-black uppercase tracking-widest text-[10px]">
                            Ajukan / Hubungi
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Etalase UMKM Section -->
    <div id="umkm" class="py-24 bg-slate-50 relative overflow-hidden">
        <!-- Background Elements -->
        <div
            class="absolute top-0 right-0 w-[500px] h-[500px] bg-amber-100/40 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-teal-100/40 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2 pointer-events-none">
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
                <div class="max-w-2xl">
                    <div
                        class="inline-flex items-center gap-2 bg-white/80 backdrop-blur border border-amber-200 text-amber-700 px-4 py-1.5 rounded-full mb-6 text-[10px] font-black uppercase tracking-widest shadow-sm">
                        <i class="fas fa-store text-amber-500"></i>
                        <span>Ekonomi Kreatif & Lokal</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-slate-800 mb-4 tracking-tight leading-tight">
                        Produk Unggulan <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-orange-600">Terbaik
                            Desa</span>
                    </h2>
                    <p class="text-slate-500 text-base md:text-lg leading-relaxed font-medium">
                        Jelajahi potensi ekonomi kreatif dari tangan-tangan terampil warga kami. Dukung produk lokal
                        untuk kemajuan bersama.
                    </p>
                </div>
                <div class="hidden md:block">
                    <a href="{{ route('umkm_rakyat.index') }}"
                        class="group inline-flex items-center gap-3 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-full px-8 py-4 font-bold shadow-lg shadow-slate-200/50 transition-all hover:-translate-y-1">
                        <span>Lihat Semua Produk</span>
                        <div
                            class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center group-hover:bg-amber-50 group-hover:text-amber-600 transition-colors">
                            <i class="fas fa-arrow-right text-xs"></i>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Premium UMKM Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse($umkms as $u)
                    <div
                        class="group relative bg-white rounded-[2rem] p-3 border border-slate-100 hover:border-amber-200 hover:shadow-[0_20px_50px_-12px_rgba(245,158,11,0.15)] transition-all duration-500 flex flex-col h-full hover:-translate-y-1">

                        <!-- Image Container with Overlay -->
                        <div class="aspect-[4/3] rounded-[1.5rem] overflow-hidden relative mb-4 shadow-sm">
                            <img src="{{ $u->foto_usaha ? asset('storage/' . $u->foto_usaha) : 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=800&auto=format&fit=crop' }}"
                                alt="{{ $u->nama_usaha }}"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-in-out">

                            <!-- Badges -->
                            <div class="absolute top-3 left-3 flex gap-2 z-10">
                                <span
                                    class="bg-white/95 backdrop-blur-sm text-slate-800 text-[10px] font-black px-3 py-1.5 rounded-lg shadow-sm uppercase tracking-wider border border-white/50 flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-amber-500"></i> {{ Str::limit($u->desa, 15) }}
                                </span>
                            </div>

                            <!-- Hover Action -->
                            <div
                                class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-[2px]">
                                <a href="{{ route('umkm_rakyat.show', $u->slug) }}"
                                    class="bg-white text-slate-900 px-6 py-3 rounded-full font-bold text-xs transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300 shadow-xl hover:bg-amber-500 hover:text-white flex items-center gap-2">
                                    <i class="fas fa-search"></i> Lihat Detail
                                </a>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="px-2 pb-2 flex-grow flex flex-col">
                            <div class="flex items-center gap-2 mb-2">
                                <span
                                    class="w-1.5 h-1.5 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.5)]"></span>
                                <span
                                    class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $u->jenis_usaha }}</span>
                            </div>

                            <h3
                                class="text-lg font-black text-slate-800 mb-2 line-clamp-1 group-hover:text-amber-600 transition-colors tracking-tight">
                                <a href="{{ route('umkm_rakyat.show', $u->slug) }}">{{ $u->nama_usaha }}</a>
                            </h3>

                            <div class="flex items-center gap-2 mb-4">
                                <div
                                    class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-[10px] uppercase font-bold border border-slate-200">
                                    {{ substr($u->nama_pemilik, 0, 1) }}
                                </div>
                                <span class="text-xs text-slate-500 font-bold truncate">{{ $u->nama_pemilik }}</span>
                            </div>

                            <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $u->no_wa) }}" target="_blank"
                                    class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1.5 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition-colors group/wa">
                                    <i class="fab fa-whatsapp text-sm group-hover/wa:scale-110 transition-transform"></i>
                                    Chat
                                </a>
                                <span
                                    class="text-[10px] text-amber-500 font-bold bg-amber-50 px-2 py-1 rounded-md border border-amber-100 flex items-center gap-1">
                                    <i class="fas fa-star text-[9px]"></i> Unggulan
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div
                            class="bg-white rounded-[2.5rem] p-12 border border-dashed border-slate-200 max-w-lg mx-auto relative overflow-hidden group hover:border-amber-200 transition-colors">
                            <div class="relative z-10">
                                <div
                                    class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300 group-hover:scale-110 group-hover:text-amber-400 transition-all duration-500">
                                    <i class="fas fa-store-slash text-3xl"></i>
                                </div>
                                <h3 class="text-slate-800 font-black text-lg mb-2">Belum Ada Produk</h3>
                                <p class="text-slate-500 text-sm mb-6 font-medium">Jadilah yang pertama membuka etalase
                                    digital di desa Anda.</p>
                                <a href="{{ route('umkm_rakyat.create') }}"
                                    class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-teal-600 to-emerald-600 text-white text-xs font-bold rounded-xl hover:shadow-lg hover:shadow-teal-500/30 transition-all hover:-translate-y-1">
                                    <i class="fas fa-plus-circle mr-2"></i> Buka Etalase Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Lowongan Kerja (Loker) Section -->
    <div id="loker" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div class="max-w-xl">
                    <div
                        class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-700 px-4 py-2 rounded-full mb-4 text-xs font-bold uppercase tracking-widest">
                        <i class="fas fa-briefcase"></i>
                        <span>Peluang Karir</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-2">Informasi Lowongan Kerja</h2>
                    <p class="text-gray-500 text-sm md:text-base leading-relaxed">
                        Temukan peluang karir terbaik dan kembangkan potensi diri bersama mitra kami.
                    </p>
                </div>
                <div class="text-slate-400 text-xs font-medium italic">
                    Bekerjasama dengan Dinas Tenaga Kerja
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($jobs as $job)
                    <div
                        class="group bg-slate-50 hover:bg-white p-6 rounded-[2.5rem] border border-transparent hover:border-indigo-100 hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-300">
                        <div class="flex flex-col h-full">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shrink-0 shadow-sm border border-slate-100 group-hover:border-indigo-100">
                                    <i class="fas fa-building text-indigo-500 text-xl"></i>
                                </div>
                                <div>
                                    <h4
                                        class="text-xs font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">
                                        {{ Str::limit($job->company_name ?? 'Mitra Kecamatan', 20) }}
                                    </h4>
                                    <p class="text-[10px] text-indigo-600 font-bold flex items-center gap-1">
                                        <i class="fas fa-map-marker-alt"></i> Wilayah Kecamatan
                                    </p>
                                </div>
                            </div>

                            <h3
                                class="text-lg font-bold text-gray-800 mb-3 group-hover:text-indigo-600 transition-colors leading-tight">
                                {{ $job->title }}
                            </h3>

                            <p class="text-xs text-slate-500 line-clamp-2 mb-6 leading-relaxed">
                                {{ Str::limit($job->description, 80) }}
                            </p>

                            <div class="mt-auto pt-4 border-t border-slate-100/50 flex items-center justify-between">
                                <span class="text-[10px] font-medium text-slate-400">Posting
                                    {{ $job->created_at ? $job->created_at->diffForHumans() : 'Baru' }}</span>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $job->contact_wa) }}" target="_blank"
                                    class="text-xs font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 group/link">
                                    Lamar <i
                                        class="fas fa-arrow-right text-[10px] group-hover/link:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-slate-400 italic">
                        Belum ada lowongan kerja tersedia saat ini.
                    </div>
                @endforelse
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
            </div> <!-- Close Grid -->

            <div class="mt-16 text-center">
                <a href="{{ route('public.berita.index') }}"
                    class="btn bg-white hover:bg-rose-50 text-rose-600 border-rose-100 rounded-2xl px-10 font-black shadow-sm transition-all h-14">
                    Lihat Semua Berita & Kegiatan <i class="fas fa-arrow-right ml-2 text-xs"></i>
                </a>
            </div>
        </div> <!-- Close Container -->
    </div> <!-- Close Section -->

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
    <footer class="bg-slate-800 text-gray-300 py-8mb-20 lg:mb-0">
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

    <!-- Service Submission Modal (PERFECTED & COMPACT) -->
    <dialog id="permohonanModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box max-w-2xl rounded-3xl bg-white p-0 overflow-hidden shadow-2xl border border-slate-100">
            <!-- Modal Header (Compact & Professional) -->
            <div
                class="bg-gradient-to-r from-teal-600 to-teal-700 px-6 py-4 flex justify-between items-center text-white shrink-0 shadow-lg">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <i class="fas fa-paper-plane text-lg text-teal-100"></i>
                    </div>
                    <div>
                        <h3 id="modalServiceTitle" class="font-black text-sm uppercase tracking-wider opacity-90">
                            Formulir Pengajuan</h3>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                            <span class="text-[9px] font-bold text-teal-100 uppercase tracking-widest">Respon Cepat
                                1x24
                                Jam</span>
                        </div>
                    </div>
                </div>
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost text-teal-100 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
            </div>

            <form id="submissionForm" class="p-6 space-y-5 bg-slate-50/30">
                @csrf
                <!-- Identification Section (3-Column Grid) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="form-control">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1 px-1">Nama
                            Lengkap</label>
                        <input type="text" name="nama_pemohon" placeholder="Sesuai KTP..."
                            class="input input-bordered bg-slate-50 border-slate-200 h-11 rounded-xl focus:border-teal-500 font-medium transition-all text-xs"
                            required>
                    </div>

                    <div class="form-control">
                        <label
                            class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1 px-1">WhatsApp</label>
                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-[10px]">+62</span>
                            <input type="tel" name="whatsapp" placeholder="812xxxx..."
                                class="input input-bordered bg-slate-50 border-slate-200 h-11 rounded-xl focus:border-teal-500 font-medium pl-9 w-full transition-all text-xs"
                                required>
                        </div>
                    </div>

                    <div class="form-control">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1 px-1">NIK
                            (Opsional)</label>
                        <input type="text" name="nik" placeholder="16 Digit..."
                            class="input input-bordered bg-slate-50 border-slate-200 h-11 rounded-xl focus:border-teal-500 font-medium transition-all text-xs"
                            maxlength="16">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1 px-1">Asal
                            Desa</label>
                        <select name="desa_id"
                            class="select select-bordered bg-slate-50 border-slate-200 h-11 rounded-xl focus:border-teal-500 font-medium transition-all text-xs"
                            required>
                            <option value="" disabled selected>Pilih Desa...</option>
                            @foreach($desas as $desa)
                                <option value="{{ $desa->id }}">{{ $desa->nama_desa }}</option>
                            @endforeach
                            <option value="999">Luar Wilayah Kecamatan Besuk</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1 px-1">Jenis
                            Layanan</label>
                        <input type="text" id="inputJenisLayanan" name="jenis_layanan" readonly
                            class="input input-bordered bg-slate-100 border-slate-200 h-11 rounded-xl font-bold text-teal-700 text-xs">
                    </div>
                </div>

                <div class="form-control">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1 px-1">Uraian /
                        Keperluan Singkat</label>
                    <textarea name="uraian"
                        placeholder="Contoh: Mengajukan pembuatan KK baru karena penambahan anggota keluarga..."
                        class="textarea textarea-bordered bg-slate-50 border-slate-200 rounded-xl focus:border-teal-500 min-h-[80px] font-medium transition-all text-xs"
                        required></textarea>
                </div>

                <!-- Attachment Area (DYNAMIC & LABELED) -->
                <div class="bg-teal-50/50 p-4 rounded-2xl border border-dashed border-teal-200">
                    <div class="flex items-center justify-between mb-3 px-1">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-paperclip text-teal-600 text-xs text-xs text-xs"></i>
                            <span class="text-[11px] font-black text-teal-700 uppercase tracking-widest">Persyaratan
                                Berkas</span>
                        </div>
                        <button type="button" onclick="addAttachmentField()"
                            class="btn btn-xs btn-ghost text-teal-600 hover:bg-teal-100 rounded-lg text-[9px] font-bold">
                            <i class="fas fa-plus-circle mr-1"></i> Tambah Berkas
                        </button>
                    </div>

                    <div id="dynamicAttachments" class="space-y-3">
                        <!-- JS dynamic fields go here -->
                        <div class="bg-white/50 border border-slate-100 rounded-xl p-3 text-center py-6">
                            <i class="fas fa-spinner animate-spin text-teal-300 text-xl"></i>
                        </div>
                    </div>

                    <p class="mt-3 text-[9px] text-teal-600/70 font-medium px-1">
                        <i class="fas fa-info-circle mr-1"></i> Format: JPG, PNG, PDF (Maks 5MB/file)
                    </p>
                </div>

                <!-- Anti-Spam Honeypot (Hidden) -->
                <div class="hidden">
                    <input type="text" name="website" tabindex="-1" autocomplete="off">
                </div>

                <div class="flex flex-col gap-3 pt-2">
                    <label class="flex items-center gap-3 cursor-pointer group px-1">
                        <input type="checkbox" name="is_agreed" class="checkbox checkbox-teal checkbox-xs rounded-md"
                            checked required>
                        <span
                            class="text-[10px] text-slate-500 font-medium group-hover:text-slate-700 transition-colors">Saya
                            menyatakan data di atas benar & sesuai aslinya.</span>
                    </label>

                    <button type="submit" id="btnSubmitPermohonan"
                        class="btn bg-teal-600 hover:bg-teal-700 border-0 text-white btn-block rounded-xl py-4 h-auto font-black uppercase tracking-widest text-xs shadow-lg hover:shadow-teal-200 transition-all">
                        Kirim Pengajuan Sekarang <i class="fas fa-paper-plane ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Pengaduan & Aspirasi Section (ENHANCED) -->
    <div id="pengaduan" class="py-24 bg-slate-900 overflow-hidden relative">
        <!-- Decoration -->
        <div
            class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl">
        </div>
        <div
            class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl">
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="text-white">
                    <div
                        class="inline-flex items-center gap-2 bg-teal-500/20 text-teal-300 px-4 py-2 rounded-full mb-6 text-[10px] font-black uppercase tracking-widest">
                        <i class="fas fa-bullhorn"></i>
                        <span>Pengaduan & Aspirasi</span>
                    </div>
                    <h2 class="text-3xl md:text-5xl font-black mb-6 leading-tight">Transparansi Penanganan Masalah
                    </h2>
                    <p class="text-slate-400 text-lg mb-10 leading-relaxed font-medium">
                        Warga menyampaikan laporan, desa merespon, dan kecamatan memantau proses hingga tuntas.
                    </p>

                    <!-- Workflow Alur -->
                    <div class="space-y-6">
                        <div class="flex gap-5">
                            <div
                                class="w-10 h-10 bg-teal-500 text-slate-900 rounded-xl flex items-center justify-center font-black shrink-0">
                                1</div>
                            <div>
                                <h4 class="font-bold text-teal-300">Warga Menyampaikan Laporan</h4>
                                <p class="text-sm text-slate-400 mt-1">Gunakan formulir online atau hubungi admin
                                    WhatsApp resmi kami.</p>
                            </div>
                        </div>
                        <div class="flex gap-5">
                            <div
                                class="w-10 h-10 bg-slate-800 text-teal-300 rounded-xl flex items-center justify-center font-black shrink-0 border border-slate-700">
                                2</div>
                            <div>
                                <h4 class="font-bold text-slate-200">Diteruskan & Diproses di Desa</h4>
                                <p class="text-sm text-slate-400 mt-1">Laporan masuk ke dashboad desa terkait untuk
                                    verifikasi lapangan.</p>
                            </div>
                        </div>
                        <div class="flex gap-5">
                            <div
                                class="w-10 h-10 bg-slate-800 text-teal-300 rounded-xl flex items-center justify-center font-black shrink-0 border border-slate-700">
                                3</div>
                            <div>
                                <h4 class="font-bold text-slate-200">Kecamatan Memantau & Menindaklanjuti</h4>
                                <p class="text-sm text-slate-400 mt-1">Tim kecamatan memastikan solusi diberikan
                                    secara
                                    tepat waktu.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-[3rem] p-8 lg:p-12">
                    <h4 class="text-lg font-bold text-white mb-8 flex items-center gap-3">
                        <i class="fas fa-check-double text-teal-500"></i>
                        Laporan Selesai Terkini
                    </h4>

                    <div class="space-y-6">
                        @forelse($resolvedComplaints as $res)
                            <div
                                class="bg-white/5 rounded-2xl p-5 border border-white/5 hover:bg-white/10 hover:border-white/20 transition-all group">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-[9px] font-black text-teal-400 uppercase tracking-widest">{{ $res->jenis_layanan }}</span>
                                        <span
                                            class="text-xs font-bold text-white mt-1">{{ Str::limit($res->uraian, 60) }}</span>
                                    </div>
                                    <span
                                        class="bg-teal-500/20 text-teal-400 text-[8px] font-black px-2 py-1 rounded-full border border-teal-500/30 uppercase tracking-widest">Selesai</span>
                                </div>
                                <div
                                    class="flex items-center gap-2 text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-4">
                                    <i class="fas fa-map-marker-alt text-teal-500"></i>
                                    <span>Lokasi: {{ $res->desa->nama_desa ?? 'Pihak Kecamatan' }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 opacity-50">
                                <i class="fas fa-box-open text-4xl mb-4 text-slate-700"></i>
                                <p class="text-slate-500 text-sm italic">Belum ada pengaduan publik yang bisa
                                    ditampilkan di
                                    sini.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-10">
                        <button onclick="openBotWithQuery('Cara membuat pengaduan')"
                            class="btn btn-block bg-teal-600 hover:bg-teal-700 border-0 text-white font-black rounded-2xl py-4 h-auto shadow-xl">
                            Ajukan Laporan Sekarang <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Administrative Bot Portal -->
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
                            <p>Saya siap membantu Anda memberikan informasi resmi terkait persyaratan administrasi.
                            </p>
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
                        class="text-[9px] font-bold text-teal-600 hover:underline">Butuh Tindak Lanjut
                        Petugas?</button>
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

        function openBotWithQuery(text) {
            const modal = document.getElementById('publicServiceModal');
            if (modal) {
                modal.showModal();
                sendQuickChip(text);
            }
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

        // --- PERMOHONAN LAYANAN LOGIC ---
        const permohonanModal = document.getElementById('permohonanModal');
        const submissionForm = document.getElementById('submissionForm');
        const dynamicAttachments = document.getElementById('dynamicAttachments');

        function openSubmissionModal(serviceName, requirements = '') {
            document.getElementById('modalServiceTitle').innerText = 'Ajukan: ' + serviceName;
            document.getElementById('inputJenisLayanan').value = serviceName;

            // Clear and Parse Requirements
            if (dynamicAttachments) {
                dynamicAttachments.innerHTML = '';

                // Try to split requirements by numbers (1., 2., etc.) or bullets or commas
                let reqList = [];
                if (requirements) {
                    // Remove common preamble like "Syarat:" or "Persyaratan:"
                    let cleanReqs = requirements.replace(/^(Persyaratan|Syarat|SOP):\s*/i, '');

                    // Split by numeric list (1., 2., ...) or just common document names
                    let splitters = [/\d+[\.\)]\s*/, /,\s*/, /;\s*/];
                    let currentList = [cleanReqs];

                    splitters.forEach(regex => {
                        let newList = [];
                        currentList.forEach(item => {
                            newList = newList.concat(item.split(regex).filter(s => s.trim().length > 3));
                        });
                        currentList = newList;
                    });
                    reqList = currentList.map(s => s.trim()).slice(0, 5); // Limit to first 5 detected
                }

                if (reqList.length > 0) {
                    reqList.forEach(label => addAttachmentField(label));
                } else {
                    // Fallback default fields
                    addAttachmentField('KTP / Identitas');
                    addAttachmentField('Dokumen Pendukung');
                }
            }

            if (permohonanModal) permohonanModal.showModal();
        }

        function addAttachmentField(label = '') {
            if (!dynamicAttachments) return;
            const div = document.createElement('div');
            div.className = 'form-control bg-white/60 p-2 rounded-xl border border-slate-100 flex flex-col gap-1 transition-all hover:border-teal-200';
            div.innerHTML = `
                <div class="flex justify-between items-center px-1">
                    <input type="text" name="foto_labels[]" value="${label}" 
                        class="bg-transparent border-none text-[10px] font-bold text-slate-600 focus:ring-0 p-0 w-full" 
                        placeholder="Nama Berkas (Contoh: KTP)...">
                    <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-slate-300 hover:text-rose-500 transition-colors">
                        <i class="fas fa-times-circle text-xs"></i>
                    </button>
                </div>
                <input type="file" name="foto[]" 
                    class="file-input file-input-bordered file-input-xs bg-white border-slate-200 rounded-lg w-full" 
                    accept=".jpg,.jpeg,.png,.pdf" required>
            `;
            dynamicAttachments.appendChild(div);
        }

        if (submissionForm) {
            submissionForm.addEventListener('submit', async function (e) {
                e.preventDefault();
                const btn = document.getElementById('btnSubmitPermohonan');
                const originalText = btn.innerHTML;

                // Normalize WA
                let waInput = this.whatsapp.value.replace(/[^0-9]/g, '');
                if (waInput.startsWith('0')) waInput = '62' + waInput.substring(1);
                if (waInput.startsWith('8')) waInput = '62' + waInput;
                this.whatsapp.value = waInput;

                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner animate-spin"></i> Sedang Mengirim...';

                try {
                    const formData = new FormData(this);
                    const response = await fetch("{{ route('public.service.submit') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const res = await response.json();

                    if (response.ok) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pengajuan Terkirim!',
                            text: 'Terima kasih, berkas Anda akan segera diverifikasi oleh petugas kami.',
                            confirmButtonColor: '#0d9488',
                            timer: 5000
                        });
                        this.reset();
                        permohonanModal.close();
                    } else {
                        throw new Error(res.message || 'Terjadi kesalahan saat mengirim.');
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Mengirim',
                        text: error.message,
                        confirmButtonColor: '#0d9488'
                    });
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            });
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

        // --- TRACKING LOGIC ---
        function handleTracking() {
            const input = document.getElementById('trackingInput').value.trim();
            if (!input) {
                showToast('Mohon masukkan nomor WA atau ID Berkas', 'info');
                return;
            }
            // Redirect to tracking page
            window.location.href = '{{ route('public.tracking') }}?q=' + encodeURIComponent(input);
        }

        // --- MOBILE BOTTOM BAR LOGIC ---
        function toggleMobileMenu() {
            // Placeholder for any mobile menu logic if needed
        }
    </script>

    <!-- Mobile Bottom Bar (NEW) -->
    <div
        class="fixed bottom-0 left-0 right-0 bg-white/80 backdrop-blur-lg border-t border-slate-100 z-50 lg:hidden px-6 py-3">
        <div class="flex items-center justify-between">
            <a href="/" class="flex flex-col items-center gap-1 text-teal-600">
                <i class="fas fa-home text-lg"></i>
                <span class="text-[9px] font-bold uppercase tracking-tighter">Home</span>
            </a>
            <a href="#layanan"
                class="flex flex-col items-center gap-1 text-slate-400 hover:text-teal-600 transition-colors">
                <i class="fas fa-layer-group text-lg"></i>
                <span class="text-[9px] font-bold uppercase tracking-tighter">Layanan</span>
            </a>
            <button onclick="document.getElementById('publicServiceModal').showModal()"
                class="flex flex-col items-center gap-1 -mt-8 bg-teal-600 text-white w-14 h-14 rounded-full shadow-lg border-4 border-white">
                <i class="fas fa-search mt-3"></i>
                <span class="text-[7px] font-black uppercase tracking-tighter mt-1">Lacak</span>
            </button>
            <a href="#jelajah"
                class="flex flex-col items-center gap-1 text-slate-400 hover:text-teal-600 transition-colors">
                <i class="fas fa-map-marked-alt text-lg"></i>
                <span class="text-[9px] font-bold uppercase tracking-tighter">Wilayah</span>
            </a>
            <button onclick="activateVoiceGuide()"
                class="flex flex-col items-center gap-1 text-slate-400 hover:text-teal-600 transition-colors">
                <i class="fas fa-headset text-lg"></i>
                <span class="text-[9px] font-bold uppercase tracking-tighter">Bantuan</span>
            </button>
        </div>
    </div>

    <script>
        const desasData = {
            @foreach($desas as $desa)
                @php 
                    $slug = strtolower(str_replace(' ', '', $desa->nama_desa));
                @endphp
                "{{ strtoupper($desa->nama_desa) }}": "https://{{ $slug }}.tatadesa.com",
            @endforeach
        };

        // Harmonic Professional Palette (Earthy & Teal Govt Tones)
        const villageColors = [
            '#0f766e', '#0369a1', '#1d4ed8', '#4338ca', '#6d28d9',
            '#7e22ce', '#a21caf', '#be185d', '#b91c1c', '#c2410c',
            '#b45309', '#a16207', '#4d7c0f', '#15803d', '#166534',
            '#3f6212', '#115e59'
        ];

        // Initialize Map with smooth motion
        const map = L.map('mapContainer', {
            center: [-7.78, 113.47],
            zoom: 13,
            scrollWheelZoom: false,
            attributionControl: false,
            zoomControl: false,
            zoomSnap: 0.5,
            zoomDelta: 0.5
        });

        L.control.zoom({ position: 'topright' }).addTo(map);

        // Cleanest Basemap (Voyager style)
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_nolabels/{z}/{x}/{y}{r}.png', {
            maxZoom: 19
        }).addTo(map);

        // Overlay labels for context at higher zoom
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager_only_labels/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            opacity: 0.6
        }).addTo(map);

        // --- LAYER 1: KECAMATAN OUTER GLOW ---
        fetch('/data/layer_kecamatan.geojson')
            .then(res => res.json())
            .then(data => {
                // Shadow/Glow Layer
                L.geoJSON(data, {
                    style: {
                        color: '#0d9488',
                        weight: 15,
                        opacity: 0.05,
                        fill: false,
                        interactive: false
                    }
                }).addTo(map);

                // Main Boundary
                L.geoJSON(data, {
                    style: {
                        color: '#1e293b',
                        weight: 4,
                        opacity: 0.8,
                        dashArray: '1, 12',
                        lineCap: 'round',
                        fill: false,
                        interactive: false
                    }
                }).addTo(map);
            });

        // --- LAYER 2: 17 DESA (Premium Interactive) ---
        let desaLayer;
        fetch('/data/layer_desa.geojson')
            .then(res => res.json())
            .then(data => {
                desaLayer = L.geoJSON(data, {
                    style: function (feature) {
                        const colorIndex = data.features.indexOf(feature) % villageColors.length;
                        return {
                            fillColor: villageColors[colorIndex],
                            fillOpacity: 0.25,
                            color: 'white',
                            weight: 1.5,
                            className: 'premium-desa-path'
                        };
                    },
                    onEachFeature: function (feature, layer) {
                        // Extract and clean the name
                        const rawName = feature.properties.nm_kelurahan || feature.properties.name || "";
                        const nama = rawName.trim().toUpperCase();

                        // Generate the slug for the tatadesa.com domain
                        const slug = nama.toLowerCase().replace(/\s+/g, '');
                        const url = `https://${slug}.tatadesa.com`;

                        layer.on({
                            mouseover: function (e) {
                                const l = e.target;
                                l.setStyle({
                                    fillOpacity: 0.6,
                                    weight: 3,
                                    color: '#fff',
                                    fillColor: '#0d9488'
                                });

                                layer.bindTooltip(`
                                    <div class="px-2 py-1 text-center">
                                        <p class="text-[8px] font-bold text-teal-400 uppercase tracking-widest mb-0.5">Wilayah Desa</p>
                                        <p class="text-xs font-black text-white">${nama}</p>
                                    </div>
                                `, {
                                    sticky: true,
                                    className: 'premium-tooltip',
                                    direction: 'top',
                                    offset: [0, -10]
                                }).openTooltip();

                                l.bringToFront();
                            },
                            mouseout: function (e) {
                                desaLayer.resetStyle(e.target);
                            },
                            click: function (e) {
                                // Smooth zoom into the village
                                map.flyToBounds(e.target.getBounds(), {
                                    padding: [80, 80],
                                    duration: 1.2
                                });

                                const popupContent = `
                                    <div class="premium-popup-card">
                                        <div class="popup-header">
                                            <div class="icon-box">
                                                <i class="fas fa-landmark"></i>
                                            </div>
                                            <div class="text-box">
                                                <h4>${nama}</h4>
                                                <span>Portal Resmi Desa</span>
                                            </div>
                                        </div>
                                        <div class="popup-body">
                                            <p>Akses layanan mandiri dan informasi publik Desa ${nama} secara digital.</p>
                                            <a href="${url}" target="_blank" rel="noopener noreferrer" class="popup-btn">
                                                Kunjungi Website <i class="fas fa-external-link-alt ml-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                `;

                                layer.bindPopup(popupContent, {
                                    className: 'premium-leaflet-popup',
                                    closeButton: false,
                                    maxWidth: 280
                                }).openPopup();
                            }
                        });
                    }
                }).addTo(map);

                map.fitBounds(desaLayer.getBounds(), { padding: [60, 60] });
            });

        // --- LAYER 3: PULSING POI ---
        fetch('/data/layer_poi.geojson')
            .then(res => res.json())
            .then(data => {
                L.geoJSON(data, {
                    pointToLayer: function (feature, latlng) {
                        const icon = L.divIcon({
                            className: 'poi-pulse-wrapper',
                            html: `
                                <div class="pulse-ring"></div>
                                <div class="pulse-core shadow-2xl">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div class="poi-label">${feature.properties.name}</div>
                            `,
                            iconSize: [40, 40],
                            iconAnchor: [20, 20]
                        });
                        return L.marker(latlng, { icon: icon });
                    },
                    onEachFeature: function (feature, layer) {
                        layer.on('click', () => {
                            window.open(feature.properties.map_url, '_blank');
                        });
                    }
                }).addTo(map);
            });
    </script>

    <style>
        /* Pulse Animation */
        @keyframes pulse-ring {
            0% {
                transform: scale(0.33);
                opacity: 0.8;
            }

            80%,
            100% {
                opacity: 0;
                transform: scale(2.5);
            }
        }

        .poi-pulse-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pulse-ring {
            position: absolute;
            width: 40px;
            height: 40px;
            background: #0d9488;
            border-radius: 50%;
            animation: pulse-ring 2s cubic-bezier(0.25, 0.46, 0.45, 0.94) infinite;
        }

        .pulse-core {
            position: relative;
            width: 32px;
            height: 32px;
            background: #0d9488;
            border: 3px solid white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            z-index: 2;
        }

        .poi-label {
            position: absolute;
            top: 40px;
            background: rgba(15, 23, 42, 0.9);
            color: white;
            font-size: 9px;
            font-weight: 800;
            padding: 4px 8px;
            border-radius: 6px;
            white-space: nowrap;
            pointer-events: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Tooltip & Popup Stylings */
        .premium-tooltip {
            background: #0f172a !important;
            border: none !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4) !important;
            border-radius: 12px !important;
            padding: 0 !important;
        }

        .premium-tooltip:before {
            border-top-color: #0f172a !important;
        }

        .premium-leaflet-popup .leaflet-popup-content-wrapper {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 28px !important;
            padding: 0 !important;
            overflow: hidden;
            border: 1px solid white;
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25) !important;
        }

        .premium-leaflet-popup .leaflet-popup-content {
            margin: 0 !important;
            width: 280px !important;
        }

        .premium-popup-card {
            padding: 0;
            font-family: 'Outfit', sans-serif;
        }

        .popup-header {
            background: linear-gradient(135deg, #0d9488 0%, #0f172a 100%);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            color: white;
        }

        .icon-box {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .text-box h4 {
            font-weight: 900;
            font-size: 16px;
            margin: 0;
            line-height: 1.2;
        }

        .text-box span {
            font-size: 10px;
            font-weight: 600;
            opacity: 0.7;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .popup-body {
            padding: 20px;
        }

        .popup-body p {
            font-size: 12px;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .popup-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            background: #0d9488;
            color: white !important;
            text-decoration: none !important;
            padding: 12px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 800;
            transition: all 0.3s;
        }

        .popup-btn:hover {
            background: #0f172a;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(13, 148, 136, 0.2);
        }

        .premium-desa-path {
            cursor: pointer;
            transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            outline: none !important;
        }

        /* Remove focus outline around map elements */
        .leaflet-container :focus {
            outline: none !important;
        }

        path.leaflet-interactive:focus {
            outline: none !important;
        }
    </style>

    <script src="{{ asset('voice-guide/voice.bundle.js') }}?v=2.7"></script>

</body>

</html>