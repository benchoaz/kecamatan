<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Verifikasi;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasiKesraController extends Controller
{
    /**
     * Kasi Kesra Dashboard
     * Displays summary of social welfare reports and administrative compliance.
     */
    public function index()
    {
        if (!auth()->user()->isSuperAdmin() && !auth()->user()->isOperatorKecamatan()) {
            abort(403, 'Akses Terbatas: Anda tidak memiliki izin untuk modul Kesra.');
        }

        $stats = [
            'waiting' => Submission::where('status', Submission::STATUS_SUBMITTED)
                ->where('menu_id', 3)->count(),
            'returned' => Submission::where('status', Submission::STATUS_RETURNED)
                ->where('menu_id', 3)->count(),
            'reviewed' => Submission::where('status', Submission::STATUS_REVIEWED)
                ->where('menu_id', 3)->count(),
        ];

        $recentSubmissions = Submission::where('menu_id', 3)
            ->with(['desa', 'aspek'])
            ->latest()
            ->take(10)
            ->get();

        return view('kecamatan.kesra.dashboard', compact('stats', 'recentSubmissions'));
    }

    /**
     * Verifikasi Program Sosial & Bansos
     */
    public function bansosIndex()
    {
        $desa_id = request('desa_id');
        $submissions = [];
        $desas = [];

        if ($desa_id) {
            $submissions = Submission::where('menu_id', 3)
                ->where('desa_id', $desa_id)
                ->whereHas('aspek', function ($q) {
                    $q->where('kode_aspek', 'kes_sosial');
                })
                ->with(['desa', 'submittedBy'])
                ->latest()
                ->get();
        } else {
            $desas = \App\Models\Desa::withCount([
                'submissions' => function ($q) {
                    $q->whereHas('aspek', function ($q) {
                        $q->where('kode_aspek', 'kes_sosial');
                    });
                }
            ])->orderBy('nama_desa')->get();
        }

        return view('kecamatan.kesra.monitoring.index', [
            'village_first' => true,
            'desa_id' => $desa_id,
            'desas' => $desas,
            'title' => 'Verifikasi Program Sosial & Bansos',
            'desc' => 'Penelaahan laporan penyaluran bantuan sosial dan dokumen pendukung desa.',
            'submissions' => $submissions
        ]);
    }

    /**
     * Monitoring Pendidikan & Kepemudaan
     */
    public function pendidikanIndex()
    {
        $desa_id = request('desa_id');
        $submissions = [];
        $desas = [];

        if ($desa_id) {
            $submissions = Submission::where('menu_id', 3)
                ->where('desa_id', $desa_id)
                ->whereHas('aspek', function ($q) {
                    $q->where('kode_aspek', 'kes_pendidikan');
                })
                ->with(['desa', 'submittedBy'])
                ->latest()
                ->get();
        } else {
            $desas = \App\Models\Desa::withCount([
                'submissions' => function ($q) {
                    $q->whereHas('aspek', function ($q) {
                        $q->where('kode_aspek', 'kes_pendidikan');
                    });
                }
            ])->orderBy('nama_desa')->get();
        }

        return view('kecamatan.kesra.monitoring.index', [
            'village_first' => true,
            'desa_id' => $desa_id,
            'desas' => $desas,
            'title' => 'Monitoring Pendidikan & Kepemudaan',
            'desc' => 'Evaluasi laporan kegiatan pendidikan, kepemudaan, dan olahraga desa.',
            'submissions' => $submissions
        ]);
    }

    /**
     * Monitoring Kesehatan & KB
     */
    public function kesehatanIndex()
    {
        $desa_id = request('desa_id');
        $submissions = [];
        $desas = [];

        if ($desa_id) {
            $submissions = Submission::where('menu_id', 3)
                ->where('desa_id', $desa_id)
                ->whereIn('aspek_id', [12, 13]) // Kesehatan & Posyandu
                ->with(['desa', 'submittedBy'])
                ->latest()
                ->get();
        } else {
            $desas = \App\Models\Desa::withCount([
                'submissions' => function ($q) {
                    $q->whereIn('aspek_id', [12, 13]);
                }
            ])->orderBy('nama_desa')->get();
        }

        return view('kecamatan.kesra.monitoring.index', [
            'village_first' => true,
            'desa_id' => $desa_id,
            'desas' => $desas,
            'title' => 'Monitoring Kesehatan & KB',
            'desc' => 'Pemantauan kegiatan kesehatan masyarakat, stunting, dan layanan posyandu.',
            'submissions' => $submissions
        ]);
    }

    /**
     * Kehidupan Sosial, Budaya & Keagamaan
     */
    public function sosialBudayaIndex()
    {
        $submissions = Submission::where('menu_id', 3)
            ->with(['desa', 'submittedBy'])
            ->latest()
            ->get();

        return view('kecamatan.kesra.monitoring.index', [
            'title' => 'Kehidupan Sosial, Budaya & Keagamaan',
            'desc' => 'Laporan kegiatan keagamaan, pelestarian budaya, dan nilai sosial masyarakat.',
            'submissions' => $submissions
        ]);
    }

    /**
     * Rekomendasi ke Camat
     */
    public function rekomendasiIndex()
    {
        $submissions = Submission::where('menu_id', 3)
            ->where('status', Submission::STATUS_REVIEWED)
            ->with(['desa', 'aspek', 'reviewedBy'])
            ->latest()
            ->get();

        return view('kecamatan.kesra.rekomendasi.index', compact('submissions'));
    }

    /**
     * Workflow: Review Action (Return or Recommend)
     */
    public function process(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);

        $validated = $request->validate([
            'action' => 'required|in:return,recommend',
            'catatan' => 'required|string|min:10',
        ]);

        $newStatus = ($validated['action'] === 'return') ? Submission::STATUS_RETURNED : Submission::STATUS_REVIEWED;
        if (!auth()->user()->isSuperAdmin() && !auth()->user()->isOperatorKecamatan()) {
            abort(403, 'Akses Terbatas: Anda tidak memiliki izin untuk memproses laporan.');
        }
        abort_unless($submission->status === Submission::STATUS_SUBMITTED, 422, 'Laporan tidak dalam status menunggu telaah.');

        DB::beginTransaction();
        try {
            $submission->update([
                'status' => $newStatus,
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);

            Verifikasi::create([
                'submission_id' => $submission->id,
                'verifikator_id' => auth()->id(),
                'status' => $newStatus,
                'catatan' => $validated['catatan'],
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'domain' => 'kecamatan',
                'action' => $validated['action'],
                'table_name' => 'submission',
                'record_id' => $submission->id,
                'old_values' => json_encode(['status' => Submission::STATUS_SUBMITTED]),
                'new_values' => json_encode(['status' => $newStatus, 'note' => $validated['catatan']]),
                'ip_address' => $request->ip(),
            ]);

            DB::commit();
            return back()->with('success', 'Laporan berhasil ' . ($validated['action'] === 'return' ? 'dikembalikan ke desa.' : 'direkomendasikan ke Camat.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
