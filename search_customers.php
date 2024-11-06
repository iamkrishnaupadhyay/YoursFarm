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

$output = '';
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $output .= "<tr>
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
    $output .= "<tr><td colspan='6'>No customers found</td></tr>";
}

echo $output;
$conn->close();
?>
