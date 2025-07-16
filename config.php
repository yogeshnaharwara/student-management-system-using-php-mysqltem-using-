<?php
// Replace with your actual database credentials
$host = 'localhost'; // Your MySQL host (often 'localhost')
$user = 'root';      // Your MySQL username
$pass = '';          // Your MySQL password (usually empty for XAMPP)
$db = 'user_db';     // The name of your database

// Create connection
$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
