<?php
include 'config.php';
$current_page = basename($_SERVER['PHP_SELF']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $insert = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
    if (mysqli_query($conn, $insert)) {
        $success = "Thank you! Your message has been sent.";
    } else {
        $error = "Error sending message: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact | MCC Supermarket System</title>
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
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
    box-shadow: 2px 0 15px rgba(0,0,0,0.1);
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

.contact-section {
    margin-left: 280px;
    padding: 40px 60px;
}

.contact-header {
    text-align: center;
    margin-bottom: 40px;
}

.contact-header h1 {
    font-size: 36px;
    font-weight: 700;
    color: #2c3e50;
}

.contact-header p {
    font-size: 17px;
    color: #5d6d7e;
    max-width: 700px;
    margin: 10px auto;
}

.contact-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    padding: 35px;
    margin-bottom: 40px;
}

.form-control {
    border-radius: 10px;
    border: 1px solid #d6dbdf;
    padding: 12px 15px;
}

.form-control:focus {
    box-shadow: none;
    border-color: #2980b9;
}

.btn-send {
    background: #2980b9;
    color: #fff;
    font-weight: 600;
    border-radius: 8px;
    padding: 10px 25px;
    transition: 0.3s;
    border: none;
}

.btn-send:hover {
    background: #1f618d;
}

.alert { border-radius: 10px; }

.info-section {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    margin-bottom: 40px;
}

.info-card {
    background: #fff;
    flex: 1;
    min-width: 250px;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.08);
    padding: 25px;
    text-align: center;
    transition: transform 0.3s ease;
}

.info-card:hover {
    transform: translateY(-5px);
}

.info-card h4 {
    color: #2980b9;
    font-weight: 600;
    margin-bottom: 10px;
}

.info-card p {
    color: #566573;
}

.map-frame {
    border: none;
    border-radius: 15px;
    width: 100%;
    height: 300px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
</style>
</head>
<body>

<div class="sidebar">
    <div class="logo-container">
        <img src="logo.png" alt="MCC Logo" class="logo">
    </div>
    <div class="brand">MCC <br> SUPERMARKET</div>
    <nav>
        <a href="dashboard.php" class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">Dashboard</a>
        <a href="about.php" class="<?= ($current_page == 'about.php') ? 'active' : '' ?>">About</a>
        <a href="contact.php" class="<?= ($current_page == 'contact.php') ? 'active' : '' ?>">Contact</a>
        <a href="report.php" class="<?= ($current_page == 'report.php') ? 'active' : '' ?>">Reports</a>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="login.php" class="<?= ($current_page == 'login.php') ? 'active' : '' ?>">Login</a>
        <?php else: ?>
            <a href="logout.php" class="<?= ($current_page == 'logout.php') ? 'active' : '' ?>">Logout</a>
        <?php endif; ?>
    </nav>
</div>

<div class="top-bar">
    CONTACT MCC SUPERMARKET
</div>

<div class="contact-section">
    <div class="contact-header">
        <h1>Get In Touch With Us</h1>
        <p>Have any questions or suggestions? Fill out the form below and we will get back to you as soon as possible.</p>
    </div>

    <?php if(isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="contact-card">
        <form action="" method="post">
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label fw-bold">Your Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Write your message..." required></textarea>
            </div>
            <button type="submit" class="btn-send">Send Message</button>
        </form>
    </div>

    <div class="info-section">
        <div class="info-card">
            <h4>📍 Address</h4>
            <p>Kampala, Uganda, Kasanga<br>MCC Supermarket Main Branch</p>
        </div>
        <div class="info-card">
            <h4>📞 Phone</h4>
            <p>+256 77 982 9625<br>+256 75 765 4321</p>
        </div>
        <div class="info-card">
            <h4>✉️ Email</h4>
            <p>support@mccsupermarket.com<br>info@mccsupermarket.com</p>
        </div>
    </div>

    <iframe class="map-frame" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3260.696518726223!2d44.0815!3d9.5213!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOcKwMzEnMTYuNyJOIDQ0wrAwNCcxMy40IkU!5e0!3m2!1sen!2sso!4v0000000000000" allowfullscreen="" loading="lazy"></iframe>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
