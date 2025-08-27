<?php

namespace mody\base\editor;

use function Mody\Base\Functions\enqueue_script;

defined('ABSPATH') || exit;

add_action('admin_enqueue_scripts', __NAMESPACE__.'\admin_enqueue_scripts');

function admin_enqueue_scripts(): void {
    $handle = 'baseEditor';
    enqueue_script(MODY_BASE_DIR, MODY_BASE_URL, $handle, true);

    $theme_palette = get_field('field_color_palette_repeater', 'option');
    if ($theme_palette && is_array($theme_palette)) {
        $localized_palette = [];
        foreach ($theme_palette as $color) {
            $localized_palette[] = $color['color_value'];
        }
    } else {
        $localized_palette = ['#000000', '#FFFFFF'];
    }

    wp_localize_script("mody-base-{$handle}", 'ModyBase', [
        'palette' => $localized_palette,
    ]);
    wp_enqueue_script("mody-base-{$handle}");
}