<?php

namespace App\Jobs;

use App\Models\ProcessedRequest;
use App\Models\RequestReport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateRequestReportJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Check the table and save total requests
     */
    public function handle(): void
    {
        $totalRequests = ProcessedRequest::count();

        $requestsByOrganization = ProcessedRequest::query()
            ->select('organization')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('organization')
            ->get();

        $requestsByStatus = ProcessedRequest::query()
            ->select('status')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('status')
            ->get();

        $report = [
            'total_requests' => $totalRequests,
            'by_organization' => $requestsByOrganization,
            'by_status' => $requestsByStatus,
        ];

        // Create a new report and save it in the request_reports table.
        RequestReport::create([

            // Store the date and time when the report is generated.
            'generated_at' => now(),

            // Store the total number of processed requests.
            'total_requests' => $report['total_requests'],

            // Extract the total for each organization.
            // pluck() keeps the result as a Laravel Collection.
            // The organization is used as the key and the total as the value.
            'by_organization' => $report['by_organization']
                ->pluck('total', 'organization')
                // Convert the Collection into a regular PHP array.
                ->toArray(),

            // Extract the total for each status.
            // pluck() keeps the result as a Laravel Collection.
            // The status is used as the key and the total as the value.
            'by_status' => $report['by_status']
                ->pluck('total', 'status')
                // Convert the Collection into a regular PHP array.
                ->toArray(),
        ]);

    }
}
