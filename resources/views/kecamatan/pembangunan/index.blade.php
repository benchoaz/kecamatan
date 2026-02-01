@extends('layouts.kecamatan')

@section('title', 'Monitoring Pembangunan Desa')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4 align-items-end">
            <div class="col-md-6">
                <h2 class="fw-bold text-slate-800 mb-1">Monitoring Pembangunan</h2>
                <p class="text-slate-500 small">Analisa dan pengawasan kegiatan fisik/non-fisik lintas desa.</p>
            </div>
            <div class="col-md-6">
                <form action="{{ route('kecamatan.pembangunan.index') }}" method="GET"
                    class="row g-2 justify-content-md-end">
                    <div class="col-auto">
                        <select name="desa_id" class="form-select form-select-sm rounded-pill px-3 shadow-sm border-0">
                            <option value="">Semua Desa</option>
                            @foreach($desas as $desa)
                                <option value="{{ $desa->id }}" {{ $desa_id == $desa->id ? 'selected' : '' }}>
                                    {{ $desa->nama_desa }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <div class="form-check form-switch pt-1">
                            <input class="form-check-input" type="checkbox" name="anomali" value="1" id="filterAnomali" {{ $isAnomaliOnly ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="form-check-label small text-slate-600" for="filterAnomali">Hanya Anomali</label>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit"
                            class="btn btn-sm btn-brand-600 text-white rounded-pill px-3 shadow-sm">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        @if($isAnomaliOnly && $pembangunan->isEmpty())
            <div class="alert alert-success rounded-4 border-0 shadow-sm d-flex align-items-center p-4">
                <div class="bg-emerald-100 text-emerald-600 rounded-circle p-3 me-4">
                    <i class="fas fa-check-double fa-2x"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Semua Terkendali!</h5>
                    <p class="mb-0">Tidak ditemukan indikasi anomali pada laporan desa untuk filter saat ini.</p>
                </div>
            </div>
        @endif

        <div class="row g-4">
            @forelse($pembangunan as $item)
                <div class="col-xl-4 col-md-6">
                    <div
                        class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden position-relative {{ !empty($item->alerts) ? 'border-start border-4 border-danger' : '' }}">
                        @if(!empty($item->alerts))
                            <div class="position-absolute top-0 end-0 p-3">
                                <span
                                    class="badge bg-danger rounded-pill shadow-sm animate__animated animate__pulse animate__infinite">
                                    <i class="fas fa-triangle-exclamation me-1"></i> Anomali
                                </span>
                            </div>
                        @endif

                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="badge bg-brand-50 text-brand-700 px-2 py-1 rounded small fw-600">
                                    {{ $item->desa->nama_desa }}
                                </span>
                                <span class="text-slate-400 small">•</span>
                                <span class="text-slate-500 small">TA {{ $item->tahun_anggaran }}</span>
                            </div>

                            <h5 class="fw-bold text-slate-800 mb-2 line-clamp-2" style="height: 3rem;">
                                {{ $item->nama_kegiatan }}
                            </h5>

                            <div class="row g-3 mb-4">
                                <div class="col-6 text-center border-end">
                                    <div class="text-slate-400 small text-uppercase fw-bold tracking-tighter"
                                        style="font-size: 10px;">Progres Fisik</div>
                                    <div class="h5 fw-bold text-slate-800 mb-0">{{ $item->progres_fisik }}</div>
                                </div>
                                <div class="col-6 text-center">
                                    <div class="text-slate-400 small text-uppercase fw-bold tracking-tighter"
                                        style="font-size: 10px;">Status Pengerjaan</div>
                                    <div
                                        class="fw-bold text-{{ $item->status_kegiatan == 'Selesai' ? 'emerald' : 'amber' }}-600 small">
                                        {{ $item->status_kegiatan }}
                                    </div>
                                </div>
                            </div>

                            @if(!empty($item->alerts))
                                <div class="bg-red-50 rounded-3 p-3 mb-4">
                                    <div class="small fw-bold text-red-600 mb-1">Indikasi Temuan:</div>
                                    <ul class="list-unstyled mb-0 m-0 p-0">
                                        @foreach($item->alerts as $alert)
                                            <li class="small text-red-700 mb-1 d-flex align-items-start gap-2">
                                                <i class="fas fa-circle-info mt-1"></i>
                                                <span>{{ $alert['message'] }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                                <div class="small text-slate-400">
                                    <i class="far fa-clock me-1"></i>
                                    {{ $item->updated_at->diffForHumans() }}
                                </div>
                                <a href="{{ route('kecamatan.pembangunan.show', $item->id) }}"
                                    class="btn btn-sm btn-outline-slate rounded-pill px-3">
                                    Detail Review
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="text-slate-300 mb-3"><i class="fas fa-layer-group fa-4x"></i></div>
                    <p class="text-slate-500">Belum ada laporan pembangunan yang dikirim oleh desa.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $pembangunan->links() }}
        </div>

        <!-- Integrated Section: Kepatuhan Administrasi (Lama) -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 py-4 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="fw-bold text-slate-800 mb-1">
                                    <i class="fas fa-file-shield text-brand-600 me-2"></i> Kepatuhan Administrasi
                                </h4>
                                <p class="text-slate-500 small mb-0">Status audit dokumen dan laporan reguler (Ekbang).</p>
                            </div>
                            <a href="{{ route('kecamatan.ekbang.index') }}"
                                class="btn btn-sm btn-brand-600 text-white rounded-pill px-4">
                                Buka Modul Audit
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-4 bg-slate-50">
                        <div class="row g-4">
                            @php
                                $statusMap = [
                                    'draft' => ['label' => 'Draft', 'class' => 'secondary'],
                                    'submitted' => ['label' => 'Perlu Review', 'class' => 'warning'],
                                    'reviewed' => ['label' => 'Sudah Review', 'class' => 'info'],
                                    'approved' => ['label' => 'Selesai/Ok', 'class' => 'emerald'],
                                    'returned' => ['label' => 'Dikembalikan', 'class' => 'danger'],
                                ];
                            @endphp

                            @foreach($statusMap as $status => $meta)
                                <div class="col">
                                    <div
                                        class="bg-white rounded-3 p-3 text-center shadow-sm h-100 border-top border-3 border-{{ $meta['class'] }}">
                                        <div class="text-slate-400 small text-uppercase fw-bold mb-1" style="font-size: 10px;">
                                            {{ $meta['label'] }}</div>
                                        <div class="h3 fw-bold text-slate-800 mb-0">{{ $submissionStats[$status] ?? 0 }}</div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-md-3">
                                <div
                                    class="bg-brand-600 text-white rounded-3 p-3 shadow-sm h-100 d-flex flex-column justify-content-center">
                                    <div class="small opacity-75 text-uppercase fw-bold mb-1" style="font-size: 10px;">Total
                                        Dokumen</div>
                                    <div class="h3 fw-bold mb-0">{{ array_sum($submissionStats->toArray()) }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 p-3 bg-white rounded-4 border border-slate-100 shadow-sm">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-blue-50 text-blue-600 rounded-circle p-3">
                                    <i class="fas fa-lightbulb"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-slate-800 mb-1">Informasi Integrasi</h6>
                                    <p class="text-slate-500 small mb-0">Tabel di atas merangkum data dari fitur audit
                                        dokumen lama. Anda masih dapat melakukan ekspor paket audit ZIP melalui tombol
                                        <strong>Buka Modul Audit</strong>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .bg-brand-50 {
            background-color: #f0f7ff;
        }

        .text-brand-700 {
            color: #1d4ed8;
        }

        .border-brand-600 {
            border-color: #2563eb !important;
        }

        .btn-brand-600 {
            background-color: #2563eb;
            border: none;
        }

        .btn-brand-600:hover {
            background-color: #1d4ed8;
        }

        .btn-outline-slate {
            border-color: #cbd5e1;
            color: #64748b;
        }

        .btn-outline-slate:hover {
            background-color: #f8fafc;
            color: #334155;
        }
    </style>
@endsection