<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MissingPersonRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_submit_missing_person_request(): void
    {
        $response = $this->post('/missing-person', [
            'full_name' => 'John Doe',
            'birth_date' => '1990-01-01',
            'last_seen_place' => 'New York',
            'description' => 'Last seen near central station',
            'contacts' => 'john@example.com',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('missing_person_requests', [
            'full_name' => 'John Doe',
            'status' => 'new',
        ]);
    }
}
