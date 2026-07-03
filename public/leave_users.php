<?php

session_start();

unset($_SESSION['users_admin']);

$page = $_GET['page'] ?? 'dashboard.php';

header("Location: ".$page);
exit();

?>