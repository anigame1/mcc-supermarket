<?php
include 'config.php';
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCC Supermarket Dashboard</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f6f8;
            font-family: 'Poppins', sans-serif;
        }

        .main-content {
            margin-left: 260px;
            padding: 30px;
        }

        .dashboard-row {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: flex-start;
        }
        .dashboard-box {
            width: 300px;
            height: 180px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .dashboard-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.2);
        }
        .dashboard-box i {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .dashboard-box h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .dashboard-box p {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .box-users { background: linear-gradient(135deg, #16a085, #1abc9c);margin-left:40px; }
        .box-sales { background: linear-gradient(135deg, #2980b9, #3498db); }
        .box-about { background: linear-gradient(135deg, #e67e22, #f39c12); }
        .box-contact { background: linear-gradient(135deg, #8e44ad, #9b59b6); }

        .box-about a, .box-contact a {
            color: #fff;
            text-decoration: none;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .box-about a:hover, .box-contact a:hover {
            background: rgba(255,255,255,0.25);
            box-shadow: 0 0 12px rgba(255,255,255,0.4);
            transform: scale(1.05);
        }

        .summary-section {
            margin-top: 40px;
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .summary-section h2 {
            margin-bottom: 20px;
            color: #2c3e50;
        }
        .summary-items {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
        }
        .summary-card {
            flex: 1;
            min-width: 220px;
            background: #f9fafb;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            transition: 0.3s;
        }
        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        }
        .summary-card i {
            font-size: 28px;
            color: #3498db;
            margin-right: 10px;
        }

        .sales-table {
            margin-top: 40px;
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .sales-table h2 {
            color: #2c3e50;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        table th {
            background: #3498db;
            color: #fff;
        }
        table tr:hover {
            background: #f2f2f2;
        }

        .chart-section {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-top: 40px;
        }
        .chart-box {
            flex: 1;
            min-width: 400px;
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .chart-box h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .main-content { margin-left: 0; padding: 20px; }
            .dashboard-row, .chart-section, .summary-items { flex-direction: column; }
        }
    </style>
</head>

<body>
    <div class="main-content">
        <div class="dashboard-row">
            <div class="dashboard-box box-users">
                <i class="fa-solid fa-users"></i>
                <h3>Total Users</h3>
                <p>
                    <?php 
                        $userCount = mysqli_query($conn, "SELECT COUNT(*) AS total FROM user_form");
                        $countRow = mysqli_fetch_assoc($userCount);
                        echo $countRow['total'];
                    ?>
                </p>
            </div>

            <div class="dashboard-box box-sales">
                <i class="fa-solid fa-dollar-sign"></i>
                <h3>Total Sales Today</h3>
                <p>
                    $<?php 
                        $salesQuery = mysqli_query($conn, "SELECT SUM(total) AS total_sales FROM payments WHERE DATE(date)=CURDATE()");
                        $salesRow = mysqli_fetch_assoc($salesQuery);
                        echo number_format($salesRow['total_sales'] ?? 0, 2);
                    ?>
                </p>
            </div>

            <div class="dashboard-box box-about">
                <i class="fa-solid fa-circle-info"></i>
                <a href="about.php">About</a>
            </div>

            <div class="dashboard-box box-contact">
                <i class="fa-solid fa-phone"></i>
                <a href="contact.php">Contact</a>
            </div>
        </div>

        <div class="summary-section">
            <h2><i class="fa-solid fa-chart-line"></i> Quick Summary</h2>
            <div class="summary-items">
                <div class="summary-card"><i class="fa-solid fa-user-plus"></i> New Users Today: 
                    <strong>
                        <?php 
                            $newUsers = mysqli_query($conn, "SELECT COUNT(*) AS total FROM user_form WHERE DATE(created_at)=CURDATE()");
                            $newRow = mysqli_fetch_assoc($newUsers);
                            echo $newRow['total'] ?? 0;
                        ?>
                    </strong>
                </div>
                <div class="summary-card"><i class="fa-solid fa-cart-shopping"></i> Orders Today: 
                    <strong>
                        <?php 
                            $orders = mysqli_query($conn, "SELECT COUNT(*) AS total FROM payments WHERE DATE(date)=CURDATE()");
                            $orderRow = mysqli_fetch_assoc($orders);
                            echo $orderRow['total'] ?? 0;
                        ?>
                    </strong>
                </div>
                <div class="summary-card"><i class="fa-solid fa-money-bill"></i> Weekly Revenue: 
                    <strong>
                        $<?php 
                            $rev = mysqli_query($conn, "SELECT SUM(total) AS total FROM payments WHERE YEARWEEK(date)=YEARWEEK(CURDATE())");
                            $revRow = mysqli_fetch_assoc($rev);
                            echo number_format($revRow['total'] ?? 0, 2);
                        ?>
                    </strong>
                </div>
            </div>
        </div>

        <div class="sales-table">
            <h2><i class="fa-solid fa-clock-rotate-left"></i> Recent Sales</h2>
            <table>
                <thead>
                    <tr>
                        <th>Sale ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Method</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sales = mysqli_query($conn, "
                            SELECT payments.*, user_form.name AS customer_name
                            FROM payments
                            JOIN user_form ON payments.user_id = user_form.id
                            ORDER BY payments.date DESC
                            LIMIT 5
                        ");
                        while($row = mysqli_fetch_assoc($sales)){
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>" . htmlspecialchars($row['customer_name']) . "</td>
                                    <td>$" . number_format($row['total'], 2) . "</td>
                                    <td>" . ucfirst($row['method']) . "</td>
                                    <td>{$row['date']}</td>
                                </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="chart-section">
            <div class="chart-box">
                <h2><i class="fa-solid fa-chart-column"></i> Weekly Sales Overview</h2>
                <canvas id="salesChart"></canvas>
            </div>

            <div class="chart-box">
                <h2><i class="fa-solid fa-chart-pie"></i> Payment Method Breakdown</h2>
                <canvas id="methodChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const salesCtx = document.getElementById('salesChart');
        new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Sales (USD)',
                    data: [120, 250, 300, 180, 500, 400, 600],
                    backgroundColor: '#3498db',
                    borderRadius: 6
                }]
            },
            options: { scales: { y: { beginAtZero: true } } }
        });

        const methodCtx = document.getElementById('methodChart');
        new Chart(methodCtx, {
            type: 'pie',
            data: {
                labels: ['Card', 'Mobile Money', 'PayPal'],
                datasets: [{
                    data: [45, 35, 20],
                    backgroundColor: ['#1abc9c', '#f39c12', '#9b59b6']
                }]
            }
        });
    </script>
</body>
</html>
<?php
include 'footer.php';
?>