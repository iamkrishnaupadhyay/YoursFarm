<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit();
    }

    // Hash the password
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO customers (name, phone, address, email, password) VALUES ('$name', '$phone', '$address', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        // sendEmail($email, $name, $password);
        header("Location: view_customers.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

function sendEmail($to, $name, $password) {
    $subject = "Welcome to Our Service!";
    $message = "Hello $name,\n\nYour account has been created successfully.\n\nYour Details:\nName: $name\nPassword: $password\n\nThank you for joining us!";
    $headers = "From: upadhyay2000krishna@gmail.com.com"; // Replace with your email

    if (mail($to, $subject, $message, $headers)) {
        echo "Email sent successfully.";
    } else {
        echo "Failed to send email.";
    }
}
?>
