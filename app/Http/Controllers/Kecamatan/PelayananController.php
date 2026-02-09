<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\PublicService;
use App\Models\PelayananFaq;
use App\Models\PengunjungKecamatan;
use App\Models\MasterLayanan;
use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelayananController extends Controller
{
    /**
     * Inbox Pengaduan
     */
    public function inbox()
    {
        $complaints = PublicService::with('desa')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('kecamatan.pelayanan.inbox', compact('complaints'));
    }

    /**
     * Detail Pengaduan
     */
    public function show($id)
    {
        $complaint = PublicService::with(['desa', 'handler'])->findOrFail($id);

        $statuses = [
            'Menunggu Klarifikasi',
            'Diterima',
            'Dalam Proses',
            'Dikoordinasikan',
            'Selesai',
            'Di luar kewenangan'
        ];

        return view('kecamatan.pelayanan.show', compact('complaint', 'statuses'));
    }

    /**
     * Update Tindak Lanjut
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'internal_notes' => 'nullable|string',
            'public_response' => 'nullable|string',
            'completion_type' => 'nullable|in:digital,physical',
            'result_file' => 'nullable|file|mimes:pdf|max:5120',
            'ready_at' => 'nullable|date',
            'pickup_person' => 'nullable|string|max:255',
            'pickup_notes' => 'nullable|string',
        ]);

        $complaint = PublicService::findOrFail($id);
        $updateData = [
            'status' => $request->status,
            'internal_notes' => $request->internal_notes,
            'public_response' => $request->public_response,
            'handled_by' => auth()->id(),
            'handled_at' => now(),
            'completion_type' => $request->completion_type,
            'ready_at' => $request->ready_at,
            'pickup_person' => $request->pickup_person,
            'pickup_notes' => $request->pickup_notes,
        ];

        // Handle PDF upload for digital completion
        if ($request->hasFile('result_file')) {
            $path = $request->file('result_file')->store('public_services/results', 'public');
            $updateData['result_file_path'] = $path;
        }

        if ($request->filled('public_response')) {
            $updateData['responded_at'] = now();
        }

        $complaint->update($updateData);

        return redirect()->back()->with('success', 'Tindak lanjut pengaduan berhasil diperbarui.');
    }

    /**
     * FAQ Management
     */
    public function faqIndex()
    {
        $faqs = PelayananFaq::orderBy('category')->get();
        return view('kecamatan.pelayanan.faq.index', compact('faqs'));
    }

    public function faqStore(Request $request)
    {
        $data = $request->validate([
            'category' => 'required|string',
            'keywords' => 'required|string',
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        PelayananFaq::create($data);

        return redirect()->back()->with('success', 'FAQ Administrasi berhasil ditambahkan.');
    }

    public function faqUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'category' => 'required|string',
            'keywords' => 'required|string',
            'question' => 'required|string',
            'answer' => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        $faq = PelayananFaq::findOrFail($id);
        $faq->update($data);

        return redirect()->back()->with('success', 'FAQ Administrasi berhasil diperbarui.');
    }

    /**
     * Statistik Pelayanan
     */
    public function statistics()
    {
        $stats = [
            'total' => PublicService::count(),
            'pending' => PublicService::where('status', 'Menunggu Klarifikasi')->count(),
            'processed' => PublicService::whereIn('status', ['Diterima', 'Dalam Proses', 'Dikoordinasikan'])->count(),
            'completed' => PublicService::where('status', 'Selesai')->count(),
            'by_category' => PublicService::select('jenis_layanan', DB::raw('count(*) as total'))
                ->groupBy('jenis_layanan')
                ->get(),
            'by_village' => PublicService::select('desa_id', DB::raw('count(*) as total'))
                ->with('desa')
                ->groupBy('desa_id')
                ->get(),
        ];

        return view('kecamatan.pelayanan.statistics', compact('stats'));
    }

    /**
     * Buku Tamu (Moved from Pemerintahan)
     */
    public function visitorIndex()
    {
        $visitors = PengunjungKecamatan::with('desaAsal')
            ->orderBy('status', 'desc')
            ->orderBy('jam_datang', 'desc')
            ->take(100)
            ->get();

        $desas = Desa::orderBy('nama_desa')->get();
        return view('kecamatan.pelayanan.visitor.index', compact('visitors', 'desas'));
    }

    public function visitorStore(Request $request)
    {
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
        $visitor = PengunjungKecamatan::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:menunggu,dilayani,selesai'
        ]);

        $visitor->update($validated);
        return back()->with('success', 'Status pengunjung berhasil diperbarui.');
    }

    /**
     * Master Layanan (Self Service)
     */
    public function layananIndex()
    {
        $layanan = MasterLayanan::orderBy('urutan')->get();
        return view('kecamatan.pelayanan.layanan.index', compact('layanan'));
    }

    public function layananCreate()
    {
        return view('kecamatan.pelayanan.layanan.form');
    }

    public function layananStore(Request $request)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi_syarat' => 'required|string',
            'estimasi_waktu' => 'nullable|string|max:100',
            'ikon' => 'required|string|max:100',
            'warna_bg' => 'required|string|max:100',
            'warna_text' => 'required|string|max:100',
            'is_active' => 'required|boolean',
            'urutan' => 'required|integer',
        ]);

        MasterLayanan::create($validated);
        return redirect()->route('kecamatan.pelayanan.layanan.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function layananEdit($id)
    {
        $layanan = MasterLayanan::findOrFail($id);
        return view('kecamatan.pelayanan.layanan.form', compact('layanan'));
    }

    public function layananUpdate(Request $request, $id)
    {
        $layanan = MasterLayanan::findOrFail($id);
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi_syarat' => 'required|string',
            'estimasi_waktu' => 'nullable|string|max:100',
            'ikon' => 'required|string|max:100',
            'warna_bg' => 'required|string|max:100',
            'warna_text' => 'required|string|max:100',
            'is_active' => 'required|boolean',
            'urutan' => 'required|integer',
        ]);

        $layanan->update($validated);
        return redirect()->route('kecamatan.pelayanan.layanan.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function layananDestroy($id)
    {
        $layanan = MasterLayanan::findOrFail($id);
        $layanan->delete();
        return redirect()->route('kecamatan.pelayanan.layanan.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
