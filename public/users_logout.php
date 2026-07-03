<?php
session_start();

unset($_SESSION['users_admin']);

header("Location: users_login.php");
exit();
?>