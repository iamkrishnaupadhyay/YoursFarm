<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL to delete a record
    $sql = "DELETE FROM customers WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_customers.php");
        exit();
    } else {
        echo "Error deleting customer: " . $conn->error;
    }
}

$conn->close();
// Redirect back to the customer list
header("Location: view_customers.php");
exit();
?>
