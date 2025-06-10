<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <div class="flex flex-col items-center">
            <img class="w-24 h-24 rounded-full border-4 border-green-400 mb-4" src="<?= esc($user['profile_picture']) ?>" alt="Profile Picture">
            <h2 class="text-2xl font-bold text-gray-800 mb-2"><?= esc($user['username']) ?></h2>
            <p class="text-gray-500 mb-4"><?= esc($user['email']) ?></p>
            <a href="#" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition">Edit Profile</a>
        </div>
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">About</h3>
            <p class="text-gray-600 text-sm">
                <?= esc($user['bio']) ?>
            </p>
        </div>
        <?php if (!empty($user['social_links'])): ?>
        <div class="mt-6">
            <h4 class="text-md font-semibold text-gray-700 mb-2">Social Links</h4>
            <div class="flex space-x-4">
                <?php foreach ($user['social_links'] as $platform => $link): ?>
                    <a href="<?= esc($link) ?>" target="_blank" class="text-blue-500 hover:underline capitalize"><?= esc($platform) ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>