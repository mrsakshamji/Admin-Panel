<?php
header('Content-Type: application/json');
include('config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = trim($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        echo json_encode(["success" => false, "message" => "Email already exists"]);
        exit;
    }

    // Insert into DB
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => true, "message" => "Account created successfully"]);
        exit;
    } else {
        echo json_encode(["success" => false, "message" => "Database error. Please try again."]);
        exit;
    }
}

echo json_encode(["success" => false, "message" => "Invalid request"]);
exit;
