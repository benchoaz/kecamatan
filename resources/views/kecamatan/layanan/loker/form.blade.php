@extends('layouts.kecamatan')

@php
    $isEdit = isset($loker);
    $title = $isEdit ? 'Ubah Data Lowongan' : 'Tambah Lowongan Baru';
@endphp

@section('title', $title)

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="mb-4">
            <a href="{{ route('kecamatan.loker.index') }}"
                class="btn btn-link text-slate-500 text-decoration-none p-0 small fw-bold">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-premium rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom border-light">
                        <h5 class="mb-0 fw-bold fs-6">{{ $title }}</h5>
                    </div>
                    <form
                        action="{{ $isEdit ? route('kecamatan.loker.update', $loker->id) : route('kecamatan.loker.store') }}"
                        method="POST">
                        @csrf
                        @if($isEdit) @method('PUT') @endif

                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label class="form-label small fw-bold text-slate-700">Judul/Posisi Lowongan</label>
                                    <input type="text" name="title"
                                        class="form-control bg-slate-50 border-slate-200 @error('title') is-invalid @enderror"
                                        placeholder="Contoh: Admin Gudang (Laki-laki)"
                                        value="{{ old('title', $loker->title ?? '') }}" required>
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label small fw-bold text-slate-700">Nama Perusahaan/Usaha</label>
                                    <input type="text" name="company_name"
                                        class="form-control bg-slate-50 border-slate-200 @error('company_name') is-invalid @enderror"
                                        placeholder="Contoh: PT. Sumber Makmur"
                                        value="{{ old('company_name', $loker->company_name ?? '') }}" required>
                                    @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label small fw-bold text-slate-700">WhatsApp (Format: 62xx)</label>
                                    <input type="text" name="contact_wa"
                                        class="form-control bg-slate-50 border-slate-200 @error('contact_wa') is-invalid @enderror"
                                        placeholder="Contoh: 628123456789"
                                        value="{{ old('contact_wa', $loker->contact_wa ?? '') }}" required>
                                    @error('contact_wa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label small fw-bold text-slate-700">Deskripsi & Syarat</label>
                                    <textarea name="description" rows="5"
                                        class="form-control bg-slate-50 border-slate-200 @error('description') is-invalid @enderror"
                                        placeholder="Tuliskan detail lowongan dan persyaratan di sini..."
                                        required>{{ old('description', $loker->description ?? '') }}</textarea>
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-0">
                                    <label class="form-label small fw-bold text-slate-700">Status Publikasi</label>
                                    <select name="is_active" class="form-select bg-slate-50 border-slate-200">
                                        <option value="1" {{ old('is_active', $loker->is_active ?? 1) == 1 ? 'selected' : '' }}>Aktif (Tampil)</option>
                                        <option value="0" {{ old('is_active', $loker->is_active ?? 1) == 0 ? 'selected' : '' }}>Non-aktif (Sembunyikan)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-slate-50 border-0 p-4 text-end">
                            <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 fw-bold shadow-sm">
                                <i class="fas fa-save me-2"></i> {{ $isEdit ? 'Perbarui Lowongan' : 'Simpan Lowongan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection