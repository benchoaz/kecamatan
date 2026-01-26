@extends('layouts.kecamatan')

@section('title', $title ?? 'Administrasi Perangkat Desa')

@section('content')
    <div class="content-header mb-4">
        <div class="header-breadcrumb">
            <a href="{{ route('kecamatan.dashboard') }}" class="text-primary"><i class="fas fa-arrow-left"></i> Kembali ke
                Dashboard</a>
        </div>
        <div class="header-title d-flex justify-content-between align-items-center w-100">
            <div>
                <h1>{{ $title ?? 'Administrasi Perangkat Desa' }}</h1>
                <p class="text-muted">
                    @if($desa_id)
                        Data Riwayat & Legalitas {{ $title ?? 'Perangkat Desa' }}
                    @else
                        Pilih Desa untuk Melihat Detail Administrasi
                    @endif
                </p>
            </div>
            @if($desa_id)
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPersonilModal">
                    <i class="fas fa-plus me-2"></i> Tambah Personil
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
                            @if(isset($kategori) && $kategori == 'bpd')
                                <th class="text-center">Jumlah Anggota BPD</th>
                            @else
                                <th class="text-center">Jumlah Kades</th>
                                <th class="text-center">Jumlah Perangkat</th>
                            @endif
                            <th class="text-center">Total Personil</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($desas as $index => $desa)
                            <tr>
                                <td class="ps-4 text-muted small">{{ $index + 1 }}</td>
                                <td class="fw-bold text-slate-700"> Desa {{ $desa->nama_desa }}</td>
                                @if(isset($kategori) && $kategori == 'bpd')
                                    <td class="text-center">
                                        <span class="badge bg-primary-soft text-primary">{{ $desa->bpd_count }}</span>
                                    </td>
                                    <td class="text-center fw-bold">
                                        {{ $desa->bpd_count }}
                                    </td>
                                @else
                                    <td class="text-center">
                                        <span class="badge bg-primary-soft text-primary">{{ $desa->kades_count }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-slate-100 text-slate-700">{{ $desa->perangkat_count }}</span>
                                    </td>
                                    <td class="text-center fw-bold">
                                        {{ $desa->kades_count + $desa->perangkat_count }}
                                    </td>
                                @endif
                                <td class="text-end pe-4">
                                    <a href="{{ url()->current() }}?desa_id={{ $desa->id }}"
                                        class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        Cek Detail <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="card bg-white border-gray-200 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4">Nama / NIK</th>
                            <th>Jabatan</th>
                            <th>Masa Jabatan</th>
                            <th>Legalitas (SK)</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($personils as $p)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">{{ $p->nama }}</div>
                                    <small class="text-muted">{{ $p->nik }}</small>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $p->jabatan }}</span></td>
                                <td>
                                    <div class="small">
                                        {{ $p->masa_jabatan_mulai ? $p->masa_jabatan_mulai->format('d/m/Y') : '' }}
                                        <i class="fas fa-arrow-right mx-1 text-muted"></i>
                                        {{ $p->masa_jabatan_selesai ? $p->masa_jabatan_selesai->format('d/m/Y') : 'Sekarang' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="small fw-500">No: {{ $p->nomor_sk ?? '-' }}</div>
                                    @if($p->file_sk)
                                        <a href="#" class="btn btn-xs btn-outline-primary mt-1">
                                            <i class="fas fa-file-pdf"></i> Lihat SK
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if($p->is_active)
                                        <span class="badge bg-success-soft text-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger-soft text-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-icon" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Edit Data</a>
                                            </li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-user-minus me-2"></i>
                                                    Nonaktifkan</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-users fa-3x mb-3 text-muted"></i>
                                        <p>Data belum tersedia untuk desa ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Simple Placeholder Modal for Demo -->
    <div class="modal fade" id="addPersonilModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Personil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('kecamatan.pemerintahan.detail.personil.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="kategori" value="{{ $kategori ?? 'perangkat' }}">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NIK (16 Digit)</label>
                                <input type="text" name="nik" class="form-control" maxlength="16" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jabatan</label>
                                <select name="jabatan" class="form-select" required>
                                    @if(($kategori ?? 'perangkat') == 'perangkat')
                                        <option value="Kepala Desa">Kepala Desa</option>
                                        <option value="Sekretaris Desa">Sekretaris Desa</option>
                                        <option value="Kaur Keuangan">Kaur Keuangan</option>
                                        <option value="Kaur Perencanaan">Kaur Perencanaan</option>
                                        <option value="Kaur Umum">Kaur Umum</option>
                                        <option value="Kasi Pemerintahan">Kasi Pemerintahan</option>
                                        <option value="Kasi Kesejahteraan">Kasi Kesejahteraan</option>
                                        <option value="Kasi Pelayanan">Kasi Pelayanan</option>
                                        <option value="Kepala Dusun">Kepala Dusun</option>
                                    @else
                                        <option value="Ketua BPD">Ketua BPD</option>
                                        <option value="Wakil Ketua BPD">Wakil Ketua BPD</option>
                                        <option value="Sekretaris BPD">Sekretaris BPD</option>
                                        <option value="Anggota BPD">Anggota BPD</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor SK</label>
                                <input type="text" name="nomor_sk" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mulai Menjabat</label>
                                <input type="date" name="masa_jabatan_mulai" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Unggah Surat Keputusan (PDF)</label>
                                <input type="file" name="file_sk" class="form-control" accept="application/pdf">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menu-pages.css') }}">
    <style>
        .bg-success-soft {
            background-color: rgba(16, 185, 129, 0.1);
        }

        .bg-danger-soft {
            background-color: rgba(239, 68, 68, 0.1);
        }

        .fw-500 {
            font-weight: 500;
        }
    </style>
@endpush