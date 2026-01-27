<?php

namespace App\Http\Controllers;

use App\Models\AppProfile;
use App\Services\ApplicationProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationProfileController extends Controller
{
    protected $profileService;

    public function __construct(ApplicationProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        $profile = $this->profileService->getProfile();
        return view('kecamatan.settings.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:100',
            'region_name' => 'required|string|max:100',
            'region_level' => 'required|in:desa,kecamatan,kabupaten',
            'tagline' => 'nullable|string|max:200',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image_umkm' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'image_pariwisata' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'image_festival' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $profile = AppProfile::first() ?? new AppProfile();

        $data = $request->only(['app_name', 'region_name', 'region_level', 'tagline']);
        $data['updated_by'] = auth()->id();

        // Handle File Uploads
        $fileFields = [
            'logo' => 'logo_path',
            'image_umkm' => 'image_umkm',
            'image_pariwisata' => 'image_pariwisata',
            'image_festival' => 'image_festival'
        ];

        foreach ($fileFields as $requestKey => $dbColumn) {
            if ($request->hasFile($requestKey)) {
                // Delete old file if exists
                if ($profile->$dbColumn) {
                    Storage::disk('public')->delete($profile->$dbColumn);
                }
                $data[$dbColumn] = $request->file($requestKey)->store('app', 'public');
            }
        }

        $profile->fill($data);
        $profile->save();

        $this->profileService->clearCache();

        return redirect()->back()->with('success', 'Identitas aplikasi berhasil diperbarui.');
    }
}
