<?php

namespace App\Http\Controllers;

use App\Models\ProcessedRequest;
use App\Models\RequestReport;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        // Retrieve the most recently generated report.
        $latestReport = RequestReport::latest('generated_at')->first();

        // Retrieve the reference entered by the user.
        $reference = trim($request->query('reference', ''));

        // Build the processed requests query.
        $query = ProcessedRequest::query();

        // Search by reference when a reference is provided.
        if ($reference !== '') {
            $query->where(
                'reference_code',
                'like',
                '%'.$reference.'%'
            );
        }

        // Display the 20 most recent processed requests.
        // Pagination shows 10 requests per page.
        $recentRequests = $query
            ->orderBy('processed_at', 'desc')
            ->orderBy('id', 'desc')
            ->limit(20)
            ->paginate(10)
            ->withQueryString();

        // Calculate organization statistics using all processed requests.
        // These statistics are independent from pagination and reference search.
        $totalRequests = ProcessedRequest::count();

        $requestsByOrganization = ProcessedRequest::query()
            ->selectRaw('organization, COUNT(*) as total')
            ->groupBy('organization')
            ->orderByDesc('total')
            ->get()
            ->map(function ($organization) use ($totalRequests) {
                $organization->percentage = $totalRequests > 0
                    ? round(($organization->total / $totalRequests) * 100, 1)
                    : 0;

                return $organization;
            });

        return view('dashboard', [
            'latestReport' => $latestReport,
            'recentRequests' => $recentRequests,
            'totalRequests' => $totalRequests,
            'requestsByOrganization' => $requestsByOrganization,
        ]);
    }
}
