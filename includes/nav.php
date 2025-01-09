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
<nav class="bg-gray-700 h-24 lg:hidden">
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
    <div class="hidden lg:block col-span-2 sidebar">
        <nav class="bg-gray-700 h-screen flex flex-col">
            <p class="text-center text-2xl text-white font-semibold py-2">Sidebar</p>
            <hr class="border-gray-500">
            <ul class="flex flex-col text-white">
                <?php foreach ($navItems as $item): ?>
                    <li class="py-2 mt-1 hover:bg-neutral-500">
                        <a href="<?= $item['href'] ?>" class="flex items-center desktop-nav">
                            <i class="fa-solid <?= $item['icon'] ?> mr-2 ml-8"></i> <?= $item['name'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="mt-auto pb-4 text-center">
                <p class="text-pink-500 text-2xl">
                    Hello, <a href="../pages/profile.php" class="font-bold"><?= $_SESSION['user'] ?></a>
                </p>
                <a href="../session/logout.php" class="text-white">(Log out)</a>
            </div>
        </nav>
    </div>