@extends('layouts.kecamatan')

@section('title', 'Pengaturan Profil Aplikasi')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="content-header mb-4">
            <div class="header-title">
                <h1 class="text-slate-900 fw-bold display-6">Pengaturan Pusat</h1>
                <p class="text-slate-500 fs-5 mb-0">Kelola identitas dan branding wilayah secara terpusat.</p>
                <div class="header-accent"></div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-emerald border-0 shadow-sm rounded-4 p-4 mb-4 animate__animated animate__fadeIn">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box icon-box-emerald sm">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-emerald-900">Berhasil!</h6>
                        <p class="mb-0 text-emerald-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-xl-8">
                <div class="card border-0 shadow-premium rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-4 px-4 border-bottom border-light">
                        <div class="d-flex align-items-center gap-2 text-slate-900">
                            <i class="fas fa-cog text-primary"></i>
                            <h5 class="mb-0 fw-bold">Konfigurasi Identitas & Media</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('kecamatan.settings.profile.update') }}" method="POST"
                            enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label text-slate-700 fw-semibold">Nama Aplikasi</label>
                                    <input type="text" name="app_name" value="{{ old('app_name', $profile->app_name) }}"
                                        class="form-control form-control-lg bg-slate-50 border-slate-200 rounded-3"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-slate-700 fw-semibold">Nama Wilayah</label>
                                    <input type="text" name="region_name"
                                        value="{{ old('region_name', $profile->region_name) }}"
                                        class="form-control form-control-lg bg-slate-50 border-slate-200 rounded-3"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-slate-700 fw-semibold">Tingkat Wilayah</label>
                                    <select name="region_level"
                                        class="form-select form-select-lg bg-slate-50 border-slate-200 rounded-3" required>
                                        <option value="desa" {{ $profile->region_level == 'desa' ? 'selected' : '' }}>Desa
                                        </option>
                                        <option value="kecamatan" {{ $profile->region_level == 'kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                                        <option value="kabupaten" {{ $profile->region_level == 'kabupaten' ? 'selected' : '' }}>Kabupaten</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label text-slate-700 fw-semibold">Tagline / Slogan</label>
                                    <input type="text" name="tagline" value="{{ old('tagline', $profile->tagline) }}"
                                        class="form-control form-control-lg bg-slate-50 border-slate-200 rounded-3">
                                </div>

                                <div class="col-md-12 mt-4">
                                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-4">
                                        <div class="row align-items-center">
                                            <div class="col-md-2 text-center border-end border-slate-200">
                                                @if($profile->logo_path)
                                                    <img src="{{ asset('storage/' . $profile->logo_path) }}"
                                                        class="img-fluid rounded-3 shadow-sm mb-3 d-block mx-auto"
                                                        style="max-height: 60px;">
                                                @else
                                                    <div class="bg-white p-3 rounded-3 shadow-sm mb-3 border d-inline-block">
                                                        <i class="fas fa-landmark text-slate-200 fa-2x"></i>
                                                    </div>
                                                @endif
                                                <span class="d-block text-[10px] fw-bold text-slate-400 uppercase">Logo
                                                    Sistem</span>
                                            </div>
                                            <div class="col-md-10 ps-md-4">
                                                <label class="form-label text-slate-700 fw-semibold">Ganti Logo
                                                    Wilayah</label>
                                                <input type="file" name="logo"
                                                    class="form-control bg-white border-slate-200 rounded-3">
                                                <p class="text-[11px] text-slate-400 mt-2 mb-0 italic">Format JPG/PNG,
                                                    maksimal 2MB.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Landing Page Visuals -->
                                <div class="col-md-12 mt-4">
                                    <div class="p-4 border border-teal-100 bg-teal-50 bg-opacity-30 rounded-4">
                                        <div class="d-flex align-items-center gap-2 mb-4">
                                            <i class="fas fa-images text-teal-600"></i>
                                            <h6 class="mb-0 fw-bold text-teal-900 border-bottom border-teal-200 pb-1">Media
                                                Visual Landing Page</h6>
                                        </div>

                                        <div class="row g-4">
                                            <div class="col-md-4">
                                                <label class="form-label text-slate-700 small fw-bold">Visual UMKM</label>
                                                @if($profile->image_umkm)
                                                    <img src="{{ asset('storage/' . $profile->image_umkm) }}"
                                                        class="w-100 rounded-3 shadow-sm mb-2 object-cover"
                                                        style="height: 120px;">
                                                @endif
                                                <input type="file" name="image_umkm"
                                                    class="form-control form-control-sm border-slate-200">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label text-slate-700 small fw-bold">Visual
                                                    Pariwisata</label>
                                                @if($profile->image_pariwisata)
                                                    <img src="{{ asset('storage/' . $profile->image_pariwisata) }}"
                                                        class="w-100 rounded-3 shadow-sm mb-2 object-cover"
                                                        style="height: 120px;">
                                                @endif
                                                <input type="file" name="image_pariwisata"
                                                    class="form-control form-control-sm border-slate-200">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label text-slate-700 small fw-bold">Visual Festival
                                                    Budaya</label>
                                                @if($profile->image_festival)
                                                    <img src="{{ asset('storage/' . $profile->image_festival) }}"
                                                        class="w-100 rounded-3 shadow-sm mb-2 object-cover"
                                                        style="height: 120px;">
                                                @endif
                                                <input type="file" name="image_festival"
                                                    class="form-control form-control-sm border-slate-200">
                                            </div>
                                        </div>
                                        <p class="text-[10px] text-teal-700 mt-3 mb-0">
                                            <i class="fas fa-info-circle me-1"></i> Visual ini ditampilkan pada bagian
                                            "Potensi Wilayah". Rekomendasi 5MB/file.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-5 pt-3 border-top border-light">
                                <button type="submit" class="btn btn-primary btn-lg px-5 rounded-3 fw-bold shadow-sm"
                                    style="background-color: #4f46e5; border-color: #4f46e5; color: white;">
                                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 mt-4 mt-xl-0">
                <div class="alert bg-primary bg-opacity-10 border-0 p-4 rounded-4 shadow-sm mb-4">
                    <h6 class="fw-bold text-primary mb-3">Instruksi Owner Sistem</h6>
                    <p class="text-primary text-opacity-75 small mb-0">
                        Pastikan data Branding Wilayah sudah sesuai dengan SK. Perubahan akan segera berdampak pada seluruh
                        etalase publik (Landing Page & Portal).
                    </p>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-slate-900 mb-3">Audit Log Terakhir</h6>
                        <div class="d-flex align-items-start gap-3">
                            <i class="fas fa-history text-slate-400 mt-1"></i>
                            <div>
                                <p class="small text-slate-600 mb-1">Terakhir diperbarui oleh:</p>
                                <p class="fw-bold text-slate-900 mb-0">
                                    {{ $profile->editor ? $profile->editor->nama_lengkap : 'Sistem' }}
                                </p>
                                <p class="text-[11px] text-slate-400">
                                    {{ $profile->updated_at ? $profile->updated_at->format('d M Y, H:i') : '-' }} WIB
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection