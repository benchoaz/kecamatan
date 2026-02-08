@extends('layouts.umkm')

@section('page_title', 'Profil Usaha')

@section('content')
    <div class="max-w-4xl">
        @if(session('success'))
            <div
                class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3">
                <i class="fas fa-check-circle text-emerald-500"></i>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('umkm_rakyat.settings.update', $umkm->manage_token) }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <div class="bg-white rounded-[3rem] shadow-xl shadow-slate-200/50 border border-slate-50 overflow-hidden mb-8">
                <div class="p-8 md:p-12 border-b border-slate-50">
                    <h3 class="text-xl font-black text-slate-800 mb-2">Informasi Identitas</h3>
                    <p class="text-sm text-slate-500 font-medium">Data ini akan ditampilkan di etalase publik Toko Anda.</p>
                </div>

                <div class="p-8 md:p-12 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nama
                                Usaha/Toko</label>
                            <input type="text" name="nama_usaha" value="{{ $umkm->nama_usaha }}" required
                                class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-6 py-4 text-sm font-semibold text-slate-700 focus:bg-white focus:border-sky-500/20 focus:ring-4 focus:ring-sky-500/10 transition-all outline-none">
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nama
                                Pemilik</label>
                            <input type="text" name="nama_pemilik" value="{{ $umkm->nama_pemilik }}" required
                                class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-6 py-4 text-sm font-semibold text-slate-700 focus:bg-white focus:border-sky-500/20 focus:ring-4 focus:ring-sky-500/10 transition-all outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">WhatsApp
                                (Order)</label>
                            <input type="text" name="no_wa" value="{{ $umkm->no_wa }}" required
                                class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-6 py-4 text-sm font-semibold text-slate-700 focus:bg-white focus:border-sky-500/20 focus:ring-4 focus:ring-sky-500/10 transition-all outline-none">
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Desa</label>
                            <select name="desa" required
                                class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-6 py-4 text-sm font-semibold text-slate-700 focus:bg-white focus:border-sky-500/20 focus:ring-4 focus:ring-sky-500/10 transition-all outline-none appearance-none">
                                @foreach($desas as $desa)
                                    <option value="{{ $desa->nama_desa }}" {{ $umkm->desa == $desa->nama_desa ? 'selected' : '' }}>{{ $desa->nama_desa }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Jenis
                            Usaha</label>
                        <input type="text" name="jenis_usaha" value="{{ $umkm->jenis_usaha }}" required
                            placeholder="Contoh: Kuliner / Kerajinan"
                            class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-6 py-4 text-sm font-semibold text-slate-700 focus:bg-white focus:border-sky-500/20 focus:ring-4 focus:ring-sky-500/10 transition-all outline-none">
                    </div>

                    <div>
                        <label
                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Deskripsi
                            Toko</label>
                        <textarea name="deskripsi" rows="4"
                            class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-6 py-4 text-sm font-semibold text-slate-700 focus:bg-white focus:border-sky-500/20 focus:ring-4 focus:ring-sky-500/10 transition-all outline-none">{{ $umkm->deskripsi }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[3rem] shadow-xl shadow-slate-200/50 border border-slate-50 overflow-hidden mb-12">
                <div class="p-8 md:p-12 border-b border-slate-50">
                    <h3 class="text-xl font-black text-slate-800 mb-2">Foto Toko</h3>
                    <p class="text-sm text-slate-500 font-medium">Foto ini akan muncul sebagai sampul di direktori UMKM.</p>
                </div>

                <div class="p-8 md:p-12">
                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        <div
                            class="w-48 h-48 rounded-[2rem] overflow-hidden bg-slate-100 border-4 border-white shadow-lg flex-shrink-0">
                            @if($umkm->foto_usaha)
                                <img src="{{ asset('storage/' . $umkm->foto_usaha) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-200 text-4xl">
                                    <i class="fas fa-store"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <label
                                class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 px-1">Ganti
                                Foto Sampul</label>
                            <input type="file" name="foto_usaha" accept="image/*"
                                class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-sky-50 file:text-sky-600 hover:file:bg-sky-100 transition-all">
                            <p class="text-[10px] text-slate-400 mt-4 leading-relaxed px-1">Direkomendasikan ukuran kotak
                                (1:1) dengan resolusi minimal 800x800 pixel agar terlihat tajam.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('umkm_rakyat.manage', $umkm->manage_token) }}"
                    class="px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest text-slate-400 hover:text-slate-600 transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="bg-seller-primary text-white font-black px-12 py-4 rounded-2xl shadow-lg shadow-sky-500/20 hover:scale-[1.02] active:scale-95 transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection