@extends('layouts.kecamatan')

@section('title', 'Monev Trantibum Wilayah')

@section('content')
    <div class="content-header mb-4">
        <div class="header-title">
            <h1>Monitoring Ketertiban & Keamanan</h1>
            <p class="text-muted">Pengawasan Situasi Kamtibmas & Response Koordinasi Desa</p>
        </div>
    </div>

    <!-- Security Radar Summary -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-white border-gray-200 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted small text-uppercase fw-bold">Incident Rate</h6>
                    <div class="d-flex align-items-end justify-content-between mt-2">
                        <h3 class="text-gray-900 fw-bold mb-0">Low</h3>
                        <span class="text-success small"><i class="fas fa-arrow-down me-1"></i> 12%</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-white border-gray-200 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted small text-uppercase fw-bold">Critical Task</h6>
                    <div class="d-flex align-items-end justify-content-between mt-2">
                        <h3 class="text-gray-900 fw-bold mb-0">2</h3>
                        <span class="text-danger small">High Priority</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-white border-gray-200 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted small text-uppercase fw-bold">Linmas Active</h6>
                    <div class="d-flex align-items-end justify-content-between mt-2">
                        <h3 class="text-gray-900 fw-bold mb-0">144</h3>
                        <span class="text-muted small">All Villages</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-white border-gray-200 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted small text-uppercase fw-bold">System Status</h6>
                    <div class="d-flex align-items-end justify-content-between mt-2">
                        <h3 class="text-success fw-bold mb-0">Live</h3>
                        <span class="badge bg-success bg-opacity-10 text-success">Secured</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-white border-gray-200 shadow-sm">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 text-gray-800"><i class="fas fa-tower-observation me-2"></i> Laporan Masuk Seluruh Wilayah</h6>
            <div class="card-actions">
                <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-filter me-2"></i>Filter Desa</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light text-muted small">
                    <tr>
                        <th class="ps-4">Asal Desa</th>
                        <th>Jenis Insiden / Kategori</th>
                        <th>Urgency</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Atensi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allReports as $report)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-gray-800">{{ $report->desa->nama_desa }}</div>
                                <div class="extra-small text-muted">{{ $report->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <div class="text-gray-900">{{ $report->aspek->nama_aspek }}</div>
                                <div class="extra-small text-muted">
                                    {{ Str::limit($report->catatan_review ?? 'Pemantauan rutin.', 40) }}</div>
                            </td>
                            <td>
                                @php
                                    $urgency = ['submitted' => 'High', 'draft' => 'Low', 'approved' => 'Normal'][$report->status] ?? 'Normal';
                                    $uClass = ['submitted' => 'danger', 'draft' => 'secondary', 'approved' => 'success'][$report->status] ?? 'info';
                                @endphp
                                <span class="text-{{ $uClass }} small fw-bold">
                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> {{ $urgency }}
                                </span>
                            </td>
                            <td>
                                <span
                                    class="badge bg-{{ $uClass }} bg-opacity-10 text-{{ $uClass }} border border-{{ $uClass }} border-opacity-25">
                                    {{ strtoupper($report->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('kecamatan.trantibum.show', $report->id) }}" class="btn btn-sm btn-icon"><i
                                        class="fas fa-magnifying-glass"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada laporan gangguan keamanan dari desa.
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
@endpush