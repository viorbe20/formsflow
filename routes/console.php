<?php

use App\Jobs\ProcessApplicationRequestsJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Define the default Laravel "inspire" Artisan command.
// It displays a random inspirational quote when the command is executed.
Artisan::command('inspire', function () {
    // Display the generated inspirational quote in the console.
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Run the complete ETL and reporting process once a day.
//Schedule::job(new ProcessApplicationRequestsJob())->everyMinute();
Schedule::job(new ProcessApplicationRequestsJob())->daily();
