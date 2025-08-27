<?php

namespace Mody\Base\Functions;

defined('ABSPATH') || exit;

function enqueue_script(string $dir, string $url, string $handle, bool $only_register = false): void {
    $asset_file = $dir . '/dist/' . $handle . '.asset.php';
    if (!file_exists($asset_file)) {
        wp_die(__('Error: Mody Base asset file is missing. Please run the build process to generate the necessary files.',
            'mody-base'));
    }
    $asset = require_once $asset_file;

    if($only_register) {
        wp_register_script('mody-base-' . $handle, $url . '/dist/' . $handle . '.js', $asset['dependencies'], $asset['version']);
        return;
    }
    wp_enqueue_script('mody-base-' . $handle, $url . '/dist/' . $handle . '.js', $asset['dependencies'], $asset['version']);
}