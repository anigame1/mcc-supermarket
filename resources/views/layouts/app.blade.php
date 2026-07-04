<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'MCC Supermarket System')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@stack('styles')
</head>
<body>

@include('partials.flash')

<div class="sidebar">
    <div class="logo-container">
        <img src="{{ asset('logo.png') }}" alt="MCC Logo" class="logo">
    </div>

    <div class="brand">MCC <br> SUPERMARKET</div>

    <nav>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>

        @auth
            <a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.*') ? 'active' : '' }}">Shop &amp; Cart</a>
        @endauth

        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>

        @guest
            <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
            <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
        @else
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout ({{ auth()->user()->name }})</button>
            </form>
        @endguest

        <div class="nav-heading">Staff Area</div>
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Manage Users</a>
        <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">Reports</a>

        @auth('admin')
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit">Admin Logout</button>
            </form>
        @endauth
    </nav>
</div>

<div class="top-bar">@yield('page-title', 'MCC SUPERMARKET')</div>

<div class="main-content">
    @yield('content')
</div>

<footer style="text-align:center; background:#3498db; color:#fff; padding:15px 0; margin-top:20px;">
    &copy; {{ date('Y') }} MCC Supermarket System. All Rights Reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
