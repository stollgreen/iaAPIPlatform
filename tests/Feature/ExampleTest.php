<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_302_in_http_requests(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }
}
