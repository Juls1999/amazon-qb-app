<?php
// include '../includes/view_response.php';
error_reporting(0);
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

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.tailwindcss.css">

    <!-- Main CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-default@4/default.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>


    <!-- Loading Screen -->
    <div id="loading-screen">
        <p>Loading...</p>
    </div>
    <!-- nav -->
    <?php include '../includes/nav.php'; ?>

    <div class="col-span-12 lg:col-span-10">
        <div class="mx-4">
            <!-- Table Container with Horizontal Scrolling -->
            <div class="max-h-screen overflow-y-auto lg:overflow-x-hidden">
                <table id="feedbackTable" class="min-w-full divide-y divide-gray-200 table-fixed">
                    <thead class="bg-gray-500">
                        <tr class="bg-gray-200">
                            <th class="hidden px-4 py-2 text-left text-sm font-medium w-1/5">ID</th>
                            <th class="px-4 py-2 text-left text-sm font-medium w-1/5">Prompt</th>
                            <th class="px-4 py-2 text-left text-sm font-medium w-1/5">Response</th>
                            <th class="px-4 py-2 text-left text-sm font-medium w-1/5">Feedback</th>
                            <th class="px-4 py-2 text-left text-sm font-medium w-1/5">Created at</th>
                            <th class="px-4 py-2 text-center text-sm font-medium w-1/5">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($responses as $index => $response): ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-300">
                                <td class="hidden"><?= $response['id']; ?></td>
                                <td class="truncate px-4 py-2"><?= $response['prompt']; ?></td>
                                <td class="truncate px-4 py-2"><?= $response['message']; ?></td>
                                <td class="truncate px-4 py-2"><?= $response['feedback_type']; ?></td>
                                <td class="truncate px-4 py-2"><?= $response['created_at']; ?></td>
                                <td class="px-4 py-2 text-center lg:flex lg:gap-2 lg:justify-center">
                                    <button id="editButton"
                                        class="px-2 py-2 lg:px-4 lg:py-2 rounded-md bg-amber-500 lg:flex text-white hover:bg-amber-700">
                                        <i class="fa-solid fa-pencil lg:mr-1 lg:mt-1"></i><span
                                            class="hidden lg:block">Edit</span>
                                    </button>
                                    <button id="deleteButton"
                                        class="px-2 py-2 lg:px-3 lg:py-2 rounded-md bg-red-500 lg:flex text-white hover:bg-red-700 ">
                                        <i class="fa-solid fa-trash-can lg:mr-1 lg:mt-1"></i><span
                                            class="hidden lg:block">Delete</span>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50  items-center justify-center hidden">
                <div class="bg-white rounded-lg shadow-lg max-w-md w-full">
                    <div class="bg-amber-500 py-3 flex">
                        <h2 class="text-xl text-white ml-4 font-semibold mb-4"><i
                                class="fa-solid fa-pencil mr-2"></i>Edit Feedback</h2>
                        <i id="exitButton"
                            class="fa-solid fa-x text-gray-600 ml-auto mt-2 mr-4 hover:cursor-pointer"></i>
                    </div>
                    <div class="h-[400px] mx-2">
                        <div class="my-2">
                            <label for="prompt" class="lg:text-xl">Prompt:</label>
                            <textarea name="prompt" id="prompt" placeholder="TBA"
                                class="border border-black w-full h-24 resize-none text-justify bg-gray-200 text-gray-400"
                                disabled></textarea>
                        </div>
                        <div class="my-2">
                            <label for="response" class="lg:text-xl">Response:</label>
                            <textarea name="response" id="response" placeholder="TBA"
                                class="border border-black w-full h-36 resize-none text-justify"></textarea>
                        </div>
                    </div>
                    <hr class="">
                    <div class="flex justify-center bg-amber-500">
                        <button id="saveButton"
                            class="px-4 py-2 bg-green-600 text-white rounded mt-3 mb-3 disabled:bg-gray-400 disabled:text-gray-600 cursor-not-allowed">
                            <i class="fa-solid fa-floppy-disk mr-1"></i>Save Changes
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
    </div>

    <!-- Tailwind css -->

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.tailwindcss.js"></script>
    <!-- table.js -->
    <script src="../scripts/table.js"></script>
    <!-- custom JS -->
    <script src="../scripts/feedbacks.js"></script>
    <!-- Custom Toggle Script -->
    <script src="../scripts/toggle.js"></script>
    <!-- Custom Navigation Script -->
    <script src="../scripts/navigation.js"> </script>
</body>

</html>