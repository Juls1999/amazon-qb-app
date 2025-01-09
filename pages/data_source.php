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
    <title>AI - KB - Data Source</title>

    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.0/css/dataTables.tailwindcss.css">

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

    <div class="col-span-12 lg:col-span-10 bg-gray-400">
        <div class="bg-white mx-4 rounded-md my-3">
            <div class="ml-4 flex gap-2">
                <button class="bg-green-500 hover:bg-green-600 py-1 px-4 rounded-full text-white mt-3 mb-1"><i
                        class="fa-solid fa-plus"></i> Add Data Source</button>
                <button id="editBtn"
                    class="bg-yellow-500 hover:bg-yellow-600 py-1 px-4 rounded-full text-white disabled:opacity-50 mt-3 mb-1 cursor-not-allowed"
                    disabled><i class="fa-solid fa-pencil"></i> Edit Data Source</button>
                <button class="bg-red-500 hover:bg-red-600 py-1 px-4 rounded-full text-white mt-3 mb-1"><i
                        class="fa-solid fa-trash"></i> Delete Data Source</button>
            </div>
            <div class="mx-6 max-h-[560px] min-h-[560px] overflow-y-auto md:overflow-x-hidden">
                <table id="dataTable" class="display hover:cursor-pointer">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-4 py-2 text-left font-medium">ID</th>
                            <th class="border border-gray-300 px-4 py-2 text-left font-medium">Name</th>
                            <th class="border border-gray-300 px-4 py-2 text-left font-medium">Status</th>
                            <th class="border border-gray-300 px-4 py-2 text-left font-medium">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">1</td>
                            <td class="border border-gray-300 px-4 py-2">Crystal Dash Support</td>
                            <td class="border border-gray-300 px-4 py-2">CREATING</td>
                            <td class="border border-gray-300 px-4 py-2">2024-12-24</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">2</td>
                            <td class="border border-gray-300 px-4 py-2">Fanvil Support</td>
                            <td class="border border-gray-300 px-4 py-2">ACTIVE</td>
                            <td class="border border-gray-300 px-4 py-2">2024-12-23</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">3</td>
                            <td class="border border-gray-300 px-4 py-2">Fanvil Support</td>
                            <td class="border border-gray-300 px-4 py-2">ACTIVE</td>
                            <td class="border border-gray-300 px-4 py-2">2024-12-23</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">4</td>
                            <td class="border border-gray-300 px-4 py-2">Fanvil Support</td>
                            <td class="border border-gray-300 px-4 py-2">ACTIVE</td>
                            <td class="border border-gray-300 px-4 py-2">2024-12-23</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">5</td>
                            <td class="border border-gray-300 px-4 py-2">Fanvil Support</td>
                            <td class="border border-gray-300 px-4 py-2">ACTIVE</td>
                            <td class="border border-gray-300 px-4 py-2">2024-12-23</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">2</td>
                            <td class="border border-gray-300 px-4 py-2">Fanvil Support</td>
                            <td class="border border-gray-300 px-4 py-2">ACTIVE</td>
                            <td class="border border-gray-300 px-4 py-2">2024-12-23</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">2</td>
                            <td class="border border-gray-300 px-4 py-2">Fanvil Support</td>
                            <td class="border border-gray-300 px-4 py-2">ACTIVE</td>
                            <td class="border border-gray-300 px-4 py-2">2024-12-23</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">2</td>
                            <td class="border border-gray-300 px-4 py-2">Fanvil Support</td>
                            <td class="border border-gray-300 px-4 py-2">ACTIVE</td>
                            <td class="border border-gray-300 px-4 py-2">2024-12-23</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">2</td>
                            <td class="border border-gray-300 px-4 py-2">Fanvil Support</td>
                            <td class="border border-gray-300 px-4 py-2">ACTIVE</td>
                            <td class="border border-gray-300 px-4 py-2">2024-12-23</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">2</td>
                            <td class="border border-gray-300 px-4 py-2">Fanvil Support</td>
                            <td class="border border-gray-300 px-4 py-2">ACTIVE</td>
                            <td class="border border-gray-300 px-4 py-2">2024-12-23</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">2</td>
                            <td class="border border-gray-300 px-4 py-2">Fanvil Support</td>
                            <td class="border border-gray-300 px-4 py-2">ACTIVE</td>
                            <td class="border border-gray-300 px-4 py-2">2024-12-23</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">2</td>
                            <td class="border border-gray-300 px-4 py-2">Fanvil Support</td>
                            <td class="border border-gray-300 px-4 py-2">ACTIVE</td>
                            <td class="border border-gray-300 px-4 py-2">2024-12-23</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">2</td>
                            <td class="border border-gray-300 px-4 py-2">Fanvil Support</td>
                            <td class="border border-gray-300 px-4 py-2">ACTIVE</td>
                            <td class="border border-gray-300 px-4 py-2">2024-12-23</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">2</td>
                            <td class="border border-gray-300 px-4 py-2">Fanvil Support</td>
                            <td class="border border-gray-300 px-4 py-2">ACTIVE</td>
                            <td class="border border-gray-300 px-4 py-2">2024-12-23</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">2</td>
                            <td class="border border-gray-300 px-4 py-2">Fanvil Support</td>
                            <td class="border border-gray-300 px-4 py-2">ACTIVE</td>
                            <td class="border border-gray-300 px-4 py-2">2024-12-23</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div id="editModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center">
            <div class="bg-white rounded w-1/3">
                <div class="bg-yellow-500 py-4 text-center text-white">
                    <h2 class="text-lg font-medium"><i class="fa-solid fa-pencil"></i> Edit Data Source</h2>
                </div>

                <div class="px-6">
                    <div class="mb-4 mt-4">
                        <label for="editId" class="block text-sm font-medium">ID</label>
                        <input id="editId" class="border border-gray-300 px-4 py-2 w-full bg-gray-300" type="text"
                            disabled />
                    </div>
                    <div class="mb-4">
                        <label for="editName" class="block text-sm font-medium">Name</label>
                        <input id="editName" class="border border-gray-300 px-4 py-2 w-full" type="text" />
                    </div>
                    <div class="mb-4">
                        <label for="editStatus" class="block text-sm font-medium">Status</label>
                        <input id="editStatus" class="border border-gray-300 px-4 py-2 w-full bg-gray-300" type="text"
                            disabled />
                    </div>
                    <div class="mb-4">
                        <label for="editCreatedAt" class="block text-sm font-medium">Created At</label>
                        <input id="editCreatedAt" class="border border-gray-300 px-4 py-2 w-full bg-gray-300"
                            type="text" disabled />
                    </div>
                </div>
                <div class="flex justify-center bg-yellow-500 py-4">
                    <button id="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                    <button id="saveChanges" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                </div>
            </div>
        </div>


    </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <!-- Tailwind css -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.2.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.0/js/dataTables.tailwindcss.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Toggle Script -->
    <script src="../scripts/toggle.js"></script>
    <script src="../scripts/data_source.js"></script>

    <!-- Custom Navigation Script -->
    <script src="../scripts/navigation.js"> </script>
</body>

</html>