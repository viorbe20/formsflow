<?php

namespace App\Services;

use App\Models\ApplicationRequest;
use App\Models\ProcessedRequest;
use Illuminate\Support\LazyCollection;

class RequestETLService
{
    /**
     * Extract application requests from the source table in batches.
     */
    public function extract(): LazyCollection
    {
        return ApplicationRequest::query()->lazyById(100);
    }

    /**
     * Transform an application request into the data structure
     * required by the processed requests table.
     */
    public function transform(ApplicationRequest $request): array
    {
        $normalizedText = implode(' ', [
            $request->subject,
            $request->statement,
            $request->request_text,
        ]);

        $normalizedText = preg_replace(
            '/\s+/',
            ' ',
            trim($normalizedText)
        );

        return [
            'reference_code' => $request->reference_code,
            'organization' => trim($request->organization),
            'unit' => trim($request->unit),
            'subject' => trim($request->subject),
            'normalized_text' => $normalizedText,
            'status' => $request->status,
            'category' => $request->category,
            'priority' => $request->priority,
            'source_created_at' => $request->created_at,
            'processed_at' => now(),
        ];
    }

    /**
     * Load transformed data into the processed requests table.
     */
    public function load(array $data): ProcessedRequest
    {
        return ProcessedRequest::updateOrCreate(
            ['reference_code' => $data['reference_code']],
            $data
        );
    }
}