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

    <link rel="stylesheet" href="../styles/style.css">
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
        <h1 class="text-2xl text-center py-4 font-bold">AI-KB - Index Provisioning </h1>

        <!-- Index Provisioned -->
        <div>
            <div class="border mx-20 mb-10 bg-yellow-100">
                <h2 class="text-xl font-bold text-center">Index Provisioned</h2>

                <div class="flex justify-center mt-5">
                    <table class="table-auto  w-3/4 border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-300 px-4 py-2 text-left font-medium">ID</th>
                                <th class="border border-gray-300 px-4 py-2 text-left font-medium">Name</th>
                                <th class="border border-gray-300 px-4 py-2 text-left font-medium">Description</th>
                                <th class="border border-gray-300 px-4 py-2 text-left font-medium">Units</th>
                                <th class="border border-gray-300 px-4 py-2 text-left font-medium">Indexed Text Bytes</th>
                                <th class="border border-gray-300 px-4 py-2 text-left font-medium">Indexed Text Document Count</th>
                                <th class="border border-gray-300 px-4 py-2 text-left font-medium">Status</th>
                                <th class="border border-gray-300 px-4 py-2 text-left font-medium">Created At</th>
                                <th class="border border-gray-300 px-4 py-2 text-left font-medium">Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-100">
                                <td class="border border-gray-300 px-4 py-2">1</td>
                                <td class="border border-gray-300 px-4 py-2">Index Main</td>
                                <td class="border border-gray-300 px-4 py-2">the main index of the chatbot</td>
                                <td class="border border-gray-300 px-4 py-2">2</td>
                                <td class="border border-gray-300 px-4 py-2">30MB</td>
                                <td class="border border-gray-300 px-4 py-2">5000</td>
                                <td class="border border-gray-300 px-4 py-2">ACTIVE</td>
                                <td class="border border-gray-300 px-4 py-2">2024-12-24</td>
                                <td class="border border-gray-300 px-4 py-2">2024-12-31</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Update Index -->
        <div class="border mx-20 mt-10 bg-green-100">
            <h2 class="text-xl font-bold text-center">Update Index Provisioning</h2>

            <div>
                <label for="data_source">Index ID:</label>
                <select name="data_source" id="data_source" class="border rounded border-gray-700 px-14 mb-2 ml-8">
                    <option value="#">TBA</option>
                </select>
            </div>
            <div>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="border rounded border-gray-700 mb-2 ml-10" placeholder="Name">
            </div>
            <div>
                <label for="description">Description:</label>
                <input type="text" name="description" id="description" class="border rounded border-gray-700 mb-2"
                    placeholder="Description">
            </div>
            <div>
                <label for="unit">Units:</label>
                <input type="text" name="unit" id="unit" class="border rounded border-gray-700 mb-2 ml-11"
                    placeholder="Number of Units">
            </div>
            <button class="bg-green-600 px-4 py-1 rounded-full text-white ml-32"><i
                    class="fa-solid fa-floppy-disk mr-1"></i>Update Index</button>
        </div>
    </div>
    </div>
    <!-- Tailwind css -->
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>

    <!-- Custom Toggle Script -->
    <script src="../scripts/toggle.js"></script>

    <!-- Custom Navigation Script -->
    <script src="../scripts/navigation.js"> </script>
</body>

</html>