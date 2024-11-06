<?php
include 'db_connection.php';

if (isset($_GET['customer_id']) && is_numeric($_GET['customer_id'])) {
    $customer_id = intval($_GET['customer_id']); // Sanitize the input
    $customer_name = htmlspecialchars($_GET['customer_name']); // Sanitize the input

    // Query to get contributions for the specific customer
    $sql = "SELECT * FROM milk_deliveries WHERE customer_id = $customer_id"; // Use sanitized input
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Milk Delivery History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .customer-info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.2em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50; /* Green */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .action-links a {
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .action-links a:hover {
            color: #0056b3; /* Darker blue */
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff; /* Blue */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            margin: 10px auto;
            margin-left:46%;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #0056b3; /* Darker blue */
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            table {
                font-size: 14px; /* Smaller font size for smaller screens */
            }
            .back-button {
                width: 100%; /* Full width button on mobile */
            }
        }
    </style>
</head>
<body>
    <h2>Customer Milk Delivery History</h2>

    <div class="customer-info">
        ID: <strong><?= $customer_id; ?></strong> &nbsp; | &nbsp; Name: <strong><?= $customer_name; ?></strong>
    </div>

    <table>
        <tr>
            <th>Date</th>
            <th>Quantity (Liters)</th>
            <th>Fat Percentage</th>
            <th>Price per Liter</th>
            <th>Total Payment</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['date_time']}</td>
                        <td>{$row['quantity']}</td>
                        <td>{$row['fat_percentage']}</td>
                        <td>{$row['price_per_liter']}</td>
                        <td>{$row['total_payment']}</td>
                        <td class='action-links'>
                            <a href='edit_contribution.php?id={$row['id']}&customer_id={$customer_id}&customer_name={$customer_name}'>Edit</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No contributions found for this customer.</td></tr>";
        }
        ?>
    </table>
    
    <a href="view_customers.php" class="back-button">Back to Customers</a>
</body>
</html>

<?php
} else {
    echo "Customer ID not specified or invalid.";
}
$conn->close();
?>
