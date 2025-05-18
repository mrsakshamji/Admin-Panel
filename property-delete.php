<?php
require 'config/db.php'; // Database connection

// Set header to return JSON response
header('Content-Type: application/json');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid or missing property ID']);
    exit;
}

$id = intval($_GET['id']);

// Prepare and execute delete statement
$stmt = $conn->prepare("DELETE FROM property WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Property deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete property']);
}
?>
