<?php
include 'db_connection.php';

// Initialize search variable
$search_query = isset($_POST['search']) ? $_POST['search'] : '';

// Build the SQL query based on the search input
$sql = "SELECT * FROM customers";
if ($search_query) {
    $search_query = $conn->real_escape_string($search_query); // Sanitize the input
    $sql .= " WHERE name LIKE '%$search_query%' OR id = '$search_query'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #2C3E50;
            font-size: 2.5em;
            font-weight: bold;
            text-align: center;
            padding: 20px;
            margin-top: 0;
            background-color: #EAEDED;
            border-bottom: 4px solid #4CAF50;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .add-button, .logout-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .logout-button {
            background-color: #d32f2f;
        }
        .add-button:hover {
            background-color: #45a049;
        }
        .logout-button:hover {
            background-color: #f44336;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background-color: #fff;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .edit-button, .delete-button, .add-delivery-button, .view-history-button {
            padding: 6px 20px;
            margin-right: 10px;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .edit-button { background-color: #FF9800; }
        .edit-button:hover { background-color: green; }
        .delete-button { background-color: #f44336; }
        .delete-button:hover { background-color: #d32f2f; }
        .add-delivery-button { background-color: #2196F3; }
        .add-delivery-button:hover { background-color: #1976D2; }
        .view-history-button { background-color: #9C27B0; }
        .view-history-button:hover { background-color: #7B1FA2; }
        .search-container {
            margin-bottom: 20px;
            text-align: center;
        }
        input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 200px;
        }

        .search-container {
    margin: 20px auto; /* Center the container */
    display: flex; /* Use flexbox for alignment */
    justify-content: center; /* Center the content */
    align-items: center; /* Vertically center the input */
    width: 100%; /* Full width */
}

.search-container input[type="text"] {
    padding: 12px 15px; /* Padding for comfort */
    border: 1px solid #ccc; /* Light border */
    border-radius: 25px; /* Rounded edges */
    width: 300px; /* Fixed width for the search input */
    font-size: 16px; /* Font size for readability */
    transition: all 0.3s ease; /* Smooth transition */
    outline: none; /* Remove outline */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}

.search-container input[type="text"]:focus {
    border-color: #4CAF50; /* Change border color on focus */
    box-shadow: 0 0 5px rgba(76, 175, 80, 0.5); /* Highlight effect */
}

/* Optional: Add some styles for a clear button (if needed) */
.search-container .clear-button {
    margin-left: 10px; /* Space between input and button */
    padding: 10px 15px;
    border: none;
    border-radius: 25px; /* Rounded edges */
    background-color: #f44336; /* Red background */
    color: white;
    cursor: pointer;
    transition: background-color 0.3s;
}

.search-container .clear-button:hover {
    background-color: #d32f2f; /* Darker red on hover */
}

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <h2>Customers List</h2>
    
    <!-- Search Form -->
    <div class="search-container">
        <input type="text" id="search" placeholder="Search by ID or Name" value="<?= htmlspecialchars($search_query) ?>">
    </div>

    <div class="button-container">
        <a href="add_customer.php" class="add-button">Add Customer</a>
        <a href="index.php" class="logout-button">Logout</a>
    </div>

    <table id="customer-table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['email']}</td>
                        <td>
                            <a href='edit_customer.php?id={$row['id']}' class='edit-button'>Edit</a> 
                            <a href='delete_customer.php?id={$row['id']}' class='delete-button' onclick='return confirm(\"Are you sure you want to delete this customer?\")'>Delete</a> 
                            <a href='add_contribution.php?customer_id={$row['id']}&customer_name=" . urlencode($row['name']) . "' class='add-delivery-button'>Add Milk Delivery</a> 
                            <a href='view_contributions.php?customer_id={$row['id']}&customer_name=" . urlencode($row['name']) . "' class='view-history-button'>View History</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No customers found</td></tr>";
        }

        $conn->close();
        ?>
    </table>

    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                let query = $(this).val();
                $.ajax({
                    url: 'search_customers.php',
                    method: 'POST',
                    data: {search: query},
                    success: function(data) {
                        $('#customer-table').html(data);
                    }
                });
            });
        });
    </script>
</body>
</html>
