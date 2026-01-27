<?php

use App\Http\Controllers\Kecamatan\DashboardController;
use App\Http\Controllers\Kecamatan\EkbangController;
use App\Http\Controllers\Kecamatan\KesraController;
use App\Http\Controllers\Kecamatan\PemerintahanController;
use App\Http\Controllers\Kecamatan\TrantibumController;
use App\Http\Controllers\Kecamatan\VerifikasiController;
use App\Http\Controllers\Kecamatan\LaporanController;
use App\Http\Controllers\Kecamatan\UserManagementController;
use App\Http\Controllers\Master\DesaMasterController;
use App\Http\Controllers\Pemerintahan\AparaturController; // Keep for now or move
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('kecamatan')->name('kecamatan.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Verification & Approval
    Route::prefix('verifikasi')->name('verifikasi.')->group(function () {
        Route::get('/', [VerifikasiController::class, 'index'])->name('index');
        Route::get('/{uuid}', [VerifikasiController::class, 'show'])->name('show');
        Route::post('/{id}/process', [VerifikasiController::class, 'process'])->name('process');
    });

    // Pemerintahan (Monitoring Side)
    Route::prefix('pemerintahan')->name('pemerintahan.')->group(function () {
        Route::get('/', [PemerintahanController::class, 'index'])->name('index');
        Route::get('/export-audit', [PemerintahanController::class, 'exportAudit'])->name('export');

        // Visitor Registry (Buku Tamu)
        Route::get('/visitor', [PemerintahanController::class, 'visitorIndex'])->name('visitor.index');
        Route::post('/visitor', [PemerintahanController::class, 'visitorStore'])->name('visitor.store');
        Route::patch('/visitor/{id}', [PemerintahanController::class, 'visitorUpdate'])->name('visitor.update');

        // Administrative Governance Modules (Detailed Monitoring)
        Route::prefix('detail')->name('detail.')->group(function () {
            Route::get('/personil', [PemerintahanController::class, 'personilIndex'])->name('personil.index');
            Route::post('/personil', [PemerintahanController::class, 'personilStore'])->name('personil.store');

            Route::get('/bpd', [PemerintahanController::class, 'bpdIndex'])->name('bpd.index');
            Route::post('/bpd', [PemerintahanController::class, 'personilStore'])->name('bpd.store'); // Reuse store for now

            Route::get('/lembaga', [PemerintahanController::class, 'lembagaIndex'])->name('lembaga.index');
            Route::post('/lembaga', [PemerintahanController::class, 'lembagaStore'])->name('lembaga.store');
            Route::get('/perencanaan', [PemerintahanController::class, 'perencanaanIndex'])->name('perencanaan.index');
            Route::post('/perencanaan', [PemerintahanController::class, 'perencanaanStore'])->name('perencanaan.store');
            Route::get('/perencanaan/{id}', [PemerintahanController::class, 'perencanaanShow'])->name('perencanaan.show');
            Route::get('/laporan', [PemerintahanController::class, 'laporanIndex'])->name('laporan.index');
            Route::get('/inventaris', [PemerintahanController::class, 'inventarisIndex'])->name('inventaris.index');
            Route::post('/inventaris', [PemerintahanController::class, 'inventarisStore'])->name('inventaris.store');
            Route::get('/dokumen', [PemerintahanController::class, 'dokumenIndex'])->name('dokumen.index');
            Route::post('/dokumen', [PemerintahanController::class, 'dokumenStore'])->name('dokumen.store');
        });

        // Sub-Modul: Data Kepala Desa & Perangkat
        Route::resource('aparatur', AparaturController::class);
        Route::post('aparatur/{id}/verify', [AparaturController::class, 'verify'])->name('aparatur.verify');
    });

    // Ekbang (Monitoring Side)
    Route::prefix('ekbang')->name('ekbang.')->group(function () {
        Route::get('/', [EkbangController::class, 'index'])->name('index');
        Route::get('/dana-desa', [EkbangController::class, 'danaDesa'])->name('dana-desa.index');
        Route::get('/fisik', [EkbangController::class, 'fisik'])->name('fisik.index');
        Route::get('/realisasi', [EkbangController::class, 'realisasi'])->name('realisasi.index');
        Route::get('/kepatuhan', [EkbangController::class, 'kepatuhan'])->name('kepatuhan.index');
        Route::get('/audit', [EkbangController::class, 'audit'])->name('audit.index');
    });

    // Kesejahteraan Rakyat
    Route::prefix('kesra')->name('kesra.')->group(function () {
        Route::get('/', [KesraController::class, 'index'])->name('index');
        Route::get('/bansos', [KesraController::class, 'bansosIndex'])->name('bansos.index');
        Route::get('/pendidikan', [KesraController::class, 'pendidikanIndex'])->name('pendidikan.index');
        Route::get('/kesehatan', [KesraController::class, 'kesehatanIndex'])->name('kesehatan.index');
        Route::get('/sosial-budaya', [KesraController::class, 'sosialBudayaIndex'])->name('sosial-budaya.index');
        Route::get('/rekomendasi', [KesraController::class, 'rekomendasiIndex'])->name('rekomendasi.index');
        Route::post('/process/{id}', [KesraController::class, 'process'])->name('process');
    });

    // Trantibum
    Route::prefix('trantibum')->name('trantibum.')->group(function () {
        Route::get('/', [TrantibumController::class, 'index'])->name('index');
        Route::get('/{id}', [TrantibumController::class, 'show'])->name('show');
    });

    // Modul Laporan (Monev & Rekap Administratif)
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/ekbang', [LaporanController::class, 'ekbang'])->name('ekbang');
        // Rename or keep consistency with user's structure
        Route::get('/pemerintahan', [LaporanController::class, 'pemerintahan'])->name('pemerintahan');
        Route::get('/kesra', [LaporanController::class, 'kesra'])->name('kesra');
        Route::get('/trantibum', [LaporanController::class, 'trantibum'])->name('trantibum');
        Route::get('/export', [LaporanController::class, 'export'])->name('export');
    });

    // Modul User Management
    Route::resource('users', UserManagementController::class);

    // Modul Master Data
    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('desa', DesaMasterController::class)->except(['show']);
    });
});
