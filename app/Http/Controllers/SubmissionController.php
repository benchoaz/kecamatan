<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    protected $submissionService;

    public function __construct(\App\Services\SubmissionService $submissionService)
    {
        $this->submissionService = $submissionService;
    }

    public function index(Request $request)
    {
        // TODO: Implement filters from request
        $submissions = \App\Models\Submission::with(['desa', 'menu', 'aspek'])->latest()->paginate(10);
        return response()->json($submissions);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'desa_id' => 'required|exists:desa,id',
            'menu_id' => 'required|exists:menu,id',
            'aspek_id' => 'required|exists:aspek,id',
            'tahun' => 'required|digits:4',
            'periode' => 'required|in:bulanan,triwulan,semester,tahunan',
            // Add other validations
        ]);

        try {
            // Assume Auth::id() is set, or pass from request for testing
            $userId = auth()->id() ?? 1; // Fallback for dev
            $submission = $this->submissionService->createSubmission($validated, $userId);
            return response()->json(['message' => 'Submission created', 'data' => $submission], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        $submission = \App\Models\Submission::with(['desa', 'menu', 'aspek', 'jawabanIndikator', 'buktiDukung', 'verifikasi'])->find($id);
        if (!$submission) return response()->json(['message' => 'Not found'], 404);
        return response()->json($submission);
    }

    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:submitted,reviewed,revision,approved,rejected',
            'catatan' => 'nullable|string'
        ]);

        try {
            $userId = auth()->id() ?? 1;
            // Get user role logic here or pass generic role for now
            $role = 'camat'; // Mock role for dev
            
            $submission = $this->submissionService->processApproval(
                $id, 
                $request->status, 
                $request->catatan, 
                $userId, 
                $role // In real app, get from auth()->user()->role
            );
            return response()->json(['message' => 'Status updated', 'data' => $submission]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
