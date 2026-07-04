@extends('layouts.app')

@section('title', 'Shop | MCC Supermarket')
@section('page-title', 'SHOP & SHOPPING CART')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="user-profile">
        <p>Username: <span>{{ auth()->user()->name }}</span></p>
        <p>Email: <span>{{ auth()->user()->email }}</span></p>
        <div class="flex">
            <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Are you sure you want to logout?');">
                @csrf
                <button type="submit" class="delete-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="products">
        <h1 class="heading">Latest Products</h1>
        <div class="box-container">
            @forelse ($products as $product)
                <form method="post" action="{{ route('cart.store') }}" class="box">
                    @csrf
                    <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}">
                    <div class="name">{{ $product->name }}</div>
                    <div class="price">${{ number_format($product->price, 2) }}/-</div>
                    <input type="number" min="1" name="quantity" value="1">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="submit" value="Add to Cart" class="btn">
                </form>
            @empty
                <p>No products available right now.</p>
            @endforelse
        </div>
    </div>

    <div class="shopping-cart">
        <h1 class="heading">Shopping Cart</h1>
        <table>
            <thead>
                <tr>
                    <th>Image</th><th>Name</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($cartItems as $item)
                <tr>
                    <td><img src="{{ $item->product->imageUrl() }}" height="80"></td>
                    <td>{{ $item->product->name }}</td>
                    <td>${{ number_format($item->product->price, 2) }}</td>
                    <td>
                        <form action="{{ route('cart.update', $item) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <input type="number" min="1" name="quantity" value="{{ $item->quantity }}">
                            <input type="submit" value="Update" class="option-btn">
                        </form>
                    </td>
                    <td>${{ number_format($item->subtotal(), 2) }}</td>
                    <td>
                        <form action="{{ route('cart.destroy', $item) }}" method="post" onsubmit="return confirm('Are you sure to remove this item?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">Remove</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No items in cart</td></tr>
            @endforelse
            <tr>
                <td colspan="4">Grand Total:</td>
                <td>${{ number_format($grandTotal, 2) }}</td>
                <td>
                    <form action="{{ route('cart.clear') }}" method="post" onsubmit="return confirm('Are you sure you want to delete all items in the cart?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn {{ $grandTotal > 0 ? '' : 'disabled' }}">Delete All</button>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>

        @if ($grandTotal > 0)
            <form action="{{ route('payment.show') }}" method="get" style="margin-left:500px;">
                <input type="submit" value="Pay Now" class="btn" style="background-color:green;" id="pynow">
            </form>
        @endif
    </div>
</div>
@endsection
