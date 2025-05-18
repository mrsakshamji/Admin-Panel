<?php
require 'config/db.php'; // DB connection

if (!isset($_GET['id'])) {
  echo json_encode(['success' => false, 'message' => 'No property ID provided']);
  exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM property WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $property = $result->fetch_assoc();
  echo json_encode(['success' => true, 'property' => $property]);
} else {
  echo json_encode(['success' => false, 'message' => 'Property not found']);
}
