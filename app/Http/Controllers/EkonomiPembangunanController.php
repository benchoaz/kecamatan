<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EkonomiPembangunanController extends Controller
{
    protected $submissionRepo;
    protected $masterData;

    public function __construct(
        \App\Repositories\Interfaces\SubmissionRepositoryInterface $submissionRepo,
        \App\Services\MasterDataService $masterData
    ) {
        $this->submissionRepo = $submissionRepo;
        $this->masterData = $masterData;
    }

    public function index()
    {
        $user = auth()->user();
        abort_unless($user->desa_id !== null, 403);

        $desa_id = $user->desa_id;

        // Health Check Calculations
        $healthMetrics = $this->calculateHealth($desa_id);

        // Recent Submissions for Ekbang
        $recentSubmissions = \App\Models\Submission::where('desa_id', $desa_id)
            ->whereHas('menu', function ($q) {
                $q->where('kode_menu', 'ekbang');
            })
            ->with(['menu', 'aspek'])
            ->latest()
            ->take(5)
            ->get();

        return view('kecamatan.ekbang.index', compact('healthMetrics', 'desa_id', 'recentSubmissions'));
    }

    public function kecamatanIndex()
    {
        $user = auth()->user();
        abort_unless($user->desa_id === null, 403);

        // Kecamatan view usually sees all villages or a summary
        $recentSubmissions = \App\Models\Submission::whereHas('menu', function ($q) {
            $q->where('kode_menu', 'ekbang');
        })
            ->with(['desa', 'menu', 'aspek'])
            ->latest()
            ->take(10)
            ->get();

        return view('kecamatan.ekbang.kecamatan.index', compact('recentSubmissions'));
    }

    public function danaDesaIndex()
    {
        $user = auth()->user();
        $desa_id = $user->desa_id ?? request('desa_id');
        $isOperator = $user->desa_id !== null;

        $danaDesa = [];
        $desas = [];

        if ($desa_id) {
            $danaDesa = \App\Models\Submission::where('desa_id', $desa_id)
                ->whereHas('aspek', function ($q) {
                    $q->where('kode_aspek', 'ekb_monev');
                })
                ->latest()
                ->get();
        } else {
            $desas = \App\Models\Desa::withCount([
                'submissions' => function ($q) {
                    $q->whereHas('aspek', function ($q) {
                        $q->where('kode_aspek', 'ekb_monev');
                    });
                }
            ])->orderBy('nama_desa')->get();
        }

        return view('kecamatan.ekbang.dana-desa.index', compact('danaDesa', 'desa_id', 'isOperator', 'desas'));
    }

    public function fisikIndex()
    {
        $user = auth()->user();
        $desa_id = ($user->isSuperAdmin() || $user->isOperatorKecamatan()) ? request('desa_id') : $user->desa_id;
        $isOperator = $user->desa_id !== null;

        $projects = [];
        $desas = [];

        if ($desa_id) {
            $projects = \App\Models\Submission::where('desa_id', $desa_id)
                ->whereHas('aspek', function ($q) {
                    $q->where('kode_aspek', 'ekb_fisik');
                })
                ->latest()
                ->get();
        } else {
            $desas = \App\Models\Desa::withCount([
                'submissions' => function ($q) {
                    $q->whereHas('aspek', function ($q) {
                        $q->where('kode_aspek', 'ekb_fisik');
                    });
                }
            ])->orderBy('nama_desa')->get();
        }

        return view('kecamatan.ekbang.fisik.index', compact('projects', 'desa_id', 'isOperator', 'desas'));
    }

    public function realisasiIndex()
    {
        $user = auth()->user();
        $desa_id = $user->desa_id ?? request('desa_id');
        $isOperator = $user->desa_id !== null;

        $realisasi = [];
        $desas = [];

        if ($desa_id) {
            $realisasi = \App\Models\Submission::where('desa_id', $desa_id)
                ->whereHas('aspek', function ($q) {
                    $q->where('kode_aspek', 'ekb_realisasi');
                })
                ->latest()
                ->get();
        } else {
            $desas = \App\Models\Desa::withCount([
                'submissions' => function ($q) {
                    $q->whereHas('aspek', function ($q) {
                        $q->where('kode_aspek', 'ekb_realisasi');
                    });
                }
            ])->orderBy('nama_desa')->get();
        }

        return view('kecamatan.ekbang.realisasi.index', compact('realisasi', 'desa_id', 'isOperator', 'desas'));
    }

    public function kepatuhanIndex()
    {
        $user = auth()->user();
        $desa_id = $user->desa_id ?? request('desa_id');
        $isOperator = $user->desa_id !== null;

        $kepatuhan = [];
        $desas = [];

        if ($desa_id) {
            $kepatuhan = \App\Models\Submission::where('desa_id', $desa_id)
                ->whereHas('aspek', function ($q) {
                    $q->where('kode_aspek', 'ekb_kepatuhan');
                })
                ->latest()
                ->get();
        } else {
            $desas = \App\Models\Desa::withCount([
                'submissions' => function ($q) {
                    $q->whereHas('aspek', function ($q) {
                        $q->where('kode_aspek', 'ekb_kepatuhan');
                    });
                }
            ])->orderBy('nama_desa')->get();
        }

        return view('kecamatan.ekbang.kepatuhan.index', compact('kepatuhan', 'desa_id', 'isOperator', 'desas'));
    }

    public function auditIndex()
    {
        $user = auth()->user();
        $desa_id = $user->desa_id ?? request('desa_id');
        $isOperator = $user->desa_id !== null;

        $auditLogs = [];
        $desas = [];

        if ($desa_id) {
            $auditLogs = \App\Models\Submission::where('desa_id', $desa_id)
                ->whereHas('aspek', function ($q) {
                    $q->where('kode_aspek', 'ekb_audit');
                })
                ->latest()
                ->get();
        } else {
            $desas = \App\Models\Desa::withCount([
                'submissions' => function ($q) {
                    $q->whereHas('aspek', function ($q) {
                        $q->where('kode_aspek', 'ekb_audit');
                    });
                }
            ])->orderBy('nama_desa')->get();
        }

        return view('kecamatan.ekbang.audit.index', compact('auditLogs', 'desa_id', 'isOperator', 'desas'));
    }



    protected function calculateHealth($desa_id)
    {
        // Placeholder logic for Ekbang health
        $hasRealisasi = \App\Models\Submission::where('desa_id', $desa_id)
            ->whereHas('aspek', function ($q) {
                $q->where('kode_aspek', 'ekb_realisasi');
            })
            ->where('tahun', date('Y'))
            ->exists();

        $hasMonev = \App\Models\Submission::where('desa_id', $desa_id)
            ->whereHas('aspek', function ($q) {
                $q->where('kode_aspek', 'ekb_monev');
            })
            ->where('tahun', date('Y'))
            ->exists();

        return [
            'realisasi' => $hasRealisasi,
            'monev' => $hasMonev,
            'status' => ($hasRealisasi && $hasMonev) ? 'Sehat' : 'Perlu Perhatian',
        ];
    }
}
