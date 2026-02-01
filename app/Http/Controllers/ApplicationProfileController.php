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
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image_umkm' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            'image_pariwisata' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            'image_festival' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $profile = AppProfile::first() ?? new AppProfile();

        $data = $request->only(['app_name', 'region_name', 'region_level', 'tagline']);
        $data['updated_by'] = auth()->id();

        // Handle File Uploads
        $fileFields = [
            'logo_path' => 'logo_path',
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

                $path = 'app';
                if ($requestKey === 'logo_path') {
                    $path = 'logos';
                }

                $data[$dbColumn] = $request->file($requestKey)->store($path, 'public');
            }
        }

        $profile->fill($data);
        $profile->save();

        $this->profileService->clearCache();

        return redirect()->back()->with('success', 'Identitas aplikasi berhasil diperbarui.');
    }

    public function features()
    {
        $menus = \App\Models\Menu::orderBy('urutan')->get();
        return view('kecamatan.settings.features', compact('menus'));
    }

    public function toggleFeature(Request $request)
    {
        $request->validate([
            'kode_menu' => 'required|string|exists:menu,kode_menu',
            'is_active' => 'required|boolean',
        ]);

        $menu = \App\Models\Menu::where('kode_menu', $request->kode_menu)->first();
        $menu->is_active = $request->is_active;
        $menu->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status fitur ' . $menu->nama_menu . ' berhasil diperbarui.'
        ]);
    }
}
