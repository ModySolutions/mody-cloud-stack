<?php

$sourcePath = __DIR__ . '/app/wp';
$targetPath = __DIR__ . '/app';

$directoriesToLink = ['wp-admin', 'wp-includes'];
$filesToLink = [
    'wp-activate.php',
    'wp-blog-header.php',
    'wp-comments-post.php',
    'wp-cron.php',
    'wp-links-opml.php',
    'wp-load.php',
    'wp-login.php',
    'wp-mail.php',
    'wp-settings.php',
    'wp-signup.php',
    'wp-trackback.php',
    'xmlrpc.php'
];

foreach ($directoriesToLink as $dir) {
    if (!file_exists($targetPath . '/' . $dir)) {
        symlink($sourcePath . '/' . $dir, $targetPath . '/' . $dir);
        echo "Symlinked directory: " . $dir . "\n";
    }
}

foreach ($filesToLink as $file) {
    if (!file_exists($targetPath . '/' . $file)) {
        symlink($sourcePath . '/' . $file, $targetPath . '/' . $file);
        echo "Symlinked file: " . $file . "\n";
    }
}

echo "Installation complete. Please check for a wp-config.php file." . PHP_EOL;