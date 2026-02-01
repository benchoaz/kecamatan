@extends('layouts.desa')

@section('title', 'Detail Pembangunan - ' . $item->nama_kegiatan)

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('desa.pembangunan.index') }}"
                                class="text-decoration-none">Pembangunan</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </nav>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h2 class="fw-bold text-slate-800 mb-0">{{ $item->nama_kegiatan }}</h2>
                    <div class="d-flex gap-2">
                        @php
                            $statusClass = [
                                'Draft' => 'bg-slate-100 text-slate-600',
                                'Dikirim' => 'bg-blue-100 text-blue-600',
                                'Dikembalikan' => 'bg-amber-100 text-amber-600',
                                'Dicatat' => 'bg-emerald-100 text-emerald-600',
                            ][$item->status_laporan] ?? 'bg-slate-100 text-slate-600';
                        @endphp
                        <span class="badge {{ $statusClass }} rounded-pill px-3 py-2 fw-normal">Status:
                            {{ $item->status_laporan }}</span>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-8">
                        <!-- Identitas & Progres -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold text-slate-500 text-uppercase small mb-4">Informasi Pelaksanaan</h6>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="small text-slate-400">Lokasi</div>
                                        <div class="fw-bold text-slate-800">{{ $item->lokasi }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="small text-slate-400">Tahun Anggaran</div>
                                        <div class="fw-bold text-slate-800">{{ $item->tahun_anggaran }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="small text-slate-400">Status Pengerjaan</div>
                                        <div class="fw-bold text-slate-800">{{ $item->status_kegiatan }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="small text-slate-400">Progres Fisik</div>
                                        <div class="d-flex align-items-center gap-2 mt-1">
                                            <div class="progress flex-grow-1" style="height: 10px;">
                                                @php $pct = (int) Str::replace('%', '', $item->progres_fisik); @endphp
                                                <div class="progress-bar bg-emerald-500" role="progressbar"
                                                    style="width: {{ $pct }}%"></div>
                                            </div>
                                            <span class="fw-bold text-slate-800">{{ $item->progres_fisik }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Anggaran -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold text-slate-500 text-uppercase small mb-4">Realisasi Keuangan</h6>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="small text-slate-400">Pagu Anggaran</div>
                                        <div class="h5 fw-bold text-slate-800 mb-0">Rp
                                            {{ number_format($item->pagu_anggaran, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="small text-slate-400">Realisasi</div>
                                        <div class="h5 fw-bold text-emerald-600 mb-0">Rp
                                            {{ number_format($item->realisasi_anggaran, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="p-3 bg-slate-50 rounded-3">
                                            <div class="small text-slate-600 italic">
                                                <i class="fas fa-info-circle me-1"></i> Data anggaran ini bersifat faktual
                                                untuk monitoring internal Kecamatan.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Dokumen -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold text-slate-500 text-uppercase small mb-4">Dokumen Pendukung</h6>
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item px-0 border-0 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-red-50 text-red-600 rounded p-2 me-3">
                                                <i class="fas fa-file-pdf fa-lg"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="small fw-bold">RAB Kegiatan</div>
                                                @if($item->rab_file)
                                                    <a href="{{ asset('storage/' . $item->rab_file) }}" target="_blank"
                                                        class="small text-decoration-none">Lihat Dokumen</a>
                                                @else
                                                    <span class="small text-slate-400 italic">Belum diunggah</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item px-0 border-0 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-blue-50 text-blue-600 rounded p-2 me-3">
                                                <i class="fas fa-map-location-dot fa-lg"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="small fw-bold">Gambar Rencana</div>
                                                @if($item->gambar_rencana_file)
                                                    <a href="{{ asset('storage/' . $item->gambar_rencana_file) }}"
                                                        target="_blank" class="small text-decoration-none">Lihat Dokumen</a>
                                                @else
                                                    <span class="small text-slate-400 italic">Belum diunggah</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Histori -->
                        <div class="card border-0 bg-slate-800 text-white rounded-4 shadow-sm">
                            <div class="card-body p-4">
                                <h6 class="fw-bold text-slate-400 text-uppercase small mb-3">Informasi Pelaporan</h6>
                                <div class="mb-3">
                                    <div class="small text-slate-400">Dibuat Pada</div>
                                    <div class="fw-medium">{{ $item->created_at->format('d M Y, H:i') }}</div>
                                </div>
                                <div>
                                    <div class="small text-slate-400">Update Terakhir</div>
                                    <div class="fw-medium">{{ $item->updated_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-5 mb-5">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-slate rounded-pill px-4">Kembali</a>
                    <div class="d-flex gap-2">
                        @if($item->status_laporan === 'Draft' || $item->status_laporan === 'Dikembalikan')
                            <a href="{{ route('desa.pembangunan.edit', $item->id) }}"
                                class="btn btn-slate-700 text-white rounded-pill px-4">Edit Data</a>
                            <form action="{{ route('desa.pembangunan.submit', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-emerald text-white rounded-pill px-4">Kirim
                                    Laporan</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection