<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Submission;
use App\Repositories\Interfaces\SubmissionRepositoryInterface;
use App\Services\MasterDataService;
use Illuminate\Http\Request;

class EkbangController extends Controller
{
    protected $submissionRepo;
    protected $masterData;

    public function __construct(
        SubmissionRepositoryInterface $submissionRepo,
        MasterDataService $masterData
    ) {
        $this->submissionRepo = $submissionRepo;
        $this->masterData = $masterData;
    }

    public function index()
    {
        $user = auth()->user();
        abort_unless($user->desa_id === null, 403);

        $recentSubmissions = Submission::whereHas('menu', function ($q) {
            $q->where('kode_menu', 'ekbang');
        })
            ->with(['desa', 'menu', 'aspek'])
            ->latest()
            ->take(10)
            ->get();

        return view('kecamatan.ekbang.kecamatan.index', compact('recentSubmissions'));
    }

    // Monitoring methods for Kecamatan
    public function danaDesa()
    {
        $desa_id = request('desa_id');
        $isOperator = false;

        $danaDesa = [];
        $desas = [];

        if ($desa_id) {
            $danaDesa = Submission::where('desa_id', $desa_id)
                ->whereHas('aspek', function ($q) {
                    $q->where('kode_aspek', 'ekb_monev');
                })
                ->latest()
                ->get();
        } else {
            $desas = Desa::withCount([
                'submissions' => function ($q) {
                    $q->whereHas('aspek', function ($q) {
                        $q->where('kode_aspek', 'ekb_monev');
                    });
                }
            ])->orderBy('nama_desa')->get();
        }

        return view('kecamatan.ekbang.dana-desa.index', compact('danaDesa', 'desa_id', 'isOperator', 'desas'));
    }

    public function fisik()
    {
        $desa_id = request('desa_id');
        $isOperator = false;

        $projects = [];
        $desas = [];

        if ($desa_id) {
            $projects = Submission::where('desa_id', $desa_id)
                ->whereHas('aspek', function ($q) {
                    $q->where('kode_aspek', 'ekb_fisik');
                })
                ->latest()
                ->get();
        } else {
            $desas = Desa::withCount([
                'submissions' => function ($q) {
                    $q->whereHas('aspek', function ($q) {
                        $q->where('kode_aspek', 'ekb_fisik');
                    });
                }
            ])->orderBy('nama_desa')->get();
        }

        return view('kecamatan.ekbang.fisik.index', compact('projects', 'desa_id', 'isOperator', 'desas'));
    }

    public function realisasi()
    {
        $desa_id = request('desa_id');
        $isOperator = false;

        $realisasi = [];
        $desas = [];

        if ($desa_id) {
            $realisasi = Submission::where('desa_id', $desa_id)
                ->whereHas('aspek', function ($q) {
                    $q->where('kode_aspek', 'ekb_realisasi');
                })
                ->latest()
                ->get();
        } else {
            $desas = Desa::withCount([
                'submissions' => function ($q) {
                    $q->whereHas('aspek', function ($q) {
                        $q->where('kode_aspek', 'ekb_realisasi');
                    });
                }
            ])->orderBy('nama_desa')->get();
        }

        return view('kecamatan.ekbang.realisasi.index', compact('realisasi', 'desa_id', 'isOperator', 'desas'));
    }

    public function kepatuhan()
    {
        $desa_id = request('desa_id');
        $isOperator = false;

        $kepatuhan = [];
        $desas = [];

        if ($desa_id) {
            $kepatuhan = Submission::where('desa_id', $desa_id)
                ->whereHas('aspek', function ($q) {
                    $q->where('kode_aspek', 'ekb_kepatuhan');
                })
                ->latest()
                ->get();
        } else {
            $desas = Desa::withCount([
                'submissions' => function ($q) {
                    $q->whereHas('aspek', function ($q) {
                        $q->where('kode_aspek', 'ekb_kepatuhan');
                    });
                }
            ])->orderBy('nama_desa')->get();
        }

        return view('kecamatan.ekbang.kepatuhan.index', compact('kepatuhan', 'desa_id', 'isOperator', 'desas'));
    }

    public function audit()
    {
        $desa_id = request('desa_id');
        $isOperator = false;

        $auditLogs = [];
        $desas = [];

        if ($desa_id) {
            $auditLogs = Submission::where('desa_id', $desa_id)
                ->whereHas('aspek', function ($q) {
                    $q->where('kode_aspek', 'ekb_audit');
                })
                ->latest()
                ->get();
        } else {
            $desas = Desa::withCount([
                'submissions' => function ($q) {
                    $q->whereHas('aspek', function ($q) {
                        $q->where('kode_aspek', 'ekb_audit');
                    });
                }
            ])->orderBy('nama_desa')->get();
        }

        return view('kecamatan.ekbang.audit.index', compact('auditLogs', 'desa_id', 'isOperator', 'desas'));
    }
}
