@extends('layouts.desa')

@section('title', 'Lapor Gangguan & Trantibum')

@section('content')
    <div class="content-header mb-4">
        <div class="header-title">
            <h1>Ketertiban & Keamanan</h1>
            <p class="text-muted">Pelaporan Insiden Wilayah & Monitoring Linmas Desa</p>
        </div>
        <a href="{{ route('desa.submissions.create', ['menu_id' => 4]) }}" class="btn btn-teal">
            <i class="fas fa-plus me-2"></i> Lapor Gangguan Baru
        </a>
    </div>

    <!-- Alert Status -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card bg-white border-gray-200 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success me-3">
                        <i class="fas fa-shield-halved fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1">Status Keamanan</h6>
                        <h4 class="text-gray-900 fw-bold mb-0">KONDUSIF</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-white border-gray-200 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-info bg-opacity-10 text-info me-3">
                        <i class="fas fa-person-military-pointing fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1">Total Linmas</h6>
                        <h4 class="text-gray-900 fw-bold mb-0">12 Personil</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-white border-gray-200 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning me-3">
                        <i class="fas fa-bullhorn fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small mb-1">Laporan Terbuka</h6>
                        <h4 class="text-gray-900 fw-bold mb-0">{{ $recentReports->where('status', 'submitted')->count() }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-white border-gray-200 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="mb-0 text-gray-800">Log Aktivitas Keamanan Terakhir</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light text-muted small">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Kategori / Insiden</th>
                        <th>Status</th>
                        <th>Tanggal Kejadian</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentReports as $r)
                        <tr>
                            <td class="ps-4">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold text-gray-800">{{ $r->aspek->nama_aspek }}</div>
                                <div class="small text-muted">
                                    {{ Str::limit($r->catatan_review ?? 'Laporan rutin keamanan wilayah.', 50) }}</div>
                            </td>
                            <td>
                                <span
                                    class="badge bg-{{ $r->status === 'submitted' ? 'info' : ($r->status === 'approved' ? 'success' : 'secondary') }}">
                                    {{ strtoupper($r->status) }}
                                </span>
                            </td>
                            <td>{{ $r->created_at->format('d/m/Y') }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('desa.trantibum.show', $r->id) }}" class="btn btn-sm btn-icon"><i
                                        class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted small">Belum ada laporan gangguan keamanan
                                terdaftar.</td>
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
        .btn-teal {
            background-color: #14b8a6;
            color: white;
        }

        .btn-teal:hover {
            background-color: #0d9488;
            color: white;
        }
    </style>
@endpush