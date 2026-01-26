@extends('layouts.desa')

@section('title', 'Seksi Ekonomi & Pembangunan')

@section('content')
    <div class="content-header mb-4">
        <div class="header-title">
            <h1>Ekonomi & Pembangunan</h1>
            <p class="text-muted">{{ $isOperator ? 'Modul Pelaporan & Input Data Desa' : 'Monitoring Pembangunan & Realisasi Wilayah' }}</p>
        </div>
    </div>

    @if($healthMetrics)
        <div class="row g-4 mb-5">
            <!-- Health Check Pillar: Realisasi APBDes -->
            <div class="col-md-4">
                <div class="card status-card h-100 {{ $healthMetrics['realisasi'] ? 'status-success' : 'status-danger' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="status-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            @if($healthMetrics['realisasi'])
                                <span class="badge badge-pill badge-success">Terlapor</span>
                            @else
                                <span class="badge badge-pill badge-danger">Belum Lapor</span>
                            @endif
                        </div>
                        <h6 class="card-title mb-1">Realisasi APBDes</h6>
                        <p class="text-muted small">Capaian realisasi pendapatan & belanja tahun {{ date('Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Health Check Pillar: Monev DD -->
            <div class="col-md-4">
                <div class="card status-card h-100 {{ $healthMetrics['monev'] ? 'status-success' : 'status-warning' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="status-icon">
                                <i class="fas fa-hand-holding-dollar"></i>
                            </div>
                            @if($healthMetrics['monev'])
                                <span class="badge badge-pill badge-success">Aktif</span>
                            @else
                                <span class="badge badge-pill badge-warning">Monitoring Kosong</span>
                            @endif
                        </div>
                        <h6 class="card-title mb-1">Monev Dana Desa</h6>
                        <p class="text-muted small">Monitoring penyaluran & penggunaan DD</p>
                    </div>
                </div>
            </div>

            <!-- Health Check Pillar: Status Umum -->
            <div class="col-md-4">
                <div
                    class="card status-card h-100 {{ $healthMetrics['status'] === 'Sehat' ? 'status-success' : 'status-warning' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="status-icon">
                                <i class="fas fa-shield-heart"></i>
                            </div>
                            <span
                                class="badge badge-pill {{ $healthMetrics['status'] === 'Sehat' ? 'badge-success' : 'badge-warning' }}">
                                {{ $healthMetrics['status'] }}
                            </span>
                        </div>
                        <h6 class="card-title mb-1">Integritas Pembangunan</h6>
                        <p class="text-muted small">Status kepatuhan administrasi pembangunan</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="section-title mb-4">
        <h5>{{ $isOperator ? 'Tugas & Pelaporan Desa' : 'Manajemen & Monitoring Wilayah' }}</h5>
        <div class="title-accent"></div>
    </div>

    <div class="row g-4">
        <!-- A: Dana Desa -->
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('desa.ekbang.dana-desa.index') }}" class="menu-card-link">
                <div class="card menu-card h-100">
                    <div class="card-body">
                        <div class="menu-header">
                            <div class="menu-key">A</div>
                            <div class="menu-icon-circle"><i class="fas fa-hand-holding-dollar"></i></div>
                        </div>
                        <h5 class="menu-title mt-3">{{ $isOperator ? 'Lapor Dana Desa' : 'Monitoring Dana Desa' }}</h5>
                        <p class="menu-desc">{{ $isOperator ? 'Input data pencairan & penyaluran BLT' : 'Pantau penyaluran Dana Desa wilayah' }}</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- B: Fisik -->
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('desa.ekbang.fisik.index') }}" class="menu-card-link">
                <div class="card menu-card h-100">
                    <div class="card-body">
                        <div class="menu-header">
                            <div class="menu-key">B</div>
                            <div class="menu-icon-circle"><i class="fas fa-person-digging"></i></div>
                        </div>
                        <h5 class="menu-title mt-3">{{ $isOperator ? 'Input Progres Fisik' : 'Monitoring Fisik' }}</h5>
                        <p class="menu-desc">{{ $isOperator ? 'Update persentase & foto proyek fisik' : 'Pantau capaian infrastruktur desa' }}</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- C: Realisasi -->
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('desa.ekbang.realisasi.index') }}" class="menu-card-link">
                <div class="card menu-card h-100">
                    <div class="card-body">
                        <div class="menu-header">
                            <div class="menu-key">C</div>
                            <div class="menu-icon-circle"><i class="fas fa-chart-line"></i></div>
                        </div>
                        <h5 class="menu-title mt-3">{{ $isOperator ? 'Laporan Realisasi' : 'Evaluasi Realisasi' }}</h5>
                        <p class="menu-desc">{{ $isOperator ? 'Submit capaian belanja APBDes' : 'Analisa penyerapan anggaran desa' }}</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- D: Kepatuhan -->
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('desa.ekbang.kepatuhan.index') }}" class="menu-card-link">
                <div class="card menu-card h-100">
                    <div class="card-body">
                        <div class="menu-header">
                            <div class="menu-key">D</div>
                            <div class="menu-icon-circle"><i class="fas fa-file-shield"></i></div>
                        </div>
                        <h5 class="menu-title mt-3">{{ $isOperator ? 'Kelengkapan Dokumen' : 'Verifikasi Kepatuhan' }}</h5>
                        <p class="menu-desc">{{ $isOperator ? 'Upload Perdes & dokumen pelaporan' : 'Audit kelengkapan regulasi desa' }}</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- E: Audit -->
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('desa.ekbang.audit.index') }}" class="menu-card-link">
                <div class="card menu-card h-100">
                    <div class="card-body">
                        <div class="menu-header">
                            <div class="menu-key">E</div>
                            <div class="menu-icon-circle"><i class="fas fa-magnifying-glass-chart"></i></div>
                        </div>
                        <h5 class="menu-title mt-3">{{ $isOperator ? 'Tindak Lanjut Temuan' : 'Pengawasan & Audit' }}</h5>
                        <p class="menu-desc">{{ $isOperator ? 'Jawab temuan & unggah bukti perbaikan' : 'Kelola temuan audit lintas desa' }}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="section-title mt-5 mb-4">
        <h5>{{ $isOperator ? 'Aktivitas Pelaporan Terakhir' : 'Laporan Masuk Wilayah' }}</h5>
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
                            <th>Status</th>
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
                                    <a href="{{ route('desa.submissions.edit', $recent->id) }}" class="btn btn-sm btn-icon">
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
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menu-pages.css') }}">
@endpush