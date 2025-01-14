<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: pages/home.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AI-KB</title>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-default@4/default.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <!-- Login Form -->
    <div class="flex justify-center items-center h-screen bg-gray-200">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-sm w-full">
            <h2 class="text-2xl font-semibold text-center mb-4">Login to AI-KB</h2>

            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" class="w-full p-2 mt-1 border border-gray-300 rounded" />
            </div>

            <div class="mb-2">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" class="w-full p-2 mt-1 border border-gray-300 rounded" />
            </div>
            <div class="text-end mb-2">
                <a href="#" class="text-blue-600 text-sm">Forgot your password?</a>
            </div>
            <button class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 focus:outline-none"
                id="loginBtn">Login</button>

            <div class="text-center mt-2">
                <p class="text-sm">Don't have an account? <button class="font-semibold"
                        id="registerBtn">Register</button></p>
            </div>

        </div>
    </div>

    <!-- Tailwind CSS -->
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>

    <!-- Custom Scripts (Optional) -->
    <script src="scripts/toggle.js"></script>

    <!-- Custom Register Script -->
    <script src="scripts/login.js"></script>

</body>

</html>