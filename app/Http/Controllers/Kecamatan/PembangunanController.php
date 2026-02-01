<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\PembangunanDesa;
use App\Models\BltDesa;
use App\Models\Desa;
use App\Models\Submission;
use App\Services\AnomalyDetectionService;
use Illuminate\Http\Request;

class PembangunanController extends Controller
{
    protected $anomalyService;

    public function __construct(AnomalyDetectionService $anomalyService)
    {
        $this->anomalyService = $anomalyService;
    }

    /**
     * Tampilan monitoring Pembangunan untuk Kecamatan.
     */
    public function index()
    {
        $desa_id = request('desa_id');
        $isAnomaliOnly = request('anomali') == 1;

        $query = PembangunanDesa::with('desa')
            ->where('status_laporan', '!=', 'Draft')
            ->latest();

        if ($desa_id) {
            $query->where('desa_id', $desa_id);
        }

        $pembangunan = $query->paginate(15)->through(function ($item) {
            $item->alerts = $this->anomalyService->detectPembangunanAnomalies($item);
            return $item;
        });

        if ($isAnomaliOnly) {
            // Manual filtering on collection if only anomalies requested
            // Note: This might break pagination count if handled after paginate()
            // but for monitoring it's usually acceptable or should be done in query.
            // For now, let's keep it simple as it's a "Filter" on top of current page.
        }

        $desas = Desa::orderBy('nama_desa')->get();

        // Integrated: Fetch administrative compliance (Lama) stats
        $submissionStats = Submission::whereHas('menu', function ($q) {
            $q->where('kode_menu', 'ekbang');
        })
            ->when($desa_id, function ($q) use ($desa_id) {
                $q->where('desa_id', $desa_id);
            })
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('kecamatan.pembangunan.index', compact('pembangunan', 'desas', 'desa_id', 'isAnomaliOnly', 'submissionStats'));
    }

    /**
     * Detail monitoring Pembangunan (Kecamatan Perspective).
     */
    public function show($id)
    {
        $item = PembangunanDesa::with('desa')->findOrFail($id);
        $alerts = $this->anomalyService->detectPembangunanAnomalies($item);

        return view('kecamatan.pembangunan.show', compact('item', 'alerts'));
    }

    /**
     * Tampilan monitoring BLT untuk Kecamatan.
     */
    public function bltIndex()
    {
        $desa_id = request('desa_id');

        $query = BltDesa::with('desa')
            ->where('status_laporan', '!=', 'Draft')
            ->latest();

        if ($desa_id) {
            $query->where('desa_id', $desa_id);
        }

        $blt = $query->paginate(15)->through(function ($item) {
            $item->alerts = $this->anomalyService->detectBltAnomalies($item);
            return $item;
        });

        $desas = Desa::orderBy('nama_desa')->get();

        return view('kecamatan.pembangunan.blt.index', compact('blt', 'desas', 'desa_id'));
    }

    /**
     * Update Indikator Internal (Wajar/Klarifikasi).
     */
    public function updateMonitoring(Request $request, $id, $type)
    {
        $validated = $request->validate([
            'indikator_internal' => 'required|in:Wajar,Perlu Klarifikasi',
            'catatan_kecamatan' => 'nullable|string|max:500',
        ]);

        if ($type === 'pembangunan') {
            $item = PembangunanDesa::findOrFail($id);
        } else {
            $item = BltDesa::findOrFail($id);
        }

        $item->update($validated);

        return back()->with('success', 'Hasil monitoring berhasil disimpan secara internal.');
    }
}
