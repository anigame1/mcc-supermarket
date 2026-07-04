@extends('layouts.app')

@section('title', 'About | MCC Supermarket System')
@section('page-title', 'ABOUT MCC SUPERMARKET')

@section('content')
<div class="page-section">
    <div class="page-header">
        <h1>About MCC Supermarket System</h1>
        <p>Welcome to MCC Supermarket — a modern system designed to simplify supermarket operations, enhance customer experience, and streamline daily business management.</p>
    </div>

    <div class="about-card">
        <h3>Our Mission</h3>
        <p>To provide an easy-to-use, efficient, and reliable supermarket management platform that helps store owners and employees manage sales, customers, and inventory with accuracy and convenience.</p>
    </div>

    <div class="about-card">
        <h3>Our Vision</h3>
        <p>To become a leading digital solution for supermarkets, enabling smart retail management and promoting innovation in everyday shopping experiences.</p>
    </div>

    <div class="about-card">
        <h3>Our Values</h3>
        <p>We believe in <strong>integrity</strong>, <strong>efficiency</strong>, and <strong>innovation</strong>. We aim to empower retail businesses through technology that enhances productivity and customer satisfaction.</p>
    </div>

    <div class="team-section">
        <h2>Meet Our Team</h2>
        <div class="team-members">
            <div class="member">
                <img src="{{ asset('storage/avatars/user10.jpg') }}" alt="Team Member">
                <h5>Mohamed Ali Omer</h5>
                <p>System Developer</p>
            </div>
            <div class="member">
                <img src="{{ asset('storage/avatars/IMG-20241106-WA0018.jpg') }}" alt="Team Member">
                <h5>Fatima Yusuf</h5>
                <p>UI/UX Designer</p>
            </div>
            <div class="member">
                <img src="{{ asset('storage/avatars/IMG-20231111-WA0029.jpg') }}" alt="Team Member">
                <h5>Abdi Ahmed</h5>
                <p>Database Engineer</p>
            </div>
        </div>
    </div>
</div>
@endsection
