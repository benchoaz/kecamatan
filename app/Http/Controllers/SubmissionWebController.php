<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubmissionWebController extends Controller
{
    protected $submissionService;
    protected $submissionRepo;
    protected $masterData;

    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('dashboard.view_desa'), 403);

        $submissions = \App\Models\Submission::with(['menu', 'aspek', 'reviewedBy', 'approvedBy'])
            ->latest()
            ->paginate(10);

        return view('submissions.index', compact('submissions'));
    }

    public function __construct(
        \App\Services\SubmissionService $submissionService,
        \App\Repositories\Interfaces\SubmissionRepositoryInterface $submissionRepo,
        \App\Services\MasterDataService $masterData
    ) {
        $this->submissionService = $submissionService;
        $this->submissionRepo = $submissionRepo;
        $this->masterData = $masterData;
    }

    public function create(Request $request)
    {
        abort_unless(auth()->user()->can('submission.create'), 403);

        // Cached Menu List
        $menus = $this->masterData->getAllMenus();
        $selectedMenuId = $request->get('menu_id');

        return view('submissions.create', compact('menus', 'selectedMenuId'));
    }

    public function store(Request $request)
    {
        // Validation hits DB (fine for data integrity)
        $request->validate([
            'menu_id' => 'required|exists:menu,id',
            'aspek_id' => 'required|exists:aspek,id',
            'tahun' => 'required|digits:4',
            'periode' => 'required|in:bulanan,triwulan,semester,tahunan',
            'indikator' => 'required|array',
            'action' => 'required|in:draft,submit'
        ]);

        \DB::beginTransaction();
        try {
            $user = auth()->user();

            // 1. Create/Update Submission
            // Check if exists/duplicate check logic might be needed here or handled by unique constraint
            // For now, assume new submission or simple create
            $submission = \App\Models\Submission::create([
                'uuid' => \Str::uuid(),
                'desa_id' => $user->desa_id, // Ensure user has desa_id or validation fails
                'menu_id' => $request->menu_id,
                'aspek_id' => $request->aspek_id,
                'tahun' => $request->tahun,
                'periode' => $request->periode,
                'bulan' => $request->bulan ?? null, // Add to form if needed
                'submitted_by' => $user->id,
                'status' => $request->action === 'submit' ? \App\Models\Submission::STATUS_SUBMITTED : \App\Models\Submission::STATUS_DRAFT,
                'submitted_at' => $request->action === 'submit' ? now() : null,
            ]);

            // 2. Process Indicators
            foreach ($request->indikator as $indikatorId => $data) {
                // Save Answer
                if (isset($data['nilai'])) {
                    \App\Models\JawabanIndikator::create([
                        'submission_id' => $submission->id,
                        'indikator_id' => $indikatorId,
                        'nilai' => $data['nilai'],
                        // 'jawaban_teks' => ... if needed
                    ]);
                }

                // 3. Handle File Upload
                if ($request->hasFile("indikator.{$indikatorId}.file")) {
                    $file = $request->file("indikator.{$indikatorId}.file");

                    // Store to private storage (local disk, under storage/app)
                    // This is NOT accessible via public URL directly.
                    $path = $file->store('bukti_dukung/' . $submission->uuid, 'local');

                    \App\Models\BuktiDukung::create([
                        'submission_id' => $submission->id,
                        'indikator_id' => $indikatorId,
                        'nama_file' => $file->getClientOriginalName(),
                        'path_file' => $path, // Relative path inside storage/app
                        'tipe_file' => $file->getClientOriginalExtension(),
                        'ukuran_bytes' => $file->getSize(),
                        'uploaded_by' => $user->id
                    ]);
                }
            }

            \DB::commit();

            $message = $request->action === 'submit' ? 'Laporan berhasil diajukan!' : 'Draft laporan berhasil disimpan.';
            return redirect()->route('desa.dashboard')->with('success', $message);

        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(\App\Models\Submission $submission)
    {
        // Check authorization
        // DesaScope handles isolation (operator A cannot find operator B's submission)
        // But we explicitly check capability here
        if (!auth()->user()->can('submission.edit')) {
            abort(403);
        }

        if (!$submission->isEditable() && $submission->status != 'draft') {
            // For now allow viewing, but form might be disabled if I implement that logic. 
            // But 'edit' implies change.
        }

        // Cached Menu List
        $menus = $this->masterData->getAllMenus();
        $selectedMenuId = $submission->menu_id;
        $submission->load(['jawabanIndikator', 'buktiDukung']);

        return view('submissions.create', compact('menus', 'selectedMenuId', 'submission'));
    }

    public function update(Request $request, \App\Models\Submission $submission)
    {
        $request->validate([
            'indikator' => 'required|array',
            'action' => 'required|in:draft,submit'
        ]);

        if (!$submission->isEditable()) {
            return back()->with('error', 'Laporan tidak dapat diedit saat status: ' . $submission->status);
        }

        \DB::beginTransaction();
        try {
            $user = auth()->user();

            $submission->update([
                'status' => $request->action === 'submit' ? \App\Models\Submission::STATUS_SUBMITTED : \App\Models\Submission::STATUS_DRAFT,
                'submitted_at' => $request->action === 'submit' ? now() : $submission->submitted_at,
            ]);

            // Process Indicators
            foreach ($request->indikator as $indikatorId => $data) {
                // Update/Create Answer
                if (isset($data['nilai'])) {
                    \App\Models\JawabanIndikator::updateOrCreate(
                        ['submission_id' => $submission->id, 'indikator_id' => $indikatorId],
                        ['nilai' => $data['nilai']]
                    );
                }

                // Handle File Upload
                if ($request->hasFile("indikator.{$indikatorId}.file")) {
                    $file = $request->file("indikator.{$indikatorId}.file");
                    $path = $file->store('bukti_dukung/' . $submission->uuid, 'local'); // Private storage

                    \App\Models\BuktiDukung::create([
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

            \DB::commit();
            return redirect()->route('desa.dashboard')->with('success', 'Laporan berhasil diperbarui!');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function getAspek($menuId)
    {
        // Cached Aspek List
        $aspeks = $this->masterData->getAspekByMenu($menuId);
        // We need to return JSON with id and nama_aspek. The cached collection has it.
        // It returns whole object, but we can return it as is or map. 
        // Returning collection as JSON response works fine.
        return response()->json($aspeks);
    }

    public function getIndikator($aspekId)
    {
        // Cached Indikator List
        $indikators = $this->masterData->getIndikatorByAspek($aspekId);
        return response()->json($indikators);
    }
}
