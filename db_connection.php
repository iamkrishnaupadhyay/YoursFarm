<?php
$servername = "localhost";
$username = "root"; // default username in XAMPP
$password = ""; // leave empty by default in XAMPP
$dbname = "dairy_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
