<?php

namespace App\Http\Controllers;

use App\Models\ProcessedRequest;
use App\Models\RequestReport;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Retrieve the most recently generated report.
        $latestReport = RequestReport::latest('generated_at')->first();

        // Retrieve the five most recently processed requests.
        // Use the ID as a secondary sort criterion when multiple requests
        // have the same processing timestamp.
        $recentRequests = ProcessedRequest::query()
            ->latest('processed_at')
            ->latest('id')
            ->limit(5)
            ->get();

        // Pass the report and recent requests to the Dashboard view.
        return view('dashboard', [
            'latestReport' => $latestReport,
            'recentRequests' => $recentRequests,
        ]);
    }
}