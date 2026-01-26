@extends('layouts.kecamatan')

@section('title', 'Dokumen Inti Pemerintahan Desa')

@section('content')
    <div class="content-header mb-4">
        <div class="header-breadcrumb">
            <a href="{{ route('kecamatan.dashboard') }}" class="text-primary"><i class="fas fa-arrow-left"></i> Kembali ke
                Dashboard</a>
        </div>
        <div class="header-title d-flex justify-content-between align-items-center w-100">
            <div>
                <h1>Dokumen Inti Desa</h1>
                <p class="text-muted">
                    @if($desa_id)
                        Arsip Digital Dokumen Perencanaan (RPJMDes & RKPDes)
                    @else
                        Pilih Desa untuk Melihat Arsip Dokumen Perencanaan
                    @endif
                </p>
            </div>
            @if($desa_id)
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadDokumenModal">
                    <i class="fas fa-file-arrow-up me-2"></i> Arsipkan Dokumen
                </button>
            @endif

        </div>
    </div>

    @if(!$desa_id)
        <div class="card bg-white border-gray-200 shadow-sm rounded-4 overflow-hidden mt-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small fw-bold">
                        <tr>
                            <th class="ps-4" style="width: 50px;">No</th>
                            <th>Nama Desa</th>
                            <th class="text-center">Dokumen Inti Tersimpan</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($desas as $index => $desa)
                            <tr>
                                <td class="ps-4 text-muted small">{{ $index + 1 }}</td>
                                <td class="fw-bold text-slate-700"> Desa {{ $desa->nama_desa }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary-soft text-primary px-3 py-2"
                                        style="font-size: 0.85rem;">{{ $desa->dokumens_count }} Dokumen</span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ url()->current() }}?desa_id={{ $desa->id }}"
                                        class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="row g-4 mt-2">
            <div class="col-12">
                <div class="card bg-white border-gray-200 shadow-sm rounded-4 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small">
                                <tr>
                                    <th class="ps-4">Tahun</th>
                                    <th>Jenis Dokumen</th>
                                    <th>Tgl Pengarsipan</th>
                                    <th>File</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dokumens as $d)
                                    <tr>
                                        <td class="ps-4"><span
                                                class="badge bg-dark border-secondary px-3 py-2">{{ $d->tahun }}</span></td>
                                        <td>
                                            <div class="fw-bold">{{ $d->tipe_dokumen }}</div>
                                        </td>
                                        <td>{{ $d->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-file-pdf"></i> Unduh PDF
                                            </a>
                                        </td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-icon btn-sm text-danger"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i>
                                            <p class="text-muted">Arsip dokumen legal masih kosong untuk desa ini.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Upload -->
    <div class="modal fade" id="uploadDokumenModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pengarsipan Dokumen Inti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('kecamatan.pemerintahan.detail.dokumen.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Jenis Dokumen</label>
                                <select name="tipe_dokumen" class="form-select" required>
                                    <option value="RPJMDes">RPJMDes (6 Tahun)</option>
                                    <option value="RKPDes">RKPDes (1 Tahun)</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Tahun Berlaku / Anggaran</label>
                                <input type="number" name="tahun" class="form-control" value="{{ date('Y') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Pilih Dokumen PDF (Max 5MB)</label>
                                <input type="file" name="file_dokumen" class="form-control" accept="application/pdf"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan ke Arsip</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menu-pages.css') }}">

    </style>
@endpush