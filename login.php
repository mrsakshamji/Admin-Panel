<?php
session_start();
header('Content-Type: application/json');
include("config/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $password = $_POST['password'];

    // Check user
    $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Valid login
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo json_encode(["success" => true, "message" => "Login successful!"]);
            exit;
        } else {
            echo json_encode(["success" => false, "message" => "Incorrect password."]);
            exit;
        }
    } else {
        echo json_encode(["success" => false, "message" => "User not found."]);
        exit;
    }
}

echo json_encode(["success" => false, "message" => "Invalid request."]);
exit;
