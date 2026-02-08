@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-50 relative overflow-hidden font-sans">
        <!-- Background Decorations -->
        <div class="fixed top-0 left-0 w-[500px] h-[500px] bg-teal-100/40 rounded-full blur-[100px] -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
        <div class="fixed bottom-0 right-0 w-[500px] h-[500px] bg-indigo-100/40 rounded-full blur-[100px] translate-x-1/2 translate-y-1/2 pointer-events-none"></div>

        <div class="container mx-auto px-6 py-12 relative z-10">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
                <div>
                    <div class="inline-flex items-center gap-2 bg-white/80 backdrop-blur border border-slate-200 px-4 py-1.5 rounded-full mb-4 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Dashboard UMKM</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-black text-slate-800 mb-2 tracking-tight">Kelola Etalase</h1>
                    <p class="text-slate-500 font-medium">Selamat datang di panel kendali <span class="text-teal-600 font-bold">{{ $umkm->nama_usaha }}</span></p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('umkm_rakyat.show', $umkm->slug) }}" target="_blank"
                        class="bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 font-bold px-6 py-3 rounded-2xl transition-all flex items-center gap-2 shadow-sm hover:shadow-md">
                        <i class="fas fa-external-link-alt text-slate-400"></i>
                        <span class="text-xs uppercase tracking-widest">Lihat Toko</span>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Left: Add Product Form -->
                <div class="lg:col-span-4">
                    <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] p-8 shadow-[0_20px_50px_-12px_rgba(0,0,0,0.1)] border border-white/50 sticky top-24">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-10 h-10 rounded-xl bg-teal-100 flex items-center justify-center text-teal-600">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <h2 class="text-lg font-black text-slate-800">Tambah Produk Baru</h2>
                        </div>

                        <form action="{{ route('umkm_rakyat.product.store', $umkm->manage_token) }}" method="POST"
                            enctype="multipart/form-data" class="space-y-5">
                            @csrf
                            <div class="space-y-2 group">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 group-focus-within:text-teal-500 transition-colors">Nama Produk</label>
                                <input type="text" name="nama_produk" required placeholder="Contoh: Keripik Pisang Original"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all outline-none">
                            </div>

                            <div class="space-y-2 group">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 group-focus-within:text-teal-500 transition-colors">Harga (Rp)</label>
                                <div class="relative">
                                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">Rp</span>
                                    <input type="number" name="harga" required placeholder="15000"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-5 py-4 text-sm font-bold text-slate-700 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all outline-none">
                                </div>
                            </div>

                            <div class="space-y-2 group">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 group-focus-within:text-teal-500 transition-colors">Deskripsi</label>
                                <textarea name="deskripsi" rows="3" placeholder="Jelaskan keunggulan produk Anda..."
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all outline-none resize-none"></textarea>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Foto Produk</label>
                                <input type="file" name="foto_produk" class="hidden" id="foto_produk" accept="image/*">
                                <label for="foto_produk"
                                    class="relative group/upload flex flex-col items-center justify-center w-full h-40 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-300 cursor-pointer hover:bg-teal-50 hover:border-teal-300 transition-all overflow-hidden">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 relative z-10 transition-transform group-hover/upload:scale-110">
                                        <i class="fas fa-cloud-upload-alt text-slate-400 text-3xl mb-3 group-hover/upload:text-teal-500 transition-colors"></i>
                                        <p class="text-[10px] font-black text-slate-400 uppercase group-hover/upload:text-teal-600">Klik untuk upload</p>
                                    </div>
                                    <div class="absolute inset-0 bg-teal-500/5 opacity-0 group-hover/upload:opacity-100 transition-opacity"></div>
                                </label>
                            </div>

                            <button type="submit"
                                class="w-full bg-slate-900 hover:bg-slate-800 text-white font-black py-4 rounded-2xl shadow-xl shadow-slate-900/20 active:scale-95 transition-all flex items-center justify-center gap-2 group/btn">
                                <i class="fas fa-plus-circle group-hover/btn:rotate-90 transition-transform"></i>
                                <span>Tambah Produk</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right: Current Products -->
                <div class="lg:col-span-8">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-black text-slate-800">Koleksi Produk</h2>
                            <p class="text-slate-500 text-sm font-medium">Kelola stok dan tampilan produk Anda</p>
                        </div>
                        <span class="bg-white border border-slate-200 text-slate-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-sm">
                            Total: {{ count($products) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($products as $product)
                            <div class="group bg-white rounded-[2rem] overflow-hidden shadow-lg shadow-slate-200/50 border border-slate-100 flex p-3 gap-4 hover:border-teal-200 transition-all hover:-translate-y-1">
                                <!-- Image -->
                                <div class="w-28 h-28 rounded-2xl overflow-hidden bg-slate-100 shrink-0 border border-slate-100 relative">
                                    @if($product->foto_produk)
                                        <img src="{{ asset('storage/' . $product->foto_produk) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <i class="fas fa-box-open text-2xl opacity-50"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1 min-w-0 py-1 flex flex-col">
                                    <div class="flex justify-between items-start">
                                        <h3 class="font-black text-slate-800 text-lg truncate pr-2">{{ $product->nama_produk }}</h3>
                                        <div class="dropdown dropdown-end">
                                            <label tabindex="0" class="btn btn-ghost btn-xs btn-circle text-slate-400">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </label>
                                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-xl bg-white rounded-xl w-40 border border-slate-100">
                                                <li>
                                                     <form action="{{ route('umkm_rakyat.product.delete', [$umkm->manage_token, $product->id]) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-rose-500 hover:bg-rose-50 font-bold text-xs"><i class="fas fa-trash-alt mr-2"></i> Hapus</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <p class="text-[11px] font-black text-teal-600 uppercase tracking-widest mb-1">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                                    <p class="text-xs text-slate-400 line-clamp-2 leading-relaxed mb-auto">{{ $product->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                                    
                                    <div class="flex items-center gap-2 mt-3 pt-3 border-t border-slate-50">
                                        <span class="text-[9px] font-bold text-slate-300 uppercase">Status: Aktif</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-16 text-center">
                                <div class="bg-white rounded-[3rem] border-2 border-dashed border-slate-200 p-12 group hover:border-teal-200 transition-colors">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300 group-hover:scale-110 group-hover:text-teal-400 transition-all duration-300">
                                        <i class="fas fa-box-open text-3xl"></i>
                                    </div>
                                    <h3 class="text-slate-800 font-black text-lg mb-2">Belum Ada Produk</h3>
                                    <p class="text-slate-500 text-sm font-medium mb-8">Mulai tambahkan produk unggulan Anda sekarang.</p>
                                    <button onclick="document.querySelector('input[name=nama_produk]').focus()" class="inline-flex items-center gap-2 bg-teal-50 text-teal-700 px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-teal-100 transition-colors">
                                        <i class="fas fa-arrow-left"></i> Tambah Produk Di Samping
                                    </button>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
             <!-- Secret URL Warning -->
            <div class="mt-12 max-w-4xl mx-auto">
                <div class="bg-amber-50/80 backdrop-blur rounded-2xl border border-amber-100 p-6 flex flex-col md:flex-row items-center gap-6 text-center md:text-left">
                    <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center text-xl shrink-0">
                        <i class="fas fa-key"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-amber-800 uppercase tracking-widest mb-1">Penting: Simpan Link Ini!</h4>
                        <p class="text-xs text-amber-700 font-medium leading-relaxed">
                            Link halaman ini adalah kunci akses Anda. Simpan (Bookmark) halaman ini agar Anda bisa kembali mengelola toko tanpa perlu login ulang. Jangan bagikan link ini ke orang lain.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection