#!/bin/bash

# Abort on any error
set -e

echo "Copying WordPress core files..."

PROJECT_ROOT=$(pwd)
SOURCE_PATH="${PROJECT_ROOT}/app/wp"
TARGET_PATH="${PROJECT_ROOT}/app"

if [ ! -d "${SOURCE_PATH}" ]; then
    echo "Error: WordPress source directory not found at ${SOURCE_PATH}."
    exit 1
fi

DIRS_TO_COPY=("wp-admin" "wp-includes")

FILES_TO_COPY=("index.php" "license.txt" "readme.html" "wp-activate.php" "wp-blog-header.php" "wp-comments-post.php" "wp-config-sample.php" "wp-cron.php" "wp-links-opml.php" "wp-load.php" "wp-login.php" "wp-mail.php" "wp-settings.php" "wp-signup.php" "wp-trackback.php" "xmlrpc.php")

for dir in "${DIRS_TO_COPY[@]}"; do
    if [ ! -d "${TARGET_PATH}/${dir}" ]; then
        echo "Copying directory: ${dir}"
        cp -R "${SOURCE_PATH}/${dir}" "${TARGET_PATH}/"
    fi
done

for file in "${FILES_TO_COPY[@]}"; do
    if [ ! -f "${TARGET_PATH}/${file}" ]; then
        echo "Copying file: ${file}"
        cp "${SOURCE_PATH}/${file}" "${TARGET_PATH}/"
    fi
done

echo "Cleaning up temporary WordPress installation at ${SOURCE_PATH}..."
rm -rf "${SOURCE_PATH}"
echo "Temporary directory deleted."
echo "WordPress core files copied successfully."