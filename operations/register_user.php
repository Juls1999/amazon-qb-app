<?php
require_once "../db/db_config.php";

// Check if the keys exist in the POST data
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Hash the password before storing it
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?);");
$stmt->bind_param("ss", $username, $hashedPassword);

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
