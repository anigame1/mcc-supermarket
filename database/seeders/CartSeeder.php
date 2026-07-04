<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        $demoCustomer = User::where('email', 'customer@example.com')->first();

        if (! $demoCustomer) {
            return;
        }

        $products = Product::inRandomOrder()->take(2)->get();

        foreach ($products as $product) {
            Cart::firstOrCreate(
                ['user_id' => $demoCustomer->id, 'product_id' => $product->id],
                ['quantity' => random_int(1, 3)],
            );
        }
    }
}
