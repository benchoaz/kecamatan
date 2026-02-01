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
    public function exportAudit()
    {
        $desa_id = request('desa_id');
        $desa = \App\Models\Desa::find($desa_id);

        if (!$desa && auth()->user()->desa_id) {
            $desa = auth()->user()->desa;
        }

        abort_unless($desa, 404, 'Desa tidak ditemukan.');

        $zipFile = new \PhpZip\ZipFile();
        $zipName = "Paket_Audit_Trantibum_" . str_replace(' ', '_', $desa->nama_desa) . "_" . date('Ymd') . ".zip";

        // Get Submissions for Trantibum
        $submissions = Submission::where('desa_id', $desa->id)
            ->whereHas('menu', function ($q) {
                $q->where('kode_menu', 'trantibum');
            })
            ->with(['buktiDukung', 'aspek'])
            ->get();

        foreach ($submissions as $sub) {
            $folderName = $sub->aspek->nama_aspek ?? 'Dokumen_Lainnya';
            $folderName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $folderName); // Sanitize

            foreach ($sub->buktiDukung as $bukti) {
                $fullPath = storage_path('app/local/' . $bukti->file_path);
                if (file_exists($fullPath)) {
                    $zipFile->addFile($fullPath, $folderName . "/" . basename($bukti->file_path));
                }
            }
        }

        $zipFile->saveAsFile(storage_path('app/temp/' . $zipName));
        $zipFile->close();

        return response()->download(storage_path('app/temp/' . $zipName))->deleteFileAfterSend(true);
    }
}
