<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class TrantibumController extends Controller
{
    /**
     * Domain: Desa (Village Operator)
     * Security Reporting and Patrol Log
     */
    public function index()
    {
        $user = auth()->user();
        abort_unless($user->desa_id !== null, 403);

        $desa_id = $user->desa_id;

        // Fetch reports for this desa (from Submission linked to Trantibum menu)
        $recentReports = Submission::where('desa_id', $desa_id)
            ->whereHas('menu', function ($q) {
                $q->where('kode_menu', 'trantibum');
            })
            ->with(['aspek'])
            ->latest()
            ->take(10)
            ->get();

        return view('kecamatan.trantibum.index', compact('recentReports', 'desa_id'));
    }

    /**
     * Domain: Kecamatan (Sub-district)
     * Security Monitoring across all villages
     */
    public function kecamatanIndex()
    {
        $user = auth()->user();
        abort_unless($user->desa_id === null, 403);

        $allReports = Submission::whereHas('menu', function ($q) {
            $q->where('kode_menu', 'trantibum');
        })
            ->with(['desa', 'aspek'])
            ->latest()
            ->take(20)
            ->get();

        return view('kecamatan.trantibum.kecamatan.index', compact('allReports'));
    }

    /**
     * Common method for viewing a specific report
     */
    public function show($id)
    {
        $report = Submission::with(['desa', 'aspek', 'jawabanIndikator', 'buktiDukung', 'verifikasi'])->findOrFail($id);

        $domain = auth()->user()->desa_id ? 'desa' : 'kecamatan';
        $layout = "layouts.$domain";

        return view('kecamatan.trantibum.show', compact('report', 'layout'));
    }
}
