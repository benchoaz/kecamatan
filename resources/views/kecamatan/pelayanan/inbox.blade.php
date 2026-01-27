@extends('layouts.kecamatan')

@section('title', 'Inbox Pengaduan Masyarakat')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2">
            <div>
                <h1 class="text-slate-900 fw-bold fs-3 mb-1">Inbox Pelayanan</h1>
                <p class="text-slate-400 small mb-0">Daftar pengaduan dan aspirasi masuk dari masyarakat.</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-white border rounded-3 px-3 small fw-bold text-slate-600 shadow-sm">
                    <i class="fas fa-filter me-2"></i> Filter
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden border border-slate-100">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-slate-50/50 border-bottom border-slate-100">
                            <tr>
                                <th class="ps-4 py-3 text-slate-400 text-[11px] fw-bold uppercase tracking-wider">Tanggal</th>
                                <th class="py-3 text-slate-400 text-[11px] fw-bold uppercase tracking-wider">Jenis Layanan</th>
                                <th class="py-3 text-slate-400 text-[11px] fw-bold uppercase tracking-wider">Asal Wilayah</th>
                                <th class="py-3 text-slate-400 text-[11px] fw-bold uppercase tracking-wider">Kontak (WA)</th>
                                <th class="py-3 text-slate-400 text-[11px] fw-bold uppercase tracking-wider">Status</th>
                                <th class="pe-4 py-3 text-end text-slate-400 text-[11px] fw-bold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($complaints as $item)
                                <tr class="transition-all hover:bg-slate-50/50">
                                    <td class="ps-4 py-3">
                                        <div class="fw-semibold text-slate-700 small">{{ $item->created_at->format('d M Y') }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $item->created_at->format('H:i') }} WIB</div>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-[11px] fw-bold px-2 py-1 rounded-pill
                                            {{ $item->jenis_layanan == 'Pengaduan Pelayanan' ? 'bg-rose-50 text-rose-500' :
                                               ($item->jenis_layanan == 'Permohonan Informasi' ? 'bg-blue-50 text-blue-500' : 'bg-emerald-50 text-emerald-500') }}">
                                            {{ strtoupper($item->jenis_layanan) }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-slate-600 small">{{ $item->desa ? $item->desa->nama_desa : ($item->nama_desa_manual ?? 'Umum') }}</span>
                                    </td>
                                    <td class="py-3">
                                        <a href="https://wa.me/62{{ ltrim($item->whatsapp, '0') }}" target="_blank"
                                            class="text-emerald-600 small fw-medium text-decoration-none hover:underline">
                                            <i class="fab fa-whatsapp me-1"></i> +62{{ $item->whatsapp }}
                                        </a>
                                    </td>
                                    <td class="py-3">
                                        @if($item->status == 'Menunggu Klarifikasi')
                                            <span class="text-amber-500 text-[10px] fw-bold border border-amber-100 px-2 py-1 rounded">
                                                <i class="fas fa-clock me-1"></i> ANTRIAN
                                            </span>
                                        @elseif($item->status == 'Selesai')
                                            <span class="text-emerald-500 text-[10px] fw-bold border border-emerald-100 px-2 py-1 rounded">
                                                <i class="fas fa-check-double me-1"></i> SELESAI
                                            </span>
                                        @else
                                            <span class="text-slate-500 text-[10px] fw-bold border border-slate-100 px-2 py-1 rounded">
                                                {{ strtoupper($item->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <a href="{{ route('kecamatan.pelayanan.show', $item->id) }}"
                                            class="btn btn-sm btn-white border border-slate-200 rounded-3 px-3 fw-bold text-slate-600">
                                            Buka
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="py-4 text-slate-300">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <p class="small mb-0">Belum ada laporan masuk.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($complaints->hasPages())
                <div class="card-footer bg-white border-top border-slate-100 py-3 px-4">
                    {{ $complaints->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection