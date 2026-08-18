<?php

use App\Http\Controllers\ApplicationRequestController;
use Illuminate\Support\Facades\Route;

// Defines the route for the application homepage.
Route::get('/', function () {
    return view('welcome');
});

// Displays the application request creation form.
Route::get('/requests/create', [ApplicationRequestController::class, 'create'])
    ->name('application-requests.create');
// Allows store() to receive de form
Route::post('/requests', [ApplicationRequestController::class, 'store'])
    ->name('application-requests.store');
