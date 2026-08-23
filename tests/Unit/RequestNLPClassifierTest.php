<?php

namespace Tests\Unit;

use App\Services\RequestNLPClassifier;
use PHPUnit\Framework\TestCase;

class RequestNLPClassifierTest extends TestCase
{
    // The classifier instance used by the unit tests.
    private RequestNLPClassifier $classifier;

    /**
     * Create a fresh classifier instance before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->classifier = new RequestNLPClassifier;
    }

    /**
     * Verify that an information request is classified
     * as an information request with low priority.
     */
    public function test_information_request_is_classified_as_low_priority(): void
    {
        // Classify a representative information request.
        $result = $this->classifier->classify(
            'Quiero consultar dónde puedo encontrar información sobre este procedimiento.'
        );

        // Verify the expected category and priority.
        $this->assertSame('informacion', $result['category']);
        $this->assertSame('baja', $result['priority']);
    }

    /**
     * Verify that a regular service incident is classified
     * as an incident with medium priority.
     */
    public function test_service_incident_is_classified_as_medium_priority(): void
    {
        // Classify a representative service incident.
        $result = $this->classifier->classify(
            'No puedo completar la solicitud porque el servicio devuelve un error.'
        );

        // Verify the expected category and priority.
        $this->assertSame('incidencia', $result['category']);
        $this->assertSame('media', $result['priority']);
    }

    /**
     * Verify that a documentation request is classified
     * as a documentation request with low priority.
     */
    public function test_documentation_request_is_classified_as_low_priority(): void
    {
        // Classify a representative documentation request.
        $result = $this->classifier->classify(
            'Necesito consultar el certificado y obtener una copia del justificante.'
        );

        // Verify the expected category and priority.
        $this->assertSame('documentacion', $result['category']);
        $this->assertSame('baja', $result['priority']);
    }

    /**
     * Verify that a blocked service affecting all users
     * is classified as an incident with high priority.
     */
    public function test_blocked_service_is_classified_as_high_priority(): void
    {
        // Classify a representative high-priority service incident.
        $result = $this->classifier->classify(
            'El servicio está bloqueado y ningún usuario puede registrar solicitudes.'
        );

        // Verify the expected category and priority.
        $this->assertSame('incidencia', $result['category']);
        $this->assertSame('alta', $result['priority']);
    }

    /**
     * Verify that a clear service error takes precedence
     * over generic information-related terms.
     */
    public function test_incident_terms_take_precedence_in_mixed_request(): void
    {
        // Classify a request containing both information
        // and incident-related terms.
        $result = $this->classifier->classify(
            'Necesito información sobre el trámite porque el sistema muestra un error y no me permite completar la solicitud.'
        );

        // Verify that the incident indicators take precedence.
        $this->assertSame('incidencia', $result['category']);
        $this->assertSame('media', $result['priority']);
    }

    /**
     * Verify that a documentation request remains classified as documentation
     * when it also contains a generic information-related term.
     */
    public function test_documentation_request_with_procedure_is_classified_correctly(): void
    {
        // Classify a documentation request containing the generic "trámite" term.
        $result = $this->classifier->classify(
            'Necesito la documentación necesaria para completar el trámite.'
        );

        // Documentation should remain the dominant category.
        $this->assertSame('documentacion', $result['category']);
        $this->assertSame('baja', $result['priority']);
    }

    /**
     * Verify that an unavailable service is classified as an incident
     * with high priority.
     */
    public function test_unavailable_service_is_classified_as_high_priority_incident(): void
    {
        // Classify an unavailable service affecting the request process.
        $result = $this->classifier->classify(
            'El servicio no está disponible y necesito completar la solicitud con urgencia.'
        );

        // An unavailable service should be treated as a high-priority incident.
        $this->assertSame('incidencia', $result['category']);
        $this->assertSame('alta', $result['priority']);
    }
}
