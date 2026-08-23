<?php

namespace App\Http\Controllers;

use App\Models\ProcessedRequest;
use App\Models\RequestReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        // Retrieve the most recently generated report.
        $latestReport = RequestReport::latest('generated_at')->first();

        // Define the database columns that can be used for sorting.
        $allowedSorts = [
            'reference_code',
            'organization',
            'subject',
            'status',
            'processed_at',
        ];

        // Get the requested sort column and direction from the query string.
        $sort = $request->query('sort', 'processed_at');
        $direction = $request->query('direction', 'desc');

        // Validate the requested sorting parameters.
        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'processed_at';
        }

        if (! in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        // Retrieve the reference entered by the user.
        $reference = trim($request->query('reference', ''));

        // Build the processed requests query.
        $query = ProcessedRequest::query();

        // Search by reference when a reference is provided.
        // Otherwise, display only requests processed during the last seven days.
        if ($reference !== '') {
            $query->where(
                'reference_code',
                'like',
                '%'.$reference.'%'
            );
        } else {
            $query->where(
                'processed_at',
                '>=',
                Carbon::now()->subDays(7)
            );
        }

        // Apply sorting and server-side pagination.
        $recentRequests = $query
            ->orderBy($sort, $direction)
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('dashboard', [
            'latestReport' => $latestReport,
            'recentRequests' => $recentRequests,
        ]);
    }
}
