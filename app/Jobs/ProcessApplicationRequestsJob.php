<?php

namespace App\Jobs;

use App\Services\RequestETLService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessApplicationRequestsJob implements ShouldQueue
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
     * Execute the ETL process.
     */
    public function handle(RequestETLService $etl): void
    {
        // Extract application requests progressively from the source table.
        foreach ($etl->extract() as $request) {

            // Transform and load each application request.
            $etl->load(
                $etl->transform($request)
            );
        }

        // Generate a new report after the ETL process has completed.
        GenerateRequestReportJob::dispatch();
    }
}