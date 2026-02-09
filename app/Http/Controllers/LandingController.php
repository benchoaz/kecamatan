<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Berita;
use App\Models\PelayananFaq;
use App\Models\PublicService;
use App\Models\UmkmLocal;
use App\Models\JobVacancy;
use App\Models\WorkDirectory;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $publicAnnouncements = Announcement::where('target_type', 'public')
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $latestBerita = Berita::published()
            ->with('author:id,nama_lengkap')
            ->latest('published_at')
            ->take(4)
            ->get();

        $faqKeywords = PelayananFaq::where('is_active', true)
            ->pluck('keywords')
            ->filter()
            ->flatMap(function ($k) {
                return explode(',', $k);
            })
            ->map(function ($k) {
                return trim(strtolower($k));
            })
            ->unique()
            ->values()
            ->toArray();

        // New data for overhauled landing page
        $featuredLayanan = PelayananFaq::where('is_active', true)
            ->where('category', '!=', 'Darurat')
            ->take(5)
            ->get();

        $masterLayanan = \App\Models\MasterLayanan::where('is_active', true)->orderBy('urutan')->get();

        $resolvedComplaints = PublicService::where('status', 'selesai')
            ->latest()
            ->take(3)
            ->get();

        $umkms = \App\Models\Umkm::where('status', 'aktif')->latest()->take(6)->get();
        $jobs = \App\Models\JobVacancy::where('is_active', true)->latest()->take(4)->get();
        $desas = \App\Models\Desa::orderBy('nama_desa')->get();

        // Work Directory - Latest jobs and services
        $workItems = WorkDirectory::public()->latest()->take(6)->get();

        // Hero Section Settings
        $profileService = app(\App\Services\ApplicationProfileService::class);
        $heroBg = $profileService->getHeroBg();
        $bgOpacity = $profileService->getHeroBgOpacity();
        $bgBlur = $profileService->getHeroBgBlur();
        $isHeroActive = $profileService->isHeroImageActive();
        $heroImage = $profileService->getHeroImage();
        $heroImageAlt = $profileService->getHeroImageAlt();

        return view('landing', compact(
            'publicAnnouncements',
            'latestBerita',
            'faqKeywords',
            'featuredLayanan',
            'masterLayanan',
            'resolvedComplaints',
            'umkms',
            'jobs',
            'desas',
            'workItems',
            'heroBg',
            'bgOpacity',
            'bgBlur',
            'isHeroActive',
            'heroImage',
            'heroImageAlt'
        ));
    }
}
