<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
            font-family: 'Arial', sans-serif;
            background-image: url('background.jpg'); /* Add your background image here */
            background-size: cover; /* Cover the entire viewport */
            background-position: center; /* Center the image */
            color: #fff;
            overflow: hidden;
        }

        .container {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black */
            backdrop-filter: blur(10px); /* Blur effect */
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #fff; /* White text for better visibility */
        }

        .button-customer {
            display: inline-block;
            margin: 15px 0;
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.2s;
            font-weight: bold;
            font-size: 16px;
        }
        .button-admin {
            display: inline-block;
            margin: 15px 0;
            padding: 12px 20px;
            background-color: green;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.2s;
            font-weight: bold;
            font-size: 16px;
        }

        .button-customer:hover {
            background-color: #0056b3;
            transform: translateY(-2px); /* Subtle lift effect on hover */
        }
        .button-admin:hover {
            background-color:#45a049 ;
            transform: translateY(-2px); /* Subtle lift effect on hover */
        }

        .button-admin, .button-customer :active {
            transform: translateY(0); /* Reset lift on click */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to Dairy Management System</h2>
        <a href="admin_login.php" class="button-admin">Login as Admin</a>
        <a href="customer_login.php" class="button-customer">Login as Customer</a>
    </div>
</body>
</html>
