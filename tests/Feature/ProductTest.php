<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat user admin dengan peran 'admin'
        $this->admin = User::factory()->create([
            'role' => 'admin'
        ]);

        // Buat kategori untuk produk
        $this->category = Category::factory()->create();
    }

    /** @test */
    public function it_can_create_a_product()
    {
        $response = $this->actingAs($this->admin)->post(route('products.store'), [
            'name' => 'Tes Xiaomi',
            'description' => 'Tes Produk Xiaomi.',
            'price' => 1000.000,
            'category_id' => $this->category->id,
            'image' => null,
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Tes Xiaomi',
            'description' => 'Tes Produk Xiaomi.',
            'price' => 1000.000,
            'category_id' => $this->category->id,
        ]);
    }

    /** @test */
    public function it_can_read_products()
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin)->put(route('products.update', $product), [
            'name' => 'Tes Xiaomi',
            'description' => 'Update Xiaomi.',
            'price' => 150.00,
            'category_id' => $this->category->id,
            'image' => null,
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Tes Xiaomi',
            'description' => 'Update Xiaomi.',
            'price' => 150.00,
            'category_id' => $this->category->id,
        ]);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $product = Product::factory()->create([
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('products.destroy', $product));

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
