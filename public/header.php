<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'config.php';

$current_page = basename($_SERVER['PHP_SELF']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MCC Supermarket System</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #eef2f7;
    margin: 0;
    color: #2c3e50;
}

/* ---------- Top Bar ---------- */
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

/* ---------- Sidebar ---------- */
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

/* Hover effect */
.sidebar a:hover {
    background: rgba(255, 255, 255, 0.15);
}

/* Active link style */
.sidebar a.active {
    background: #1abc9c;
    font-weight: bold;
    box-shadow: inset 3px 0 0 #fff;
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
<?php if (!isset($_SESSION['user_id'])): ?>

    <a href="leave_users.php?page=dashboard.php" 
       class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">
       Dashboard
    </a>

    <a href="leave_users.php?page=register.php" 
       class="<?= ($current_page == 'register.php') ? 'active' : '' ?>">
       Register
    </a>

    <a href="login.php" 
       class="<?= ($current_page == 'login.php') ? 'active' : '' ?>">
       Login
    </a>

<a href="users.php" 
   class="<?= ($current_page == 'users.php') ? 'active' : '' ?>">
   Users
</a>

<a href="leave_report.php?page=report.php">Reports</a>
        <?php else: ?>
            <a href="dashboard.php" class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">Dashboard</a>
            <a href="logout.php" class="<?= ($current_page == 'logout.php') ? 'active' : '' ?>">Logout</a>
        <?php endif; ?>
    </nav>
</div>

<div class="top-bar">
    MCC SUPERMARKET DASHBOARD
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
