@extends('layouts.kecamatan')

@section('title', 'Menu Pemerintahan')

@section('content')
    <div class="content-header mb-4">
        <div class="header-title">
            <h1 style="color: #1f2937; font-weight: 700; font-size: 28px;">Seksi Pemerintahan</h1>
            <p class="text-muted" style="font-size: 14px;">Buku Induk & Tata Kelola Administrasi Desa</p>
        </div>
        <div class="alert bg-soft-info border-0 rounded-4 d-flex align-items-center gap-3 p-3 mb-0">
            <i class="fas fa-shield-halved text-info fs-4"></i>
            <div>
                <strong class="text-info d-block">Catatan Sistem: LANGKAH 3 TERKUNCI</strong>
                <small class="text-dark opacity-75">Seluruh modul pada halaman ini bersifat <strong>Administratif,
                        Referensi, dan Pembinaan</strong>. Modul ini bukan merupakan alat penilaian kinerja atau monev
                    analitik.</small>
            </div>
        </div>
    </div>

    @if($healthMetrics)
        <div class="row g-4 mb-5">
            <!-- Health Check Pillar: Perangkat -->
            <div class="col-md-3">
                <div class="card status-card h-100 {{ $healthMetrics['perangkat'] ? 'status-success' : 'status-danger' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="status-icon">
                                <i class="fas fa-users-gear"></i>
                            </div>
                            @if($healthMetrics['perangkat'])
                                <span class="badge badge-pill badge-success">Lengkap</span>
                            @else
                                <span class="badge badge-pill badge-danger">Belum Lengkap</span>
                            @endif
                        </div>
                        <h6 class="card-title mb-1">Administrasi Perangkat</h6>
                        <div class="small-stats">
                            <div class="stat-item {{ $healthMetrics['summary']['has_kades'] ? 'text-success' : 'text-muted' }}">
                                <i class="fas {{ $healthMetrics['summary']['has_kades'] ? 'fa-check' : 'fa-times' }} me-1"></i>
                                Kepala Desa
                            </div>
                            <div
                                class="stat-item {{ $healthMetrics['summary']['has_sekdes'] ? 'text-success' : 'text-muted' }}">
                                <i class="fas {{ $healthMetrics['summary']['has_sekdes'] ? 'fa-check' : 'fa-times' }} me-1"></i>
                                Sekdes
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Health Check Pillar: BPD -->
            <div class="col-md-3">
                <div class="card status-card h-100 {{ $healthMetrics['bpd'] ? 'status-success' : 'status-warning' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="status-icon">
                                <i class="fas fa-users-rectangle"></i>
                            </div>
                            @if($healthMetrics['bpd'])
                                <span class="badge badge-pill badge-success">Aktif</span>
                            @else
                                <span class="badge badge-pill badge-warning">Kosong</span>
                            @endif
                        </div>
                        <h6 class="card-title mb-1">Status Keanggotaan BPD</h6>
                        <p class="text-muted small">Representasi masyarakat di desa</p>
                    </div>
                </div>
            </div>

            <!-- Health Check Pillar: Perencanaan -->
            <div class="col-md-3">
                <div class="card status-card h-100 {{ $healthMetrics['perencanaan'] ? 'status-success' : 'status-danger' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="status-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            @if($healthMetrics['perencanaan'])
                                <span class="badge badge-pill badge-success">Update 2024</span>
                            @else
                                <span class="badge badge-pill badge-danger">Lewat Jatuh Tempo</span>
                            @endif
                        </div>
                        <h6 class="card-title mb-1">Musrenbang Tahun Ini</h6>
                        <p class="text-muted small">Status administrasi perencanaan</p>
                    </div>
                </div>
            </div>

            <!-- Health Check Pillar: Aset -->
            <div class="col-md-3">
                <div class="card status-card h-100 {{ $healthMetrics['aset'] ? 'status-success' : 'status-warning' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="status-icon">
                                <i class="fas fa-boxes-stacked"></i>
                            </div>
                            <span class="small-text">{{ $healthMetrics['summary']['last_asset'] }}</span>
                        </div>
                        <h6 class="card-title mb-1">Inventarisasi Aset</h6>
                        <p class="text-muted small">Update terakhir dalam 12 bulan</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="section-title mb-4">
        <h5 style="color: #1f2937; font-weight: 600; font-size: 18px;">Buku Induk & Registri</h5>
        <div class="title-accent"></div>
    </div>

    <div class="row g-4">
        @foreach($pemerintahanMenus as $key => $menu)
            <div class="col-md-4 col-lg-3">
                <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#' }}" class="menu-card-link">
                    <div class="card menu-card h-100">
                        <div class="card-body">
                            <div class="menu-header">
                                <div class="menu-key">{{ $key }}</div>
                                <div class="menu-icon-circle">
                                    <i class="fas {{ $menu['icon'] }}"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-light text-muted border py-1 mb-2"
                                    style="font-size: 10px; font-weight: 500;">
                                    <i class="fas fa-building me-1"></i> Dikelola oleh Kecamatan
                                </span>
                                <h5 class="menu-title">{{ $menu['title'] }}</h5>
                            </div>
                            <p class="menu-desc">{{ $menu['desc'] }}</p>
                        </div>
                        <div class="menu-footer">
                            <span class="btn-text">Kelola Data Administratif</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach

        <!-- Export Audit Package -->
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('kecamatan.pemerintahan.export') }}" class="menu-card-link">
                <div class="card menu-card audit-card h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <div class="audit-icon mb-3">
                            <i class="fas fa-box-archive fa-3x"></i>
                        </div>
                        <h5 class="menu-title">Paket Audit Desa</h5>
                        <p class="menu-desc">Export semua SK & Dokumen Desa (PDF ZIP)</p>
                    </div>
                    <div class="menu-footer bg-gold">
                        <span class="text-dark fw-bold">Unduh Paket Audit</span>
                        <i class="fas fa-download text-dark"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="section-title mt-5 mb-4">
        <h5 style="color: #1f2937; font-weight: 600; font-size: 18px;">Status Laporan Terakhir</h5>
        <div class="title-accent"></div>
    </div>

    <div class="card bg-dark border-secondary">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead class="small text-muted">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Bidang / Aspek</th>
                            <th>Status Referensi</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSubmissions as $recent)
                            <tr>
                                <td class="ps-4">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-bold">{{ $recent->menu->nama_menu }}</div>
                                    <div class="small text-muted">{{ $recent->aspek->nama_aspek }}</div>
                                </td>
                                <td>
                                    @php
                                        $sClass = [
                                            'draft' => 'bg-secondary',
                                            'submitted' => 'bg-info',
                                            'returned' => 'bg-warning text-dark',
                                            'reviewed' => 'bg-primary',
                                            'approved' => 'bg-success',
                                        ][$recent->status] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $sClass }}">{{ strtoupper($recent->status) }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('kecamatan.verifikasi.show', $recent->uuid) }}"
                                        class="btn btn-sm btn-icon">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted small">Belum ada aktivitas laporan baru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4 p-3 bg-light rounded-3 border">
        <div class="d-flex gap-2 align-items-center text-muted small">
            <i class="fas fa-info-circle"></i>
            <span><strong>Informasi Tata Kelola:</strong> Seluruh modul di atas diverifikasi secara berkala oleh Seksi
                Pemerintahan Kecamatan sebagai data referensi pembinaan kewilayahan.</span>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menu-pages.css') }}">
    <style>
        /* Page-specific overrides if needed */
        .audit-card {
            border: 1px dashed #f59e0b;
        }

        .audit-icon {
            color: #f59e0b;
        }

        .bg-gold {
            background: #f59e0b !important;
        }
    </style>
@endpush