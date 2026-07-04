@extends('layouts.app')

@section('title', 'Secure Payment | MCC Supermarket')
@section('page-title', 'SECURE PAYMENT')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/payment.css') }}">
@endpush

@section('content')
<div class="payment-wrapper">
  <div class="payment-header">
    <h2>💳 Secure Payment</h2>
    <p>Complete your purchase safely</p>
  </div>

  <div class="summary-box">
    <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
    <p><strong>Total Amount:</strong> ${{ number_format($amount, 2) }}</p>
  </div>

  <form action="{{ route('payment.store') }}" method="POST">
      @csrf

      <div class="payment-methods">
          <label><input type="radio" name="method" value="card" required> 💳 Credit / Debit Card</label>
          <label><input type="radio" name="method" value="mobile"> 📱 Mobile Money</label>
          <label><input type="radio" name="method" value="paypal"> 🅿️ PayPal</label>
      </div>

      <button type="submit" class="btn">Confirm Payment</button>
  </form>

  <a href="{{ route('shop.index') }}" class="back-link">← Back to Cart</a>
</div>
@endsection
