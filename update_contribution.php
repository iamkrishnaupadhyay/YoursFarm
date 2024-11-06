<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id']) && is_numeric($_POST['id']) && isset($_POST['customer_id']) && is_numeric($_POST['customer_id'])) {
        $contribution_id = intval($_POST['id']);
        $customer_id = intval($_POST['customer_id']); // Get the customer ID
        $quantity = floatval($_POST['quantity']);
        $fat_percentage = floatval($_POST['fat_percentage']);
        $price_per_liter = floatval($_POST['price_per_liter']);

        // Update the contribution record
        $sql = "UPDATE milk_deliveries SET quantity = ?, fat_percentage = ?, price_per_liter = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("dddi", $quantity, $fat_percentage, $price_per_liter, $contribution_id);

        if ($stmt->execute()) {
            // Redirect to the contributions view page for the specific customer
            header("Location: view_customers.php");
            exit();
        } else {
            echo "Error updating contribution: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Invalid ID or Customer ID.";
    }
}
$conn->close();
?>
