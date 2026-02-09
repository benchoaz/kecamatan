<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ appProfile()->logo_path ? asset('storage/' . appProfile()->logo_path) : '' }}"
        type="image/png">

    <title>@yield('title', appProfile()->region_level . ' ' . appProfile()->region_name)</title>

    @yield('meta')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900">

    {{-- Header / Navbar --}}
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200">
        <div class="container mx-auto px-6 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3 group">
                <img src="{{ appProfile()->logo_path ? asset('storage/' . appProfile()->logo_path) : '' }}" alt="Logo"
                    class="h-10 w-auto group-hover:scale-110 transition-transform">
                <div>
                    <div class="font-black text-slate-800 leading-none">
                        {{ strtoupper(appProfile()->region_level . ' ' . appProfile()->region_name) }}
                    </div>
                    <div class="text-[10px] text-slate-500 uppercase tracking-widest mt-1">
                        {{ appProfile()->region_parent ?? 'Kabupaten Probolinggo' }}
                    </div>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="/" class="text-sm font-bold text-slate-600 hover:text-teal-600 transition-colors">Beranda</a>
                <a href="{{ route('kerja.index') }}" class="text-sm font-bold text-teal-600">Pekerjaan & Jasa</a>
                <a href="/#umkm" class="text-sm font-bold text-slate-600 hover:text-teal-600 transition-colors">UMKM</a>
                <a href="/login"
                    class="px-5 py-2 bg-slate-800 text-white rounded-xl text-sm font-bold hover:bg-slate-700 transition-all shadow-lg">Login
                    Admin</a>
            </div>
        </div>
    </nav>

    {{-- Content Area --}}
    <main>
        @yield('content')
    </main>

    {{-- Premium SEO Optimized Footer --}}
    <footer class="bg-slate-900 text-slate-400 pt-16 pb-8 border-t border-slate-800">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <!-- Col 1: Brand -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <img src="{{ appProfile()->logo_path ? asset('storage/' . appProfile()->logo_path) : '' }}"
                            alt="Logo" class="h-10 w-auto brightness-110">
                        <div>
                            <h4 class="text-white font-black text-lg leading-none uppercase tracking-tighter">
                                {{ appProfile()->region_name }}
                            </h4>
                            <p class="text-[10px] text-teal-500 font-bold uppercase tracking-widest mt-1">
                                {{ appProfile()->tagline }}
                            </p>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed">
                        Portal layanan informasi and administrasi terpadu untuk masyarakat.
                        Mewujudkan tata kelola wilayah yang efisien and transparan.
                    </p>
                </div>

                <!-- Col 2: Navigation -->
                <div>
                    <h5 class="text-white font-bold mb-6">Tautan Cepat</h5>
                    <ul class="space-y-3 text-sm">
                        <li><a href="/" class="hover:text-teal-400 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('kerja.index') }}" class="hover:text-teal-400 transition-colors">Lowongan
                                Kerja</a></li>
                        <li><a href="/#umkm" class="hover:text-teal-400 transition-colors">Produk UMKM</a></li>
                        <li><a href="/#layanan" class="hover:text-teal-400 transition-colors">Layanan Publik</a></li>
                    </ul>
                </div>

                <!-- Col 3: Contact Info -->
                <div>
                    <h5 class="text-white font-bold mb-6">Hubungi Kami</h5>
                    <ul class="space-y-4 text-sm">
                        <li class="flex gap-3">
                            <i class="fas fa-map-marker-alt mt-1 text-teal-500"></i>
                            <span>{{ appProfile()->address ?? 'Jl. Raya Utama, Kec. Besuk, Kab. Probolinggo' }}</span>
                        </li>
                        <li class="flex gap-3">
                            <i class="fas fa-phone-alt mt-1 text-teal-500"></i>
                            <span>{{ appProfile()->phone ?? '(0335) 123456' }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Office Hours -->
                <div>
                    <h5 class="text-white font-bold mb-6">Jam Operasional</h5>
                    <ul class="space-y-2 text-sm">
                        <li class="flex justify-between">
                            <span>Senin - Kamis:</span>
                            <span
                                class="text-white font-medium">{{ appProfile()->office_hours_mon_thu ?? '08:00 - 15:30' }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Jumat:</span>
                            <span
                                class="text-white font-medium">{{ appProfile()->office_hours_fri ?? '08:00 - 11:30' }}</span>
                        </li>
                        <li class="flex justify-between text-rose-500 font-bold">
                            <span>Sabtu - Minggu:</span>
                            <span>TUTUP</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-slate-500">
                    &copy; {{ date('Y') }} Pemerintah {{ appProfile()->region_parent ?? 'Kabupaten' }}. Seluruh Hak
                    Cipta Dilindungi.
                </p>
                <div class="flex gap-4">
                    @if(appProfile()->facebook_url)
                        <a href="{{ appProfile()->facebook_url }}"
                            class="text-slate-500 hover:text-white transition-colors"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if(appProfile()->instagram_url)
                        <a href="{{ appProfile()->instagram_url }}"
                            class="text-slate-500 hover:text-white transition-colors"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if(appProfile()->youtube_url)
                        <a href="{{ appProfile()->youtube_url }}"
                            class="text-slate-500 hover:text-white transition-colors"><i class="fab fa-youtube"></i></a>
                    @endif
                    @if(appProfile()->x_url)
                        <a href="{{ appProfile()->x_url }}" class="text-slate-500 hover:text-white transition-colors"><i
                                class="fab fa-x-twitter"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </footer>

</body>

</html>