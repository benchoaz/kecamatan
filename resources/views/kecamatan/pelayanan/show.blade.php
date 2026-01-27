@extends('layouts.kecamatan')

@section('title', 'Detail Pengaduan #' . $complaint->uuid)

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="mb-4">
            <a href="{{ route('kecamatan.pelayanan.inbox') }}" class="btn btn-link text-slate-500 text-decoration-none p-0">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Inbox
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-emerald border-0 shadow-sm rounded-4 p-3 mb-4">
                <p class="mb-0 text-emerald-700 small fw-medium"><i class="fas fa-check-circle me-1"></i>
                    {{ session('success') }}</p>
            </div>
        @endif

        <div class="row">
            <!-- Complaint Content -->
            <div class="col-xl-8">
                <div class="card border-0 shadow-premium rounded-4 overflow-hidden mb-4 border border-slate-100">
                    <div class="card-header bg-white py-4 px-4 border-bottom border-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box icon-box-primary xs">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold fs-6">Dokumen Pengaduan</h5>
                                    <p class="text-[10px] text-slate-400 mb-0 uppercase tracking-wider">UUID:
                                        {{ $complaint->uuid }}</p>
                                </div>
                            </div>
                            <span class="text-slate-400 small">
                                {{ $complaint->created_at->format('d M Y, H:i') }} WIB
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4 mb-5">
                            <div class="col-md-6 col-lg-3">
                                <label
                                    class="text-[10px] text-slate-400 uppercase fw-bold tracking-wider mb-1 d-block">Jenis
                                    Layanan</label>
                                <p class="fw-bold text-slate-800 mb-0 small">{{ $complaint->jenis_layanan }}</p>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label class="text-[10px] text-slate-400 uppercase fw-bold tracking-wider mb-1 d-block">Asal
                                    Wilayah</label>
                                <p class="fw-bold text-slate-800 mb-0 small">
                                    {{ $complaint->desa ? $complaint->desa->nama_desa : ($complaint->nama_desa_manual ?? 'Umum') }}
                                </p>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label
                                    class="text-[10px] text-slate-400 uppercase fw-bold tracking-wider mb-1 d-block">Kontak
                                    Pelapor</label>
                                <a href="https://wa.me/62{{ ltrim($complaint->whatsapp, '0') }}" target="_blank"
                                    class="text-emerald-600 fw-bold text-decoration-none small">
                                    <i class="fab fa-whatsapp me-1"></i> +62{{ $complaint->whatsapp }}
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label
                                    class="text-[10px] text-slate-400 uppercase fw-bold tracking-wider mb-1 d-block">Pernyataan
                                    Itikad Baik</label>
                                @if($complaint->is_agreed)
                                    <span
                                        class="text-emerald-500 text-[10px] fw-bold border border-emerald-100 px-2 py-0.5 rounded">TERECORD</span>
                                @else
                                    <span
                                        class="text-rose-400 text-[10px] fw-bold border border-rose-100 px-2 py-0.5 rounded">TIDAK
                                        ADA</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="text-[10px] text-slate-400 uppercase fw-bold tracking-wider mb-2 d-block">Uraian /
                                Aspirasi Masyarakat</label>
                            <div
                                class="p-4 bg-slate-50 border border-slate-100 rounded-4 text-slate-700 leading-relaxed fs-6">
                                {{ $complaint->uraian }}
                            </div>
                        </div>

                        @if($complaint->file_path_1 || $complaint->file_path_2)
                            <div class="mb-0">
                                <label class="text-[10px] text-slate-400 uppercase fw-bold tracking-wider mb-3 d-block">Foto /
                                    Lampiran Pendukung</label>
                                <div class="d-flex gap-3">
                                    @if($complaint->file_path_1)
                                        <a href="{{ asset('storage/' . $complaint->file_path_1) }}" target="_blank"
                                            class="attachment-preview shadow-sm rounded-4 border border-slate-200 overflow-hidden">
                                            <img src="{{ asset('storage/' . $complaint->file_path_1) }}"
                                                class="object-cover w-100 h-100">
                                        </a>
                                    @endif
                                    @if($complaint->file_path_2)
                                        <a href="{{ asset('storage/' . $complaint->file_path_2) }}" target="_blank"
                                            class="attachment-preview shadow-sm rounded-4 border border-slate-200 overflow-hidden">
                                            <img src="{{ asset('storage/' . $complaint->file_path_2) }}"
                                                class="object-cover w-100 h-100">
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if($complaint->public_response)
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden border border-emerald-100 bg-emerald-50/10">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <i class="fas fa-comment-dots text-emerald-500"></i>
                                <h6 class="mb-0 fw-bold text-emerald-900 small">Respon Publik (Yang Dilihat Masyarakat)</h6>
                            </div>
                            <p class="text-slate-700 mb-0 small leading-relaxed">{{ $complaint->public_response }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Follow-up Sidebar -->
            <div class="col-xl-4">
                <div class="card border-0 shadow-premium rounded-4 overflow-hidden mb-4 border border-slate-100">
                    <div class="card-header bg-white py-3 px-4 border-bottom border-light">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-pen-nib text-primary"></i>
                            <h6 class="mb-0 fw-bold fs-6">Form Tindak Lanjut</h6>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('kecamatan.pelayanan.update-status', $complaint->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-slate-700">Status Laporan</label>
                                <select name="status" class="form-select bg-slate-50 border-slate-200 rounded-3 small"
                                    required>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ $complaint->status == $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-slate-700">Tanggapan Untuk Publik</label>
                                <textarea name="public_response"
                                    class="form-control bg-slate-50 border-slate-200 rounded-3 h-24 small"
                                    placeholder="Tuliskan jawaban yang akan tampil di sisi publik/masyarakat...">{{ old('public_response', $complaint->public_response) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-slate-700">Catatan Internal Petugas</label>
                                <textarea name="internal_notes"
                                    class="form-control bg-slate-50 border-slate-200 rounded-3 h-24 small"
                                    placeholder="Catatan koordinasi internal (tidak terlihat publik)...">{{ old('internal_notes', $complaint->internal_notes) }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-3 fw-bold shadow-sm py-2">
                                Simpan Tindak Lanjut
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden border border-slate-100">
                    <div class="card-body p-4 text-center">
                        <div
                            class="w-12 h-12 bg-slate-100 rounded-circle d-flex align-items-center justify-center text-slate-400 mx-auto mb-3">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <p class="text-[10px] text-slate-400 uppercase fw-bold tracking-wider mb-1">Dikelola Oleh</p>
                        <p class="fw-bold text-slate-800 mb-1 small">
                            {{ $complaint->handler ? $complaint->handler->name : 'Belum Diproses' }}
                        </p>
                        @if($complaint->handled_at)
                            <p class="text-[10px] text-slate-400 mb-0">
                                Update: {{ $complaint->handled_at->format('d M Y, H:i') }} WIB</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .attachment-preview {
            width: 100px;
            height: 100px;
            display: block;
            transition: transform 0.2s;
        }

        .attachment-preview:hover {
            transform: scale(1.05);
        }
    </style>
@endsection