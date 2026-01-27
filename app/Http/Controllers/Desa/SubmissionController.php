<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\BuktiDukung;
use App\Models\JawabanIndikator;
use App\Models\Submission;
use App\Repositories\Interfaces\SubmissionRepositoryInterface;
use App\Services\MasterDataService;
use App\Services\SubmissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubmissionController extends Controller
{
    protected $submissionService;
    protected $submissionRepo;
    protected $masterData;

    public function __construct(
        SubmissionService $submissionService,
        SubmissionRepositoryInterface $submissionRepo,
        MasterDataService $masterData
    ) {
        $this->submissionService = $submissionService;
        $this->submissionRepo = $submissionRepo;
        $this->masterData = $masterData;
    }

    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('dashboard.view_desa'), 403);

        $submissions = Submission::where('desa_id', auth()->user()->desa_id)
            ->with(['menu', 'aspek', 'reviewedBy', 'approvedBy'])
            ->latest()
            ->paginate(10);

        return view('submissions.index', compact('submissions'));
    }

    public function create(Request $request)
    {
        abort_unless(auth()->user()->can('submission.create'), 403);

        $menus = $this->masterData->getAllMenus();
        $selectedMenuId = $request->get('menu_id');

        return view('submissions.create', compact('menus', 'selectedMenuId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menu,id',
            'aspek_id' => 'required|exists:aspek,id',
            'tahun' => 'required|digits:4',
            'periode' => 'required|in:bulanan,triwulan,semester,tahunan',
            'indikator' => 'required|array',
            'action' => 'required|in:draft,submit'
        ]);

        DB::beginTransaction();
        try {
            $user = auth()->user();

            $submission = Submission::create([
                'uuid' => Str::uuid(),
                'desa_id' => $user->desa_id,
                'menu_id' => $request->menu_id,
                'aspek_id' => $request->aspek_id,
                'tahun' => $request->tahun,
                'periode' => $request->periode,
                'bulan' => $request->bulan ?? null,
                'submitted_by' => $user->id,
                'status' => $request->action === 'submit' ? Submission::STATUS_SUBMITTED : Submission::STATUS_DRAFT,
                'submitted_at' => $request->action === 'submit' ? now() : null,
            ]);

            foreach ($request->indikator as $indikatorId => $data) {
                if (isset($data['nilai'])) {
                    JawabanIndikator::create([
                        'submission_id' => $submission->id,
                        'indikator_id' => $indikatorId,
                        'nilai' => $data['nilai'],
                    ]);
                }

                if ($request->hasFile("indikator.{$indikatorId}.file")) {
                    $file = $request->file("indikator.{$indikatorId}.file");
                    $path = $file->store('bukti_dukung/' . $submission->uuid, 'local');

                    BuktiDukung::create([
                        'submission_id' => $submission->id,
                        'indikator_id' => $indikatorId,
                        'nama_file' => $file->getClientOriginalName(),
                        'path_file' => $path,
                        'tipe_file' => $file->getClientOriginalExtension(),
                        'ukuran_bytes' => $file->getSize(),
                        'uploaded_by' => $user->id
                    ]);
                }
            }

            DB::commit();

            $message = $request->action === 'submit' ? 'Laporan berhasil diajukan!' : 'Draft laporan berhasil disimpan.';
            return redirect()->route('desa.dashboard')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Submission $submission)
    {
        if (!auth()->user()->can('submission.edit')) {
            abort(403);
        }

        $menus = $this->masterData->getAllMenus();
        $selectedMenuId = $submission->menu_id;
        $submission->load(['jawabanIndikator', 'buktiDukung']);

        return view('submissions.create', compact('menus', 'selectedMenuId', 'submission'));
    }

    public function update(Request $request, Submission $submission)
    {
        $request->validate([
            'indikator' => 'required|array',
            'action' => 'required|in:draft,submit'
        ]);

        if (!$submission->isEditable()) {
            return back()->with('error', 'Laporan tidak dapat diedit saat status: ' . $submission->status);
        }

        DB::beginTransaction();
        try {
            $user = auth()->user();

            $submission->update([
                'status' => $request->action === 'submit' ? Submission::STATUS_SUBMITTED : Submission::STATUS_DRAFT,
                'submitted_at' => $request->action === 'submit' ? now() : $submission->submitted_at,
            ]);

            foreach ($request->indikator as $indikatorId => $data) {
                if (isset($data['nilai'])) {
                    JawabanIndikator::updateOrCreate(
                        ['submission_id' => $submission->id, 'indikator_id' => $indikatorId],
                        ['nilai' => $data['nilai']]
                    );
                }

                if ($request->hasFile("indikator.{$indikatorId}.file")) {
                    $file = $request->file("indikator.{$indikatorId}.file");
                    $path = $file->store('bukti_dukung/' . $submission->uuid, 'local');

                    BuktiDukung::create([
                        'submission_id' => $submission->id,
                        'indikator_id' => $indikatorId,
                        'nama_file' => $file->getClientOriginalName(),
                        'path_file' => $path,
                        'tipe_file' => $file->getClientOriginalExtension(),
                        'ukuran_bytes' => $file->getSize(),
                        'uploaded_by' => $user->id
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('desa.dashboard')->with('success', 'Laporan berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function getAspek($menuId)
    {
        $aspeks = $this->masterData->getAspekByMenu($menuId);
        return response()->json($aspeks);
    }

    public function getIndikator($aspekId)
    {
        $indikators = $this->masterData->getIndikatorByAspek($aspekId);
        return response()->json($indikators);
    }
}
