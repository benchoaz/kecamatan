@extends('layouts.public')

@section('title', 'Direktori Kerja & Jasa Warga – ' . appProfile()->region_level . ' ' . appProfile()->region_name)

@section('meta')
    <meta name="description"
        content="Direktori kerja dan jasa warga di wilayah {{ appProfile()->region_level }} {{ appProfile()->region_name }}. Temukan tukang, ojek, jasa keliling, dan pekerjaan harian lainnya.">
    <meta name="keywords"
        content="kerja {{ appProfile()->region_name }}, jasa warga {{ appProfile()->region_name }}, tukang {{ appProfile()->region_name }}, ojek {{ appProfile()->region_name }}, buruh harian">
@endsection

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-teal-50">

        {{-- Header Section --}}
        <div class="bg-gradient-to-r from-teal-600 to-emerald-600 text-white py-16">
            <div class="container mx-auto px-6">
                <div class="max-w-4xl">
                    <h1 class="text-4xl md:text-5xl font-black mb-4">
                        Direktori Kerja & Jasa Warga
                    </h1>
                    <p class="text-xl text-teal-50 mb-6">
                        Direktori kerja dan jasa warga di wilayah <strong>{{ appProfile()->region_level }}
                            {{ appProfile()->region_name }}</strong>.
                        Temukan tukang, ojek, jasa keliling, dan pekerjaan harian yang Anda butuhkan.
                    </p>

                    {{-- Search Bar --}}
                    <div class="mt-8">
                        <form method="GET" action="{{ route('kerja.index') }}" class="flex flex-col md:flex-row gap-3">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari jasa atau pekerjaan..."
                                class="flex-1 px-6 py-4 rounded-xl text-slate-800 text-lg focus:ring-4 focus:ring-teal-300 shadow-inner"
                                aria-label="Cari jasa atau pekerjaan">
                            <button type="submit"
                                class="px-8 py-4 bg-white text-teal-600 rounded-xl font-bold hover:bg-teal-50 transition-all shadow-lg flex items-center justify-center gap-2">
                                <i class="fas fa-search"></i> Cari Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="container mx-auto px-6 -mt-8">
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('kerja.index') }}"
                        class="px-6 py-3 rounded-xl font-bold transition-all {{ !request('kategori') ? 'bg-teal-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        <i class="fas fa-th mr-2"></i> Semua
                    </a>

                    @foreach($categories as $cat)
                        <a href="{{ route('kerja.index', ['kategori' => $cat]) }}"
                            class="px-6 py-3 rounded-xl font-bold transition-all {{ request('kategori') == $cat ? 'bg-teal-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                            @if($cat == 'Jasa & Pekerjaan Harian')
                                <i class="fas fa-tools mr-2"></i>
                            @elseif($cat == 'Transportasi Rakyat')
                                <i class="fas fa-motorcycle mr-2"></i>
                            @else
                                <i class="fas fa-shopping-cart mr-2"></i>
                            @endif
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Info Daftar --}}
        <div class="container mx-auto px-6 mt-8">
            <div
                class="bg-teal-600 rounded-3xl shadow-xl p-8 text-white flex flex-col lg:flex-row items-center justify-between gap-8 overflow-hidden relative border border-white/20">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-emerald-400/20 rounded-full blur-3xl"></div>

                <div class="relative z-10 flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
                    <div
                        class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-[2rem] flex items-center justify-center text-4xl shadow-2xl border border-white/30 transform rotate-3">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div class="max-w-xl">
                        <h4 class="text-2xl md:text-3xl font-black mb-2 tracking-tight">Ingin Jasa Anda Terdaftar?</h4>
                        <p class="text-teal-50 text-base md:text-lg leading-relaxed opacity-90">
                            Khusus warga wilayah {{ appProfile()->region_level }} {{ appProfile()->region_name }}.
                            Pendaftaran gratis dan validasi data dilakukan langsung oleh petugas kecamatan agar informasi
                            tetap terpercaya.
                        </p>
                    </div>
                </div>

                <div class="relative z-10 w-full lg:w-auto">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', appProfile()->phone ?? '') }}?text=Halo%20Admin%20{{ appProfile()->region_level }}%20{{ appProfile()->region_name }},%20saya%20ingin%20mendaftarkan%20jasa/pekerjaan%20saya%20di%20Direktori%20Kerja."
                        target="_blank"
                        class="flex items-center justify-center gap-3 px-10 py-5 bg-white text-teal-600 rounded-2xl font-black hover:bg-teal-50 transition-all shadow-2xl hover:scale-105 active:scale-95 text-lg w-full md:w-auto">
                        <i class="fab fa-whatsapp text-2xl"></i>
                        Daftar Lewat WhatsApp
                    </a>
                </div>
            </div>
        </div>

        {{-- Work Items Grid --}}
        <div class="container mx-auto px-6 py-12">
            @if($workItems->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($workItems as $item)
                        <div
                            class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-slate-100">
                            <div class="p-6">
                                {{-- Icon & Category --}}
                                <div class="flex items-start justify-between mb-4">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-teal-500 to-emerald-500 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg">
                                        <i class="fas {{ $item->icon }}"></i>
                                    </div>
                                    <span class="px-3 py-1 bg-teal-50 text-teal-700 text-xs font-bold rounded-full">
                                        {{ $item->job_category }}
                                    </span>
                                </div>

                                {{-- Job Title --}}
                                <h3 class="text-xl font-black text-slate-800 mb-2">
                                    {{ $item->job_title }}
                                </h3>

                                {{-- Display Name --}}
                                <p class="text-lg text-slate-600 mb-4">
                                    <i class="fas fa-user text-teal-600 mr-2"></i>
                                    {{ $item->display_name }}
                                </p>

                                {{-- Service Area --}}
                                @if($item->service_area)
                                    <p class="text-sm text-slate-500 mb-2">
                                        <i class="fas fa-map-marker-alt text-teal-600 mr-2"></i>
                                        {{ $item->service_area }}
                                    </p>
                                @endif

                                {{-- Service Time --}}
                                @if($item->service_time)
                                    <p class="text-sm text-slate-500 mb-4">
                                        <i class="fas fa-clock text-teal-600 mr-2"></i>
                                        {{ $item->service_time }}
                                    </p>
                                @endif

                                {{-- Actions --}}
                                <div class="flex gap-3 mt-6">
                                    <a href="{{ $item->whatsapp_link }}" target="_blank"
                                        class="flex-1 px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold text-center transition-all shadow-lg">
                                        <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                                    </a>
                                    <a href="{{ route('kerja.show', $item->id) }}"
                                        class="px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition-all">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12">
                    {{ $workItems->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-20">
                    <div class="w-32 h-32 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-slate-400 text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-700 mb-2">Tidak Ada Data</h3>
                    <p class="text-slate-500">Belum ada data pekerjaan atau jasa untuk kategori ini.</p>
                </div>
            @endif
        </div>

        {{-- Disclaimer --}}
        <div class="container mx-auto px-6 pb-12">
            <div class="bg-amber-50 border-l-4 border-amber-500 rounded-xl p-6">
                <div class="flex items-start gap-4">
                    <i class="fas fa-info-circle text-amber-600 text-2xl mt-1"></i>
                    <div>
                        <h4 class="font-bold text-amber-900 mb-2">Disclaimer</h4>
                        <p class="text-amber-800 leading-relaxed">
                            Informasi pekerjaan dan jasa warga ditampilkan berdasarkan pendataan yang dimiliki oleh
                            <strong>Pemerintah {{ appProfile()->region_level }} {{ appProfile()->region_name }}</strong>.
                            Pemerintah kecamatan hanya memfasilitasi informasi
                            dan tidak terlibat dalam hubungan kerja atau transaksi.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection