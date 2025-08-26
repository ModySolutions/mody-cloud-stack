<?php

namespace mody\theme\hooks;

add_action('init', __NAMESPACE__.'\init', 100);
add_action('after_setup_theme', __NAMESPACE__.'\after_setup_theme');
add_action('wp_enqueue_scripts', __NAMESPACE__.'\wp_enqueue_scripts', 100);
add_action('the_content', __NAMESPACE__.'\the_content', 100);
add_action('admin_head', __NAMESPACE__.'\admin_head', 100);
add_action('wp_footer', __NAMESPACE__.'\wp_footer', 100);
add_action('admin_menu', __NAMESPACE__.'\admin_menu', 100);
add_action('wpseo_metabox_prio', __NAMESPACE__.'\wpseo_metabox_prio', 100);
add_action('enqueue_block_editor_assets', __NAMESPACE__.'\enqueue_block_editor_assets', 100);

add_filter('allowed_block_types_all', __NAMESPACE__.'\allowed_block_types_all');

const NEED_TOBUILD_FRONTEND_ERROR_MESSAGE = '<strong>ERROR:</strong> You need to run `pnpm build` or `pnpm dev` to create the app.js file.';

function init(): void {
    register_nav_menus([
        'header_menu' => __('Header menu'),
        'footer_top_menu' => __('Footer top menu'),
        'footer_bottom_menu' => __('Footer bottom menu'),
    ]);

    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_resource_hints', 2);
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');

    wp_deregister_script('heartbeat');

    if (!current_user_can('manage_options')) {
        show_admin_bar(false);
    }
}

function after_setup_theme(): void {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('editor-styles');
    add_theme_support('align-wide');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ]);

    remove_theme_support('core-block-patterns');

    load_theme_textdomain('app', THEME_DIR.'/languages');
}

function wp_enqueue_scripts(): void {
    foreach (_scripts() as $script) {
        wp_register_script($script['handle'], $script['url'], $script['deps'], $script['ver'], $script['args'],);
        wp_localize_script($script['handle'], 'App', [
            'network_url' => network_home_url(),
            'site_url' => site_url(),
            'ajax_url' => admin_url('admin-ajax.php'),
            'account_page_id' => get_option('account_page_id'),
        ]);
        wp_enqueue_script($script['handle']);
    }

    foreach (_styles() as $style) {
        wp_register_style($style['handle'], $style['url'], $style['deps'], $style['ver'], $style['media'],);
        wp_enqueue_style($style['handle']);
    }
}

function enqueue_block_editor_assets(): void {
    $script = <<<EOF
window.onload = function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } }
EOF;
    wp_add_inline_script('wp-blocks', $script);
}

function allowed_block_types_all($allowed_blocks): array|bool {
    return $allowed_blocks;
}

function the_content(string $p): string {
    return preg_replace('/<p>\\s*?(<a rel=\"attachment.*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '$1', $p);
}

function admin_head(): void {
    echo '<style>.yoast-notice-go-premium, .wpseo-metabox-buy-premium, .yoast_premium_upsell_admin_block, .wpseo_content_cell #sidebar {display: none;}</style>';
}

function wp_footer(): void {
    wp_deregister_script('wp-embed');
}

function admin_menu(): void {
    if (function_exists('remove_menu_page')) {
        remove_menu_page('edit-comments.php');
    }

    remove_filter('update_footer', 'core_update_footer');
}

function wpseo_metabox_prio(): string {
    return 'low';
}

function _scripts(): array {
    $file = THEME_DIR.'/dist/app.asset.php';
    if(!file_exists($file)) {
        wp_die(__(NEED_TOBUILD_FRONTEND_ERROR_MESSAGE, 'app'));
    }
    $app = include($file);
    return [
        [
            'handle' => 'app',
            'url' => THEME_URI.'/dist/app.js',
            'ver' => $app['version'],
            'deps' => array_merge($app['dependencies'], ['wp-api']),
            'args' => ['in_footer' => true, 'defer' => true],
        ],
    ];
}

function _styles(): array {
    $file = THEME_DIR.'/dist/app.asset.php';
    if(!file_exists($file)) {
        wp_die(__(NEED_TOBUILD_FRONTEND_ERROR_MESSAGE, 'app'));
    }
    $app = include($file);
    return [
        [
            'handle' => 'app',
            'url' => THEME_URI.'/dist/app.css',
            'ver' => $app['version'],
            'deps' => null,
            'media' => 'all',
        ],
    ];
}
