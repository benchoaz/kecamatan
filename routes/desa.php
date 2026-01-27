<?php

use App\Http\Controllers\Desa\DashboardController;
use App\Http\Controllers\Desa\EkbangController;
use App\Http\Controllers\Desa\PemerintahanController;
use App\Http\Controllers\Desa\SubmissionController;
use App\Http\Controllers\Desa\TrantibumController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('desa')->name('desa.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Web Submission Routes
    Route::prefix('submissions')->name('submissions.')->group(function () {
        Route::get('/', [SubmissionController::class, 'index'])->name('index');
        Route::get('/create', [SubmissionController::class, 'create'])->name('create');
        Route::post('/', [SubmissionController::class, 'store'])->name('store');
        Route::get('/helper/aspek/{menuId}', [SubmissionController::class, 'getAspek']);
        Route::get('/helper/indikator/{aspekId}', [SubmissionController::class, 'getIndikator']);
        Route::get('/{submission}/edit', [SubmissionController::class, 'edit'])->name('edit');
        Route::put('/{submission}', [SubmissionController::class, 'update'])->name('update');
    });

    // Ekbang (Input Side)
    Route::prefix('ekbang')->name('ekbang.')->group(function () {
        Route::get('/', [EkbangController::class, 'index'])->name('index');
        Route::get('/dana-desa', [EkbangController::class, 'danaDesa'])->name('dana-desa.index');
        Route::get('/fisik', [EkbangController::class, 'fisik'])->name('fisik.index');
        Route::get('/realisasi', [EkbangController::class, 'realisasi'])->name('realisasi.index');
        Route::get('/kepatuhan', [EkbangController::class, 'kepatuhan'])->name('kepatuhan.index');
        Route::get('/audit', [EkbangController::class, 'audit'])->name('audit.index');
    });

    // Pemerintahan (Input Side)
    Route::prefix('pemerintahan')->name('pemerintahan.')->group(function () {
        Route::get('/', [PemerintahanController::class, 'index'])->name('index');
        Route::get('/export-audit', [PemerintahanController::class, 'exportAudit'])->name('export');

        Route::prefix('detail')->name('detail.')->group(function () {
            Route::get('/personil', [PemerintahanController::class, 'personilIndex'])->name('personil.index');
            Route::get('/bpd', [PemerintahanController::class, 'bpdIndex'])->name('bpd.index');
            Route::get('/lembaga', [PemerintahanController::class, 'lembagaIndex'])->name('lembaga.index');
            Route::get('/perencanaan', [PemerintahanController::class, 'perencanaanIndex'])->name('perencanaan.index');
            Route::get('/perencanaan/{id}', [PemerintahanController::class, 'perencanaanShow'])->name('perencanaan.show');
            Route::get('/laporan', [PemerintahanController::class, 'laporanIndex'])->name('laporan.index');
            Route::get('/inventaris', [PemerintahanController::class, 'inventarisIndex'])->name('inventaris.index');
            Route::get('/dokumen', [PemerintahanController::class, 'dokumenIndex'])->name('dokumen.index');

            Route::post('/personil', [PemerintahanController::class, 'personilStore'])->name('personil.store');
            Route::post('/inventaris', [PemerintahanController::class, 'inventarisStore'])->name('inventaris.store');
            Route::post('/lembaga', [PemerintahanController::class, 'lembagaStore'])->name('lembaga.store');
            Route::post('/dokumen', [PemerintahanController::class, 'dokumenStore'])->name('dokumen.store');
            Route::post('/perencanaan', [PemerintahanController::class, 'perencanaanStore'])->name('perencanaan.store');
        });
    });

    // Trantibum (Input Side)
    Route::prefix('trantibum')->name('trantibum.')->group(function () {
        Route::get('/', [TrantibumController::class, 'index'])->name('index');
        Route::get('/{id}', [TrantibumController::class, 'show'])->name('show');
    });
});
