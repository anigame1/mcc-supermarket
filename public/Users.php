<?php
session_start();

if (!isset($_SESSION['users_admin'])) {
    header("Location: users_login.php");
    exit();
}

$_SESSION['users_page_active'] = true;

include 'config.php';
include 'header.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>shop_db Operations</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        #a { text-decoration: none; }
        .fade-out {
            opacity: 1;
            transition: opacity 1s ease-out;
        }
        .fade-out.hide {
            opacity: 0;
        }
        img.profile-pic {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ccc;
        }

        .main-content {
            margin-left: 260px; 
            padding: 30px;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="main-content">

      <h2 class="text-center my-4">User List</h2>

      <?php if (isset($_GET['message'])): ?>
        <div id="alertMessage" class="alert text-center fade-out 
          <?php 
            if ($_GET['message'] === 'updated') echo 'alert-success';
            elseif ($_GET['message'] === 'deleted') echo 'alert-danger';
            elseif ($_GET['message'] === 'added') echo 'alert-primary';
          ?>"
          role="alert">
          <?php
            if ($_GET['message'] === 'updated') echo '✅ User updated successfully!';
            elseif ($_GET['message'] === 'added') echo '✅ User added successfully!';
            elseif ($_GET['message'] === 'deleted') echo '❌ User deleted successfully!';
          ?>
        </div>
      <?php endif; ?>

      <button class="btn btn-primary my-3">
        <a href="register.php" class="text-light" id="a">Add User</A>
      </button>

      <a href="users_logout.php"
   class="btn btn-danger float-end"
   onclick="return confirm('Logout from Users Page?')">
   Logout
</a>

      <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Profile Image</th>
            <th scope="col">Operations</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM user_form";
          $result = mysqli_query($conn, $sql);
          if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $id = $row['id'];
              $name = $row['name'];
              $email = $row['email'];
              $image = !empty($row['image']) ? $row['image'] : 'default.png';
              
              echo '
              <tr>
                <th scope="row">'.$id.'</th>
                <td>'.$name.'</td>
                <td>'.$email.'</td>
                <td><img src="uploaded_image/'.$image.'" class="profile-pic" alt="User Image"></td>
                <td>
                  <a href="update.php?updateid='.$id.'" class="btn btn-primary btn-sm text-light" id="a">Update</a>
                  <a href="delete.php?deleteid='.$id.'" class="btn btn-danger btn-sm text-light" id="a"
                     onclick="return confirm(\'Are you sure you want to delete this user?\')">Delete</a>
                </td>
              </tr>';
            }
          } else {
            echo '<tr><td colspan="5" class="text-center text-muted">No users found.</td></tr>';
          }
          ?>
        </tbody>
      </table>

    </div> 

    <script>
      const alertBox = document.getElementById('alertMessage');
      if (alertBox) {
        setTimeout(() => {
          alertBox.classList.add('hide');
          setTimeout(() => alertBox.style.display = 'none', 1000); 
        }, 3000); 
      }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include 'footer.php'; ?>
