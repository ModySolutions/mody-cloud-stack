<?php

/*
 * Plugin Name: Mody login
 * Plugin URI: https://mody.cloud
 * Description: Login styles for the Mody Cloud theme.
 * Author: Mody Cloud
 * Version: 0.0.1
 * Author URI: https://mody.cloud
 */

define( 'ORION_URL', plugin_dir_url( __FILE__ ) );
define( 'ORION_PATH', plugin_dir_path( __FILE__ ) );
define( 'ORION_VER', filemtime( ORION_PATH . '/dist/orion.css' ) );
const ORION_META_KEY_PAGES_NAME  = 'session-page';
const ORION_SETTINGS_OBJECT_ID   = 914;
const ORION_GOOGLE_MAPS_API_KEY  = 'AIzaSyAncEM3NM9bgoV2vPCghVsC0Zj2wSQJ6PA';
const ORION_GOOGLE_FONTS_API_KEY = 'AIzaSyBDjBu0YICdC1CxOAu5DTizv3gzzTLPs6o';

$autoload = ORION_PATH . '/vendor/autoload.php';
if(!file_exists($autoload)){
    wp_die('Please run "composer install" from the mody-login plugin directory.');
}

require_once $autoload;

if ( function_exists( 'acf_add_local_field_group' ) ) {
	\orion\actions\Orion_Initializer::start();
}
