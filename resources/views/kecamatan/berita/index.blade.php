@extends('layouts.kecamatan')

@section('title', 'Manajemen Berita & Informasi')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-slate-800 mb-1">Berita & Informasi</h4>
                <p class="text-slate-500 small mb-0">Kelola publikasi berita untuk landing page publik.</p>
            </div>
            <a href="{{ route('kecamatan.berita.create') }}" class="btn btn-primary px-4 rounded-3 fw-bold shadow-sm">
                <i class="fas fa-plus me-2"></i> Buat Berita Baru
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card border-0 shadow-premium rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-slate-50 border-bottom border-slate-100">
                            <tr>
                                <th class="px-4 py-3 text-slate-500 uppercase small fw-bold" style="width: 50px;">No</th>
                                <th class="px-4 py-3 text-slate-500 uppercase small fw-bold">Berita</th>
                                <th class="px-4 py-3 text-slate-500 uppercase small fw-bold">Kategori</th>
                                <th class="px-4 py-3 text-slate-500 uppercase small fw-bold">Status</th>
                                <th class="px-4 py-3 text-slate-500 uppercase small fw-bold">Penulis</th>
                                <th class="px-4 py-3 text-slate-500 uppercase small fw-bold">Tanggal</th>
                                <th class="px-4 py-3 text-slate-500 uppercase small fw-bold text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-0">
                            @forelse($berita as $item)
                                <tr class="border-bottom border-slate-50">
                                    <td class="px-4 py-3 text-slate-600 small">
                                        {{ ($berita->currentPage() - 1) * $berita->perPage() + $loop->iteration }}</td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                @if($item->thumbnail)
                                                    <img src="{{ asset('storage/' . $item->thumbnail) }}"
                                                        class="rounded-3 object-cover" width="60" height="40" alt="">
                                                @else
                                                    <div class="bg-slate-100 rounded-3 d-flex align-items-center justify-content-center"
                                                        width="60" height="40" style="width: 60px; height: 40px;">
                                                        <i class="fas fa-image text-slate-300"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-bold text-slate-800 line-clamp-1 truncate"
                                                    style="max-width: 250px;">{{ $item->judul }}</div>
                                                <div class="text-[10px] text-slate-400">View:
                                                    {{ number_format($item->view_count) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="badge bg-slate-100 text-slate-600 border border-slate-200 rounded-pill px-3 fw-medium">
                                            {{ $item->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <form action="{{ route('kecamatan.berita.toggle-status', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="border-0 bg-transparent p-0">
                                                @if($item->status === 'published')
                                                    <span
                                                        class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 fw-medium">
                                                        <i class="fas fa-check-circle me-1"></i> Published
                                                    </span>
                                                @else
                                                    <span
                                                        class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 fw-medium">
                                                        <i class="fas fa-clock me-1"></i> Draft
                                                    </span>
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 small">
                                        {{ $item->author->nama_lengkap ?? 'System' }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-500 small">
                                        @if($item->published_at)
                                            {{ $item->published_at->isoFormat('D MMM YYYY') }}
                                        @else
                                            <span class="text-slate-300 italic">Belum tayang</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm rounded-3 shadow-none border-0" type="button"
                                                data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-h text-slate-400"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-premium rounded-4 py-2">
                                                <li>
                                                    <a class="dropdown-item py-2 px-3 small d-flex align-items-center"
                                                        href="{{ route('public.berita.show', $item->slug) }}" target="_blank">
                                                        <i class="fas fa-external-link-alt me-2 text-blue-400"></i> Preview
                                                        Publik
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item py-2 px-3 small d-flex align-items-center"
                                                        href="{{ route('kecamatan.berita.edit', $item->id) }}">
                                                        <i class="fas fa-edit me-2 text-blue-500"></i> Edit Berita
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider border-slate-50">
                                                </li>
                                                <li>
                                                    <form action="{{ route('kecamatan.berita.destroy', $item->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Arsipkan berita ini? Berita tidak akan tampil di publik namun masih tersimpan di database.')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="dropdown-item py-2 px-3 small d-flex align-items-center text-danger">
                                                            <i class="fas fa-archive me-2"></i> Arsipkan
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-5 text-center">
                                        <div class="opacity-20 mb-3">
                                            <i class="fas fa-newspaper fa-3x text-slate-300"></i>
                                        </div>
                                        <h6 class="fw-bold text-slate-400">Belum ada berita</h6>
                                        <p class="text-slate-400 small">Klik tombol 'Buat Berita Baru' untuk mulai menulis.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($berita->hasPages())
                <div class="card-footer bg-white border-top border-slate-50 px-4 py-3">
                    {{ $berita->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection