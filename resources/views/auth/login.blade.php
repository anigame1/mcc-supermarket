@extends('layouts.app')

@section('title', 'Login | MCC Supermarket')
@section('page-title', 'CUSTOMER LOGIN')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@section('content')
<div class="form-container">
    <form action="{{ route('login') }}" method="post">
        @csrf
        <h3>Login Now</h3>
        <input type="email" name="email" value="{{ old('email') }}" required placeholder="Enter email" class="box">
        <input type="password" name="password" required placeholder="Enter password" class="box">
        <label style="display:flex; align-items:center; gap:8px; font-size:16px; margin-top:5px;">
            <input type="checkbox" name="remember" style="width:auto; border:1px solid #000;"> Remember me
        </label>
        <input type="submit" name="submit" class="btn" value="Login Now">
        <p>Don't have an account? <a href="{{ route('register') }}">Register now</a></p>
    </form>
</div>
@endsection
