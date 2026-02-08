<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use App\Models\UmkmLocal;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LayananPublikController extends Controller
{
    /**
     * --- UMKM SECTION ---
     */

    public function umkmIndex()
    {
        $umkm = UmkmLocal::latest()->paginate(10);
        return view('kecamatan.layanan.umkm.index', compact('umkm'));
    }

    public function umkmCreate()
    {
        return view('kecamatan.layanan.umkm.form');
    }

    public function umkmStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'product' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'contact_wa' => 'required|string|max:20',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'required|boolean',
            'is_featured' => 'required|boolean',
        ]);

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('umkm-images', 'public');
            $validated['image_path'] = $path;
        }

        UmkmLocal::create($validated);

        return redirect()->route('kecamatan.umkm.index')->with('success', 'Data UMKM berhasil ditambahkan.');
    }

    public function umkmEdit($id)
    {
        $umkm = UmkmLocal::findOrFail($id);
        return view('kecamatan.layanan.umkm.form', compact('umkm'));
    }

    public function umkmUpdate(Request $request, $id)
    {
        $umkm = UmkmLocal::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'product' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'contact_wa' => 'required|string|max:20',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'required|boolean',
            'is_featured' => 'required|boolean',
        ]);

        if ($request->hasFile('image_path')) {
            if ($umkm->image_path) {
                Storage::disk('public')->delete($umkm->image_path);
            }
            $path = $request->file('image_path')->store('umkm-images', 'public');
            $validated['image_path'] = $path;
        }

        $umkm->update($validated);

        return redirect()->route('kecamatan.umkm.index')->with('success', 'Data UMKM berhasil diperbarui.');
    }

    public function umkmDestroy($id)
    {
        $umkm = UmkmLocal::findOrFail($id);
        if ($umkm->image_path) {
            Storage::disk('public')->delete($umkm->image_path);
        }
        $umkm->delete();

        return redirect()->route('kecamatan.umkm.index')->with('success', 'Data UMKM berhasil dihapus.');
    }

    /**
     * --- JOB VACANCY SECTION ---
     */

    public function lokerIndex()
    {
        $loker = JobVacancy::latest()->paginate(10);
        return view('kecamatan.layanan.loker.index', compact('loker'));
    }

    public function lokerCreate()
    {
        return view('kecamatan.layanan.loker.form');
    }

    public function lokerStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'contact_wa' => 'required|string|max:20',
            'description' => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        JobVacancy::create($validated);

        return redirect()->route('kecamatan.loker.index')->with('success', 'Data Lowongan Kerja berhasil ditambahkan.');
    }

    public function lokerEdit($id)
    {
        $loker = JobVacancy::findOrFail($id);
        return view('kecamatan.layanan.loker.form', compact('loker'));
    }

    public function lokerUpdate(Request $request, $id)
    {
        $loker = JobVacancy::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'contact_wa' => 'required|string|max:20',
            'description' => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        $loker->update($validated);

        return redirect()->route('kecamatan.loker.index')->with('success', 'Data Lowongan Kerja berhasil diperbarui.');
    }

    public function lokerDestroy($id)
    {
        $loker = JobVacancy::findOrFail($id);
        $loker->delete();

        return redirect()->route('kecamatan.loker.index')->with('success', 'Data Lowongan Kerja berhasil dihapus.');
    }
}
