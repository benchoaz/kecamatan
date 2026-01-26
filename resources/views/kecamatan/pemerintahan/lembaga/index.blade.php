@extends('layouts.kecamatan')

@section('title', 'Lembaga & Organisasi Kemasyarakatan Desa')

@section('content')
    <div class="content-header mb-4">
        <div class="header-breadcrumb">
            <a href="{{ route('kecamatan.dashboard') }}" class="text-primary"><i class="fas fa-arrow-left"></i> Kembali ke
                Dashboard</a>
        </div>
        <div class="header-title d-flex justify-content-between align-items-center w-100">
            <div>
                <h1>Lembaga & Organisasi Desa</h1>
                <p class="text-muted">
                    @if($desa_id)
                        Daftar Legalitas PKK, Karang Taruna, LPM, Posyandu, dan Lainnya
                    @else
                        Pilih Desa untuk Melihat Detail Administrasi Lembaga
                    @endif
                </p>
            </div>
            @if($desa_id)
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLembagaModal">
                    <i class="fas fa-plus me-2"></i> Tambah Lembaga
                </button>
            @endif

        </div>
    </div>

    @if(!$desa_id)
        <div class="card bg-white border-gray-200 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small fw-bold">
                        <tr>
                            <th class="ps-4" style="width: 50px;">No</th>
                            <th>Nama Desa</th>
                            <th>Lembaga Terdaftar</th>
                            <th class="text-center">Jumlah Lembaga</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($desas as $index => $desa)
                            <tr>
                                <td class="ps-4 text-muted small">{{ $index + 1 }}</td>
                                <td class="fw-bold text-slate-700"> Desa {{ $desa->nama_desa }}</td>
                                <td>
                                    @forelse($desa->lembaga->take(5) as $l)
                                        <span class="badge bg-primary-soft text-primary me-1 mb-1"
                                            style="font-size: 0.65rem;">{{ $l->nama_lembaga }}</span>
                                    @empty
                                        <span class="text-muted small italic">Belum ada data</span>
                                    @endforelse
                                    @if($desa->lembaga->count() > 5)
                                        <span class="text-muted small">...</span>
                                    @endif
                                </td>
                                <td class="text-center fw-bold">
                                    {{ $desa->lembaga->count() }}
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
        <div class="card bg-white border-gray-200 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4">Nama Lembaga / Tipe</th>
                            <th>Ketua</th>
                            <th>Tahun Formasi</th>
                            <th>Legalitas (No SK)</th>
                            <th>Status Akreditasi/Legal</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lembagas as $l)
                            <tr>
                                <td class="ps-4 text-slate-700">
                                    <div class="fw-bold">{{ $l->nama_lembaga }}</div>
                                    <span class="badge bg-primary-soft text-primary text-uppercase" style="font-size: 0.65rem;">
                                        {{ $l->tipe_lembaga }}
                                    </span>
                                </td>
                                <td>{{ $l->ketua ?? '-' }}</td>
                                <td>{{ $l->tahun_pembentukan ?? '-' }}</td>
                                <td>
                                    <div class="small fw-500">{{ $l->nomor_sk ?? 'Belum ada SK' }}</div>
                                    @if($l->file_sk)
                                        <a href="#" class="btn btn-xs btn-outline-info mt-1">
                                            <i class="fas fa-file-pdf"></i> Lihat SK
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if($l->is_active)
                                        <span class="badge bg-success-soft text-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger-soft text-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-icon btn-sm"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-sitemap fa-3x mb-3 text-muted"></i>
                                    <p class="text-muted">Data organisasi desa belum diinput.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Modal Tambah Lembaga -->
    <div class="modal fade" id="addLembagaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Lembaga Desa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('kecamatan.pemerintahan.detail.lembaga.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Tipe Lembaga</label>
                                <select name="tipe_lembaga" class="form-select" required>
                                    <option value="PKK">PKK (Pemberdayaan Kesejahteraan Keluarga)</option>
                                    <option value="Karang Taruna">Karang Taruna</option>
                                    <option value="LPM">LPM (Lembaga Pemberdayaan Masyarakat)</option>
                                    <option value="Posyandu">Posyandu</option>
                                    <option value="RT/RW">Forum RT/RW</option>
                                    <option value="Lainnya">Lembaga Lainnya</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Nama Lembaga (Sesuai SK)</label>
                                <input type="text" name="nama_lembaga" class="form-control"
                                    placeholder="Contoh: PKK Desa Sukamaju" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Nama Ketua</label>
                                <input type="text" name="ketua" class="form-control" placeholder="Nama Lengkap">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No SK</label>
                                <input type="text" name="nomor_sk" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tahun Formasi</label>
                                <input type="number" name="tahun_pembentukan" class="form-control" placeholder="YYYY">
                            </div>
                            <div class="col-12">
                                <label class="form-label">File SK (PDF)</label>
                                <input type="file" name="file_sk" class="form-control" accept="application/pdf">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Lembaga</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menu-pages.css') }}">
    <style>
        .bg-primary-soft {
            background-color: rgba(59, 130, 246, 0.1);
        }

        .bg-success-soft {
            background-color: rgba(16, 185, 129, 0.1);
        }

        .bg-danger-soft {
            background-color: rgba(239, 68, 68, 0.1);
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-xs {
            padding: 0.2rem 0.6rem;
            font-size: 0.75rem;
        }
    </style>
    </style>
@endpush