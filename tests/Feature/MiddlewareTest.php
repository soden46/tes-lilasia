<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function non_admin_cannot_access_admin_routes()
    {
        $user = \App\Models\User::factory()->create(['role' => 'user']);


        $response = $this->actingAs($user)->get('categories');


        $response->assertRedirect('/home');
    }

    /** @test */
    public function admin_can_access_admin_routes()
    {
        $admin = \App\Models\User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('categories');

        $response->assertStatus(200);
    }
}
