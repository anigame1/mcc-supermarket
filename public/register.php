
<?php
include 'header.php'; 
?>
<?php
include 'config.php'; 

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];

    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_images/' . $image;

    if ($pass != $cpass) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO user_form (name, email, password, image) 
                                       VALUES ('$name', '$email', '$pass', '$image')");

        if ($insert) {
            move_uploaded_file($image_tmp_name, $image_folder);
            echo "<script>alert('Registered successfully!'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Registration failed!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Supermarket System</title>
    <link rel="stylesheet" href="Css/style.css">
</head>
<body>

<div class="form-container">
    <form action="" method="post" enctype="multipart/form-data">
        <h3>Register Now</h3>

        <input type="text" name="name" required placeholder="Enter username" class="box">
        <input type="email" name="email" required placeholder="Enter email" class="box">
        <input type="password" name="password" required placeholder="Enter password" class="box">
        <input type="password" name="cpassword" required placeholder="Confirm password" class="box">
        <input type="file" name="image" accept="image/*" required class="box">

        <input type="submit" name="submit" class="btn" value="Register Now">
        <p>Already have an account? <a href="login.php">Login now</a></p>
    </form>
</div>
</body>
</html>
<?php
include 'footer.php';
?>