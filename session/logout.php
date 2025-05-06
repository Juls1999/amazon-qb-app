<?php
session_start();

// Clear all session data
$_SESSION = [];

// Destroy the session
session_destroy();

// Destroy the session cookie if it exists
if (isset($_COOKIE[session_name()])) {
    // Expire the session cookie
    setcookie(session_name(), '', time() - 3600, '/', '', isset($_SERVER["HTTPS"]), true); // Secure flag and HttpOnly flag
}

// Optionally regenerate the session ID before redirecting to prevent reuse of session
session_regenerate_id(true);  // This is useful for security

// Redirect to the homepage or login page
header("Location: /amazon-q/index.php", true, 302); // Using 302 for temporary redirection
exit();
?>