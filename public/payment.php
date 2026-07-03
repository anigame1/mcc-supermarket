<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['amount'])){
    $amount = $_POST['amount'];
    $_SESSION['total_amount'] = $amount; // store for later use
} else if(isset($_SESSION['total_amount'])){
    $amount = $_SESSION['total_amount'];
} else {
    header("Location: index.php");
    exit;
}

$select_user = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('Query failed');
$fetch_user = mysqli_fetch_assoc($select_user);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Secure Payment</title>
  <link rel="stylesheet" href="Css/payment.css"> 
</head>
<body>

<div class="payment-wrapper">
  <div class="payment-header">
    <h2>💳 Secure Payment</h2>
    <p>Complete your purchase safely</p>
  </div>

  <div class="summary-box">
    <p><strong>Name:</strong> <?php echo htmlspecialchars($fetch_user['name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($fetch_user['email']); ?></p>
    <p><strong>Total Amount:</strong> $<?php echo number_format($amount, 2); ?></p>
  </div>

  <form action="receipt.php" method="POST">
      <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
      <input type="hidden" name="amount" value="<?php echo $amount; ?>">

      <div class="payment-methods">
          <label><input type="radio" name="method" value="card" required> 💳 Credit / Debit Card</label>
          <label><input type="radio" name="method" value="mobile"> 📱 Mobile Money</label>
          <label><input type="radio" name="method" value="paypal"> 🅿️ PayPal</label>
      </div>

      <button type="submit" class="btn">Confirm Payment</button>
  </form>

  <a href="index.php" class="back-link">← Back to Cart</a>
</div>

</body>
</html>
