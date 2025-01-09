<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to the login page
    header("Location: ../index.php");
    exit(); // Ensure no further code is executed
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI - KB</title>

    <link rel="stylesheet" href="../styles/styles.css">

    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-default@4/default.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- nav -->
    <?php include "../includes/nav.php"; ?>

    <!-- Loading Screen -->
    <div id="loading-screen">
        <p>Loading...</p>
    </div>

    <div class="col-span-12 lg:col-span-10">
        <p class="mt-5 ml-12 font-semibold text-2xl">Edit Profile</p>
        <div class="mt-5 ml-5">
            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
            <input type="password" id="password" name="password"
                class="w-1/4 p-2 mt-1 border border-gray-300 rounded" />
        </div>
        <div class="mt-5 ml-5">
            <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirm New
                Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword"
                class="w-1/4 p-2 mt-1 border border-gray-300 rounded" />
        </div>

        <button class="mt-6 ml-24 border rounded-md bg-green-500 p-2 hover:bg-green-600 text-white" id="saveBtn">Save
            Changes</button>
    </div>
    </div>
    <!-- Tailwind css -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>

    <!-- Custom Toggle Script -->
    <script src="../scripts/toggle.js"></script>

    <!-- Custom Navigation Script -->
    <script src="../scripts/navigation.js"> </script>

    <!-- Custom Profile Script -->
    <script src="../scripts/profile.js"></script>
</body>

</html>