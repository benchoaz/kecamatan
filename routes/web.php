<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
require __DIR__ . '/debug.php';

use App\Http\Controllers\AuthController;

use App\Http\Controllers\FileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

// Public Landing Page
Route::get('/', function () {
    $publicAnnouncements = \App\Models\Announcement::where('target_type', 'public')
        ->where('is_active', true)
        ->where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->orderBy('priority', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();

    $latestBerita = \App\Models\Berita::published()
        ->with('author:id,nama_lengkap')
        ->latest('published_at')
        ->take(4)
        ->get();

    return view('landing', compact('publicAnnouncements', 'latestBerita'));
});

// Public Service Portal
Route::get('/layanan', function () {
    return view('layanan');
})->name('layanan');

use App\Http\Controllers\PublicServiceController;
use App\Http\Controllers\ApplicationProfileController;
use App\Http\Controllers\Kecamatan\DesaMasterController; // Added for DesaMasterController

Route::post('/public-service/submit', [PublicServiceController::class, 'submit'])->name('public.service.submit');
Route::get('/api/faq-search', [PublicServiceController::class, 'faqSearch'])->name('api.faq.search');

// Public Berita Routes (Read-Only)
Route::prefix('berita')->name('public.berita.')->group(function () {
    Route::get('/', [\App\Http\Controllers\PublicBeritaController::class, 'index'])->name('index');
    Route::get('/{slug}', [\App\Http\Controllers\PublicBeritaController::class, 'show'])->name('show');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']); // Fallback for GET logout errors

// Shared Dashboard Redirector
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Generic Auth-Required Routes
Route::middleware(['auth'])->group(function () {
    // Generic Auth-Required Routes
    Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard.chart-data');

    // Secure File Route (Protected by Auth, but FileController should handle specific permissions)
    Route::get('/files/{uuid}/{filename}', [FileController::class, 'show'])->name('files.show');

    // Kecamatan Domain Routes
    Route::middleware(['role:Operator Kecamatan,Super Admin'])->group(function () {
        // System Settings
        Route::get('/kecamatan/settings/profile', [ApplicationProfileController::class, 'index'])->name('kecamatan.settings.profile');
        Route::put('/kecamatan/settings/profile', [ApplicationProfileController::class, 'update'])->name('kecamatan.settings.profile.update');

        // Pelayanan Domain
        Route::prefix('kecamatan/pelayanan')->name('kecamatan.pelayanan.')->group(function () {
            Route::get('/inbox', [\App\Http\Controllers\Kecamatan\PelayananController::class, 'inbox'])->name('inbox');
            Route::get('/inbox/{id}', [\App\Http\Controllers\Kecamatan\PelayananController::class, 'show'])->name('show');
            Route::put('/inbox/{id}/status', [\App\Http\Controllers\Kecamatan\PelayananController::class, 'updateStatus'])->name('update-status');

            Route::get('/faq', [\App\Http\Controllers\Kecamatan\PelayananController::class, 'faqIndex'])->name('faq.index');
            Route::post('/faq', [\App\Http\Controllers\Kecamatan\PelayananController::class, 'faqStore'])->name('faq.store');
            Route::put('/faq/{id}', [\App\Http\Controllers\Kecamatan\PelayananController::class, 'faqUpdate'])->name('faq.update');

            Route::get('/statistics', [\App\Http\Controllers\Kecamatan\PelayananController::class, 'statistics'])->name('statistics');

            // Buku Tamu (Moved from Pemerintahan)
            Route::get('/visitor', [\App\Http\Controllers\Kecamatan\PelayananController::class, 'visitorIndex'])->name('visitor.index');
            Route::post('/visitor', [\App\Http\Controllers\Kecamatan\PelayananController::class, 'visitorStore'])->name('visitor.store');
            Route::patch('/visitor/{id}', [\App\Http\Controllers\Kecamatan\PelayananController::class, 'visitorUpdate'])->name('visitor.update');
        });

        // Pengumuman Domain
        Route::prefix('kecamatan/announcements')->name('kecamatan.announcements.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Kecamatan\AnnouncementController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Kecamatan\AnnouncementController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Kecamatan\AnnouncementController::class, 'store'])->name('store');
            Route::get('/{announcement}/edit', [\App\Http\Controllers\Kecamatan\AnnouncementController::class, 'edit'])->name('edit');
            Route::put('/{announcement}', [\App\Http\Controllers\Kecamatan\AnnouncementController::class, 'update'])->name('update');
            Route::delete('/{announcement}', [\App\Http\Controllers\Kecamatan\AnnouncementController::class, 'destroy'])->name('destroy');
        });
    });
});
