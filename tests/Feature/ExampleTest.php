<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_application_returns_a_successful_response(): void
    {
        // Buat pengguna yang terautentikasi
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/');

        // Periksa status kode
        $response->assertStatus(200);
    }
}
