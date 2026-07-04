<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function index(): View
    {
        $products = Product::orderBy('name')->get();

        $cartItems = Auth::user()->cartItems()->with('product')->get();

        $grandTotal = $cartItems->sum(fn ($item) => $item->subtotal());

        return view('shop.index', [
            'products' => $products,
            'cartItems' => $cartItems,
            'grandTotal' => $grandTotal,
        ]);
    }
}
