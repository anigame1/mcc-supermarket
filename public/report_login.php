<?php
session_start();

$error = "";

if(isset($_POST['login'])){

    $password = trim($_POST['password']);

    // Hashed Report Password
    $report_password_hash = '$2y$10$z8xkPir.XKS6n389DsUnq.2A04/aFM9T7o8XmPjpZlirrjk7zqsey';

    if(password_verify($password, $report_password_hash)){

        $_SESSION['report_admin'] = true;

        header("Location: report.php");
        exit();

    }else{

        $error = "Incorrect Password!";

    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Report Login</title>

<style>

body{

    margin:0;
    padding:0;
    background:#f4f6f9;
    font-family:Arial, Helvetica, sans-serif;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;

}

/* Login Box */

.login-box{

    width:380px;
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 0 15px rgba(0,0,0,.15);

    animation:slideDown .8s ease;
    transition:.3s;

}

.login-box:hover{

    transform:translateY(-3px);
    box-shadow:0 15px 30px rgba(0,0,0,.15);

}

/* Animation */

@keyframes slideDown{

    from{

        opacity:0;
        transform:translateY(-40px);

    }

    to{

        opacity:1;
        transform:translateY(0);

    }

}

/* Heading */

h2{

    text-align:center;
    margin-bottom:25px;

}

/* Error */

.error{

    background:#f8d7da;
    color:#842029;
    padding:12px;
    border-radius:8px;
    margin-bottom:15px;
    text-align:center;
    font-weight:bold;

}

/* Input */

input{

    width:100%;
    padding:12px;
    margin-bottom:20px;
    border:1px solid #ccc;
    border-radius:8px;
    box-sizing:border-box;
    transition:.3s;

}

input:focus{

    outline:none;
    transform:scale(1.03);
    box-shadow:0 0 10px rgba(37,99,235,.3);

}

/* Button Container */

.button-group{

    display:flex;
    gap:10px;

}

/* Buttons */

button,
.cancel-btn{

    flex:1;
    padding:12px;
    border:none;
    border-radius:10px;
    font-size:16px;
    font-weight:bold;
    text-decoration:none;
    text-align:center;
    transition:all .3s ease;

}

/* Login Button */

button{

    background:#2563eb;
    color:#fff;
    cursor:pointer;

}

button:hover{

    background:#1d4ed8;
    transform:translateY(-5px);
    box-shadow:0 8px 15px rgba(37,99,235,.4);

}

/* Cancel Button */

.cancel-btn{

    background:#dc2626;
    color:#fff;

}

.cancel-btn:hover{

    background:#b91c1c;
    transform:translateY(-5px);
    box-shadow:0 8px 15px rgba(220,38,38,.4);

}

/* Click Animation */

button:active,
.cancel-btn:active{

    transform:scale(.95);

}

</style>

</head>

<body>

<div class="login-box">

<h2>Report Login</h2>

<?php
if($error != ""){
    echo "<div class='error'>$error</div>";
}
?>

<form method="POST">

<input
type="password"
name="password"
placeholder="Enter Report Password"
required>

<div class="button-group">

    <button
    type="submit"
    name="login">
    Login
    </button>

    <a
    href="dashboard.php"
    class="cancel-btn">
    Cancel
    </a>

</div>

</form>

</div>

</body>
</html>