<?php

namespace Mody\Invoice\Hooks;

const INVOICE_POST_TYPE_NAME = 'invoice';
const INVOICE_POST_STATUS_NAME = 'invoice-status';

if (function_exists('acf_add_options_page')) {
    add_action('init', __NAMESPACE__.'\init');
    add_action('acf/init', __NAMESPACE__.'\acf_init');
}

function init(): void {
    $invoice_labels = array(
        'name' => _x('Invoices', 'Post type general name', 'app'),
        'singular_name' => _x('Invoice', 'Post type singular name', 'app'),
        'menu_name' => _x('Invoices', 'Admin Menu text', 'app'),
        'name_admin_bar' => _x('Invoices', 'Add New on Toolbar', 'app'),
        'add_new' => __('Add New', 'app'),
        'add_new_item' => __('Add New Invoice', 'app'),
        'new_item' => __('New Invoice', 'app'),
        'edit_item' => __('Edit Invoice', 'app'),
        'view_item' => __('View Invoice', 'app'),
        'all_items' => __('All Invoices', 'app'),
        'search_items' => __('Search Invoices', 'app'),
        'parent_item_colon' => __('Parent Invoice:', 'app'),
        'not_found' => __('No events found.', 'app'),
        'not_found_in_trash' => __('No events found in Trash.', 'app'),
        'featured_image' => _x('Invoice Cover Image', 'Overrides the "Featured Image" phrase for this post type.',
            'app'),
        'set_featured_image' => _x('Set cover image', 'Overrides the "Set featured image" phrase for this post type.',
            'app'),
        'remove_featured_image' => _x('Remove cover image',
            'Overrides the "Remove featured image" phrase for this post type.', 'app'),
        'use_featured_image' => _x('Use as cover image',
            'Overrides the "Use as featured image" phrase for this post type.', 'app'),
        'archives' => _x('Invoices archives', 'The post type archive label used in nav menus.', 'app'),
        'insert_into_item' => _x("\\Insert into invoice",
            'Overrides the "Insert into post"/"Insert into page" phrase (used when inserting media into a post).',
            'app'),
        'uploaded_to_this_item' => _x('Uploaded to this events',
            'Overrides the "Uploaded to this post"/"Uploaded to this page" phrase (used when viewing media attached to a post).',
            'app'),
        'filter_items_list' => _x('Filter events list',
            'Screen reader text for the filter links heading on the post type listing screen.', 'app'),
        'items_list_navigation' => _x('Invoices list navigation',
            'Screen reader text for the pagination heading on the post type listing screen.', 'app'),
        'items_list' => _x('Invoices list',
            'Screen reader text for the items list heading on the post type listing screen.', 'app'),
    );
    register_post_type(INVOICE_POST_TYPE_NAME, [
        'labels' => $invoice_labels,
        'public' => true,
        'has_archive' => true,
        'supports' => ['title'],
        'menu_icon' => 'dashicons-money-alt',
    ]);

    $labels = array(
        'name' => _x('Status', 'app'),
        'singular_name' => _x('Status', 'app'),
        'search_items' => _x('Search status', 'app'),
        'popular_items' => _x('Popular status', 'app'),
        'all_items' => _x('All status', 'app'),
        'parent_item' => _x('Parent status', 'app'),
        'parent_item_colon' => _x('Parent status:', 'app'),
        'edit_item' => _x('Edit status', 'app'),
        'update_item' => _x('Update status', 'app'),
        'add_new_item' => _x('Add New status', 'app'),
        'new_item_name' => _x('New status', 'app'),
        'separate_items_with_commas' => _x('Separate status with commas', 'app'),
        'add_or_remove_items' => _x('Add or remove status', 'app'),
        'choose_from_most_used' => _x('Choose from the most used status', 'app'),
        'menu_name' => _x('Status', 'app'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => false,
        'show_admin_column' => true,
        'hierarchical' => true,
        'rewrite' => true,
        'query_var' => true,
        'has_archive' => true,
        'meta_box_cb' => false,
    );

    register_taxonomy(INVOICE_POST_STATUS_NAME, array(INVOICE_POST_TYPE_NAME), $args);
}

function acf_init(): void {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    $field_invoice_default_values = array(
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => INVOICE_POST_TYPE_NAME,
                ),
            ),
        ),
        'style' => 'default',
    );

    invoice_data_group_fields($field_invoice_default_values);
    invoice_item_groups_fields($field_invoice_default_values);
    invoice_status_group_fields($field_invoice_default_values);
    invoice_sidebar_total_group_fields($field_invoice_default_values);

    $field_status_default_values = array(
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => INVOICE_POST_STATUS_NAME,
                ),
            ),
        ),
        'style' => 'seamless',
    );

    status_group_fields($field_status_default_values);
}

function invoice_data_group_fields(array $field_default_values): bool {
    if (!function_exists('acf_add_local_field_group')) {
        return false;
    }

    $invoice_logo_field = array(
        'key' => 'field_invoice_logo',
        'label' => __('Company Logo', 'app'),
        'name' => 'invoice_logo',
        'type' => 'image',
        'instructions' => __('Upload the company logo to be displayed on the invoice.', 'app'),
        'required' => true,
        'wrapper' => array(
            'width' => '50',
        ),
    );

    $invoice_number_field = array(
        'key' => 'field_invoice_number',
        'label' => __('Invoice Number', 'app'),
        'name' => 'invoice_number',
        'type' => 'text',
        'instructions' => __('Enter the invoice number.', 'app'),
        'required' => true,
        'wrapper' => array(
            'width' => '50',
        ),
    );

    $invoice_sender_field = apply_filters('mody_invoice_sender_field', array(
        'key' => 'field_invoice_sender',
        'label' => __('Sender Information', 'app'),
        'name' => 'invoice_sender',
        'type' => 'textarea',
        'instructions' => __('Enter the sender\'s information (e.g., company name, address, contact details).', 'app'),
        'required' => true,
        'wrapper' => array(
            'width' => '50',
        ),
        'rows' => 3,
    ));

    $invoice_issue_date_field = array(
        'key' => 'field_invoice_issue_date',
        'label' => __('Invoice issue date', 'app'),
        'name' => 'invoice_issue_date',
        'type' => 'date_picker',
        'instructions' => __('Select the date of the invoice.', 'app'),
        'required' => true,
        'wrapper' => array(
            'width' => '50',
        ),
    );

    $invoice_client_field = apply_filters('mody_invoice_client_field', array(
        'key' => 'field_invoice_client',
        'label' => __('Client Information', 'app'),
        'name' => 'invoice_client',
        'type' => 'textarea',
        'instructions' => __('Enter the client\'s information (e.g., company name, address, contact details).', 'app'),
        'required' => true,
        'wrapper' => array(
            'width' => '50',
        ),
        'rows' => 3,
    ));

    $invoice_due_date_field = array(
        'key' => 'field_invoice_due_date',
        'label' => __('Invoice due date', 'app'),
        'name' => 'invoice_due_date',
        'type' => 'date_picker',
        'instructions' => __('Select the due date of the invoice.', 'app'),
        'required' => true,
        'wrapper' => array(
            'width' => '50',
        ),
    );

    $invoice_notes_field = array(
        'key' => 'field_invoice_notes',
        'label' => __('Notes / Terms', 'app'),
        'name' => 'invoice_notes',
        'type' => 'textarea',
        'rows' => 3,
        'wrapper' => array(
            'width' => '100',
        ),
        'instructions' => __('Add any additional notes, payment terms, or instructions for the client.', 'app'),
        'required' => false,
    );

    $invoice_data_fields = array(
        $invoice_logo_field,
        $invoice_number_field,
        $invoice_sender_field,
        $invoice_issue_date_field,
        $invoice_client_field,
        $invoice_due_date_field,
        $invoice_notes_field,
    );

    $invoice_data_group = array(
        'key' => 'mody_invoice_data',
        'title' => __('Invoice Data', 'app'),
        'fields' => $invoice_data_fields,
    );
    return acf_add_local_field_group(array_merge($field_default_values, $invoice_data_group));
}

function invoice_item_groups_fields(array $field_default_values): bool {
    if (!function_exists('acf_add_local_field_group')) {
        return false;
    }

    $invoice_items_fields = array(
        array(
            'key' => 'field_invoice_items_repeater',
            'label' => __('Items', 'app'),
            'name' => 'invoice_items',
            'type' => 'flexible_content',
            'instructions' => __('Add the products or services included in this invoice.', 'app'),
            'required' => true,
            'button_label' => __('Add item', 'app'),
            'layouts' => array(
                array(
                    'key' => 'layout_invoice_item',
                    'name' => 'invoice_item',
                    'label' => __('Invoice Item', 'app'),
                    'display' => 'block',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_invoice_item_description',
                            'label' => __('Description', 'app'),
                            'name' => 'description',
                            'type' => 'text',
                            'required' => true,
                            'wrapper' => array(
                                'width' => '30',
                            ),
                        ),
                        array(
                            'key' => 'field_invoice_item_quantity',
                            'label' => __('Quantity', 'app'),
                            'name' => 'quantity',
                            'type' => 'number',
                            'required' => true,
                            'wrapper' => array(
                                'width' => '30',
                            )
                        ),
                        array(
                            'key' => 'field_invoice_item_taxable',
                            'label' => __('Taxable', 'app'),
                            'name' => 'taxable',
                            'type' => 'true_false',
                            'wrapper' => array(
                                'width' => '10',
                            ),
                            'ui' => true,
                            'ui_on_text' => __('Yes', 'app'),
                            'ui_off_text' => __('No', 'app'),
                        ),
                        array(
                            'key' => 'field_invoice_item_price',
                            'label' => __('Price', 'app'),
                            'name' => 'price',
                            'type' => 'number',
                            'required' => true,
                            'wrapper' => array(
                                'width' => '30',
                            )
                        ),
                    ),
                ),
            ),
        ),
    );

    $invoice_items_group = array(
        'key' => 'mody_invoice_items',
        'title' => __('Invoice Items', 'app'),
        'fields' => $invoice_items_fields,
        'style' => 'seamless'
    );
    return acf_add_local_field_group(array_merge($field_default_values, $invoice_items_group));
}

function invoice_status_group_fields(array $field_default_values): bool {
    if (!function_exists('acf_add_local_field_group')) {
        return false;
    }

    $invoice_status_field = array(
        'key' => 'field_invoice_status',
        'label' => __('Invoice Status', 'app'),
        'name' => 'invoice_status',
        'type' => 'taxonomy',
        'taxonomy' => INVOICE_POST_STATUS_NAME,
        'field_type' => 'select',
        'allow_null' => true,
        'load_save_terms' => true,
        'instructions' => __('Select the current status of the invoice.', 'app'),
        'required' => true,
        'return_format' => 'id',
        'add_term' => false,
    );

    $sidebar_status_group = array(
        'key' => 'mody_invoice_sidebar_status',
        'title' => __('Invoice Status', 'app'),
        'fields' => array(
            $invoice_status_field
        ),
        'position' => 'side',
        'hide_on_screen' => array('invoice-status'),
    );
    return acf_add_local_field_group(array_merge($field_default_values, $sidebar_status_group));
}

function invoice_sidebar_total_group_fields(array $field_default_values): bool {
    if (!function_exists('acf_add_local_field_group')) {
        return false;
    }

    $invoice_total_fields = array(
        array(
            'key' => 'field_invoice_subtotal',
            'label' => __('Subtotal', 'app'),
            'name' => 'invoice_subtotal',
            'type' => 'number',
            'readonly' => true,
            'instructions' => __('The subtotal of all items.', 'app'),
        ),
        array(
            'key' => 'field_invoice_tax',
            'label' => __('Tax', 'app'),
            'name' => 'invoice_tax',
            'type' => 'number',
            'readonly' => true,
            'instructions' => __('The tax amount.', 'app'),
        ),
        array(
            'key' => 'field_invoice_total',
            'label' => __('Total', 'app'),
            'name' => 'invoice_total',
            'type' => 'number',
            'readonly' => true,
            'instructions' => __('The total amount due.', 'app'),
        ),
    );

    $sidebar_totals_group = array(
        'key' => 'mody_invoice_sidebar_totals',
        'title' => __('Invoice Totals', 'app'),
        'fields' => $invoice_total_fields,
        'position' => 'side',
    );

    return acf_add_local_field_group(array_merge($field_default_values, $sidebar_totals_group));
}

function status_group_fields(array $field_status_default_values): bool {
    if (!function_exists('acf_add_local_field_group')) {
        return false;
    }

    $status_color_field = array(
        'key' => 'field_status_color',
        'label' => __('Status Color', 'app'),
        'name' => 'status_color',
        'type' => 'color_picker',
        'instructions' => __('Select a color to represent this status.', 'app'),
        'required' => false,
    );

    $status_fields = array(
        $status_color_field,
    );

    $status_group = array(
        'key' => 'mody_invoice_status',
        'title' => __('Status Details', 'app'),
        'fields' => $status_fields,
    );

    return acf_add_local_field_group(array_merge($field_status_default_values, $status_group));
}