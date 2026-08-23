<?php

namespace App\Console\Commands;

use App\Services\RequestETLService;
use Illuminate\Console\Command;

class ProcessRequestsETL extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'etl:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process application requests through the ETL pipeline';

    /**
     * Execute the console command.
     */
    public function handle(RequestETLService $etl): int
    {
        $requests = $etl->extract();

        foreach ($requests as $request) {
            $transformed = $etl->transform($request);

            $etl->load($transformed);
        }

        $this->info("Processed {$requests->count()} application requests.");

        return self::SUCCESS;
    }
}
