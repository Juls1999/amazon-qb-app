<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Destroy the session cookie if it exists
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

header("Location: /amazon-q/index.php");
exit();
?>