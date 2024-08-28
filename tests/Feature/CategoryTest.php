<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat user admin dengan peran 'admin'
        $this->admin = User::factory()->create([
            'role' => 'admin'
        ]);
    }

    /** @test */
    public function it_can_create_a_category()
    {
        $response = $this->actingAs($this->admin)->post(route('categories.store'), [
            'name' => 'Smartphone',
        ]);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', [
            'name' => 'Smartphone',
        ]);
    }

    /** @test */
    public function it_can_read_categories()
    {
        $category = Category::factory()->create(['name' => 'Kategori Tes']);

        $response = $this->actingAs($this->admin)->get(route('categories.index'));

        $response->assertStatus(200);
        $response->assertSee('Kategori Tes');
    }

    /** @test */
    public function it_can_update_a_category()
    {
        $category = Category::factory()->create(['name' => 'Kategori Tes']);

        $response = $this->actingAs($this->admin)->put(route('categories.update', $category), [
            'name' => 'Kategori Tes',
        ]);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Kategori Tes',
        ]);
    }

    /** @test */
    public function it_can_delete_a_category()
    {
        $category = Category::factory()->create(['name' => 'Kategori Tes Update']);

        $response = $this->actingAs($this->admin)->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }
}
