<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\PublicService;
use App\Models\PelayananFaq;
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
        ]);

        $complaint = PublicService::findOrFail($id);
        $updateData = [
            'status' => $request->status,
            'internal_notes' => $request->internal_notes,
            'public_response' => $request->public_response,
            'handled_by' => auth()->id(),
            'handled_at' => now(),
        ];

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
}
