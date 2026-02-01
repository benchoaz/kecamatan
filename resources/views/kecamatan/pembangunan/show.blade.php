@extends('layouts.kecamatan')

@section('title', 'Review Laporan - ' . $item->nama_kegiatan)

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('kecamatan.pembangunan.index') }}"
                                class="text-decoration-none">Monitoring Pembangunan</a></li>
                        <li class="breadcrumb-item active">Review Detail</li>
                    </ol>
                </nav>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h2 class="fw-bold text-slate-800 mb-0">Review: {{ $item->nama_kegiatan }}</h2>
                        <span class="badge bg-slate-100 text-slate-600 rounded-pill px-3 py-1 fw-normal mt-2">
                            Laporan dari: {{ $item->desa->nama_desa }} (Status: {{ $item->status_laporan }})
                        </span>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Left: Data Pelaksanaan (Read Only from Desa) -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold text-slate-400 text-uppercase small mb-4">Informasi Pelaksanaan (Data
                                    Desa)</h6>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="small text-slate-400">Lokasi & TA</div>
                                        <div class="fw-bold text-slate-800">{{ $item->lokasi }} (TA
                                            {{ $item->tahun_anggaran }})</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="small text-slate-400">Pagu vs Realisasi</div>
                                        <div class="fw-bold text-slate-800">
                                            Rp {{ number_format($item->realisasi_anggaran, 0, ',', '.') }} /
                                            <span class="text-slate-500 fw-normal">Rp
                                                {{ number_format($item->pagu_anggaran, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="small text-slate-400">Progres Fisik Terlapor</div>
                                        <div class="d-flex align-items-center gap-2 mt-1">
                                            <div class="progress flex-grow-1" style="height: 10px;">
                                                @php $pct = (int) Str::replace('%', '', $item->progres_fisik); @endphp
                                                <div class="progress-bar bg-emerald-500" role="progressbar"
                                                    style="width: {{ $pct }}%"></div>
                                            </div>
                                            <span class="fw-bold text-slate-800">{{ $item->progres_fisik }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="small text-slate-400">Dokumen Pendukung</div>
                                        <div class="mt-1">
                                            @if($item->rab_file)
                                                <a href="{{ asset('storage/' . $item->rab_file) }}" target="_blank"
                                                    class="btn btn-xs btn-outline-danger px-2 py-0"><i
                                                        class="fas fa-file-pdf"></i> RAB</a>
                                            @endif
                                            @if($item->gambar_rencana_file)
                                                <a href="{{ asset('storage/' . $item->gambar_rencana_file) }}" target="_blank"
                                                    class="btn btn-xs btn-outline-primary px-2 py-0"><i
                                                        class="fas fa-image"></i> Gambar</a>
                                            @endif
                                            @if(!$item->rab_file && !$item->gambar_rencana_file)
                                                <span class="text-slate-400 italic small">Tidak ada lampiran</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Anomaly Alerts -->
                        @if(!empty($alerts))
                            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-red-50 border-start border-danger border-4">
                                <div class="card-body p-4">
                                    <h6 class="fw-bold text-red-600 text-uppercase small mb-3"><i
                                            class="fas fa-magnifying-glass-chart me-2"></i>Hasil Analitik Anomali (Sistem)</h6>
                                    <ul class="list-group list-group-flush bg-transparent">
                                        @foreach($alerts as $alert)
                                            <li
                                                class="list-group-item bg-transparent border-red-100 px-0 d-flex align-items-start gap-3">
                                                <div class="text-{{ $alert['type'] }}">
                                                    <i class="fas fa-circle-exclamation fa-lg"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-slate-800">{{ $alert['message'] }}</div>
                                                    <div class="small text-slate-500">Kode Deteksi:
                                                        <code>{{ $alert['code'] }}</code></div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @else
                            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-emerald-50">
                                <div class="card-body p-4 text-center">
                                    <div class="text-emerald-500 mb-2"><i class="fas fa-check-circle fa-2x"></i></div>
                                    <h6 class="fw-bold text-emerald-800 mb-0">Tidak Terdeteksi Anomali oleh Sistem</h6>
                                    <p class="text-emerald-600 small mb-0">Data terlihat konsisten berdasarkan parameter
                                        analitik standar.</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Right: Kecamatan Review & Monitoring -->
                    <div class="col-lg-4">
                        <!-- Indikator Internal Form -->
                        <div class="card border-0 shadow-sm rounded-4 bg-slate-800 text-white mb-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold text-slate-400 text-uppercase small mb-4">Indikator Internal Kecamatan
                                </h6>
                                <form
                                    action="{{ route('kecamatan.pembangunan.update-monitoring', [$item->id, 'pembangunan']) }}"
                                    method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="form-label small text-slate-400">Hasil Review Sementara</label>
                                        <select name="indikator_internal"
                                            class="form-select bg-slate-700 border-0 text-white rounded-3 shadow-none">
                                            <option value="Wajar" {{ $item->indikator_internal == 'Wajar' ? 'selected' : '' }}>Wajar</option>
                                            <option value="Perlu Klarifikasi" {{ $item->indikator_internal == 'Perlu Klarifikasi' ? 'selected' : '' }}>Perlu Klarifikasi / Flag Lapangan</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label small text-slate-400">Catatan Internal (Monitoring
                                            Lapangan)</label>
                                        <textarea name="catatan_kecamatan"
                                            class="form-control bg-slate-700 border-0 text-white rounded-3 shadow-none"
                                            rows="4"
                                            placeholder="Tuliskan catatan untuk tim lapangan atau pembinaan...">{{ $item->catatan_kecamatan }}</textarea>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-brand-600 text-white w-100 rounded-pill py-2 shadow-sm">
                                        Update Hasil Monitoring
                                    </button>
                                </form>
                                <div class="mt-4 p-3 bg-slate-700 rounded-3 border-start border-amber-500 border-3">
                                    <div class="small fw-bold text-amber-500"><i class="fas fa-user-shield me-1"></i> Area
                                        Internal</div>
                                    <p class="small text-slate-400 mb-0 italic">Inputan di panel ini **TIDAK TERLIHAT** oleh
                                        operator desa.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Forward/Process Logic (Optional, using Verifikasi pattern) -->
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold text-slate-500 text-uppercase small mb-3">Tindak Lanjut Laporan</h6>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-danger btn-sm rounded-pill py-2">Kembalikan
                                        Laporan</button>
                                    <button class="btn btn-emerald btn-sm text-white rounded-pill py-2">Tandai Sudah
                                        Dicatat</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 mb-5">
                    <a href="{{ route('kecamatan.pembangunan.index') }}"
                        class="btn btn-outline-slate rounded-pill px-4">Kembali Ke Monitoring</a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-brand-600 {
            background-color: #2563eb;
        }

        .text-emerald-500 {
            color: #10b981;
        }

        .bg-red-50 {
            background-color: #fef2f2;
        }

        .bg-emerald-50 {
            background-color: #ecfdf5;
        }

        .btn-xs {
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
        }
    </style>
@endsection