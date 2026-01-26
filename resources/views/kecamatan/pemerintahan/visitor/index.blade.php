@extends('layouts.kecamatan')

@section('title', 'Buku Tamu Kecamatan')

@section('content')
    <div class="content-header mb-4">
        <div class="header-title">
            <h1 class="text-white">Buku Tamu Kecamatan</h1>
            <p class="text-muted">Registrasi & Pemantauan Pengunjung</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Form Registrasi -->
        <div class="col-md-4">
            <div class="card bg-slate-800 border-slate-700 h-100">
                <div class="card-header border-slate-700 bg-slate-800/50">
                    <h5 class="card-title text-white mb-0">Registrasi Pengunjung</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('kecamatan.pemerintahan.visitor.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-slate-300">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control bg-slate-900 border-slate-700 text-white"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-slate-300">NIK (Opsional)</label>
                            <input type="text" name="nik" class="form-control bg-slate-900 border-slate-700 text-white"
                                maxlength="16">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-slate-300">Asal Desa (Kecamatan)</label>
                            <select name="desa_asal_id" class="form-select bg-slate-900 border-slate-700 text-white">
                                <option value="">-- Luar Kecamatan --</option>
                                @foreach($desas as $desa)
                                    <option value="{{ $desa->id }}">{{ $desa->nama_desa }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-slate-300">Alamat (Jika Luar Kecamatan)</label>
                            <input type="text" name="alamat_luar"
                                class="form-control bg-slate-900 border-slate-700 text-white">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-slate-300">Tujuan Bidang</label>
                            <select name="tujuan_bidang" class="form-select bg-slate-900 border-slate-700 text-white"
                                required>
                                <option value="Pemerintahan">Pemerintahan</option>
                                <option value="Ekbang">Ekbang</option>
                                <option value="Kesra">Kesra</option>
                                <option value="Trantib">Trantib</option>
                                <option value="Camat / Sekcam">Camat / Sekcam</option>
                                <option value="Pelayanan Umum">Pelayanan Umum</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-slate-300">Keperluan</label>
                            <textarea name="keperluan" class="form-control bg-slate-900 border-slate-700 text-white"
                                rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Daftarkan Pengunjung</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Monitoring -->
        <div class="col-md-8">
            <div class="card bg-slate-800 border-slate-700 h-100">
                <div class="card-header border-slate-700 bg-slate-800/50 d-flex justify-content-between align-items-center">
                    <h5 class="card-title text-white mb-0">Antrian & Riwayat Hari Ini</h5>
                    <span class="badge bg-primary">{{ $visitors->where('created_at', '>=', today())->count() }}
                        Pengunjung</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0">
                            <thead>
                                <tr class="border-slate-700">
                                    <th>Nama</th>
                                    <th>Asal</th>
                                    <th>Tujuan</th>
                                    <th>Status</th>
                                    <th>Jam</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="border-slate-700">
                                @forelse($visitors as $visitor)
                                    <tr class="align-middle border-slate-700">
                                        <td>
                                            <div class="fw-bold">{{ $visitor->nama }}</div>
                                            <div class="small text-slate-400">{{ $visitor->keperluan }}</div>
                                        </td>
                                        <td>{{ $visitor->desaAsal->nama_desa ?? $visitor->alamat_luar }}</td>
                                        <td><span class="badge bg-slate-700">{{ $visitor->tujuan_bidang }}</span></td>
                                        <td>
                                            @if($visitor->status == 'menunggu')
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            @elseif($visitor->status == 'dilayani')
                                                <span class="badge bg-info">Dilayani</span>
                                            @else
                                                <span class="badge bg-success">Selesai</span>
                                            @endif
                                        </td>
                                        <td>{{ $visitor->jam_datang->format('H:i') }}</td>
                                        <td>
                                            @if($visitor->status != 'selesai')
                                                <form action="{{ route('kecamatan.pemerintahan.visitor.update', $visitor->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    @if($visitor->status == 'menunggu')
                                                        <input type="hidden" name="status" value="dilayani">
                                                        <button class="btn btn-sm btn-outline-info">Layani</button>
                                                    @else
                                                        <input type="hidden" name="status" value="selesai">
                                                        <button class="btn btn-sm btn-outline-success">Selesai</button>
                                                    @endif
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-slate-500">Belum ada pengunjung hari ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .bg-slate-800 {
            background-color: #1e293b !important;
        }

        .bg-slate-900 {
            background-color: #0f172a !important;
        }

        .border-slate-700 {
            border-color: #334155 !important;
        }

        .text-slate-300 {
            color: #cbd5e1 !important;
        }

        .text-slate-400 {
            color: #94a3b8 !important;
        }

        .text-slate-500 {
            color: #64748b !important;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #0f172a;
            border-color: #3b82f6;
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
        }
    </style>
@endpush