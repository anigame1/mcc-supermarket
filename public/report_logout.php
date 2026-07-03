<?php

session_start();

unset($_SESSION['report_admin']);

header("Location: dashboard.php");

exit();

?>