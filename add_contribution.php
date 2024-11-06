<?php
session_start();
include 'db_connection.php';

// Check if admin is logged in
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

// Get customer ID and name from query string or set defaults
$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : null;
$customer_name = isset($_GET['customer_name']) ? $_GET['customer_name'] : 'Unknown Customer';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $date_time = date('Y-m-d H:i:s'); // Automatically set current date and time
    $quantity = $_POST['quantity'];
    $fat_percentage = $_POST['fat_percentage'];
    $price_per_liter = $_POST['price_per_liter'];
    $total_payment = $quantity * $price_per_liter; // Calculate total payment

    // Insert into milk_deliveries table
    $sql = "INSERT INTO milk_deliveries (customer_id, date_time, quantity, fat_percentage, price_per_liter, total_payment) 
            VALUES ('$customer_id', '$date_time', '$quantity', '$fat_percentage', '$price_per_liter', '$total_payment')";

    if ($conn->query($sql) === TRUE) {
        // On successful insert, use JavaScript to open a modal
        echo "<script>
                window.onload = function() {
                    showModal('$customer_id', '" . addslashes($customer_name) . "');
                };
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Milk Delivery</title>
    <style>
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

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }

        .customer-info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
            color: #555;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="number"] {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
            flex: 1;
            margin-right: 10px;
        }

        button:hover {
            background-color: #45a049;
        }

        .back-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s;
            flex: 1;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 300px; /* Could be more or less, depending on screen size */
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add Milk Delivery</h2>
        <div class="customer-info">
            ID: <strong><?= $customer_id; ?></strong> &nbsp; | &nbsp; Name: <strong><?= $customer_name; ?></strong>
        </div>
        <form method="POST">
            <input type="hidden" name="customer_id" value="<?= $customer_id; ?>">

            <label>Quantity (liters):</label>
            <input type="number" step="0.01" name="quantity" required>

            <label>Fat Percentage:</label>
            <input type="number" step="0.01" name="fat_percentage" required>

            <label>Price per Liter:</label>
            <input type="number" step="0.01" name="price_per_liter" required>

            <div class="button-container">
                <button type="submit">Add Milk Delivery</button>
                <a href="view_customers.php" class="back-button">Back to Customers</a>
            </div>
        </form>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p>Milk delivery added successfully!</p>
            <p>Do you want to:</p>
            <button onclick="printReceipt()">Print Receipt</button>
            <button onclick="viewHistory('<?= $customer_id; ?>', '<?= $customer_name; ?>')">View History</button>
            <button onclick="goBack()">Back to Customers</button> <!-- New Button -->
        </div>
    </div>

    <script>
    // Store customer ID in a global variable to be accessed by printReceipt
    let customerId;

    function showModal(id, customerName) {
        customerId = id; // Store the customer ID
        document.getElementById("myModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }

    function printReceipt() {
        // Redirect to print_receipt.php with the customer ID
        window.location.href = "print_receipt.php?customer_id=" + customerId;
        closeModal();
    }

    function viewHistory(customerId, customerName) {
        window.location.href = "view_contributions.php?customer_id=" + customerId + "&customer_name=" + encodeURIComponent(customerName);
    }

    function goBack() {
        window.location.href = "view_customers.php"; // Redirect to view_customers page
    }

    // Close the modal when clicking anywhere outside of it
    window.onclick = function(event) {
        if (event.target === document.getElementById("myModal")) {
            closeModal();
        }
    };
</script>

</body>
</html>
