<?php
session_start();
include 'config.php'; 

$admin_password = "12345"; 

$id = $_GET['updateid'];

if (!isset($_SESSION['authorized_'.$id])) {
    if (isset($_POST['admin_pass'])) {
        if ($_POST['admin_pass'] === $admin_password) {
            $_SESSION['authorized_'.$id] = true; 
                } else {
            $error = "❌ Incorrect password!";
        }
    }

    if (!isset($_SESSION['authorized_'.$id])) {
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <title>Admin Password Required</title>
        </head>
        <body>
        <div class="container my-5">
            <h3 class="mb-3">🔐 Enter Admin Password to Continue</h3>
            <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <form method="post">
                <input type="password" name="admin_pass" class="form-control mb-3" placeholder="Enter admin password" required>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        </body>
        </html>
        <?php
        exit();
    }
}

$sql = "SELECT * FROM user_form WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$name = $row["name"];
$email = $row["email"];
$userpass = $row["password"];
$image = $row["image"];

$updated = false;

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $userpass = $_POST["password"];

    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_image/' . $image_name;
        move_uploaded_file($image_tmp, $image_folder);

        $sql = "UPDATE user_form SET name='$name', email='$email', password='$userpass', image='$image_name' WHERE id=$id";
        $image = $image_name; 
    } else {
        $sql = "UPDATE user_form SET name='$name', email='$email', password='$userpass' WHERE id=$id";
    }

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $updated = true;
    } else {
        die(mysqli_error($conn));
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Update User</title>
</head>
<body>
<div class="container my-5">
    <h3 class="mb-4">✏️ Update User Details</h3>

    <?php if ($updated): ?>
        <div class="alert alert-success">✅ User updated successfully!</div>
        <a href="display.php" class="btn btn-primary">Go to Display Page</a>
    <?php else: ?>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" class="form-control" name="password" value="<?php echo htmlspecialchars($userpass); ?>" required>
            </div>

            <div class="mb-3">
                <label>Profile Image</label><br>
                <?php if (!empty($image) && file_exists("uploaded_image/$image")): ?>
                    <img src="uploaded_image/<?php echo $image; ?>" width="100" height="100" class="rounded mb-2" alt="Profile Image">
                <?php else: ?>
                    <p class="text-muted">No image uploaded</p>
                <?php endif; ?>
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">Upload new image (optional)</small>
            </div>

            <button type="submit" class="btn btn-success" name="submit">Update</button>
            <button type="button" class="btn btn-danger" onclick="window.location.href='display.php'">
                Logout
            </button>

        </form>
    <?php endif; ?>
</div>
</body>
</html>
