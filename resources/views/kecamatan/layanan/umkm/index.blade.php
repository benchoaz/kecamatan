@extends('layouts.kecamatan')

@section('title', 'Manajemen Etalase UMKM')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-slate-800 mb-1">Etalase UMKM</h4>
                <p class="text-slate-500 small mb-0">Kelola produk UMKM unggulan untuk ditampilkan di landing page.</p>
            </div>
            <a href="{{ route('kecamatan.umkm.create') }}" class="btn btn-primary px-4 rounded-3 fw-bold shadow-sm">
                <i class="fas fa-plus me-2"></i> Tambah UMKM
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card border-0 shadow-premium rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-slate-50 border-bottom border-slate-100">
                            <tr>
                                <th class="px-4 py-3 text-slate-500 uppercase small fw-bold" style="width: 50px;">No</th>
                                <th class="px-4 py-3 text-slate-500 uppercase small fw-bold">UMKM & Produk</th>
                                <th class="px-4 py-3 text-slate-500 uppercase small fw-bold">Kontak WA</th>
                                <th class="px-4 py-3 text-slate-500 uppercase small fw-bold">Status</th>
                                <th class="px-4 py-3 text-slate-500 uppercase small fw-bold text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-0">
                            @forelse($umkm as $item)
                                <tr class="border-bottom border-slate-50">
                                    <td class="px-4 py-3 text-slate-600 small">
                                        {{ ($umkm->currentPage() - 1) * $umkm->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                @if($item->image_path)
                                                    <img src="{{ asset('storage/' . $item->image_path) }}"
                                                        class="rounded-3 object-cover shadow-sm" width="50" height="50" alt="">
                                                @else
                                                    <div class="bg-slate-100 rounded-3 d-flex align-items-center justify-content-center"
                                                        style="width: 50px; height: 50px;">
                                                        <i class="fas fa-store text-slate-300"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-bold text-slate-800">{{ $item->name }}</div>
                                                <div class="text-slate-500 small">{{ $item->product }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="https://wa.me/{{ $item->contact_wa }}" target="_blank" class="text-success text-decoration-none small fw-bold">
                                            <i class="fab fa-whatsapp me-1"></i> {{ $item->contact_wa }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($item->is_active)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 fw-medium">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-slate-100 text-slate-400 border border-slate-200 rounded-pill px-3 fw-medium">
                                                Non-aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="{{ route('kecamatan.umkm.edit', $item->id) }}"
                                                class="btn btn-sm btn-light text-amber-500 shadow-sm border border-slate-200">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('kecamatan.umkm.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus data UMKM ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light text-rose-500 shadow-sm border border-slate-200">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-5 text-center">
                                        <div class="opacity-20 mb-3">
                                            <i class="fas fa-store fa-3x text-slate-300"></i>
                                        </div>
                                        <h6 class="fw-bold text-slate-400">Belum ada data UMKM</h6>
                                        <p class="text-slate-400 small">Klik tombol 'Tambah UMKM' untuk mulai mengisi.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($umkm->hasPages())
                <div class="card-footer bg-white border-top border-slate-50 px-4 py-3">
                    {{ $umkm->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
