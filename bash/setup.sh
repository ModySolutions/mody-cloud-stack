#!/bin/bash

# Abort on any error
set -e

echo "Creating symlinks for WordPress core files..."

PROJECT_ROOT=$(pwd)
SOURCE_PATH="${PROJECT_ROOT}/app/wp"
TARGET_PATH="${PROJECT_ROOT}/app"

DIRS_TO_LINK=("wp-admin" "wp-includes")

FILES_TO_LINK=("index.php" "license.txt" "readme.html" "wp-activate.php" "wp-blog-header.php" "wp-comments-post.php" "wp-config-sample.php" "wp-cron.php" "wp-links-opml.php" "wp-load.php" "wp-login.php" "wp-mail.php" "wp-settings.php" "wp-signup.php" "wp-trackback.php" "xmlrpc.php")

for dir in "${DIRS_TO_LINK[@]}"; do
    if [ ! -L "${TARGET_PATH}/${dir}" ]; then
        echo "Creating symlink for directory: ${dir}"
        ln -s "${SOURCE_PATH}/${dir}" "${TARGET_PATH}/${dir}"
    fi
done

for file in "${FILES_TO_LINK[@]}"; do
    if [ ! -L "${TARGET_PATH}/${file}" ]; then
        echo "Creating symlink for file: ${file}"
        ln -s "${SOURCE_PATH}/${file}" "${TARGET_PATH}/${file}"
    fi
done

echo "WordPress core symlinks created successfully."