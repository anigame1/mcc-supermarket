<?php
session_start();
include 'config.php';

if (!isset($_POST['user_id'], $_POST['amount'], $_POST['method'])) {
  header("Location: payment.php");
  exit;
}

$user_id = $_POST['user_id'];
$total = $_POST['amount'];
$method = $_POST['method'];

$select_user = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('Query failed');
$fetch_user = mysqli_fetch_assoc($select_user);

$date = date('Y-m-d H:i:s');

$insert_payment = mysqli_query($conn, "
  INSERT INTO payments (user_id, name, email, total, method, date)
  VALUES ('$user_id', '{$fetch_user['name']}', '{$fetch_user['email']}', '$total', '$method', '$date')
") or die('Payment insert failed: ' . mysqli_error($conn));

$qr_data = "Name: {$fetch_user['name']}\nEmail: {$fetch_user['email']}\nTotal: $total\nMethod: $method\nDate: $date";
$qr_data = urlencode($qr_data);
$qr_code_url = "https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={$qr_data}";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Receipt</title>
<link rel="stylesheet" href="Css/receipt.css">
</head>

<body>

<div class="receipt">
  <h2>🛒 SUPERMARKET RECEIPT</h2>
  <p><small>Kampala City, Shop #204</small></p>
  <div class="divider"></div>

  <p><strong>Name:</strong> <?php echo $fetch_user['name']; ?></p>
  <p><strong>Email:</strong> <?php echo $fetch_user['email']; ?></p>
  <p><strong>Payment Method:</strong> <?php echo strtoupper($method); ?></p>
  <p class="total">TOTAL: $<?php echo number_format($total, 2); ?></p>
  <p><strong>Date:</strong> <?php echo $date; ?></p>

  <div class="divider"></div>
  <p class="success">✅ PAYMENT SUCCESSFUL</p>
  <p>Thank you! Wishing you a wonderful day ahead.</p>
  <div class="divider"></div>

  <h3>Scan to Verify</h3>
  <div style="padding:10px; border:2px solid #000; display:inline-block; background:#fff;">
    <img src="<?php echo $qr_code_url; ?>" width="200" height="200" alt="QR Code">
  </div>
  <div class="divider"></div>

  <button onclick="window.print()">🖨️ Print Receipt</button>
  <a href="payment.php">← Back to Home</a>
</div>

</body>
</html>
