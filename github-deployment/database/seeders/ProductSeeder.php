<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'title' => 'Smartphone X',
                'description' => 'Latest smartphone with advanced features and high-quality camera.',
                'price' => 599.99,
                'stock' => 50,
                'image' => null,
            ],
            [
                'title' => 'Laptop Pro',
                'description' => 'Professional laptop for work and gaming with high performance.',
                'price' => 1299.99,
                'stock' => 25,
                'image' => null,
            ],
            [
                'title' => 'Wireless Headphones',
                'description' => 'Premium wireless headphones with noise cancellation.',
                'price' => 199.99,
                'stock' => 100,
                'image' => null,
            ],
            [
                'title' => 'Smart Watch',
                'description' => 'Feature-rich smartwatch with health monitoring.',
                'price' => 299.99,
                'stock' => 75,
                'image' => null,
            ],
            [
                'title' => 'Gaming Console',
                'description' => 'Next-generation gaming console for immersive gaming experience.',
                'price' => 499.99,
                'stock' => 30,
                'image' => null,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
