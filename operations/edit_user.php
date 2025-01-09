<?php
session_start();
require_once "../db/db_config.php";

// Check if the keys exist in the POST data
$password = isset($_POST['password']) ? $_POST['password'] : '';
$username = $_SESSION['user'];

// Hash the password before storing it
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Prepare and bind
$stmt = $conn->prepare("UPDATE `users` SET `password` = '$hashedPassword' WHERE `username` = ?;");
$stmt->bind_param("s", $username);


// Execute the statement
if ($stmt->execute()) {
    // Return success response in JSON format
    echo json_encode(['status' => 'success']);
} else {
    // Return error response in JSON format
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

// Close the connection
$stmt->close();
$conn->close();