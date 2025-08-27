<?php

namespace Mody\Invoice\CPT;

use const Mody\Invoice\INVOICE_POST_STATUS_NAME;
use const Mody\Invoice\INVOICE_POST_TYPE_NAME;

add_action( 'init', __NAMESPACE__ . '\init' );

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