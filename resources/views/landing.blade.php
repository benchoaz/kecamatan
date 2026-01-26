<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kecamatan SAE - Pelayanan Profesional & Transparan</title>

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
    </style>
</head>

<body class="bg-slate-50">

    <!-- Navbar -->
    <div class="navbar bg-white shadow-md px-6 py-3 sticky top-0 z-50 border-b border-gray-200">
        <div class="navbar-start">
            <a href="/" class="flex items-center gap-3">
                <div
                    class="w-11 h-11 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg flex items-center justify-center shadow-sm">
                    <i class="fas fa-landmark text-white text-lg"></i>
                </div>
                <div>
                    <div class="text-xs font-semibold text-gray-700 uppercase tracking-wide">PROBOLINGGO</div>
                    <div class="text-[10px] text-gray-500">Home</div>
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
                <li><a href="#operasional"
                        class="text-sm font-medium text-gray-600 hover:text-teal-600 hover:bg-teal-50 rounded-lg">Berita</a>
                </li>
            </ul>
        </div>
        <div class="navbar-end">
            <a href="{{ route('login') }}"
                class="btn btn-sm bg-teal-600 hover:bg-teal-700 text-white border-0 rounded-lg px-5 font-medium shadow-sm">Masuk</a>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="hero min-h-[65vh] bg-gradient-to-br from-slate-50 via-white to-teal-50/30">
        <div class="hero-content text-center py-16">
            <div class="max-w-4xl">
                <div
                    class="inline-flex items-center gap-2 bg-teal-50 text-teal-700 border border-teal-200 px-4 py-2 rounded-full mb-6 text-sm font-medium">
                    <i class="fas fa-certificate text-xs"></i>
                    <span>Sistem Administrasi Pemerintah Resmi</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-5 leading-tight">
                    Transformasi <span class="text-teal-600">Pelayanan</span><br class="hidden md:block"> Masyarakat
                    Digital
                </h1>
                <p class="text-base md:text-lg text-gray-600 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Mewujudkan tata kelola kecamatan yang profesional, transparan, dan terintegrasi untuk masyarakat
                    yang lebih berdaya.
                </p>
                <a href="{{ route('login') }}"
                    class="btn bg-teal-600 hover:bg-teal-700 text-white border-0 btn-lg rounded-lg px-10 font-medium shadow-md hover:shadow-lg transition-all">
                    Masuk Sistem <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

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
                        <img src="https://images.unsplash.com/photo-1558449028-b53a39d100fc?auto=format&fit=crop&q=80&w=800"
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
                        <img src="https://images.unsplash.com/photo-1590059235ef9-22a84976c66d?auto=format&fit=crop&q=80&w=800"
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
                        <img src="https://images.unsplash.com/photo-1544911835-343542289c03?auto=format&fit=crop&q=80&w=800"
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

    <!-- Informasi Operasional Section -->
    <div id="operasional" class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="card bg-gradient-to-br from-teal-50/50 to-blue-50/50 shadow-md border border-gray-200 rounded-2xl">
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
                                    <div class="w-11 h-11 bg-teal-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-clock text-teal-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800 text-sm">Senin - Kamis</div>
                                        <div class="text-xs text-gray-500">08:00 WIB - 15:30 WIB</div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 bg-teal-100 rounded-full flex items-center justify-center flex-shrink-0">
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
                            <div class="inline-flex items-center gap-2 bg-emerald-50 text-emerald-700 border border-emerald-200 px-5 py-2 rounded-full text-xs font-semibold">
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
                        Kecamatan <span class="text-teal-400">SAE</span>
                    </h4>
                    <p class="text-xs text-gray-400">Pemerintah Kabupaten Pemerintah • Solusi Administrasi Terpadu</p>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-xs text-gray-400">Copyright © {{ date('Y') }} All Rights Reserved.</p>
                    <p class="text-[10px] text-gray-500 mt-1">Platform ini adalah portal internal resmi ASN/Petugas Kecamatan.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Accessibility Button -->
    <div class="fixed bottom-5 left-5 z-40">
        <button class="btn btn-circle bg-blue-600 hover:bg-blue-700 border-0 shadow-lg w-14 h-14">
            <i class="fas fa-wheelchair text-white text-xl"></i>
        </button>
    </div>

</body>

</html>