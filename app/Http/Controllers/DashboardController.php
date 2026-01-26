<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengunjungKecamatan;
use App\Models\Desa;
use App\Models\Submission;
use App\Models\AuditLog;
use App\Models\Indikator;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard.
     */
    protected $submissionRepo;

    public function __construct(\App\Repositories\Interfaces\SubmissionRepositoryInterface $submissionRepo)
    {
        $this->submissionRepo = $submissionRepo;
    }

    /**
     * Entry point for dashboard.
     * Redirects to the appropriate domain dashboard.
     */
    public function index()
    {
        if (auth()->user()->desa_id !== null) {
            return redirect()->route('desa.dashboard');
        }
        return redirect()->route('kecamatan.dashboard');
    }

    /**
     * Domain: Desa Dashboard
     */
    public function desaIndex()
    {
        $currentUser = auth()->user();

        // Submission Stats
        $submissionQuery = \App\Models\Submission::where('desa_id', $currentUser->desa_id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);

        $submissionCounts = $submissionQuery->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $stats = [
            'nama_desa' => $currentUser->desa?->nama_desa,
            'summary' => [
                'draft' => $submissionCounts->get(\App\Models\Submission::STATUS_DRAFT, 0),
                'returned' => $submissionCounts->get(\App\Models\Submission::STATUS_RETURNED, 0),
                'submitted' => $submissionCounts->get(\App\Models\Submission::STATUS_SUBMITTED, 0) +
                    $submissionCounts->get(\App\Models\Submission::STATUS_REVIEWED, 0),
            ],
            'surat_bulan_ini' => $submissionCounts->sum(),
        ];

        // Desa Activities
        $activities = \App\Models\AuditLog::whereHas('user', function ($q) use ($currentUser) {
            $q->where('desa_id', $currentUser->desa_id);
        })
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($log) {
                return [
                    'icon' => $this->getIconForAction($log->action),
                    'type' => $this->getTypeForAction($log->action),
                    'message' => 'Anda ' . $log->action . ' ' . $log->table_name,
                    'time' => $log->created_at->diffForHumans()
                ];
            });

        return view('dashboard.desa', compact('stats', 'activities'));
    }

    /**
     * Domain: Kecamatan Dashboard
     */
    public function kecamatanIndex()
    {
        $currentUser = auth()->user();

        $stats = [
            'jumlah_desa' => \App\Models\Desa::count(),
            'pengunjung_hari_ini' => PengunjungKecamatan::hariIni()->count(),
            'total_penduduk' => 12847, // Placeholder
            'laporan_masuk' => \App\Models\Submission::whereMonth('created_at', now()->month)->count(),
        ];

        $activities = \App\Models\AuditLog::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($log) {
                return [
                    'icon' => $this->getIconForAction($log->action),
                    'type' => $this->getTypeForAction($log->action),
                    'message' => $log->user->name . ' ' . $log->action . ' ' . $log->table_name,
                    'time' => $log->created_at->diffForHumans()
                ];
            });

        return view('kecamatan.dashboard.index', compact('stats', 'activities'));
    }

    private function getIconForAction($action)
    {
        return match ($action) {
            'create' => 'fa-plus-circle',
            'update' => 'fa-edit',
            'delete' => 'fa-trash',
            default => 'fa-info-circle',
        };
    }

    private function getTypeForAction($action)
    {
        return match ($action) {
            'create' => 'success',
            'update' => 'info',
            'delete' => 'danger',
            default => 'primary',
        };
    }

    /**
     * Get dashboard statistics (for AJAX requests).
     */
    public function stats()
    {
        // Return real-time stats data
        return response()->json([
            'total_penduduk' => 12847,
            'surat_bulan_ini' => 156,
            'jumlah_desa' => 8,
            'umkm_terdaftar' => 342,
            'trend' => [
                'penduduk' => '+2.5%',
                'surat' => '+12%',
                'umkm' => '+8.3%'
            ]
        ]);
    }

    /**
     * Get chart data (for AJAX requests).
     */
    public function chartData(Request $request)
    {
        $period = $request->get('period', '7days');

        // Sample chart data
        $serviceData = [
            'labels' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            'datasets' => [
                [
                    'label' => 'Surat Masuk',
                    'data' => [12, 19, 15, 25, 22, 8, 5]
                ],
                [
                    'label' => 'Surat Keluar',
                    'data' => [8, 15, 12, 18, 20, 6, 3]
                ]
            ]
        ];

        $populationData = [
            'labels' => ['Sukamaju', 'Mekar Jaya', 'Harapan', 'Sejahtera', 'Makmur', 'Damai', 'Sentosa', 'Bahagia'],
            'data' => [2150, 1890, 1650, 1420, 1780, 1350, 1280, 1327]
        ];

        return response()->json([
            'service' => $serviceData,
            'population' => $populationData
        ]);
    }
}
