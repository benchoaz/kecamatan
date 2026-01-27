@extends(auth()->user()->desa_id ? 'layouts.desa' : 'layouts.kecamatan')

@section('title', 'Menu Pemerintahan')

@section('content')
    <div class="content-header mb-4">
        <div class="header-title">
            <h1 class="text-slate-900 fw-bold display-6">Seksi Pemerintahan</h1>
            <p class="text-slate-500 fs-5 mb-0">Buku Induk & Tata Kelola Administrasi Desa</p>
        </div>
        <div class="alert border-0 rounded-4 d-flex align-items-center gap-4 p-4 mt-4 shadow-sm"
            style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-left: 5px solid #0ea5e9 !important;">
            <div class="d-flex align-items-center justify-content-center shadow-sm"
                style="width: 60px; height: 60px; background: white; border-radius: 18px; color: #0ea5e9;">
                <i class="fas fa-circle-info fa-2x"></i>
            </div>
            <div>
                <h5 class="fw-bold text-slate-900 mb-1">Pusat Navigasi Administrasi</h5>
                <p class="text-slate-600 mb-0 small">
                    Gunakan modul di bawah untuk memantau kelengkapan data personil, inventaris, dan kepatuhan dokumen
                    digital dari 17 desa sewilayah kecamatan.
                </p>
            </div>
        </div>
    </div>

    <div class="section-title mb-4 d-flex align-items-center gap-3 mt-5">
        <h4 class="fw-bold text-slate-800 mb-0">Modul Administrasi Sektoral (A-H)</h4>
        <div class="flex-grow-1 border-bottom border-slate-200"></div>
    </div>

    <div class="row g-4 mb-5">
        @foreach($pemerintahanMenus as $key => $menu)
            <div class="col-md-4 col-lg-3">
                <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#' }}" class="text-decoration-none group">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden bg-white hover-up"
                        style="transition: all 0.3s ease; border: 1px solid #e2e8f0 !important;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div class="bg-light text-slate-800 rounded-4 p-3 fs-4 shadow-sm">
                                    <i class="fas {{ $menu['icon'] }}"></i>
                                </div>
                                <div class="bg-light text-muted rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">
                                    MODUL {{ $key }}
                                </div>
                            </div>
                            <h5 class="fw-bold text-slate-900 mb-2">{{ $menu['title'] }}</h5>
                            <p class="text-muted small mb-0">{{ $menu['desc'] }}</p>
                        </div>
                        <div class="card-footer bg-light border-0 p-3 d-flex justify-content-between align-items-center">
                            <span class="text-muted fw-bold small text-uppercase">Kelola Data</span>
                            <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                style="width: 28px; height: 28px;">
                                <i class="fas fa-chevron-right text-dark small"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach

        <!-- Export Audit Package -->
        <div class="col-md-4 col-lg-3">
            <a href="{{ auth()->user()->desa_id ? route('desa.pemerintahan.export') : route('kecamatan.pemerintahan.export') }}"
                class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden"
                    style="transition: all 0.3s ease; border: 2px dashed #f59e0b !important; background: #fffcf0;">
                    <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center text-center">
                        <div class="bg-amber-100 text-amber-600 rounded-circle p-4 mb-3">
                            <i class="fas fa-box-archive fa-3x"></i>
                        </div>
                        <h5 class="fw-bold text-slate-800 mb-2">Paket Audit Desa</h5>
                        <p class="text-slate-500 small mb-0">Export SK & Dokumen Desa (PDF ZIP)</p>
                    </div>
                    <div class="card-footer border-0 p-3 d-flex justify-content-between align-items-center"
                        style="background: #f59e0b;">
                        <span class="text-white fw-bold small uppercase">Unduh Paket Audit</span>
                        <i class="fas fa-download text-white"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="section-title d-flex align-items-center gap-3 mt-5 mb-4">
        <h4 class="fw-bold text-slate-800 mb-0">Status Laporan Terakhir</h4>
        <div class="flex-grow-1 border-bottom border-slate-200"></div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-slate-50 border-bottom border-slate-200">
                    <tr class="text-slate-500 small fw-bold">
                        <th class="ps-4 py-3" style="width: 80px;">NO</th>
                        <th class="py-3">BIDANG / ASPEK</th>
                        <th class="py-3">STATUS REFERENSI</th>
                        <th class="text-end pe-4 py-3">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSubmissions as $recent)
                        <tr>
                            <td class="ps-4">
                                <div class="bg-slate-100 text-slate-600 rounded-pill d-flex align-items-center justify-content-center fw-bold"
                                    style="width: 32px; height: 32px; font-size: 0.8rem;">
                                    {{ $loop->iteration }}
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-slate-800">{{ $recent->menu->nama_menu }}</div>
                                <div class="small text-slate-500">{{ $recent->aspek->nama_aspek }}</div>
                            </td>
                            <td>
                                @php
                                    $sStyle = [
                                        'draft' => 'bg-slate-100 text-slate-600 border-slate-200',
                                        'submitted' => 'bg-sky-100 text-sky-700 border-sky-200',
                                        'returned' => 'bg-amber-100 text-amber-700 border-amber-200',
                                        'reviewed' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                        'approved' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                    ][$recent->status] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                                @endphp
                                <span class="badge border px-3 py-2 rounded-pill small {{ $sStyle }}">
                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                    {{ strtoupper($recent->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ auth()->user()->desa_id ? route('desa.submissions.edit', $recent->id) : route('kecamatan.verifikasi.show', $recent->uuid) }}"
                                    class="btn btn-icon btn-light rounded-circle shadow-sm">
                                    <i class="fas fa-arrow-right text-indigo-600"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="text-slate-400 mb-2">
                                    <i class="fas fa-clipboard-question fa-3x"></i>
                                </div>
                                <p class="text-slate-500">Belum ada aktivitas laporan baru ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 p-4 rounded-4 border border-info-subtle bg-info-subtle bg-opacity-10">
        <div class="d-flex gap-3 align-items-center">
            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center"
                style="width: 32px; height: 32px; min-width: 32px;">
                <i class="fas fa-info-circle small"></i>
            </div>
            <p class="mb-0 text-slate-700 small" style="line-height: 1.5;">
                <strong>Informasi Tata Kelola:</strong> Seluruh modul di atas diverifikasi secara berkala oleh Seksi
                Pemerintahan Kecamatan sebagai data referensi pembinaan kewilayahan. Pastikan seluruh dokumen legal telah
                diarsipkan dengan format PDF.
            </p>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .shadow-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -7px rgba(0, 0, 0, 0.05) !important;
        }

        /* Premium Background Colors */
        .bg-emerald-50 {
            background-color: #ecfdf5;
        }

        .bg-emerald-100 {
            background-color: #d1fae5;
        }

        .bg-emerald-500 {
            background-color: #10b981;
        }

        .text-emerald-700 {
            color: #047857;
        }

        .bg-rose-50 {
            background-color: #fff1f2;
        }

        .bg-rose-100 {
            background-color: #ffe4e6;
        }

        .bg-rose-500 {
            background-color: #f43f5e;
        }

        .text-rose-700 {
            color: #be123c;
        }

        .bg-amber-50 {
            background-color: #fffbeb;
        }

        .bg-amber-100 {
            background-color: #fef3c7;
        }

        .bg-amber-500 {
            background-color: #f59e0b;
        }

        .text-amber-700 {
            color: #b45309;
        }

        .bg-indigo-50 {
            background-color: #eef2ff;
        }

        .bg-indigo-100 {
            background-color: #e0e7ff;
        }

        .text-indigo-600 {
            color: #4f46e5;
        }

        .text-indigo-700 {
            color: #4338ca;
        }

        .text-indigo-400 {
            color: #818cf8;
        }

        .bg-sky-100 {
            background-color: #e0f2fe;
        }

        .text-sky-700 {
            color: #0369a1;
        }

        .bg-slate-50 {
            background-color: #f8fafc;
        }

        .bg-slate-100 {
            background-color: #f1f5f9;
        }

        .text-slate-400 {
            color: #94a3b8;
        }

        .text-slate-500 {
            color: #64748b;
        }

        .text-slate-600 {
            color: #475569;
        }

        .text-slate-700 {
            color: #334155;
        }

        .text-slate-800 {
            color: #1e293b;
        }

        .text-slate-900 {
            color: #0f172a;
        }

        .border-slate-200 {
            border-color: #e2e8f0 !important;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .btn-icon:hover {
            transform: scale(1.1);
            transition: all 0.2s ease;
        }
    </style>
@endpush