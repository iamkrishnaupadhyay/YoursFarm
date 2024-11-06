<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'customer') {
    header("Location: customer_login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

// Fetch customer-specific data
$sql = "SELECT * FROM milk_deliveries WHERE customer_id = '$customer_id'";
$result = $conn->query($sql);

// Calculate total contribution
$totalContribution = 0;
while ($row = $result->fetch_assoc()) {
    $totalContribution += $row['total_payment'];
}

// Reset result pointer to fetch data for display
$result->data_seek(0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .total-contribution {
            text-align: center;
            font-size: 20px;
            color: #fff;
            background-color: #007bff;
            padding: 15px;
            border-radius: 5px;
            margin: 20px auto;
            width: 50%; /* Centering the total contribution */
        }
        .logout-button {
            display: block;
            width: 150px;
            margin: 10px auto;
            padding: 10px;
            background-color: #dc3545; /* Red for Logout */
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .logout-button:hover {
            background-color: #c82333; /* Darker red on hover */
        }
    </style>
</head>
<body>
    <h2>Your Milk Delivery</h2>
    <table>
        <tr>
            <th>Date & Time</th>
            <th>Quantity</th>
            <th>Fat Percentage</th>
            <th>Price</th>
            <th>Total Price</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['date_time']; ?></td>
                <td><?php echo $row['quantity']; ?> liters</td>
                <td><?php echo $row['fat_percentage']; ?>%</td>
                <td>Rs.<?php echo number_format($row['price_per_liter'], 2); ?></td>
                <td>Rs.<?php echo number_format($row['total_payment'], 2); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <div class="total-contribution">Total Milk Delivery: Rs.<?php echo number_format($totalContribution, 2); ?></div>
    <a href="index.php" class="logout-button">Logout</a>
</body>
</html>
