<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\DesaMasterController;
use App\Http\Controllers\Pemerintahan\AparaturController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\Kecamatan\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Landing Page
Route::get('/', function () {
    return view('landing');
});

// Public Service Portal
Route::get('/layanan', function () {
    return view('layanan');
})->name('layanan');


// Auth Routes
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'authenticate']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Dashboard Controller Router
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Domain: Desa (Village Operator)
Route::middleware(['auth'])->prefix('desa')->name('desa.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'desaIndex'])->name('dashboard');

    // Web Submission Routes
    Route::prefix('submissions')->name('submissions.')->group(function () {
        Route::get('/', [\App\Http\Controllers\SubmissionWebController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\SubmissionWebController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\SubmissionWebController::class, 'store'])->name('store');
        Route::get('/helper/aspek/{menuId}', [\App\Http\Controllers\SubmissionWebController::class, 'getAspek']);
        Route::get('/helper/indikator/{aspekId}', [\App\Http\Controllers\SubmissionWebController::class, 'getIndikator']);
        Route::get('/{submission}/edit', [\App\Http\Controllers\SubmissionWebController::class, 'edit'])->name('edit');
        Route::put('/{submission}', [\App\Http\Controllers\SubmissionWebController::class, 'update'])->name('update');
    });



    // Ekbang (Input Side)
    Route::prefix('ekbang')->name('ekbang.')->group(function () {
        Route::get('/', [\App\Http\Controllers\EkonomiPembangunanController::class, 'index'])->name('index');
        Route::get('/dana-desa', [\App\Http\Controllers\EkonomiPembangunanController::class, 'danaDesa'])->name('dana-desa.index');
        Route::get('/fisik', [\App\Http\Controllers\EkonomiPembangunanController::class, 'fisik'])->name('fisik.index');
        Route::get('/realisasi', [\App\Http\Controllers\EkonomiPembangunanController::class, 'realisasi'])->name('realisasi.index');
        Route::get('/kepatuhan', [\App\Http\Controllers\EkonomiPembangunanController::class, 'kepatuhan'])->name('kepatuhan.index');
        Route::get('/audit', [\App\Http\Controllers\EkonomiPembangunanController::class, 'audit'])->name('audit.index');
    });
});

// Domain: Kecamatan (Kasi, Camat, Admin)
Route::middleware(['auth'])->prefix('kecamatan')->name('kecamatan.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'kecamatanIndex'])->name('dashboard');

    // Verification & Approval
    Route::prefix('verifikasi')->name('verifikasi.')->group(function () {
        Route::get('/', [\App\Http\Controllers\VerifikasiController::class, 'index'])->name('index');
        Route::get('/{uuid}', [\App\Http\Controllers\VerifikasiController::class, 'show'])->name('show');
        Route::post('/{id}/process', [\App\Http\Controllers\VerifikasiController::class, 'process'])->name('process');
    });

    // Pemerintahan (Monitoring Side)
    Route::prefix('pemerintahan')->name('pemerintahan.')->group(function () {
        Route::get('/', [\App\Http\Controllers\PemerintahanController::class, 'index'])->name('index');
        Route::get('/export-audit', [\App\Http\Controllers\PemerintahanDetailController::class, 'exportAudit'])->name('export');

        // Visitor Registry (Buku Tamu)
        Route::get('/visitor', [\App\Http\Controllers\PemerintahanDetailController::class, 'visitorIndex'])->name('visitor.index');
        Route::post('/visitor', [\App\Http\Controllers\PemerintahanDetailController::class, 'visitorStore'])->name('visitor.store');
        Route::patch('/visitor/{id}', [\App\Http\Controllers\PemerintahanDetailController::class, 'visitorUpdate'])->name('visitor.update');

        // Administrative Governance Modules (Detailed Monitoring)
        Route::prefix('detail')->name('detail.')->group(function () {
            Route::get('/personil', [\App\Http\Controllers\PemerintahanDetailController::class, 'personilIndex'])->name('personil.index');
            Route::get('/bpd', [\App\Http\Controllers\PemerintahanDetailController::class, 'bpdIndex'])->name('bpd.index');
            Route::get('/lembaga', [\App\Http\Controllers\PemerintahanDetailController::class, 'lembagaIndex'])->name('lembaga.index');
            Route::get('/perencanaan', [\App\Http\Controllers\PemerintahanDetailController::class, 'perencanaanIndex'])->name('perencanaan.index');
            Route::get('/perencanaan/{id}', [\App\Http\Controllers\PemerintahanDetailController::class, 'perencanaanShow'])->name('perencanaan.show');
            Route::get('/laporan', [\App\Http\Controllers\PemerintahanDetailController::class, 'laporanIndex'])->name('laporan.index');
            Route::get('/inventaris', [\App\Http\Controllers\PemerintahanDetailController::class, 'inventarisIndex'])->name('inventaris.index');
            Route::get('/dokumen', [\App\Http\Controllers\PemerintahanDetailController::class, 'dokumenIndex'])->name('dokumen.index');

            // Actions (Kecamatan Managed)
            Route::post('/personil', [\App\Http\Controllers\PemerintahanDetailController::class, 'personilStore'])->name('personil.store');
            Route::post('/inventaris', [\App\Http\Controllers\PemerintahanDetailController::class, 'inventarisStore'])->name('inventaris.store');
            Route::post('/lembaga', [\App\Http\Controllers\PemerintahanDetailController::class, 'lembagaStore'])->name('lembaga.store');
            Route::post('/dokumen', [\App\Http\Controllers\PemerintahanDetailController::class, 'dokumenStore'])->name('dokumen.store');
            Route::post('/perencanaan', [\App\Http\Controllers\PemerintahanDetailController::class, 'perencanaanStore'])->name('perencanaan.store');
        });

        // Sub-Modul: Data Kepala Desa & Perangkat
        Route::resource('aparatur', AparaturController::class);
        Route::post('aparatur/{id}/verify', [AparaturController::class, 'verify'])->name('aparatur.verify');
    });

    // Ekbang (Monitoring Side)
    Route::prefix('ekbang')->name('ekbang.')->group(function () {
        Route::get('/', [\App\Http\Controllers\EkonomiPembangunanController::class, 'kecamatanIndex'])->name('index');
    });

    // Kesejahteraan Rakyat (Pasal 439)
    Route::prefix('kesra')->name('kesra.')->group(function () {
        Route::get('/', [App\Http\Controllers\KasiKesraController::class, 'index'])->name('index');
        Route::get('/bansos', [App\Http\Controllers\KasiKesraController::class, 'bansosIndex'])->name('bansos.index');
        Route::get('/pendidikan', [App\Http\Controllers\KasiKesraController::class, 'pendidikanIndex'])->name('pendidikan.index');
        Route::get('/kesehatan', [App\Http\Controllers\KasiKesraController::class, 'kesehatanIndex'])->name('kesehatan.index');
        Route::get('/sosial-budaya', [App\Http\Controllers\KasiKesraController::class, 'sosialBudayaIndex'])->name('sosial-budaya.index');
        Route::get('/rekomendasi', [App\Http\Controllers\KasiKesraController::class, 'rekomendasiIndex'])->name('rekomendasi.index');
        Route::post('/process/{id}', [App\Http\Controllers\KasiKesraController::class, 'process'])->name('process');
    });

    // Trantibum
    Route::prefix('trantibum')->name('trantibum.')->group(function () {
        Route::get('/', [\App\Http\Controllers\TrantibumController::class, 'kecamatanIndex'])->name('index');
    });

    // Modul User Management (Access Control)
    Route::resource('users', UserManagementController::class);

    // Modul Master Data (Foundation)
    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('desa', DesaMasterController::class)->except(['show']);
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard.chart-data');

    // Secure File Route
    Route::get('/files/{uuid}/{filename}', [\App\Http\Controllers\FileController::class, 'show'])
        ->name('files.show');
});
