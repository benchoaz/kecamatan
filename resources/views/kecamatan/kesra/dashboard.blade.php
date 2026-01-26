@extends('layouts.kecamatan')

@section('title', 'Dashboard Kesejahteraan Rakyat')

@section('content')
    <div class="content-header mb-4">
        <div class="header-title">
            <h1 class="text-white">Dashboard Kesejahteraan Rakyat</h1>
            <p class="text-muted">Pemantauan Bidang Pelayanan & Pemberdayaan Sosial (Pasal 439)</p>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card status-card h-100 status-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="status-icon"><i class="fas fa-file-export"></i></div>
                        <span class="badge badge-pill badge-info">{{ $stats['waiting'] }} Laporan</span>
                    </div>
                    <h6 class="card-title mb-1">Menunggu Telaah</h6>
                    <p class="text-muted small">Laporan desa yang perlu ditinjau administrasinya.</p>
                    <a href="{{ route('kecamatan.kesra.bansos.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card status-card h-100 status-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="status-icon"><i class="fas fa-undo"></i></div>
                        <span class="badge badge-pill badge-warning">{{ $stats['returned'] }} Laporan</span>
                    </div>
                    <h6 class="card-title mb-1">Dikembalikan ke Desa</h6>
                    <p class="text-muted small">Laporan yang memerlukan perbaikan dokumen.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card status-card h-100 status-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="status-icon"><i class="fas fa-check-double"></i></div>
                        <span class="badge badge-pill badge-success">{{ $stats['reviewed'] }} Laporan</span>
                    </div>
                    <h6 class="card-title mb-1">Direkomendasikan</h6>
                    <p class="text-muted small">Laporan yang telah diteruskan ke Camat.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities / Submissions -->
    <div class="section-title mb-4">
        <h5 class="text-white">Laporan Terbaru Bidang Kesra</h5>
        <div class="title-accent"></div>
    </div>

    <div class="card bg-dark border-secondary">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead class="bg-secondary bg-opacity-10 text-muted small">
                    <tr>
                        <th class="ps-4">Asal Desa</th>
                        <th>Program / Aspek</th>
                        <th>Tahun</th>
                        <th>Status Saat Ini</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSubmissions as $s)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $s->desa->nama_desa }}</div>
                                <div class="extra-small text-muted">{{ $s->created_at->diffForHumans() }}</div>
                            </td>
                            <td>{{ $s->aspek->nama_aspek }}</td>
                            <td>{{ $s->tahun }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $s->status === 'submitted' ? 'info' : ($s->status === 'returned' ? 'warning' : 'success') }}">
                                    {{ strtoupper($s->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('kecamatan.kesra.bansos.index') }}" class="btn btn-sm btn-icon"><i
                                        class="fas fa-arrow-right"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada laporan masuk di bidang ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection