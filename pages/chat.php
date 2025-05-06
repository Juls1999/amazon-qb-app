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
    <!-- Tailwindcss -->
    <link rel="stylesheet" href="../styles/style.css">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Faustina:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">


    <!-- Main CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-default@4/default.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>



    <!-- nav -->
    <?php include '../includes/nav.php'; ?>

    <!-- Main Content -->
    <div class="col-span-12 lg:col-span-10 p-4">
        <h1 class="text-2xl font-bold uppercase">Crystal Dash Agent</h1>
        <div class="flex flex-col h-[370px] lg:h-[480px] border border-gray-300 rounded-lg overflow-hidden">

            <div id="chatBox" class="flex-1 p-4 overflow-y-auto bg-neutral-200 border-b border-gray-300">
                <!-- Chat messages will appear here -->

            </div>

            <button id="destroySessionBtn" class="bg-red-400 hover:bg-red-600 text-white px-4 py-2 rounded-md">End
                Chat</button>
            <div class="flex items-center border-t border-gray-300 bg-gray-50 p-2">
                <input type="text" id="userPrompt" placeholder="Type your message..."
                    class="flex-1 border border-gray-300 rounded-lg p-2 mr-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button id="sendButton"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Send
                </button>
            </div>
        </div>
        <p class="text-sm lg:text-base text-red-500 text-center mt-2">Use end chat before and after you use the
            chatbot to refresh the session.</p>
    </div>
    <!-- End of Main Content -->
    </div><!-- End of Desktop View-->


    <!-- Tailwind css -->
    <!--Jquery-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
    <!-- custom script -->
    <script src="../scripts/chat.js"></script>


    <!-- Custom Navigation Script -->
    <script src="../scripts/navigation.js"> </script>


</body>

</html>