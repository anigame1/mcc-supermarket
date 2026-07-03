<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'config.php';

if(isset($_SESSION['user_id'])){
    header('location:index.php');
    exit;
}

include 'header.php';

$message = [];

if(isset($_POST['submit'])){

    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $pass = trim($_POST['password']);

    $select = mysqli_query($conn, "SELECT * FROM user_form WHERE email='$email'") 
    or die('Query failed');

    if(mysqli_num_rows($select) > 0){

        $row = mysqli_fetch_assoc($select);

        if($row['password'] === $pass){

            $_SESSION['user_id'] = $row['id'];

            header('location:index.php');
            exit;

        } else {

            $message[] = 'Incorrect email or password!';

        }

    } else {

        $message[] = 'Incorrect email or password!';

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="Css/style.css">
<style>
.message { 
    position: fixed; top: 20px; right: 20px; padding: 10px 15px; 
    border-radius: 5px; z-index: 9999; cursor: pointer; 
    box-shadow: 0 3px 8px rgba(0,0,0,0.3); background: #dc3545; color: #fff;
}
</style>
</head>
<body>

<?php
if(!empty($message)){
    foreach($message as $msg){
        echo "<div class='message' onclick='this.remove();'>{$msg}</div>";
    }
}
?>

<div class="form-container">
    <form action="" method="post">
        <h3>Login Now</h3>
        <input type="email" name="email" required placeholder="Enter email" class="box">
        <input type="password" name="password" required placeholder="Enter password" class="box">
        <input type="submit" name="submit" class="btn" value="Login Now">
        <p>Don't have an account? <a href="register.php">Register now</a></p>
    </form>
</div>

</body>
</html>

<?php
include 'footer.php';
?>