<?php
session_start();
require_once "../db/db_config.php";

// Check if the keys exist in the POST data
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Prepare and bind
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?;");
$stmt->bind_param("s", $username);

// Execute the statement
header('Content-Type: application/json'); // Set header for JSON response

if ($stmt->execute()) {
    $result = $stmt->get_result();

    // Check if username exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch the user record

        // Verify password
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row['username'];
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Wrong Password']);
        }
    } else {
        // Username not found
        echo json_encode(['status' => 'error', 'message' => 'Username not found']);
    }
} else {
    // Return error response in JSON format
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

// Close the connection
$stmt->close();
$conn->close();
