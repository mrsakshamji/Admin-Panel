<?php
$host = 'sql12.freesqldatabase.com';        // or 127.0.0.1
$username = 'sql12779348';         // your MySQL username
$password = 'ebTCexfcLm';             // your MySQL password
$database = 'sql12779348';  // your database name

// Create a new MySQLi connection
$conn = new mysqli($host, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
