<?php
session_start();

$error = "";

if (isset($_POST['login'])) {

    $password = trim($_POST['password']);

    // Hashed password (generated using password_hash)
    $users_password_hash = "$2y$10$.J8zY7sJTA2teC30SjfdfO3Ptsgenw/7fCdhMXnN/RkMnqehPZaI6";

    if (password_verify($password, $users_password_hash)) {

        $_SESSION['users_admin'] = true;

        header("Location: users.php");
        exit();

    } else {

        $error = "Incorrect Password!";

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Users Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{

    background:#f4f6f9;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;

}


/* Login Box Animation */

.login-box{

    width:380px;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 0 15px rgba(0,0,0,.15);

    animation: slideDown 0.8s ease;

}


/* Box entrance */

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


h3{

    text-align:center;
    margin-bottom:25px;

}


/* Buttons */

button,
a.btn{

    width:100%;
    border-radius:10px;
    font-weight:bold;

    transition:all 0.3s ease;

}


/* Login Button */

.btn-primary{

    background:#2563eb;
    border:none;

}


.btn-primary:hover{

    background:#1d4ed8;
    transform:translateY(-5px);
    box-shadow:0 8px 15px rgba(37,99,235,.4);

}


/* Cancel Button */

.btn-danger{

    background:#dc2626;
    border:none;

}


.btn-danger:hover{

    background:#b91c1c;
    transform:translateY(-5px);
    box-shadow:0 8px 15px rgba(220,38,38,.4);

}


/* Click animation */

button:active,
a.btn:active{

    transform:scale(0.95);

}


/* Input animation */

.form-control{

    transition:0.3s ease;

}


.form-control:focus{

    transform:scale(1.03);
    box-shadow:0 0 10px rgba(37,99,235,.3);

}


</style>

</head>

<body>

<div class="login-box">

<h3>Users Page Login</h3>

<?php
if($error!=""){
    echo "<div class='alert alert-danger'>$error</div>";
}
?>

<form method="POST">

<div class="mb-3">

<label class="form-label">Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<div class="d-flex gap-2">

<button
type="submit"
name="login"
class="btn btn-primary w-50">
Login
</button>

<a href="dashboard.php" 
class="btn btn-danger w-50">
Cancel
</a>

</div>
</form>

</div>

</body>
</html>