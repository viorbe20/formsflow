<?php

namespace App\Jobs;

use App\Services\RequestETLService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\RequestNLPClassifier;

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
    public function handle(
        RequestETLService $etl,
        RequestNLPClassifier $classifier
    ): void
    {
        // Extract application requests progressively from the source table.
        foreach ($etl->extract() as $request) {

            // Transform and load each application request.
            $etl->load(
                $etl->transform($request, $classifier)
            );
        }

        // Generate a new report after the ETL process has completed.
        GenerateRequestReportJob::dispatch();
    }
}