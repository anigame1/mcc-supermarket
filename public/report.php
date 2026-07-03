<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['report_admin'])) {
    header("Location: report_login.php");
    exit();
}

include 'config.php';
include 'header.php';


$selected_date = $_GET['date'] ?? date('Y-m-d');
$day_of_week = date('l', strtotime($selected_date));
$date_condition = "WHERE DATE(date) = '$selected_date'";

$result_total = mysqli_query($conn, "SELECT SUM(total) AS total_sales FROM payments $date_condition");
$row_total = mysqli_fetch_assoc($result_total);
$total_sales = $row_total['total_sales'] ?? 0;

$result_count = mysqli_query($conn, "SELECT COUNT(*) AS total_payments FROM payments $date_condition");
$row_count = mysqli_fetch_assoc($result_count);
$total_payments = $row_count['total_payments'] ?? 0;

$result_top = mysqli_query($conn, "
    SELECT name, email, SUM(total) AS total_spent, COUNT(*) AS purchases
    FROM payments $date_condition
    GROUP BY user_id
    ORDER BY total_spent DESC
    LIMIT 5
");

$result_all = mysqli_query($conn, "SELECT * FROM payments $date_condition ORDER BY date DESC");

$result_products = mysqli_query($conn, "
    SELECT p.name, SUM(pi.quantity) AS total_sold, SUM(pi.quantity * pi.price) AS total_amount
    FROM payment_items pi
    JOIN products p ON pi.product_id = p.id
    JOIN payments pay ON pi.payment_id = pay.id
    WHERE DATE(pay.date) = '$selected_date'
    GROUP BY pi.product_id
    ORDER BY total_sold DESC
");

$products_arr = [];
while($row = mysqli_fetch_assoc($result_products)){
   $products_arr[] = $row;
}

$most_product = $products_arr[0]['name'] ?? "No products sold yet";
$most_total = $products_arr[0]['total_sold'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Daily System Report</title>
<link rel="stylesheet" href="Css/report.css"> 
<style>

/* FIX OVERLAP */
.main-content{
    margin-left:260px;
    padding:30px;
}

/* FIX OVERLAP */
.main-content h1{
    float:left;
}

/* Logout Button */
.logout-btn{
    float:left;
    display:inline-block;
    background:#dc2626;
    color:#fff;
    text-decoration:none;
    padding:10px 20px;
    border-radius:6px;
    font-size:15px;
    font-weight:bold;
    transition:0.3s;
    margin-left:570px;
}

.logout-btn:hover{
    background:#ef4444;
}

@media (max-width:768px){

    .main-content{
        margin-left:0;
        padding:20px;
    }

    .logout-btn{
        float:none;
        display:inline-block;
        margin-top:15px;
    }

}

</style>
</head>
<body>

<div class="main-content">

<h1>📊 Daily System Report</h1>
<a href="report_logout.php"
   class="logout-btn"
   onclick="return confirm('Are you sure you want to logout?');">
    Logout
</a><br/><br/><br/>

<div class="date-filter">
    <input type="date" id="datePicker" value="<?php echo $selected_date; ?>">
    <div class="day-badge"><?php echo $day_of_week; ?></div>
</div>

<div class="stats">
    <div class="card">
        <h3>Total Sales</h3>
        <p>$<?php echo number_format($total_sales,2); ?></p>
    </div>
    <div class="card">
        <h3>Total Payments</h3>
        <p><?php echo $total_payments; ?></p>
    </div>
</div>

<h2>🏆 Top Buyers</h2>
<?php if (mysqli_num_rows($result_top) > 0): ?>
<table>
<tr><th>Name</th><th>Email</th><th>Total Spent ($)</th><th>Purchases</th></tr>
<?php while($row = mysqli_fetch_assoc($result_top)): ?>
<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo number_format($row['total_spent'],2); ?></td>
<td><?php echo $row['purchases']; ?></td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?><p style="text-align:center;">No buyers on this day.</p><?php endif; ?>

<h2>🧾 All Payments</h2>
<?php if (mysqli_num_rows($result_all) > 0): ?>
<table>
<tr><th>ID</th><th>Name</th><th>Email</th><th>Total ($)</th><th>Method</th><th>Date</th></tr>
<?php while($row = mysqli_fetch_assoc($result_all)): ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo number_format($row['total'],2); ?></td>
<td><?php echo $row['method']; ?></td>
<td><?php echo $row['date']; ?></td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?><p style="text-align:center;">No payments on this day.</p><?php endif; ?>



</div>

<script>
document.getElementById('datePicker').addEventListener('change', function(){
    window.location.href = '?date=' + this.value;
});
</script>

</body>
</html>
<?php
include 'footer.php';
?>