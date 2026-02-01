<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\Desa\SubmissionController;

Route::apiResource('submissions', SubmissionController::class);
Route::post('submissions/{id}/status', [SubmissionController::class, 'changeStatus']);

// SPJ Template & Draft Routes
Route::get('/spj-template/{id}/download', [\App\Http\Controllers\SpjTemplateController::class, 'downloadDraft'])->name('spj.download');
Route::delete('/spj-template/{id}', [\App\Http\Controllers\SpjTemplateController::class, 'destroy'])->name('spj.destroy');

// Real-time Assistant Routes (SAE Helper)
Route::post('/assistant/predict-docs', [\App\Http\Controllers\Desa\PembangunanController::class, 'predictDocs']);
Route::post('/assistant/estimate-tax', [\App\Http\Controllers\Desa\PembangunanController::class, 'estimateTax']);

