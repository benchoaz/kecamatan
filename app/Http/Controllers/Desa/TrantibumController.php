<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;

class TrantibumController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        abort_unless($user->desa_id !== null, 403);

        $desa_id = $user->desa_id;

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

    public function show($id)
    {
        $report = Submission::with(['desa', 'aspek', 'jawabanIndikator', 'buktiDukung', 'verifikasi'])->findOrFail($id);
        $layout = "layouts.desa";

        return view('kecamatan.trantibum.show', compact('report', 'layout'));
    }
}
