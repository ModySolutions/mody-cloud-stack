<?php
/*
 * Plugin Name: Mody Base
 * Plugin URI: https://mody.cloud
 * Description: Base module for Mody Cloud.
 * Author: Mody Cloud
 * Version: 0.0.1
 * Author URI: https://mody.cloud
 */

namespace Mody\Base;

define('MODY_BASE_DIR', plugin_dir_path(__FILE__));
define('MODY_BASE_URL', plugin_dir_url(__FILE__));

require_once __DIR__ . '/includes/acf-options.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/editor.php';