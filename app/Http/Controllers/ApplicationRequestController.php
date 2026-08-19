<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Models\ApplicationRequest;
use Illuminate\View\View;

class ApplicationRequestController extends Controller
{
    // Display the application request creation form.
    public function create(): View
    {
        return view('application-requests.create');
    }

    // Store a new application request.
    public function store(StoreApplicationRequest $request)
    {
        $validated = $request->validated();

        // By default, pending.
        $validated['status'] = 'pending';

        // Eloquent saves the application request in the database.
        $applicationRequest = ApplicationRequest::create($validated);

        return redirect()
            ->route('application-requests.create')
            ->with('success', 'La solicitud se ha registrado correctamente.')
            ->with('reference_code', $applicationRequest->reference_code);
    }
}