<?php

include 'config/db.php';

// Count rows in the 'properties' table
$sql = "SELECT COUNT(*) AS total FROM property";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo $row['total']; // Output the count
$conn->close();
?>

