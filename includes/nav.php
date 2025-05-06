<?php
$navItems = [
    ["href" => "/amazon-q/pages/home.php", "icon" => "fa-house", "name" => "Home"],
    ["href" => "/amazon-q/pages/chat.php", "icon" => "fa-comment", "name" => "Chat Bot"],
    ["href" => "/amazon-q/pages/feedbacks.php", "icon" => "fa-table", "name" => "Feedback"],
    ["href" => "/amazon-q/pages/data_source.php", "icon" => "fa-database", "name" => "Data Source"],
    ["href" => "/amazon-q/pages/index_provisioning.php", "icon" => "fa-cogs", "name" => "Index Provisioning"],
];
?>

<!-- Mobile Navigation -->
<nav class="bg-gray-700 h-24 sticky top-0 z-10 lg:hidden">
    <h1 class="text-center text-white text-2xl font-semibold">AI-KB</h1>
    <ul class="flex justify-around text-white font-semibold">
        <?php foreach ($navItems as $item): ?>
            <li>
                <a href="<?= $item['href'] ?>">
                    <i class="fa-solid <?= $item['icon'] ?> mt-7 text-2xl"></i>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<!-- Desktop Navigation -->
<div class="grid grid-cols-12">
    <div class="hidden lg:block col-span-2">
        <nav class="bg-gray-700 h-screen flex flex-col">
            <div class="flex items-center justify-center my-2">
                <img src="../images/logo.png" alt="logo" class="rounded-full w-10 h-10">
                <div class="border-l-2 border-gray-300 mx-4 h-6"></div> <!-- Divider -->
                <p class="text-xl font-anton text-white">AI - KB</p>
            </div>
            <hr class="border-gray-500 my-2">
            <ul class=" text-white">
                <?php foreach ($navItems as $item): ?>
                    <li class="mt-1 hover:bg-neutral-500">
                        <a href="<?= $item['href'] ?>" class="flex items-center font-anton py-2 ">
                            <i class="fa-solid <?= $item['icon'] ?> mr-2 ml-8"></i> <?= $item['name'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="mt-auto pb-4 text-center">
                <p class="text-pink-500 text-2xl">
                    Hello, <a href="../pages/profile.php" class="font-anton "><?= $_SESSION['user'] ?></a>
                </p>
                <a href="../session/logout.php"
                    class="text-white bg-red-600 px-3 pb-1 rounded-full hover:bg-red-700">Log out</a>
            </div>
        </nav>
    </div>