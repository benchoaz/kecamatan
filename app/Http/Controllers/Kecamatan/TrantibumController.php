<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;

class TrantibumController extends Controller
{
    public function index()
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

    public function show($id)
    {
        $report = Submission::with(['desa', 'aspek', 'jawabanIndikator', 'buktiDukung', 'verifikasi'])->findOrFail($id);
        $layout = "layouts.kecamatan";

        return view('kecamatan.trantibum.show', compact('report', 'layout'));
    }
}
