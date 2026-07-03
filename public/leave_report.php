<?php

session_start();

unset($_SESSION['report_admin']);

$page = $_GET['page'] ?? "dashboard.php";

header("Location: ".$page);

exit();

?>