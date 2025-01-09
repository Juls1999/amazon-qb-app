<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
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

<!-- Loading Screen -->
<div id="loading-screen">
    <p>Loading...</p>
</div>
<!-- nav -->
<?php include '../includes/nav.php'; ?>

<div class="col-span-12 lg:col-span-10">
    <h1 class="text-2xl text-center py-4 font-bold">AI-KB - Home</h1>

    <div class="mx-10">
        <p class="font-roboto leading-relaxed mb-2 text-justify"><span class="ml-14">Lorem</span> ipsum dolor sit amet
            consectetur
            adipisicing elit. Repudiandae, eveniet
            dolore consequuntur vero, vitae
            provident praesentium, tenetur nisi odio deleniti odit nihil. Officia, cum! Corrupti dolor doloremque
            dolores voluptatibus eligendi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias ut
            ratione excepturi fugit esse. Perspiciatis adipisci provident placeat cum sunt qui illum. Quasi commodi
            ullam minus, consequatur praesentium numquam doloribus. lorem</p>
    </div>

    <div class="mx-10">
        <p class="font-roboto  leading-relaxed mb-2 text-justify"><span class="ml-14">Lorem</span> ipsum dolor sit amet
            consectetur
            adipisicing elit. Repudiandae, eveniet
            dolore consequuntur vero, vitae
            provident praesentium, tenetur nisi odio deleniti odit nihil. Officia, cum! Corrupti dolor doloremque
            dolores voluptatibus eligendi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias ut
            ratione excepturi fugit esse. Perspiciatis adipisci provident placeat cum sunt qui illum. Quasi commodi
            ullam minus, consequatur praesentium numquam doloribus. lorem</p>
    </div>

    <div class="mx-10">
        <p class="font-roboto  leading-relaxed mb-2 text-justify"><span class="ml-14">Lorem</span> ipsum dolor sit amet
            consectetur
            adipisicing elit. Repudiandae, eveniet
            dolore consequuntur vero, vitae
            provident praesentium, tenetur nisi odio deleniti odit nihil. Officia, cum! Corrupti dolor doloremque
            dolores voluptatibus eligendi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias ut
            ratione excepturi fugit esse. Perspiciatis adipisci provident placeat cum sunt qui illum. Quasi commodi
            ullam minus, consequatur praesentium numquam doloribus. lorem</p>
    </div>
</div>
</div> <!--end of grid -->

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
<script src="../scripts/toggle.js"></script>
<script src="../scripts/navigation.js"></script>
</body>

</html>