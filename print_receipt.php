<?php
session_start();
include 'db_connection.php';

// Check if admin is logged in
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

// Get the customer ID from the query string
$customer_id = $_GET['customer_id'];

// Fetch the latest milk delivery for the given customer
$sql = "SELECT * FROM milk_deliveries WHERE customer_id = '$customer_id' ORDER BY date_time DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $delivery = $result->fetch_assoc();
} else {
    die("No delivery records found for this customer.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        /* CSS styles as provided */
        * {
            margin: 0;
            padding: 0;
            font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
            box-sizing: border-box;
            font-size: 14px;
        }
        body {
            background-color: #f6f6f6;
        }
        .body-wrap {
            background-color: #f6f6f6;
            width: 100%;
        }
        .container {
            display: block !important;
            max-width: 600px !important;
            margin: 0 auto !important;
            clear: both !important;
        }
        .content {
            max-width: 600px;
            margin: 0 auto;
            display: block;
            padding: 20px;
        }
        .main {
            background: #fff;
            border: 1px solid #e9e9e9;
            border-radius: 3px;
        }
        .content-wrap {
            padding: 20px;
        }
        .invoice {
            margin: 40px auto;
            text-align: left;
            width: 100%;
        }
        .invoice td {
            padding: 5px 0;
        }
        .invoice .invoice-items {
            width: 100%;
        }
        .invoice .invoice-items td {
            border-top: #eee 1px solid;
        }
        .invoice .invoice-items .total td {
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
            font-weight: 700;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px 5px;
        }
        button:hover {
            background-color: #45a049;
        }
        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <table class="body-wrap">
        <tr>
            <td></td>
            <td class="container" width="600">
                <div class="content">
                    <table class="main" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="content-wrap aligncenter">
                                <h2>YourFarm Dairy</h2>
                                <p>Varanasi, Uttar Pradesh, India 221005</p>
                                <h3>Milk Delivery Receipt</h3>
                                <table class="invoice">
                                    <tr>
                                        <td>Customer ID: <?= $delivery['customer_id']; ?><br>
                                            Date & Time: <?= $delivery['date_time']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table class="invoice-items" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>Quantity (liters)</td>
                                                    <td class="alignright">Rs. <?= number_format($delivery['quantity'], 2); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Fat Percentage</td>
                                                    <td class="alignright"><?= $delivery['fat_percentage']; ?>%</td>
                                                </tr>
                                                <tr>
                                                    <td>Price per Liter</td>
                                                    <td class="alignright">Rs. <?= number_format($delivery['price_per_liter'], 2); ?></td>
                                                </tr>
                                                <tr class="total">
                                                    <td class="alignright" width="80%">Total Payment</td>
                                                    <td class="alignright">Rs. <?= number_format($delivery['total_payment'], 2); ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div class="footer" style="text-align: center; margin-top: 20px;">
                        <button onclick="window.print();">Print Receipt</button>
                        <button onclick="window.location.href='view_customers.php';">Back to Customers</button>
                    </div>
                </div>
            </td>
            <td></td>
        </tr>
    </table>
</body>
</html>
