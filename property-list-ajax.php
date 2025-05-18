<?php
require 'config/db.php';

header('Content-Type: application/json');

// Get inputs with validation
$location = isset($_GET['location']) ? trim($_GET['location']) : '';
$type = isset($_GET['type']) ? trim($_GET['type']) : '';
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = isset($_GET['items_per_page']) && is_numeric($_GET['items_per_page']) ? (int)$_GET['items_per_page'] : 6;
if ($page < 1) $page = 1;
if ($items_per_page < 1) $items_per_page = 9;

$offset = ($page - 1) * $items_per_page;

// Build base SQL with filters
$where_clauses = ['1'];
$params = [];
$types = '';

if ($location !== '') {
  $where_clauses[] = "location LIKE ?";
  $params[] = "%$location%";
  $types .= 's';
}
if ($type !== '') {
  $where_clauses[] = "LOWER(type) = ?";
  $params[] = strtolower($type);
  $types .= 's';
}

$where_sql = implode(' AND ', $where_clauses);

// Get total count for pagination
$count_sql = "SELECT COUNT(*) as total FROM property WHERE $where_sql";
$stmt = $conn->prepare($count_sql);
if ($params) {
  $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$count_result = $stmt->get_result();
$total_results = $count_result->fetch_assoc()['total'];
$stmt->close();

$total_pages = ceil($total_results / $items_per_page);

// Fetch actual data with limit & offset
$data_sql = "SELECT * FROM property WHERE $where_sql ORDER BY created_at DESC LIMIT ?, ?";
$stmt = $conn->prepare($data_sql);
if ($params) {
  // Need to bind params + offset + limit
  $types_with_limits = $types . 'ii';
  $params_with_limits = array_merge($params, [$offset, $items_per_page]);
  $stmt->bind_param($types_with_limits, ...$params_with_limits);
} else {
  $stmt->bind_param('ii', $offset, $items_per_page);
}

$stmt->execute();
$result = $stmt->get_result();

$properties = [];
while ($row = $result->fetch_assoc()) {
  $properties[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode([
  'success' => true,
  'properties' => $properties,
  'total_results' => $total_results,
  'total_pages' => $total_pages,
]);
exit;
