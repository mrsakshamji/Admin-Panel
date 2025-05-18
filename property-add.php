<?php
include 'config/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize inputs
    $type = $conn->real_escape_string($_POST['property_type'] ?? '');
    $title = $conn->real_escape_string($_POST['property_title'] ?? '');
    $price = floatval($_POST['property_price'] ?? 0);
    $alt = $conn->real_escape_string($_POST['property_alt'] ?? '');
    $location = $conn->real_escape_string($_POST['location'] ?? '');
    $logoAlt = $conn->real_escape_string($_POST['logo_alt'] ?? '');

    $imageDir = 'images/';

    // Property front image
    if (isset($_FILES['property_front_image_upload']) && $_FILES['property_front_image_upload']['error'] == 0) {
        $frontImageTmp = $_FILES['property_front_image_upload']['tmp_name'];
        $frontImageName = basename($_FILES['property_front_image_upload']['name']);
        $frontImagePath = $imageDir . time() . '_front_' . $frontImageName;
        move_uploaded_file($frontImageTmp, $frontImagePath);
    } else {
        $frontImagePath = '';
    }

    // Logo image
    if (isset($_FILES['logo_upload']) && $_FILES['logo_upload']['error'] == 0) {
        $logoTmp = $_FILES['logo_upload']['tmp_name'];
        $logoName = basename($_FILES['logo_upload']['name']);
        $logoPath = $imageDir . time() . '_logo_' . $logoName;
        move_uploaded_file($logoTmp, $logoPath);
    } else {
        $logoPath = '';
    }

    $sql = "INSERT INTO property (type, img, alt, title, price, location, logo, logoAlt) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdsss", $type, $frontImagePath, $alt, $title, $price, $location, $logoPath, $logoAlt);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Property added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
