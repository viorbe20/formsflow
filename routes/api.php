<?php

use App\Http\Controllers\Api\ApplicationRequestController;
use Illuminate\Support\Facades\Route;

// Application request API endpoints.
Route::get('/requests', [ApplicationRequestController::class, 'index'])
    ->name('api.requests.index');

Route::post('/requests', [ApplicationRequestController::class, 'store'])
    ->name('api.requests.store');

Route::get('/requests/{reference_code}', [ApplicationRequestController::class, 'show'])
    ->name('api.requests.show');

Route::patch('/requests/{reference_code}/archive', [ApplicationRequestController::class, 'archive'])
    ->name('api.requests.archive');