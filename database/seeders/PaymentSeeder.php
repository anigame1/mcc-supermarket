<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        if (Payment::count() > 0) {
            return;
        }

        $users = User::all();
        $products = Product::all();
        $methods = ['card', 'mobile', 'paypal'];

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        // Generate a realistic trail of sales for the last 14 days so the
        // dashboard charts, weekly revenue, and reports have real data to
        // show instead of looking freshly installed.
        for ($daysAgo = 13; $daysAgo >= 0; $daysAgo--) {
            $day = Carbon::today()->subDays($daysAgo);
            $paymentsToday = $daysAgo === 0 ? random_int(3, 5) : random_int(2, 6);

            for ($i = 0; $i < $paymentsToday; $i++) {
                $user = $users->random();
                $itemCount = random_int(1, 3);
                $chosenProducts = $products->random(min($itemCount, $products->count()));

                $paidAt = $day->copy()->setTime(random_int(8, 20), random_int(0, 59), random_int(0, 59));

                DB::transaction(function () use ($user, $chosenProducts, $methods, $paidAt) {
                    $total = 0;
                    $items = [];

                    foreach ($chosenProducts as $product) {
                        $quantity = random_int(1, 5);
                        $lineTotal = $product->price * $quantity;
                        $total += $lineTotal;

                        $items[] = [
                            'product_id' => $product->id,
                            'quantity' => $quantity,
                            'price' => $product->price,
                        ];
                    }

                    $payment = Payment::create([
                        'user_id' => $user->id,
                        'total' => round($total, 2),
                        'method' => $methods[array_rand($methods)],
                        'date' => $paidAt,
                    ]);

                    foreach ($items as $item) {
                        PaymentItem::create($item + ['payment_id' => $payment->id]);
                    }
                });
            }
        }
    }
}
