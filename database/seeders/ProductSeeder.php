<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Fresh Bread Loaf', 'price' => 2.50, 'image' => 'product-1.jpg', 'stock' => 120],
            ['name' => 'Full Cream Milk 1L', 'price' => 1.80, 'image' => 'product-2.jpg', 'stock' => 200],
            ['name' => 'Rice 5kg Bag', 'price' => 9.99, 'image' => 'product-3.jpg', 'stock' => 80],
            ['name' => 'White Sugar 2kg', 'price' => 4.20, 'image' => 'product-4.jpg', 'stock' => 150],
            ['name' => 'Cooking Oil 2L', 'price' => 6.75, 'image' => 'product-5.jpg', 'stock' => 100],
            ['name' => 'Maize Flour 2kg', 'price' => 3.40, 'image' => 'product-6.jpg', 'stock' => 140],
            ['name' => 'Eggs Tray (30 pcs)', 'price' => 5.50, 'image' => 'product-7.jpg', 'stock' => 90],
            ['name' => 'Bathing Soap Pack', 'price' => 2.10, 'image' => 'product-8.jpg', 'stock' => 175],
            ['name' => 'Soft Drink Crate', 'price' => 8.00, 'image' => 'product-9.jpg', 'stock' => 60],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['name' => $product['name']], $product);
        }
    }
}
