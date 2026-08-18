<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\ApplicationRequest;
use Illuminate\Http\Request;

class ApplicationRequestController extends Controller
{   // Display the application request creation form.
    public function create(): View
    {
        return view('application-requests.create');
    }

    
    //Store a new application request.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'organization' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'statement' => ['required', 'string'],
            'request_text' => ['required', 'string'],
        ]);
        $validated['reference_code'] = 'FF-' . now()->format('YmdHis');
        // By default, pending
        $validated['status'] = 'pending';
        // Eloquent use it for saving data in application-requests
        $applicationRequest = ApplicationRequest::create($validated);

        return redirect()
            ->route('application-requests.create')
            ->with('success', 'La solicitud se ha registrado correctamente.')
            ->with('reference_code', $applicationRequest->reference_code);
    }
}