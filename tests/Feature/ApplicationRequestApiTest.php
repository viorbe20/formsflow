<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\ApplicationRequest;
use Tests\TestCase;

class ApplicationRequestApiTest extends TestCase
{
    // Reset the test database before each test.
    use RefreshDatabase;

    /**
     * Verify that the API returns stored application requests.
     *
     * A test record is created in the database first.
     * The API should then return that record in the "data" collection.
     */
    public function test_can_list_stored_application_requests(): void
    {
        // Create a test application request in the database.
        $applicationRequest = \App\Models\ApplicationRequest::factory()->create();

        // Request the list of application requests.
        $response = $this->getJson('/api/requests');

        // The endpoint should respond with HTTP 200 OK.
        $response->assertStatus(200);

        // The response should contain the reference code of the stored request.
        $response->assertJsonFragment([
            'reference_code' => $applicationRequest->reference_code,
        ]);
    }

    /**
     * Verify that a valid request can be created through the API.
     *
     * The test sends valid application request data and verifies
     * that the API creates and stores the request correctly.
     */
    public function test_can_create_application_request(): void
    {
        // Define valid data for the API request.
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '600123456',
            'organization' => 'Educación',
            'unit' => 'Dirección General de Innovación y Formación del Profesorado',
            'subject' => 'Test application request',
            'statement' => 'This is a test statement.',
            'request_text' => 'This is a test request.',
        ];

        // Send the POST request to the API.
        $response = $this->postJson('/api/requests', $data);

        // A successful creation should return HTTP 201 Created.
        $response->assertStatus(201);

        // Verify the expected response structure.
        $response->assertJsonStructure([
            'message',
            'data' => [
                'reference_code',
                'status',
                'created_at',
            ],
        ]);

        // The newly created request should have a pending status.
        $response->assertJsonPath('data.status', 'pending');

        // Retrieve the generated reference code from the response.
        $referenceCode = $response->json('data.reference_code');

        // Verify that the request was actually stored in the database.
        $this->assertDatabaseHas('application_requests', [
            'reference_code' => $referenceCode,
            'email' => 'test@example.com',
            'status' => 'pending',
        ]);
    }

    /**
     * Verify that the API rejects an invalid application request.
     *
     * The request is intentionally incomplete to verify that
     * StoreApplicationRequest applies the required validation rules.
     */
    public function test_cannot_create_application_request_with_invalid_data(): void
    {
        // Send an incomplete request to the API.
        $response = $this->postJson('/api/requests', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Invalid input should return HTTP 422 Unprocessable Content.
        $response->assertStatus(422);

        // Verify that the required fields are reported as validation errors.
        $response->assertJsonValidationErrors([
            'organization',
            'unit',
            'subject',
            'statement',
            'request_text',
        ]);
    }
    
    /**
     * Verify that an application request can be retrieved by its reference code.
     *
     * A test request is created first and then retrieved through the API.
     */
    public function test_can_show_application_request(): void
    {
        // Create a test application request in the database.
        $applicationRequest = ApplicationRequest::factory()->create();

        // Request the application request using its reference code.
        $response = $this->getJson(
            '/api/requests/' . $applicationRequest->reference_code
        );

        // The endpoint should respond with HTTP 200 OK.
        $response->assertStatus(200);

        // Verify that the response contains the expected request data.
        $response->assertJsonPath(
            'data.reference_code',
            $applicationRequest->reference_code
        );

        $response->assertJsonPath(
            'data.email',
            $applicationRequest->email
        );

        $response->assertJsonPath(
            'data.status',
            $applicationRequest->status
        );
    }

    /**
     * Verify that the API returns 404 when the requested application does not exist.
     *
     * A reference code that does not exist in the database is used to verify
     * the API error response.
     */
    public function test_returns_not_found_for_non_existing_application_request(): void
    {
        // Use a reference code that does not exist in the test database.
        $referenceCode = 'FF-2026-999999';

        // Request the non-existing application request.
        $response = $this->getJson(
            '/api/requests/' . $referenceCode
        );

        // The API should return HTTP 404 Not Found.
        $response->assertStatus(404);
    }

    /**
     * Verify that an application request can be archived through the API.
     *
     * A pending request is created first and then archived using its
     * reference code.
     */
    public function test_can_archive_application_request(): void
    {
        // Create a pending application request in the database.
        $applicationRequest = \App\Models\ApplicationRequest::factory()->create([
            'status' => 'pending',
        ]);

        // Archive the application request through the API.
        $response = $this->patchJson(
            '/api/requests/' . $applicationRequest->reference_code . '/archive'
        );

        // The API should respond with HTTP 200 OK.
        $response->assertStatus(200);

        // Verify that the response reports the request as archived.
        $response->assertJsonPath(
            'data.reference_code',
            $applicationRequest->reference_code
        );

        $response->assertJsonPath(
            'data.status',
            'archived'
        );

        // Verify that the status was actually updated in the database.
        $this->assertDatabaseHas('application_requests', [
            'reference_code' => $applicationRequest->reference_code,
            'status' => 'archived',
        ]);
    }

}