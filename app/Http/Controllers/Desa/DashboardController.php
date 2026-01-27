<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Submission;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $currentUser = auth()->user();
        abort_unless($currentUser->desa_id !== null, 403);

        // Submission Stats
        $submissionQuery = Submission::where('desa_id', $currentUser->desa_id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);

        $submissionCounts = $submissionQuery->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $stats = [
            'nama_desa' => $currentUser->desa?->nama_desa,
            'summary' => [
                'draft' => $submissionCounts->get(Submission::STATUS_DRAFT, 0),
                'returned' => $submissionCounts->get(Submission::STATUS_RETURNED, 0),
                'submitted' => $submissionCounts->get(Submission::STATUS_SUBMITTED, 0) +
                    $submissionCounts->get(Submission::STATUS_REVIEWED, 0),
            ],
            'surat_bulan_ini' => $submissionCounts->sum(),
        ];

        // Desa Activities
        $activities = AuditLog::whereHas('user', function ($q) use ($currentUser) {
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
}
