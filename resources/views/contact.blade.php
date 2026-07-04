@extends('layouts.app')

@section('title', 'Contact | MCC Supermarket System')
@section('page-title', 'CONTACT MCC SUPERMARKET')

@section('content')
<div class="page-section">
    <div class="page-header">
        <h1>Get In Touch With Us</h1>
        <p>Have any questions or suggestions? Fill out the form below and we will get back to you as soon as possible.</p>
    </div>

    <div class="contact-form-card">
        <form action="{{ route('contact.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label fw-bold">Your Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Write your message...">{{ old('message') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>

    <div class="d-flex flex-wrap gap-4 mb-4">
        <div class="info-card flex-fill">
            <h4>📍 Address</h4>
            <p>Kampala, Uganda, Kasanga<br>MCC Supermarket Main Branch</p>
        </div>
        <div class="info-card flex-fill">
            <h4>📞 Phone</h4>
            <p>+256 77 982 9625<br>+256 75 765 4321</p>
        </div>
        <div class="info-card flex-fill">
            <h4>✉️ Email</h4>
            <p>support@mccsupermarket.com<br>info@mccsupermarket.com</p>
        </div>
    </div>

    <iframe class="map-frame" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3260.696518726223!2d44.0815!3d9.5213!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOcKwMzEnMTYuNyJOIDQ0wrAwNCcxMy40IkU!5e0!3m2!1sen!2sso!4v0000000000000" allowfullscreen loading="lazy"></iframe>
</div>
@endsection
