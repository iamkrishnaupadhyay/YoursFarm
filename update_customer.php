<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];

    $sql = "UPDATE customers SET name='$name', phone='$phone', address='$address', email='$email' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_customers.php");
        exit();
        } 
        else {
        echo "Error updating customer: " . $conn->error;
    }

    $conn->close();
}
?>
