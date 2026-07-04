<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentItem;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function show(): View|RedirectResponse
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.index');
        }

        $amount = $cartItems->sum(fn ($item) => $item->subtotal());

        return view('payment.show', [
            'amount' => $amount,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'method' => ['required', 'in:card,mobile,paypal'],
        ]);

        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.index');
        }

        $total = $cartItems->sum(fn ($item) => $item->subtotal());

        $payment = DB::transaction(function () use ($user, $cartItems, $validated, $total) {
            $payment = Payment::create([
                'user_id' => $user->id,
                'total' => $total,
                'method' => $validated['method'],
                'date' => now(),
            ]);

            foreach ($cartItems as $item) {
                PaymentItem::create([
                    'payment_id' => $payment->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            $user->cartItems()->delete();

            return $payment;
        });

        return redirect()->route('receipt.show', $payment);
    }

    public function receipt(Payment $payment): View
    {
        if ($payment->user_id !== Auth::id()) {
            throw new AuthorizationException;
        }

        $payment->load('user');

        $qrData = "Name: {$payment->user->name}\nEmail: {$payment->user->email}\nTotal: {$payment->total}\nMethod: {$payment->method}\nDate: {$payment->date}";

        return view('payment.receipt', [
            'payment' => $payment,
            'qrCodeUrl' => 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data='.urlencode($qrData),
        ]);
    }
}
