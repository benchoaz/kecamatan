@extends('layouts.kecamatan')

@section('title', 'Detail Musrenbang ' . $perencanaan->tahun)

@section('content')
    <div class="content-header mb-4">
        <div class="header-breadcrumb">
            <a href="{{ route('kecamatan.pemerintahan.detail.perencanaan.index') }}"><i class="fas fa-arrow-left"></i>
                Kembali ke Daftar
                Perencanaan</a>
        </div>
        <div class="header-title d-flex justify-content-between align-items-center w-100">
            <div>
                <h1 class="text-white">Monev Perencanaan ({{ $perencanaan->tahun }})</h1>
                <p class="text-muted">
                    <span class="badge bg-primary-soft text-primary me-2">MUSDES:
                        {{ $perencanaan->nama_musdes ?? 'Musyawarah Perencanaan' }}</span>
                    {{ $perencanaan->desa->nama_desa }} &bull; {{ $perencanaan->tanggal_kegiatan->format('d F Y') }}
                </p>
            </div>
            <div>
                <button class="btn btn-outline-light me-2"><i class="fas fa-print"></i> Cetak BA</button>
                <span class="badge bg-success-soft text-success px-3 py-2">Terverifikasi Kecamatan</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left: Event Info & Documents -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Informasi Kegiatan</h6>
                </div>
                <div class="card-body">
                    <div class="info-group mb-3">
                        <label class="small text-muted d-block">Lokasi Musyawarah</label>
                        <div class="fw-bold">{{ $perencanaan->lokasi }}</div>
                    </div>
                    <div class="info-group">
                        <label class="small text-muted d-block">Status Administrasi</label>
                        <span class="badge bg-primary">{{ strtoupper($perencanaan->status_administrasi) }}</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Lampiran Wajib (Audit Ready)</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-pdf text-danger fa-2x me-3"></i>
                                <div>
                                    <div class="fw-bold small">Berita Acara</div>
                                    <div class="text-muted" style="font-size: 0.7rem;">FILE_BA_{{ $perencanaan->tahun }}.pdf
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-icon"><i class="fas fa-download"></i></a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-invoice text-info fa-2x me-3"></i>
                                <div>
                                    <div class="fw-bold small">Daftar Hadir</div>
                                    <div class="text-muted" style="font-size: 0.7rem;">ABSENSI_{{ $perencanaan->tahun }}.pdf
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-icon"><i class="fas fa-download"></i></a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-contract text-warning fa-2x me-3"></i>
                                <div>
                                    <div class="fw-bold small">Output Hukum (SK/Perdes)</div>
                                    <div class="text-muted" style="font-size: 0.7rem;">
                                        @if($perencanaan->file_output)
                                            DOKUMEN_LEGAL_{{ $perencanaan->tahun }}.pdf
                                        @else
                                            <span class="text-danger italic">Belum Diunggah</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if($perencanaan->file_output)
                                <a href="#" class="btn btn-sm btn-icon"><i class="fas fa-download"></i></a>
                            @endif
                        </li>
                        @if($perencanaan->file_foto)
                            <li class="list-group-item">
                                <div class="fw-bold small mb-2">Dokumentasi Foto</div>
                                <img src="#" class="img-fluid rounded border" alt="Foto Musrenbang"
                                    style="width: 100%; height: 150px; object-fit: cover; background: #334155;">
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Suggestion: Verification Action for Kecamatan -->
            <div class="card mt-4 border-primary">
                <div class="card-body">
                    <h6 class="text-primary mb-3">Tindakan Monev Kecamatan</h6>
                    <button class="btn btn-success w-100 mb-2">
                        <i class="fas fa-check-double me-2"></i> Sahkan Administrasi
                    </button>
                    <button class="btn btn-outline-warning w-100">
                        <i class="fas fa-exclamation-triangle me-2"></i> Beri Catatan Pembinaan
                    </button>
                </div>
            </div>
        </div>

        <!-- Right: Proposals List -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Daftar Usulan Prioritas</h6>
                    <span class="badge bg-dark">{{ $perencanaan->usulan->count() }} Usulan</span>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Bidang</th>
                                <th>Uraian Usulan</th>
                                <th>Prioritas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perencanaan->usulan as $u)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $u->bidang }}</span></td>
                                    <td>
                                        <div class="fw-500">{{ $u->uraian }}</div>
                                    </td>
                                    <td>
                                        @php
                                            $prioClass = [
                                                'tinggi' => 'bg-danger',
                                                'sedang' => 'bg-warning',
                                                'rendah' => 'bg-info',
                                            ][$u->prioritas] ?? 'bg-secondary';
                                        @endphp
                                        <span class="badge {{ $prioClass }}">{{ strtoupper($u->prioritas) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .bg-success-soft {
            background-color: rgba(16, 185, 129, 0.1);
        }

        .fw-500 {
            font-weight: 500;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endpush