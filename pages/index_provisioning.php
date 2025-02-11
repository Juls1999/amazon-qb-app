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
    <!-- Tailwind css -->
    <link rel="stylesheet" href="../styles/style.css">
    <!-- Custom css -->
    <link rel="stylesheet" href="../styles/data_table.css">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Faustina:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.tailwindcss.css">

    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-default@4/default.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- nav -->
    <?php include "../includes/nav.php"; ?>

    <div class="col-span-12 lg:col-span-10 bg-gray-400 relative">

        <!-- Index Provisioned -->
        <div class="bg-white overflow-x-auto mx-4 my-3">
            <div class="ml-4 flex gap-2">
                <button id="addBtn" class="bg-blue-500 hover:bg-blue-600 py-1 px-4 rounded-full text-white mt-3 mb-1">
                    <i class="fa-solid fa-pencil"></i> Update Index</button>
            </div>
            <div class="mx-6 max-h-[560px] min-h-[560px] overflow-y-auto overflow-x-auto">
                <div class="flex animate-pulse">
                    <div class="h-12 w-1/6 rounded-md bg-gray-300"></div>
                    <div class="h-12 w-1/4 rounded-md bg-gray-300 ml-auto"></div>
                </div>
                <table id="dataTable" class="hover:cursor-pointer mt-2">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-4 py-2 text-left font-medium">ID</th>
                            <th class="border border-gray-300 px-4 py-2 text-left font-medium">Name</th>
                            <th class="border border-gray-300 px-4 py-2 text-left font-medium">Description</th>
                            <th class="border border-gray-300 px-4 py-2 text-left font-medium">Units</th>
                            <th class="border border-gray-300 px-4 py-2 text-left font-medium">Indexed Text Bytes
                            </th>
                            <th class="border border-gray-300 px-4 py-2 text-left font-medium">Indexed Text Document
                                Count</th>
                            <th class="border border-gray-300 px-4 py-2 text-left font-medium">Status</th>
                            <th class="border border-gray-300 px-4 py-2 text-left font-medium">Created At</th>
                            <th class="border border-gray-300 px-4 py-2 text-left font-medium">Updated At</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <tr class="animate-pulse h-9">
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                        </tr>
                        <tr class="animate-pulse h-9">
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                        </tr>
                        <tr class="animate-pulse h-9">
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="flex animate-pulse mt-2">
                    <div class="h-12 w-1/6 rounded-md bg-gray-300"></div>
                    <div class="h-12 w-1/6 rounded-md bg-gray-300 ml-auto"></div>
                </div>
            </div>
        </div>


    </div>
    </div><!-- End of Desktop View-->
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
    <script src="../scripts/data_table.js"></script>

    <!-- Custom Scripts -->
    <script src="../scripts/navigation.js"> </script>
    <script src="../scripts/index_provisioning.js"></script>
</body>

</html>