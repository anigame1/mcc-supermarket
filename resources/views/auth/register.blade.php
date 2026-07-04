@extends('layouts.app')

@section('title', 'Register | MCC Supermarket')
@section('page-title', 'CUSTOMER REGISTRATION')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@section('content')
<div class="form-container">
    <form action="{{ route('register') }}" method="post" enctype="multipart/form-data">
        @csrf
        <h3>Register Now</h3>

        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Enter username" class="box">
        <input type="email" name="email" value="{{ old('email') }}" required placeholder="Enter email" class="box">
        <input type="password" name="password" required placeholder="Enter password" class="box">
        <input type="password" name="password_confirmation" required placeholder="Confirm password" class="box">
        <input type="file" name="avatar" accept="image/*" class="box">

        <input type="submit" name="submit" class="btn" value="Register Now">
        <p>Already have an account? <a href="{{ route('login') }}">Login now</a></p>
    </form>
</div>
@endsection
