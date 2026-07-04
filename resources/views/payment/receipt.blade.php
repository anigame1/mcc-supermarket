@extends('layouts.app')

@section('title', 'Receipt | MCC Supermarket')
@section('page-title', 'PAYMENT RECEIPT')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/receipt.css') }}">
@endpush

@section('content')
<div class="receipt">
  <h2>🛒 SUPERMARKET RECEIPT</h2>
  <p><small>Kampala City, Shop #204</small></p>
  <div class="divider"></div>

  <p><strong>Name:</strong> {{ $payment->user->name }}</p>
  <p><strong>Email:</strong> {{ $payment->user->email }}</p>
  <p><strong>Payment Method:</strong> {{ strtoupper($payment->method) }}</p>
  <p class="total">TOTAL: ${{ number_format($payment->total, 2) }}</p>
  <p><strong>Date:</strong> {{ $payment->date->format('Y-m-d H:i:s') }}</p>

  <div class="divider"></div>
  <p class="success">✅ PAYMENT SUCCESSFUL</p>
  <p>Thank you! Wishing you a wonderful day ahead.</p>
  <div class="divider"></div>

  <h3>Scan to Verify</h3>
  <div style="padding:10px; border:2px solid #000; display:inline-block; background:#fff;">
    <img src="{{ $qrCodeUrl }}" width="200" height="200" alt="QR Code">
  </div>
  <div class="divider"></div>

  <button onclick="window.print()">🖨️ Print Receipt</button>
  <a href="{{ route('shop.index') }}">← Back to Shop</a>
</div>
@endsection
