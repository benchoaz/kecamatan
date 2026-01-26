@extends('layouts.kecamatan')

@section('title', 'Monev Keuangan & Pembangunan (Ekbang)')

@section('content')
    <div class="content-header mb-4">
        <div class="header-title">
            <h1>Command Center Ekbang</h1>
            <p class="text-muted">Monitoring Realisasi APBDes: DD, ADD, PAD, & Bagi Hasil Pajak (BHP)</p>
        </div>
    </div>

    <!-- Pagu Realisasi Agregat (Perspektif Inspektorat) -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="badge bg-primary px-3 py-2 rounded-pill">DANA DESA</div>
                        <i class="fas fa-landmark opacity-50 fa-lg"></i>
                    </div>
                    <h3 class="mb-1 fw-bold">Rp 24,5 M</h3>
                    <p class="extra-small mb-0 opacity-75">Total Pagu Agregat 2025</p>
                    <div class="progress mt-3 bg-dark" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: 45%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden"
                style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="badge bg-success px-3 py-2 rounded-pill">ADD / PAD</div>
                        <i class="fas fa-hand-holding-dollar opacity-50 fa-lg"></i>
                    </div>
                    <h3 class="mb-1 fw-bold">Rp 8,2 M</h3>
                    <p class="extra-small mb-0 opacity-75">Realisasi ADD & Pendapatan Asli</p>
                    <div class="progress mt-3 bg-dark" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 60%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden"
                style="background: linear-gradient(135deg, #064e3b 0%, #065f46 100%);">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="badge bg-warning text-dark px-3 py-2 rounded-pill">Bagi Hasil</div>
                        <i class="fas fa-coins opacity-50 fa-lg"></i>
                    </div>
                    <h3 class="mb-1 fw-bold">Rp 3,1 M</h3>
                    <p class="extra-small mb-0 opacity-75">Hutang Pajak & Retribusi Daerah</p>
                    <div class="progress mt-3 bg-dark" style="height: 6px;">
                        <div class="progress-bar bg-warning" style="width: 30%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden"
                style="background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%);">
                <div class="card-body p-4 text-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="badge bg-danger px-3 py-2 rounded-pill">AUDIT ZONE</div>
                        <i class="fas fa-shield-virus opacity-50 fa-lg"></i>
                    </div>
                    <h3 class="mb-1 fw-bold">2 DESA</h3>
                    <p class="extra-small mb-0 opacity-75">Keterlambatan SPJ Tahap II</p>
                    <div class="mt-3">
                        <span class="badge bg-soft-light text-white extra-small">Risk Level: Medium</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Monitoring Grid -->
    <div class="card bg-white border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 text-gray-800 fw-bold"><i class="fas fa-stream me-2"></i> Log Monitoring Fisik & Keuangan</h6>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-filter"></i> Filter</button>
                <button class="btn btn-sm btn-dark"><i class="fas fa-download"></i> Ekspor Report</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light text-muted small fw-bold">
                    <tr>
                        <th class="ps-4">Identitas Desa</th>
                        <th>Program Kerja / Sumber Dana</th>
                        <th class="text-center">Progress Fisik</th>
                        <th>Status Audit</th>
                        <th class="text-end pe-4">Validasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSubmissions as $s)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-gray-800">Desa {{ $s->desa->nama_desa }}</div>
                                <div class="extra-small text-muted">ID: #{{ $s->uuid }}</div>
                            </td>
                            <td>
                                <div class="fw-500">{{ $s->aspek->nama_aspek }}</div>
                                <div class="d-flex gap-1 mt-1">
                                    <span class="badge bg-soft-primary text-primary border-primary extra-small"
                                        style="font-size: 9px;">DD</span>
                                    <span class="badge bg-soft-info text-info border-info extra-small"
                                        style="font-size: 9px;">TA {{ $s->tahun }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="progress w-75 bg-light" style="height: 4px;">
                                        <div class="progress-bar bg-success" style="width: 75%"></div>
                                    </div>
                                    <small class="extra-small text-muted mt-1">75% Lengkap</small>
                                </div>
                            </td>
                            <td>
                                @php
                                    $sClass = [
                                        'submitted' => 'bg-info',
                                        'reviewed' => 'bg-primary',
                                        'approved' => 'bg-success',
                                        'returned' => 'bg-warning text-dark'
                                    ][$s->status] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $sClass }} py-1 px-3 rounded-pill text-uppercase"
                                    style="font-size: 10px;">
                                    {{ $s->status }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('kecamatan.verifikasi.show', $s->uuid) }}"
                                    class="btn btn-sm btn-icon border hover-primary">
                                    <i class="fas fa-magnifying-glass"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Aman! Belum ada anomali laporan pembangunan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menu-pages.css') }}">
    <style>
        .hover-primary:hover {
            background-color: #3b82f6;
            color: white !important;
            border-color: #3b82f6 !important;
        }

        .extra-small {
            font-size: 0.7rem;
        }

        .bg-soft-primary {
            background: rgba(59, 130, 246, 0.1);
        }

        .bg-soft-info {
            background: rgba(6, 182, 212, 0.1);
        }

        .bg-soft-light {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
@endpush