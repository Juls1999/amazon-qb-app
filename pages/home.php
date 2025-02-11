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
    <!-- Tailwindcss -->
    <link rel="stylesheet" href="../styles/style.css">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Faustina:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-default@4/default.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
    <!-- fontawesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <!-- nav -->
    <?php include '../includes/nav.php'; ?>

    <div class="col-span-12 lg:col-span-10 max-h-screen overflow-y-auto ">

        <header class="grid grid-cols-12">
            <div class="col-span-12 lg:col-span-6 flex flex-col lg:items-center gap-y-4 ">
                <h1 class="text-5xl text-center font-anton mt-12 mb-5">[Header Here]
                </h1>
                <p class="mx-10 lg:mx-0 lg:ml-16 font-faustina text-xl "><span class="font-bold">[Description
                        here]</span>:
                    Lorem
                    ipsum dolor sit
                    amet consectetur
                    adipisicing elit.
                    Tempore dignissimos minus perferendis! Quae iste mollitia, cumque praesentium nobis autem
                    officia
                    deleniti non voluptatem commodi dolor molestiae voluptatibus in doloremque alias?</p>
                <div class="lg:flex gap-2 justify-center hidden mt-3 ">
                    <button class=" bg-red-600 hover:bg-red-800 px-4 font-semibold py-1 rounded-full text-white"><i
                            class="fa-solid fa-cart-shopping"></i> Purchase
                        now</button>
                    <a href="#" class=" hover:text-red-600 mt-3 italic text-sm">Read more...</a>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-6 flex lg:justify-start justify-center items-center max-h-[370px]">
                <img src="../images/main_product.png" class="w-3/4 h-3/4" alt="main product">
            </div>
            <div class="flex w-screen justify-center gap-8 mb-10 lg:hidden">
                <button class=" bg-red-600 hover:bg-red-800 px-4 py-1 rounded-full text-white">Purchase
                    now</button>
                <a href="#" class="font-semibold hover:text-red-600 mt-1.5">View product</a>
            </div>
        </header>

        <main class="mx-10" id="about-us">
            <p class="leading-relaxed mb-2"><span class="ml-14">Lorem</span> ipsum dolor sit amet
                consectetur
                adipisicing elit. Repudiandae, eveniet
                dolore consequuntur vero, vitae
                provident praesentium, tenetur nisi odio deleniti odit nihil. Officia, cum! Corrupti dolor doloremque
                dolores voluptatibus eligendi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias ut
                ratione excepturi fugit esse. Perspiciatis adipisci provident placeat cum sunt qui illum. Quasi commodi
                ullam minus, consequatur praesentium numquam doloribus. lorem</p>
            <p class="leading-relaxed mb-2"><span class="ml-14">Lorem</span> ipsum dolor sit amet
                consectetur
                adipisicing elit. Repudiandae, eveniet
                dolore consequuntur vero, vitae
                provident praesentium, tenetur nisi odio deleniti odit nihil. Officia, cum! Corrupti dolor doloremque
                dolores voluptatibus eligendi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias ut
                ratione excepturi fugit esse. Perspiciatis adipisci provident placeat cum sunt qui illum. Quasi commodi
                ullam minus, consequatur praesentium numquam doloribus. lorem</p>
            <p class="leading-relaxed mb-2"><span class="ml-14">Lorem</span> ipsum dolor sit amet
                consectetur
                adipisicing elit. Repudiandae, eveniet
                dolore consequuntur vero, vitae
                provident praesentium, tenetur nisi odio deleniti odit nihil. Officia, cum! Corrupti dolor doloremque
                dolores voluptatibus eligendi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Molestias ut
                ratione excepturi fugit esse. Perspiciatis adipisci provident placeat cum sunt qui illum. Quasi commodi
                ullam minus, consequatur praesentium numquam doloribus. lorem</p>
        </main>
        <footer class="mt-5">
            <div class="bg-gray-600 max-h-24 min-h-24 flex justify-center items-center">
                <p class="font-anton text-5xl text-white">[footer here]</p>
            </div>
        </footer>
    </div>
    </div> <!-- End of Desktop View-->

    <!-- Tailwind CSS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
    <script src="../scripts/navigation.js"></script>
</body>

</html>