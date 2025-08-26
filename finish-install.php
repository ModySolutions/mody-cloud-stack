<?php

// Check if wp-config.php already exists
if (file_exists(__DIR__ . '/wp-config.php')) {
    echo "wp-config.php already exists. Skipping.\n";
} else {
    echo "Creating wp-config.php...\n";

    $dotenvPath = __DIR__ . '/.env';
    if (file_exists($dotenvPath)) {
        echo "Using credentials from .env file.\n";
        $env = parse_ini_file($dotenvPath);
        $dbName = $env['DB_NAME'] ?? '';
        $dbUser = $env['DB_USER'] ?? '';
        $dbPassword = $env['DB_PASSWORD'] ?? '';
        $dbHost = $env['DB_HOST'] ?? 'localhost';
    } else {
        echo "No .env file found. Please provide database credentials.\n";
        $dbName = readline("Enter Database Name: ");
        $dbUser = readline("Enter Database User: ");
        $dbPassword = readline("Enter Database Password: ");
        $dbHost = readline("Enter Database Host (default: localhost): ") ?: 'localhost';
    }

    // Fetch unique salts from WordPress.org API
    $salts = file_get_contents('https://api.wordpress.org/secret-key/1.1/salt/');
    if ($salts === false) {
        die("Error: Could not fetch WordPress salts from the API.\n");
    }

    // Build the wp-config.php content
    $wpConfigContent = <<<EOT
<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file to generate a fresh wp-config.php
 * file. You should edit this file and rename it to wp-config.php to customize it.
 *
 * This file is for developers who want to manage their WordPress installation via Composer.
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', '$dbName');

/** MySQL database username */
define('DB_USER', '$dbUser');

/** MySQL database password */
define('DB_PASSWORD', '$dbPassword');

/** MySQL hostname */
define('DB_HOST', '$dbHost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

{$salts}

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') ) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
EOT;

    file_put_contents(__DIR__ . '/app/wp-config.php', $wpConfigContent);
    echo "wp-config.php created successfully.\n";
}

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
    'xmlrpc.php',
];

foreach ($directoriesToLink as $dir) {
    if (file_exists($sourcePath . '/' . $dir) && !file_exists($targetPath . '/' . $dir)) {
        symlink($sourcePath . '/' . $dir, $targetPath . '/' . $dir);
        echo "Symlinked directory: " . $dir . "\n";
    }
}

foreach ($filesToLink as $file) {
    if (file_exists($sourcePath . '/' . $file) && !file_exists($targetPath . '/' . $file)) {
        symlink($sourcePath . '/' . $file, $targetPath . '/' . $file);
        echo "Symlinked file: " . $file . "\n";
    }
}

echo "Installation complete. You are ready to start WordPress.\n";