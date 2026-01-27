<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Entry point for dashboard.
     * Redirects to the appropriate domain dashboard.
     */
    public function index()
    {
        if (auth()->user()->desa_id !== null) {
            return redirect()->route('desa.dashboard');
        }
        return redirect()->route('kecamatan.dashboard');
    }

    /**
     * Forwarding stats and chart calls to Kecamatan dashboard if needed,
     * or handle them here if they are shared.
     */
    public function stats()
    {
        return app(\App\Http\Controllers\Kecamatan\DashboardController::class)->stats();
    }

    public function chartData(Request $request)
    {
        return app(\App\Http\Controllers\Kecamatan\DashboardController::class)->chartData($request);
    }
}
