@extends('layouts.kecamatan')

@section('title', 'Dashboard Monitoring')

@section('content')
    <div class="dashboard container-fluid px-4 py-4">
        <!-- Modern Formal Welcome Section -->
        <!-- Dark Professional Welcome Section -->
        <div class="welcome-banner p-4 p-md-5 rounded-4 mb-5 position-relative overflow-hidden shadow-lg"
            style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
            <div class="position-relative z-2">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span
                        class="badge bg-primary-500 bg-opacity-25 text-primary-100 border border-primary-400 border-opacity-25 px-3 py-1 rounded-pill small fw-normal">
                        Otoritas Sistem
                    </span>
                    <span class="text-slate-400 small fw-medium">{{ now()->format('l, d F Y') }}</span>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="display-5 fw-bold text-white mb-2">
                            Selamat Datang, <span class="text-info">{{ auth()->user()->nama_lengkap }}</span>
                        </h1>
                        <p class="text-slate-300 fs-5 mb-0 opacity-80">
                            Pusat Komando Operasional & Monitoring Administrasi Kecamatan Besuk.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Icon Background -->
            <div class="position-absolute end-0 bottom-0 opacity-10 mb-n4 me-n2 z-1">
                <i class="fas fa-landmark fa-10x text-white"></i>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="row g-4 mb-5">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-premium rounded-4 h-100 overflow-hidden">
                    <div class="card-body p-4 d-flex align-items-center gap-3">
                        <div class="flex-shrink-0 bg-brand-50 text-brand-600 rounded-4 d-flex align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-users-viewfinder fa-2x"></i>
                        </div>
                        <div>
                            <span class="d-block text-tertiary small fw-bold text-uppercase tracking-wider">Total
                                Penduduk</span>
                            <h3 class="mb-0 fw-bold text-primary-900 stat-value"
                                data-count="{{ $stats['total_penduduk'] }}">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-premium rounded-4 h-100 overflow-hidden">
                    <div class="card-body p-4 d-flex align-items-center gap-3">
                        <div class="flex-shrink-0 bg-success-50 text-success-600 rounded-4 d-flex align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-file-circle-check fa-2x"></i>
                        </div>
                        <div>
                            <span class="d-block text-tertiary small fw-bold text-uppercase tracking-wider">Laporan
                                Masuk</span>
                            <h3 class="mb-0 fw-bold text-primary-900 stat-value" data-count="{{ $stats['laporan_masuk'] }}">
                                0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-premium rounded-4 h-100 overflow-hidden">
                    <div class="card-body p-4 d-flex align-items-center gap-3">
                        <div class="flex-shrink-0 bg-info-50 text-info-500 rounded-4 d-flex align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-map-location fa-2x"></i>
                        </div>
                        <div>
                            <span class="d-block text-tertiary small fw-bold text-uppercase tracking-wider">Jumlah
                                Desa</span>
                            <h3 class="mb-0 fw-bold text-primary-900 stat-value" data-count="{{ $stats['jumlah_desa'] }}">0
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-premium rounded-4 h-100 overflow-hidden">
                    <div class="card-body p-4 d-flex align-items-center gap-3">
                        <div class="flex-shrink-0 bg-warning-50 text-warning-500 rounded-4 d-flex align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-user-clock fa-2x"></i>
                        </div>
                        <div>
                            <span
                                class="d-block text-tertiary small fw-bold text-uppercase tracking-wider">Pengunjung</span>
                            <h3 class="mb-0 fw-bold text-primary-900 stat-value"
                                data-count="{{ $stats['pengunjung_hari_ini'] }}">0</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Domain Grid -->
            <div class="col-xl-8">
                <div class="mb-4 d-flex align-items-center justify-content-between">
                    <h4 class="fw-bold text-primary-900 mb-0">Bidang Pengawasan Wilayah</h4>
                    <span class="text-tertiary small">Pilih modul untuk monitor wilayah</span>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="{{ route('kecamatan.pemerintahan.index') }}" class="text-decoration-none">
                            <div class="card border-0 shadow-sm rounded-4 domain-premium p-3 h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary-900 text-white rounded-3 d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-shield-halved fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold text-primary-900">Tata Kelola Pemerintahan</h6>
                                        <p class="mb-0 text-tertiary small">Monitoring SK, BPD, & Desa</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('kecamatan.ekbang.index') }}" class="text-decoration-none">
                            <div class="card border-0 shadow-sm rounded-4 domain-premium p-3 h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-brand-600 text-white rounded-3 d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-chart-pie fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold text-primary-900">Ekonomi & Pembangunan</h6>
                                        <p class="mb-0 text-tertiary small">Monitoring APBDes & Fisik</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('kecamatan.kesra.index') }}" class="text-decoration-none">
                            <div class="card border-0 shadow-sm rounded-4 domain-premium p-3 h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-success-600 text-white rounded-3 d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-hand-holding-heart fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold text-primary-900">Kesejahteraan Rakyat</h6>
                                        <p class="mb-0 text-tertiary small">Bantuan Sosial & Layanan</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('kecamatan.trantibum.index') }}" class="text-decoration-none">
                            <div class="card border-0 shadow-sm rounded-4 domain-premium p-3 h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-danger text-white rounded-3 d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-mask-ventilator fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold text-primary-900">Trantibum & Linmas</h6>
                                        <p class="mb-0 text-tertiary small">Ketentraman & Ketertiban</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Activity Log -->
            <div class="col-xl-4">
                <div class="card border-0 shadow-premium rounded-4 overflow-hidden h-100">
                    <div class="card-header bg-white border-0 py-3 px-4">
                        <h5 class="fw-bold text-primary-900 mb-0">Audit Aktivitas Wilayah</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach($activities as $activity)
                                <div
                                    class="list-group-item border-start-0 border-end-0 border-top-0 border-bottom border-primary-50 px-4 py-3 bg-transparent">
                                    <div class="d-flex gap-3">
                                        <div class="flex-shrink-0 bg-{{ $activity['type'] }} text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                            style="width: 32px; height: 32px; font-size: 12px;">
                                            <i class="fas {{ $activity['icon'] }}"></i>
                                        </div>
                                        <div>
                                            <div class="small text-primary-900 fw-medium">{{ $activity['message'] }}</div>
                                            <div class="text-tertiary" style="font-size: 11px;">{{ $activity['time'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 text-center py-3">
                        <a href="{{ route('kecamatan.laporan.index') }}"
                            class="small text-brand-600 fw-bold text-decoration-none">LIHAT SEMUA LOG <i
                                class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>     document.addEventListener('DOMContentLoaded', function () {         const counters = document.querySelectorAll('.stat-value');         counters.forEach(counter => {             const target = parseInt(counter.getAttribute('data-count'));             const duration = 1500;             const step = target / (duration / 16);             let current = 0;             const timer = setInterval(() => {                 current += step;                 if (current >= target) {                     counter.textContent = target.toLocaleString('id-ID');                     clearInterval(timer);                 } else {                     counter.textContent = Math.floor(current).toLocaleString('id-ID');                 }             }, 16);         });     });
    </script>
@endpush