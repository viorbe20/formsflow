<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * Test the FormsFlow homepage.
     */
    public function test_the_formsflow_homepage_is_available(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('FORMSFLOW');
        $response->assertSee('Nueva solicitud');
        $response->assertSee('Dashboard');
    }
}