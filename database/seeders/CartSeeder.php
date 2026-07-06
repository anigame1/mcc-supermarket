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

        // Deterministic selection (not inRandomOrder): seeders now run on
        // every deploy, and a random pick each time would keep adding new
        // demo cart rows for this account instead of staying idempotent.
        $products = Product::orderBy('id')->take(2)->get();

        foreach ($products as $product) {
            Cart::firstOrCreate(
                ['user_id' => $demoCustomer->id, 'product_id' => $product->id],
                ['quantity' => random_int(1, 3)],
            );
        }
    }
}
