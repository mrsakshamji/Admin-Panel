<?php

include 'config/db.php';

$sql = "SELECT type, COUNT(*) as count FROM property GROUP BY type";
$result = $conn->query($sql);

$data = [
    "apartments" => 0,
    "villas" => 0,
    "townhouses" => 0
];

while ($row = $result->fetch_assoc()) {
    $data[strtolower($row['type'])] = $row['count'];
}

$conn->close();

echo json_encode($data);
?>
