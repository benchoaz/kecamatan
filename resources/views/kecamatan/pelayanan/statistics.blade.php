@extends('layouts.kecamatan')

@section('title', 'Statistik Pelayanan Masyarakat')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="mb-4 pb-2">
            <h1 class="text-slate-900 fw-bold fs-3 mb-1">Statistik Pelayanan</h1>
            <p class="text-slate-400 small mb-0">Analisis volume dan performa respons pengaduan masyarakat.</p>
        </div>

        <!-- Metric Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 border border-slate-100 h-100">
                    <p class="text-[10px] text-slate-400 fw-bold uppercase tracking-wider mb-1">Total Laporan</p>
                    <h3 class="fw-bold text-slate-900 mb-0">{{ $stats['total'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 border border-amber-100 bg-amber-50/30 h-100">
                    <p class="text-[10px] text-amber-500 fw-bold uppercase tracking-wider mb-1">Menunggu Respon</p>
                    <h3 class="fw-bold text-amber-600 mb-0">{{ $stats['pending'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 border border-blue-100 bg-blue-50/30 h-100">
                    <p class="text-[10px] text-blue-500 fw-bold uppercase tracking-wider mb-1">Giat Proses</p>
                    <h3 class="fw-bold text-blue-600 mb-0">{{ $stats['processed'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 border border-emerald-100 bg-emerald-50/30 h-100">
                    <p class="text-[10px] text-emerald-500 fw-bold uppercase tracking-wider mb-1">Sudah Selesai</p>
                    <h3 class="fw-bold text-emerald-600 mb-0">{{ $stats['completed'] }}</h3>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Categorization -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 border border-slate-100 h-100">
                    <div class="card-header bg-white py-3 px-4 border-bottom border-slate-50">
                        <h6 class="mb-0 fw-bold text-slate-800 small">Klasifikasi Layanan</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="space-y-4">
                            @foreach($stats['by_category'] as $cat)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-slate-600 small fw-medium">{{ $cat->jenis_layanan }}</span>
                                        <span class="text-slate-900 fw-bold small">{{ $cat->total }}</span>
                                    </div>
                                    @php 
                                        $percent = $stats['total'] > 0 ? ($cat->total / $stats['total']) * 100 : 0; 
                                        $colorClass = $cat->jenis_layanan == 'Pengaduan Pelayanan' ? 'bg-rose-400' : 
                                                     ($cat->jenis_layanan == 'Permohonan Informasi' ? 'bg-blue-400' : 'bg-emerald-400');
                                    @endphp
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar {{ $colorClass }} rounded-pill" role="progressbar" style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Village Distribution -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 border border-slate-100 h-100">
                    <div class="card-header bg-white py-3 px-4 border-bottom border-slate-50">
                        <h6 class="mb-0 fw-bold text-slate-800 small">Sebaran Wilayah (Top Desa)</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 400px;">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-slate-50/50 sticky-top">
                                    <tr>
                                        <th class="ps-4 py-2 text-slate-400 text-[10px] fw-bold uppercase">Nama Desa</th>
                                        <th class="pe-4 py-2 text-end text-slate-400 text-[10px] fw-bold uppercase">Volume Laporan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stats['by_village'] as $vil)
                                        <tr>
                                            <td class="ps-4 py-3 text-slate-600 small">{{ $vil->desa ? $vil->desa->nama_desa : 'Umum' }}</td>
                                            <td class="pe-4 py-3 text-end fw-bold text-slate-900 small">{{ $vil->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection