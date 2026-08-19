<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\ApplicationRequest;
use Illuminate\Http\JsonResponse;

class ApplicationRequestController extends Controller
{
    /**
     * Return a summary list of application requests.
     * Complete information will be available on GET /api/requests/{reference_code}.
     */
    public function index(): JsonResponse
    {
        $requests = ApplicationRequest::query()
            ->select([
                'reference_code',
                'organization',
                'unit',
                'subject',
                'status',
                'category',
                'priority',
                'created_at',
            ])
            ->get();

        return response()->json([
            'data' => $requests,
        ]);
    }

    /**
     * Create a new application request through the API.
     */
    public function store(StoreApplicationRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // By default, pending.
        $validated['status'] = 'pending';

        // Eloquent saves the application request in the database.
        $applicationRequest = ApplicationRequest::create($validated);

        return response()->json([
            'message' => 'Solicitud creada correctamente.',
            'data' => [
                'reference_code' => $applicationRequest->reference_code,
                'status' => $applicationRequest->status,
                'created_at' => $applicationRequest->created_at,
            ],
        ],201);
    }

    /**
     * Return a single application request by its reference code.
     */
    public function show(string $reference_code): JsonResponse
    {
        $applicationRequest = ApplicationRequest::where(
            'reference_code',
            $reference_code
        )->firstOrFail();

        return response()->json([
            'data' => $applicationRequest,
        ]);
    }

    /**
     * Archive an application request.
     */
    public function archive(string $reference_code): JsonResponse
    {
        $applicationRequest = ApplicationRequest::where(
            'reference_code',
            $reference_code
        )->firstOrFail();

        $applicationRequest->status = 'archived';
        $applicationRequest->save();

        return response()->json([
            'message' => 'Solicitud archivada correctamente.',
            'data' => [
                'reference_code' => $applicationRequest->reference_code,
                'status' => $applicationRequest->status,
            ],
        ]);
    }
}