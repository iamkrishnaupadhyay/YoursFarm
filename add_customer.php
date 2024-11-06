<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
            overflow: hidden; /* Prevent scrolling */
        }
        .container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center; /* Center text inside the container */
        }
        h2 {
            color: #2C3E50;
            margin-bottom: 20px;
        }
        label {
            margin-top: 10px;
            display: block;
            font-weight: bold;
            text-align: left; /* Align labels to the left */
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px;
            background-color: #4CAF50; /* Green for submit button */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 48%; /* Adjust width for alignment */
            transition: background-color 0.3s;
            margin-right: 4%; /* Space between buttons */
        }
        input[type="submit"]:hover {
            background-color: #45a049; /* Darker green on hover */
        }
        .back-button {
            display: inline-block; /* Make back button an inline block */
            padding: 10px;
            background-color: #2196F3; /* Blue for back button */
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
            width: 48%; /* Adjust width for alignment */
        }
        .back-button:hover {
            background-color: #1976D2; /* Darker blue on hover */
        }
        .button-container {
            display: flex; /* Use flexbox to align buttons */
            justify-content: space-between; /* Space buttons evenly */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Customer</h2>
        <form action="save_customer.php" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" required>

            <label for="phone">Phone:</label>
            <input type="text" name="phone">

            <label for="address">Address:</label>
            <input type="text" name="address">

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <div class="button-container">
                <input type="submit" value="Add Customer">
                <a href="view_customers.php" class="back-button">Back to Customers</a>
            </div>
        </form>
    </div>
</body>
</html>
