<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PemerintahanController extends Controller
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

        // Authorization using new Role helpers
        if (!$user->isSuperAdmin() && !$user->isOperatorKecamatan() && !$user->isOperatorDesa()) {
            abort(403, 'Akses Terbatas: Anda tidak memiliki izin untuk modul Pemerintahan.');
        }

        // Lockdown logic: Village operators are LOCKED to their own desa_id
        if ($user->desa_id) {
            $desa_id = $user->desa_id;
        } else {
            $desa_id = request('desa_id');
        }

        // Menu Structure A-H (Strictly Administrative)
        $pemerintahanMenus = [
            'A' => ['title' => 'Administrasi Perangkat Desa', 'icon' => 'fa-users-gear', 'route' => 'kecamatan.pemerintahan.detail.personil.index', 'desc' => 'Arsip data & SK pengangkatan/pemberhentian perangkat.'],
            'B' => ['title' => 'Administrasi BPD', 'icon' => 'fa-users-rectangle', 'route' => 'kecamatan.pemerintahan.detail.bpd.index', 'desc' => 'Arsip data pimpinan & anggota serta masa keanggotaan BPD.'],
            'C' => ['title' => 'Registrasi Lembaga Desa', 'icon' => 'fa-sitemap', 'route' => 'kecamatan.pemerintahan.detail.lembaga.index', 'desc' => 'Pendataan struktur & kepengurusan lembaga kemasyarakatan.'],
            'D' => ['title' => 'Arsip Perencanaan Desa', 'icon' => 'fa-calendar-check', 'route' => 'kecamatan.pemerintahan.detail.perencanaan.index', 'desc' => 'Penyimpanan dokumen Musrenbang & usulan pembangunan desa.'],
            'E' => ['title' => 'Monitoring LKPJ & LPPD', 'icon' => 'fa-file-signature', 'route' => 'kecamatan.pemerintahan.detail.laporan.index', 'desc' => 'Pemantauan status penyampaian & kelengkapan laporan tahunan.'],
            'F' => ['title' => 'Administrasi Inventaris', 'icon' => 'fa-boxes-stacked', 'route' => 'kecamatan.pemerintahan.detail.inventaris.index', 'desc' => 'Pendataan status administrasi aset barang & tanah milik desa.'],
            'G' => ['title' => 'Arsip Dokumen Perencanaan', 'icon' => 'fa-folder-open', 'route' => 'kecamatan.pemerintahan.detail.dokumen.index', 'desc' => 'Penyimpanan referensi dokumen RPJMDes & RKPDes (Tanpa APBDes).'],
            'H' => ['title' => 'Registri Buku Tamu', 'icon' => 'fa-clipboard-list', 'route' => 'kecamatan.pemerintahan.visitor.index', 'desc' => 'Pendataan administrasi pengunjung kantor kecamatan.'],
        ];

        // Health Check Calculations (if specific desa selected/auto-filtered)
        $healthMetrics = null;
        if ($desa_id) {
            $healthMetrics = $this->calculateHealth($desa_id);
        }

        // Recent Submissions for Operator / Selected Desa
        $recentSubmissions = \App\Models\Submission::where('desa_id', $desa_id)
            ->with(['menu', 'aspek'])
            ->latest()
            ->take(5)
            ->get();

        return view('kecamatan.pemerintahan.index', compact('pemerintahanMenus', 'healthMetrics', 'desa_id', 'recentSubmissions'));
    }

    protected function calculateHealth($desa_id)
    {
        // 1. Pilar Perangkat (Kades & Sekdes required)
        $hasKades = \App\Models\PersonilDesa::where('desa_id', $desa_id)->where('jabatan', 'Kepala Desa')->where('is_active', true)->exists();
        $hasSekdes = \App\Models\PersonilDesa::where('desa_id', $desa_id)->where('jabatan', 'Sekretaris Desa')->where('is_active', true)->exists();

        // 2. Pilar BPD
        $hasBpd = \App\Models\PersonilDesa::where('desa_id', $desa_id)->where('kategori', 'bpd')->where('is_active', true)->exists();

        // 3. Pilar Perencanaan (Yearly check for RKPDes)
        $hasPerencanaan = \App\Models\PerencanaanDesa::where('desa_id', $desa_id)->where('tahun', date('Y'))->where('status_administrasi', '!=', 'draft')->exists();

        // 4. Pilar Aset
        $lastAssetUpdate = \App\Models\InventarisDesa::where('desa_id', $desa_id)->latest('updated_at')->first();
        $hasAssetUpdate = $lastAssetUpdate && $lastAssetUpdate->updated_at->diffInMonths(now()) < 12;

        return [
            'perangkat' => $hasKades && $hasSekdes,
            'bpd' => $hasBpd,
            'perencanaan' => $hasPerencanaan,
            'aset' => $hasAssetUpdate,
            'summary' => [
                'has_kades' => $hasKades,
                'has_sekdes' => $hasSekdes,
                'last_asset' => $lastAssetUpdate ? $lastAssetUpdate->updated_at->format('d/m/Y') : '-'
            ]
        ];
    }
}
