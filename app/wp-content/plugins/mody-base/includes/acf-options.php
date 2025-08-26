<?php

namespace mody\base;

defined('ABSPATH') || exit;

if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => __('Mody Cloud', 'app'),
        'menu_title' => __('Mody Cloud', 'app'),
        'menu_slug' => 'mody-cloud-settings',
        'capability' => 'manage_options',
        'icon_url' => 'dashicons-admin-site',
        'position' => 1,
        'redirect' => 'mody-cloud-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title' => __('Theme & Styles', 'app'),
        'menu_title' => __('Theme & Styles', 'app'),
        'parent_slug' => 'mody-cloud-settings',
    ));

    add_action('acf/init', __NAMESPACE__ . '\acf_init');
}

function acf_init() : void {

    $default_classes_tab = array(
        'key'       => 'field_default_classes_tab',
        'label'     => __( 'Default classes', 'app' ),
        'name'      => 'tab_type',
        'type'      => 'tab',
        'placement' => 'left',
    );
    $default_classes_h1 = array(
        'key' => 'field_default_classes_h1',
        'label' => __('H1 Classes', 'app'),
        'name' => 'theme_default_classes_h1',
        'type' => 'text',
        'instructions' => __('Enter the default CSS classes for H1 elements.', 'app'),
    );
    $default_classes_btn_primary = array(
        'key' => 'field_default_classes_btn_primary',
        'label' => __('Primary Button Classes', 'app'),
        'name' => 'theme_default_classes_btn_primary',
        'type' => 'text',
        'instructions' => __('Enter the default CSS classes for primary buttons.', 'app'),
    );
    $default_classes_btn_secondary = array(
        'key' => 'field_default_classes_btn_secondary',
        'label' => __('Secondary Button Classes', 'app'),
        'name' => 'theme_default_classes_btn_secondary',
        'type' => 'text',
        'instructions' => __('Enter the default CSS classes for secondary buttons.', 'app'),
    );
    $default_classes_input = array(
        'key' => 'field_default_classes_input',
        'label' => __('Input Field Classes', 'app'),
        'name' => 'theme_default_classes_input',
        'type' => 'text',
        'instructions' => __('Enter the default CSS classes for form input fields.', 'app'),
    );
    $default_classes_textarea = array(
        'key' => 'field_default_classes_textarea',
        'label' => __('Textarea Classes', 'app'),
        'name' => 'theme_default_classes_textarea',
        'type' => 'text',
        'instructions' => __('Enter the default CSS classes for textarea fields.', 'app'),
    );
    $color_palette_tab = array(
        'key'       => 'field_color_palette_tab',
        'label'     => __( 'Color Palette', 'app' ),
        'name'      => 'tab_color_palette',
        'type'      => 'tab',
        'placement' => 'left',
    );
    $color_palette_repeater = array(
        'key' => 'field_color_palette_repeater',
        'label' => __('Color Palette', 'app'),
        'name' => 'theme_color_palette',
        'type' => 'repeater',
        'instructions' => __('Add colors to the theme color palette.', 'app'),
        'button_label' => __('Add color', 'app'),
        'sub_fields' => array(
            array(
                'key' => 'field_color_name',
                'label' => __('Color Name', 'app'),
                'name' => 'color_name',
                'type' => 'text',
                'instructions' => __('Enter a name for the color (e.g., Primary, Secondary).', 'app'),
                'wrapper' => array(
                    'class' => 'ignore-mody-color-picker',
                )
            ),
            array(
                'key' => 'field_color_value',
                'label' => __('Color Value', 'app'),
                'name' => 'color_value',
                'type' => 'color_picker',
                'instructions' => __('Select the color value.', 'app'),
            ),
        ),
    );
    acf_add_local_field_group(array(
        'key' => 'group_theme_styles',
        'title' => __('Theme & Styles', 'app'),
        'fields' => array(
            $default_classes_tab,
            $default_classes_h1,
            $default_classes_btn_primary,
            $default_classes_btn_secondary,
            $default_classes_input,
            $default_classes_textarea,
            $color_palette_tab,
            $color_palette_repeater
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-theme-styles',
                ),
            ),
        ),
        'menu_order' => 0,
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ));
}
