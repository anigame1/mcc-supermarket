<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $validated['product_id']],
            ['quantity' => $validated['quantity']],
        );

        if (! $cart->wasRecentlyCreated) {
            return back()->with('status', 'Product already added to cart!');
        }

        return back()->with('status', 'Product added to the cart!');
    }

    public function update(Request $request, Cart $cart): RedirectResponse
    {
        $this->authorizeOwner($cart);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart->update(['quantity' => $validated['quantity']]);

        return back()->with('status', 'Cart quantity updated successfully!');
    }

    public function destroy(Cart $cart): RedirectResponse
    {
        $this->authorizeOwner($cart);

        $cart->delete();

        return back()->with('status', 'Item is removed from cart!');
    }

    public function clear(): RedirectResponse
    {
        Auth::user()->cartItems()->delete();

        return back()->with('status', 'All items are deleted from cart!');
    }

    private function authorizeOwner(Cart $cart): void
    {
        if ($cart->user_id !== Auth::id()) {
            throw new AuthorizationException;
        }
    }
}
