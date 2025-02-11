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
    <!-- Tailwindcss -->
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

        <div class="bg-white sm:mx-4 rounded-md sm:my-3">
            <div class="ml-4 flex gap-2">
                <!-- Add Data Source Button -->
                <button id="addBtn"
                    class="bg-green-500 hover:bg-green-600 disabled:opacity-50 cursor-not-allowed py-2 px-6 md:py-1 md:px-4 rounded-full text-white mt-3 mb-1 tooltip-btn"
                    data-tooltip="Add a new data source" disabled>
                    <div class="flex gap-1"><i class="fa-solid fa-plus md:mt-1"></i> <span class="hidden md:block"> Add Data
                            Source</span></div>
                </button>

                <!-- Edit Data Source Button -->
                <button id="editBtn"
                    class="bg-yellow-500 hover:bg-yellow-600 py-2 px-6 md:py-1 md:px-4 rounded-full text-white disabled:opacity-50 mt-3 mb-1 cursor-not-allowed tooltip-btn"
                    data-tooltip="Edit the selected data source" disabled>
                    <div class="flex gap-1"><i class="fa-solid fa-pencil md:mt-1"></i> <span class="hidden md:block"> Edit Data
                            Source</span></div>
                </button>

                <!-- Delete Data Source Button -->
                <button id="deleteBtn"
                    class="bg-red-500 hover:bg-red-600 py-2 px-6 md:py-1 md:px-4 rounded-full text-white disabled:opacity-50 mt-3 mb-1 cursor-not-allowed tooltip-btn"
                    data-tooltip="Delete the selected data source" disabled>
                    <div class="flex gap-1"><i class="fa-solid fa-trash md:mt-1"></i> <span class="hidden md:block"> Delete Data
                            Source</span></div>
                </button>
            </div>

            <!-- Tooltip Container -->
            <div id="tooltip"
                class="absolute hidden bg-white text-black border border-black text-sm rounded px-2 py-1 pointer-events-none">
            </div>
            <div class="mx-6 max-h-[560px] min-h-[560px] overflow-y-auto md:overflow-x-hidden">
                <div class="flex animate-pulse">
                    <div class="h-12 w-1/6 rounded-md bg-gray-300"></div>
                    <div class="h-12 w-1/4 rounded-md bg-gray-300 ml-auto"></div>
                </div>
                <table id="dataTable" class="hover:cursor-not-allowed w-full mt-2">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-4 py-2 text-left font-medium">ID</th>
                            <th class="border border-gray-300 px-4 py-2 text-left font-medium">Name</th>
                            <th class="border border-gray-300 px-4 py-2 text-left font-medium">Status</th>
                            <th class="border border-gray-300 px-4 py-2 text-left font-medium">Created At</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Skeleton Loader Rows -->
                        <tr class="animate-pulse h-9">
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300" disabled></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                            <td class="border border-gray-300 px-4 py-2 bg-gray-300"></td>
                        </tr>
                        <tr class="animate-pulse h-9">
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
                        </tr>
                        <tr class="animate-pulse h-9">
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
                        </tr>
                        <tr class="animate-pulse h-9">
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
        <!-- Add Modal -->
        <div id="addModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 items-center justify-center">
            <div class="bg-white rounded w-screen md:w-1/3">
                <div class="bg-green-500 py-4 text-center text-white">
                    <h2 class="text-lg font-medium"><i class="fa-solid fa-plus"></i> Add Data Source</h2>
                </div>

                <div class="px-6">
                    <div class="mb-4 mt-4">
                        <label for="addId" class="block text-sm font-medium">ID</label>
                        <input id="addId" class="border border-gray-300 px-4 py-2 w-full" type="text" />
                    </div>
                    <div class="mb-4">
                        <label for="addName" class="block text-sm font-medium">Name</label>
                        <input id="addName" class="border border-gray-300 px-4 py-2 w-full" type="text" />
                    </div>
                    <div class="mb-4">
                        <label for="addStatus" class="block text-sm font-medium">Status</label>
                        <input id="addStatus" class="border border-gray-300 px-4 py-2 w-full" type="text" />
                    </div>
                </div>
                <div class="flex justify-center bg-green-500 py-4">
                    <button id="closeAddBtn" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                    <button id="saveAddBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                </div>
            </div>
        </div> <!-- End of Add Modal-->

        <!-- Edit Modal -->
        <div id="editModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 items-center justify-center">
            <div class="bg-white rounded w-screen md:w-1/3">
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
                    <button id="editSaveBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                </div>
            </div>
        </div> <!-- End of Edit Modal -->

        <!-- Delete Modal -->
        <div id="deleteModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 items-center justify-center">
            <div class="bg-white rounded w-screen md:w-1/3">
                <div class="bg-red-500 py-4 text-center text-white">
                    <h2 class="text-lg font-medium"><i class="fa-solid fa-trash"></i> Confirm Deletion</h2>
                </div>
                <div class="px-6 py-4">
                    <p class="text-sm font-medium text-gray-700">Are you sure you want to delete this data source? This
                        action cannot be undone.</p>
                </div>
                <div class="flex justify-center bg-red-500 py-4">
                    <button id="closeDeleteModal" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                    <button id="confirmDeleteBtn" class="bg-red-700 text-white px-4 py-2 rounded">Delete</button>
                </div>
            </div>
        </div> <!-- End of Delete Modal-->
    </div>
    </div> <!-- End of Desktop View-->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <!-- Tailwind css -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
    <script src="../scripts/data_table.js"></script>

    <!-- Custom Toggle Script -->
    <!-- <script src="../scripts/loading_screen.js"></script> -->
    <script src="../scripts/data_source.js"></script>

    <!-- Custom Navigation Script -->
    <script src="../scripts/navigation.js"> </script>
</body>

</html>