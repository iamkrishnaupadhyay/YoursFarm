<?php
include 'db_connection.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $contribution_id = intval($_GET['id']); // Sanitize the input

    // Fetch the contribution record for editing
    $sql = "SELECT * FROM milk_deliveries WHERE id = $contribution_id";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        // Fetch the customer name for display
        $customer_id = $row['customer_id'];
        $customer_sql = "SELECT name FROM customers WHERE id = $customer_id";
        $customer_result = $conn->query($customer_sql);
        $customer_name = $customer_result->fetch_assoc()['name'];
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Milk Delivery</title>
            <style>
                /* Existing styles remain unchanged */
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 20px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }

                h2 {
                    color: #333;
                    margin-bottom: 20px;
                    text-align: center;
                }

                .form-container {
                    background-color: white;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    width: 400px;
                }

                .customer-info {
                    margin-bottom: 20px;
                    text-align: center;
                }

                label {
                    display: block;
                    margin-bottom: 5px;
                    font-weight: bold;
                }

                input[type="number"] {
                    width: 100%;
                    padding: 10px;
                    margin-bottom: 15px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    font-size: 16px;
                }

                .button-container {
                    display: flex;
                    justify-content: space-between;
                }

                input[type="submit"], .back-button {
                    padding: 10px 20px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    transition: background-color 0.3s;
                    font-size: 16px;
                    width: calc(50% - 10px);
                }

                input[type="submit"] {
                    background-color: #4CAF50; /* Green */
                    color: white;
                }

                input[type="submit"]:hover {
                    background-color: #45a049; /* Darker green */
                }

                .back-button {
                    background-color: #007bff; /* Blue */
                    color: white;
                    text-decoration: none;
                    text-align: center;
                    margin-left: 10px; /* Add margin to create space between buttons */
                }

                .back-button:hover {
                    background-color: #0056b3; /* Darker blue */
                }
            </style>
        </head>
        <body>
            <div class="form-container">
                <h2>Edit Milk Delivery</h2>
                <div class="customer-info">
                    <p>Customer ID: <strong><?= $customer_id; ?></strong></p>
                    <p>Customer Name: <strong><?= htmlspecialchars($customer_name); ?></strong></p>
                </div>
                <form action="update_contribution.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>"> <!-- Preserve the ID for the update -->
                    <input type="hidden" name="customer_id" value="<?php echo $row['customer_id']; ?>"> <!-- Customer ID -->
                    <label for="quantity">Quantity (Liters):</label>
                    <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" required>
                    
                    <label for="fat_percentage">Fat Percentage:</label>
                    <input type="number" name="fat_percentage" value="<?php echo $row['fat_percentage']; ?>" step="0.01" required>
                    
                    <label for="price_per_liter">Price per Liter:</label>
                    <input type="number" name="price_per_liter" value="<?php echo $row['price_per_liter']; ?>" required>
                    
                    <div class="button-container">
                        <input type="submit" value="Update Contribution">
                        <a href="view_contributions.php?customer_id=<?= $customer_id; ?>&customer_name=<?= urlencode($customer_name); ?>" class="back-button">Back to History</a>
                    </div>
                </form>
            </div>
        </body>
        </html>

        <?php
    } else {
        echo "Contribution not found.";
    }
} else {
    echo "Invalid ID.";
}
$conn->close();
?>
