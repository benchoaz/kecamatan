<?php

namespace App\Http\Controllers;

use App\Models\PersonilDesa;
use App\Models\DokumenDesa;
use App\Models\LembagaDesa;
use App\Models\PengunjungKecamatan;
use App\Models\Desa;
use Illuminate\Http\Request;
use PhpZip\ZipFile;

class PemerintahanDetailController extends Controller
{
    public function exportAudit()
    {
        $user = auth()->user();
        $desa = $user->desa;
        abort_unless($desa, 404);

        $zipFile = new ZipFile();
        $zipName = "Paket_Audit_" . str_replace(' ', '_', $desa->nama_desa) . "_" . date('Ymd') . ".zip";

        // 1. Perangkat & BPD SK
        $personils = PersonilDesa::where('desa_id', $desa->id)->whereNotNull('file_sk')->get();
        foreach ($personils as $p) {
            $fullPath = storage_path('app/local/' . $p->file_sk);
            if (file_exists($fullPath)) {
                $zipFile->addFile($fullPath, "A_B_Struktur_Organisasi/" . basename($p->file_sk));
            }
        }

        // 2. Lembaga SK
        $lembagas = LembagaDesa::where('desa_id', $desa->id)->whereNotNull('file_sk')->get();
        foreach ($lembagas as $l) {
            $fullPath = storage_path('app/local/' . $l->file_sk);
            if (file_exists($fullPath)) {
                $zipFile->addFile($fullPath, "C_Lembaga_Desa/" . basename($l->file_sk));
            }
        }

        // 3. Dokumen Inti & Laporan
        $dokumens = DokumenDesa::where('desa_id', $desa->id)->get();
        foreach ($dokumens as $d) {
            $fullPath = storage_path('app/local/' . $d->file_path);
            if (file_exists($fullPath)) {
                $folder = in_array($d->tipe_dokumen, ['LKPJ', 'LPPD']) ? "E_Laporan_Tahunan/" : "G_Dokumen_Inti/";
                $zipFile->addFile($fullPath, $folder . basename($d->file_path));
            }
        }

        // 4. Perencanaan (Musrenbang BA)
        $perencanaans = \App\Models\PerencanaanDesa::where('desa_id', $desa->id)->whereNotNull('file_ba')->get();
        foreach ($perencanaans as $pr) {
            $fullPath = storage_path('app/local/' . $pr->file_ba);
            if (file_exists($fullPath)) {
                $zipFile->addFile($fullPath, "D_Perencanaan/" . basename($pr->file_ba));
            }
        }

        $zipFile->saveAsFile(storage_path('app/temp/' . $zipName));
        $zipFile->close();

        return response()->download(storage_path('app/temp/' . $zipName))->deleteFileAfterSend(true);
    }
    public function personilIndex()
    {
        $user = auth()->user();
        $desa_id = $user->desa_id ?? request('desa_id');

        $personils = [];
        $desas = [];

        if ($desa_id) {
            $personils = PersonilDesa::where('desa_id', $desa_id)
                ->where('kategori', 'perangkat')
                ->orderBy('is_active', 'desc')
                ->orderBy('jabatan')
                ->get();
        } else {
            $desas = Desa::withCount([
                'personil as kades_count' => function ($query) {
                    $query->where('kategori', 'perangkat')->where('jabatan', 'like', '%Kepala Desa%');
                },
                'personil as perangkat_count' => function ($query) {
                    $query->where('kategori', 'perangkat')->where('jabatan', 'not like', '%Kepala Desa%');
                }
            ])->orderBy('nama_desa')->get();
        }

        return view('kecamatan.pemerintahan.personil.index', compact('personils', 'desa_id', 'desas'));
    }

    public function bpdIndex()
    {
        $user = auth()->user();
        $desa_id = $user->desa_id ?? request('desa_id');

        $personils = [];
        $desas = [];

        if ($desa_id) {
            $personils = PersonilDesa::where('desa_id', $desa_id)
                ->where('kategori', 'bpd')
                ->orderBy('is_active', 'desc')
                ->get();
        } else {
            $desas = Desa::withCount([
                'personil as bpd_count' => function ($query) {
                    $query->where('kategori', 'bpd');
                }
            ])->orderBy('nama_desa')->get();
        }

        return view('kecamatan.pemerintahan.personil.index', [
            'personils' => $personils,
            'desa_id' => $desa_id,
            'desas' => $desas,
            'title' => 'Struktur BPD',
            'kategori' => 'bpd'
        ]);
    }

    public function personilStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'nik' => 'required|digits:16',
            'jabatan' => 'required|string',
            'kategori' => 'required|in:perangkat,bpd',
            'nomor_sk' => 'nullable|string',
            'masa_jabatan_mulai' => 'nullable|date',
            'file_sk' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $user = auth()->user();
        $validated['desa_id'] = $user->desa_id; // Default to operator's desa

        if ($request->hasFile('file_sk')) {
            $path = $request->file('file_sk')->store('perangkat_sk', 'local');
            $validated['file_sk'] = $path;
        }

        PersonilDesa::create($validated);

        return back()->with('success', 'Data personil berhasil ditambahkan.');
    }

    public function inventarisIndex()
    {
        $user = auth()->user();
        $desa_id = ($user->isSuperAdmin() || $user->isOperatorKecamatan()) ? request('desa_id') : $user->desa_id;

        $inventaris = [];
        $desas = [];

        if ($desa_id) {
            $inventaris = \App\Models\InventarisDesa::where('desa_id', $desa_id)
                ->orderBy('tipe_aset')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $desas = Desa::withCount('inventaris')->orderBy('nama_desa')->get();
        }

        return view('kecamatan.pemerintahan.inventaris.index', compact('inventaris', 'desa_id', 'desas'));
    }

    public function inventarisStore(Request $request)
    {
        $validated = $request->validate([
            'tipe_aset' => 'required|in:barang,tanah',
            'nama_item' => 'required|string',
            'tahun_perolehan' => 'nullable|digits:4',
            'kondisi' => 'nullable|string',
            'status_sengketa' => 'required|string',
            'luas' => 'nullable|string',
            'nomor_legalitas' => 'nullable|string',
        ]);

        $user = auth()->user();
        $validated['desa_id'] = $user->desa_id;

        \App\Models\InventarisDesa::create($validated);

        return back()->with('success', 'Data inventaris berhasil disimpan.');
    }

    public function perencanaanIndex()
    {
        $user = auth()->user();
        $desa_id = ($user->isSuperAdmin() || $user->isOperatorKecamatan()) ? request('desa_id') : $user->desa_id;

        $perencanaan = [];
        $desas = [];
        $currentPhase = $this->getCurrentPhase();

        if ($desa_id) {
            $perencanaan = \App\Models\PerencanaanDesa::where('desa_id', $desa_id)
                ->withCount('usulan')
                ->orderBy('tahun', 'desc')
                ->get();
        } else {
            $desas = Desa::withCount('perencanaan')->orderBy('nama_desa')->get();
        }

        return view('kecamatan.pemerintahan.perencanaan.index', compact('perencanaan', 'desa_id', 'desas', 'currentPhase'));
    }
    private function getCurrentPhase()
    {
        $month = (int) date('n');
        if ($month >= 1 && $month <= 6)
            return 'musdes';
        if ($month >= 7 && $month <= 9)
            return 'rkp';
        return 'apbdes';
    }
    public function perencanaanShow($id)
    {
        $perencanaan = \App\Models\PerencanaanDesa::with(['usulan', 'desa'])->findOrFail($id);
        return view('kecamatan.pemerintahan.perencanaan.show', compact('perencanaan'));
    }

    public function laporanIndex()
    {
        $user = auth()->user();
        $desa_id = ($user->isSuperAdmin() || $user->isOperatorKecamatan()) ? request('desa_id') : $user->desa_id;

        $laporans = [];
        $desas = [];

        if ($desa_id) {
            $laporans = \App\Models\DokumenDesa::where('desa_id', $desa_id)
                ->whereIn('tipe_dokumen', ['LKPJ', 'LPPD'])
                ->orderBy('tahun', 'desc')
                ->get();
        } else {
            $desas = Desa::withCount([
                'dokumens' => function ($q) {
                    $q->whereIn('tipe_dokumen', ['LKPJ', 'LPPD']);
                }
            ])->orderBy('nama_desa')->get();
        }

        return view('kecamatan.pemerintahan.laporan.index', compact('laporans', 'desa_id', 'desas'));
    }

    public function dokumenIndex()
    {
        $user = auth()->user();
        $desa_id = ($user->isSuperAdmin() || $user->isOperatorKecamatan()) ? request('desa_id') : $user->desa_id;

        $dokumens = [];
        $desas = [];

        if ($desa_id) {
            $dokumens = \App\Models\DokumenDesa::where('desa_id', $desa_id)
                ->whereIn('tipe_dokumen', ['RPJMDes', 'RKPDes'])
                ->orderBy('tahun', 'desc')
                ->get();
        } else {
            $desas = Desa::withCount([
                'dokumens' => function ($q) {
                    $q->whereIn('tipe_dokumen', ['RPJMDes', 'RKPDes']);
                }
            ])->orderBy('nama_desa')->get();
        }

        return view('kecamatan.pemerintahan.dokumen.index', compact('dokumens', 'desa_id', 'desas'));
    }

    public function dokumenStore(Request $request)
    {
        $validated = $request->validate([
            'tipe_dokumen' => 'required|string',
            'tahun' => 'required|digits:4',
            'tanggal_penyampaian' => 'nullable|date',
            'file_dokumen' => 'required|file|mimes:pdf|max:5120', // Up to 5MB for documents
        ]);

        $user = auth()->user();
        $validated['desa_id'] = $user->desa_id;

        if ($request->hasFile('file_dokumen')) {
            $path = $request->file('file_dokumen')->store('desa_dokumen', 'local');
            $validated['file_path'] = $path;
        }

        \App\Models\DokumenDesa::create($validated);

        return back()->with('success', 'Dokumen berhasil diarsipkan.');
    }

    public function lembagaIndex()
    {
        $user = auth()->user();
        $desa_id = ($user->isSuperAdmin() || $user->isOperatorKecamatan()) ? request('desa_id') : $user->desa_id;

        $lembagas = [];
        $desas = [];

        if ($desa_id) {
            $lembagas = \App\Models\LembagaDesa::where('desa_id', $desa_id)
                ->orderBy('tipe_lembaga')
                ->get();
        } else {
            $desas = Desa::with([
                'lembaga' => function ($q) {
                    $q->select('id', 'desa_id', 'nama_lembaga');
                }
            ])->orderBy('nama_desa')->get();
        }

        return view('kecamatan.pemerintahan.lembaga.index', compact('lembagas', 'desa_id', 'desas'));
    }

    public function lembagaStore(Request $request)
    {
        $validated = $request->validate([
            'nama_lembaga' => 'required|string',
            'tipe_lembaga' => 'required|string',
            'ketua' => 'nullable|string',
            'nomor_sk' => 'nullable|string',
            'tahun_pembentukan' => 'nullable|digits:4',
            'file_sk' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $user = auth()->user();
        $validated['desa_id'] = $user->desa_id;

        if ($request->hasFile('file_sk')) {
            $path = $request->file('file_sk')->store('lembaga_sk', 'local');
            $validated['file_sk'] = $path;
        }

        \App\Models\LembagaDesa::create($validated);

        return back()->with('success', 'Data lembaga berhasil ditambahkan.');
    }

    public function perencanaanStore(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|digits:4',
            'tanggal_kegiatan' => 'required|date',
            'lokasi' => 'required|string',
            'file_ba' => 'required|file|mimes:pdf|max:2048',
            'file_absensi' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'usulan' => 'required|array|min:1',
            'usulan.*.bidang' => 'required|string',
            'usulan.*.uraian' => 'required|string',
            'usulan.*.prioritas' => 'required|in:tinggi,sedang,rendah',
        ]);

        $user = auth()->user();
        $desa_id = $user->desa_id;

        \DB::beginTransaction();
        try {
            $perencanaan = \App\Models\PerencanaanDesa::create([
                'desa_id' => $desa_id,
                'tahun' => $validated['tahun'],
                'tanggal_kegiatan' => $validated['tanggal_kegiatan'],
                'lokasi' => $validated['lokasi'],
                'status_administrasi' => 'lengkap'
            ]);

            // Handle Files
            if ($request->hasFile('file_ba')) {
                $perencanaan->file_ba = $request->file('file_ba')->store('perencanaan/ba', 'local');
            }
            if ($request->hasFile('file_absensi')) {
                $perencanaan->file_absensi = $request->file('file_absensi')->store('perencanaan/absensi', 'local');
            }
            if ($request->hasFile('file_foto')) {
                $perencanaan->file_foto = $request->file('file_foto')->store('perencanaan/foto', 'local');
            }
            $perencanaan->save();

            // Handle Usulan
            foreach ($validated['usulan'] as $u) {
                $perencanaan->usulan()->create($u);
            }

            \DB::commit();
            return back()->with('success', 'Data Musrenbang & Usulan berhasil disimpan.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function visitorIndex()
    {
        abort_unless(auth()->user()->isSuperAdmin() || auth()->user()->isOperatorKecamatan(), 403);
        $visitors = PengunjungKecamatan::with('desaAsal')
            ->orderBy('status', 'desc') // 'menunggu' will be at the bottom if using string sort? wait.
            ->orderBy('jam_datang', 'desc')
            ->take(100)
            ->get();

        $desas = Desa::orderBy('nama_desa')->get();

        return view('kecamatan.pemerintahan.visitor.index', compact('visitors', 'desas'));
    }

    public function visitorStore(Request $request)
    {
        abort_unless(auth()->user()->isSuperAdmin() || auth()->user()->isOperatorKecamatan(), 403);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|digits:16',
            'desa_asal_id' => 'nullable|exists:desa,id',
            'alamat_luar' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:15',
            'tujuan_bidang' => 'required|string',
            'keperluan' => 'required|string',
        ]);

        PengunjungKecamatan::create($validated);

        return back()->with('success', 'Pengunjung berhasil didaftarkan.');
    }

    public function visitorUpdate(Request $request, $id)
    {
        abort_unless(auth()->user()->isSuperAdmin() || auth()->user()->isOperatorKecamatan(), 403);
        $visitor = PengunjungKecamatan::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:menunggu,dilayani,selesai'
        ]);

        $visitor->update($validated);

        return back()->with('success', 'Status pengunjung berhasil diperbarui.');
    }
}