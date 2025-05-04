<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "register");

// Check if the connection was successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
