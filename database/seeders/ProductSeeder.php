<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Redmi Note 8',
                'description' => 'Xiaomi Redmi Note 8.',
                'category_id' => Category::where('name', 'Smartphone')->first()->id,
                'price' => 699.999,
                'image' => 'Xiaomi.jpg',
            ],
            [
                'name' => 'Samsung A15',
                'description' => 'Samsung A15.',
                'category_id' => Category::where('name', 'Smartphone')->first()->id,
                'price' => 499.99,
                'image' => 'Samsung.jpg',
            ],
            [
                'name' => 'Komik One Piece',
                'description' => 'Komik One Piece.',
                'category_id' => Category::where('name', 'Komik')->first()->id,
                'price' => 19.99,
                'image' => 'komik.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
