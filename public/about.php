<?php
include 'config.php';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About | MCC Supermarket System</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #eef2f7;
    margin: 0;
    color: #2c3e50;
}

.top-bar {
    background: linear-gradient(90deg, #2980b9, #1f618d);
    color: #fff;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    margin: 20px auto 25px 280px;
    width: 80%;
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    letter-spacing: 1px;
}

.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 260px;
    height: 100vh;
    background: linear-gradient(180deg, #3498db, #2471a3);
    color: #fff;
    padding-top: 25px;
    box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
}

.logo-container {
    text-align: center;
    margin-bottom: 15px;
}

.logo {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
}

.brand {
    font-size: 22px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 25px;
    letter-spacing: 1px;
    line-height: 1.2;
}

.sidebar a {
    display: block;
    color: #fff;
    padding: 12px 20px;
    text-decoration: none;
    font-weight: 500;
    margin: 5px 15px;
    border-radius: 8px;
    transition: 0.3s;
}

.sidebar a:hover {
    background: rgba(255, 255, 255, 0.15);
}

.sidebar a.active {
    background: #1abc9c;
    font-weight: bold;
    box-shadow: inset 3px 0 0 #fff;
}

.about-section {
    margin-left: 280px;
    padding: 40px 60px;
}

.about-header {
    text-align: center;
    margin-bottom: 50px;
}

.about-header h1 {
    font-size: 38px;
    font-weight: 700;
    color: #2c3e50;
}

.about-header p {
    color: #5d6d7e;
    font-size: 17px;
    max-width: 700px;
    margin: 0 auto;
}

.about-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    padding: 30px;
    margin-bottom: 30px;
    transition: transform 0.3s ease;
}

.about-card:hover {
    transform: translateY(-5px);
}

.about-card h3 {
    color: #2980b9;
    font-weight: 600;
    margin-bottom: 15px;
}

.about-card p {
    color: #566573;
}

.team-section {
    text-align: center;
    margin-top: 50px;
}

.team-section h2 {
    color: #2980b9;
    font-weight: 600;
    margin-bottom: 40px;
}

.team-members {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 30px;
}

.member {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.08);
    padding: 25px;
    width: 220px;
    transition: transform 0.3s ease;
}

.member:hover {
    transform: translateY(-6px);
}

.member img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 15px;
}

.member h5 {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 5px;
}

.member p {
    font-size: 14px;
    color: #7f8c8d;
}
</style>
</head>

<body>
<div class="sidebar">
    <div class="logo-container">
        <img src="logo.png" alt="MCC Logo" class="logo">
    </div>

    <div class="brand">
        MCC <br> SUPERMARKET
    </div>

    <nav>
        <a href="dashboard.php" class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">Dashboard</a>
        <a href="about.php" class="<?= ($current_page == 'about.php') ? 'active' : '' ?>">About</a>
        <a href="display.php" class="<?= ($current_page == 'display.php') ? 'active' : '' ?>">Users</a>
        <a href="report.php" class="<?= ($current_page == 'report.php') ? 'active' : '' ?>">Reports</a>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="login.php" class="<?= ($current_page == 'login.php') ? 'active' : '' ?>">Login</a>
        <?php else: ?>
            <a href="logout.php" class="<?= ($current_page == 'logout.php') ? 'active' : '' ?>">Logout</a>
        <?php endif; ?>
    </nav>
</div>

<div class="top-bar">
    ABOUT MCC SUPERMARKET
</div>

<div class="about-section">
    <div class="about-header">
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
                <img src="uploaded_image/user10.jpg" alt="Team Member">
                <h5>Mohamed Ali Omer</h5>
                <p>System Developer</p>
            </div>
            <div class="member">
                <img src="uploaded_image/IMG-20241106-WA0018.jpg" alt="Team Member">
                <h5>Fatima Yusuf</h5>
                <p>UI/UX Designer</p>
            </div>
            <div class="member">
                <img src="uploaded_image/IMG-20231111-WA0029.jpg" alt="Team Member">
                <h5>Abdi Ahmed</h5>
                <p>Database Engineer</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
