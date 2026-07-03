<?php
include 'config.php';
session_start();

$admin_password = "12345"; // 

if (isset($_GET['deleteid']) && !isset($_SESSION['delete_authenticated'])) {
    if (isset($_POST['delete_pass'])) {
        if ($_POST['delete_pass'] === $admin_password) {
            $_SESSION['delete_authenticated'] = true; // store session flag
            header("Location: delete.php?deleteid=" . $_GET['deleteid']);
            exit();
        } else {
            $error = "❌ Incorrect password!";
        }
    }

    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Confirm Delete</title>
    </head>
    <body>
        <div class="container my-5">
            <h3 class="mb-3">🗑 Confirm Delete</h3>
            <p>Please enter the admin password to delete this record.</p>
            <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <form method="post">
                <input type="password" name="delete_pass" class="form-control mb-3" placeholder="Enter admin password" required>
                <button type="submit" class="btn btn-danger">Confirm Delete</button>
                <a href="display.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit();
}

if (isset($_GET["deleteid"])) {
    $id = $_GET["deleteid"];
    $sql = "DELETE FROM user_form WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        unset($_SESSION['delete_authenticated']);
        header('Location: display.php');
        exit();
    } else {
        die(mysqli_error($conn));
    }
}
?>
