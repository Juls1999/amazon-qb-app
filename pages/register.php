<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - AI-KB</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-default@4/default.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <!-- Registration Form -->
    <div class="flex justify-center items-center h-screen bg-gray-700">
        <div class="bg-pink-200 p-8 rounded-lg shadow-lg max-w-sm w-full">
            <h2 class="text-2xl font-semibold text-center mb-4">Register for AI-KB</h2>

            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username"
                    class="w-full p-2 mt-1 border border-gray-300 rounded" />
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full p-2 mt-1 border border-gray-300 rounded" />
            </div>

            <button class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700 focus:outline-none"
                id="registerBtn">Register</button>

            <div class="text-center mt-4">
                <p class=" text-sm">Already have an account? <button class="font-semibold" id="loginHereBtn">Login
                        here</button></p>
            </div>
        </div>
    </div>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>

    <!-- Custom Scripts (Optional) -->
    <script src="../scripts/toggle.js"></script>

    <!-- Custom register script -->
     <script src="../scripts/register.js"></script>

</body>

</html>