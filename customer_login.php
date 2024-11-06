<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $password = $_POST['password'];

    // Query to check if the customer exists
    $sql = "SELECT * FROM customers WHERE id = '$customer_id' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['user_type'] = 'customer';
        $_SESSION['customer_id'] = $customer_id;
        header("Location: customer_dashboard.php");
        exit();
    } else {
        echo "<p style='color: red;'>Invalid customer credentials!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #E6E6FA, #D8BFD8); /* Light violet gradient background */
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.9); /* Light white background with transparency */
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        h2 {
            color: #333; /* Darker text for visibility */
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            text-align: left;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .back-button {
            display: inline-block;
            margin-top: 10px;
            padding: 9px 20px;
            background-color: #6c757d; /* Gray color for Back button */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #5a6268; /* Darker gray on hover */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Customer Login</h2>
        <form method="POST">
            <label for="customer_id">Customer ID:</label>
            <input type="text" name="customer_id" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
            <a href="index.php" class="back-button">Back to Home</a>
        </form>
    </div>
</body>
</html>
