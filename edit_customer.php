<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM customers WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $customer = $result->fetch_assoc();
    } else {
        echo "Customer not found!";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer</title>
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

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50; /* Green */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
            margin-right: 10px; /* Space between buttons */
        }

        input[type="submit"]:hover {
            background-color: #45a049; /* Darker green */
        }

        .button-container {
            display: flex;
            justify-content: center; /* Center the buttons */
            margin-top: 15px;
        }

        .back-button {
            padding: 10px 20px;
            background-color: #007bff; /* Blue */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            text-align: center;
        }

        .back-button:hover {
            background-color: #0056b3; /* Darker blue */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Customer</h2>
        <form action="update_customer.php" method="post">
            <input type="hidden" name="id" value="<?php echo $customer['id']; ?>">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo $customer['name']; ?>" required>

            <label for="phone">Phone:</label>
            <input type="text" name="phone" value="<?php echo $customer['phone']; ?>">

            <label for="address">Address:</label>
            <input type="text" name="address" value="<?php echo $customer['address']; ?>">

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $customer['email']; ?>" required>

            <div class="button-container">
                <input type="submit" value="Update Customer">
                <a href="view_customers.php" class="back-button">Back to Customers</a>
            </div>
        </form>
    </div>
</body>
</html>

