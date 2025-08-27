<?php

namespace Mody\Invoice\Hooks;

use const Mody\Invoice\INVOICE_POST_STATUS_NAME;
use const Mody\Invoice\INVOICE_POST_TYPE_NAME;

if ( function_exists( 'acf_add_options_page' ) ) {
	add_action( 'acf/init', __NAMESPACE__ . '\acf_init' );
}

function acf_init(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$field_invoice_default_values = array(
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => INVOICE_POST_TYPE_NAME,
				),
			),
		),
		'style'    => 'default',
	);

	invoice_data_group_fields( $field_invoice_default_values );
	invoice_client_group_fields( $field_invoice_default_values );
	invoice_item_groups_fields( $field_invoice_default_values );
	invoice_status_group_fields( $field_invoice_default_values );
	invoice_sidebar_total_group_fields( $field_invoice_default_values );

	$field_status_default_values = array(
		'location' => array(
			array(
				array(
					'param'    => 'taxonomy',
					'operator' => '==',
					'value'    => INVOICE_POST_STATUS_NAME,
				),
			),
		),
		'style'    => 'seamless',
	);

	status_group_fields( $field_status_default_values );
}

function invoice_data_group_fields( array $field_default_values ): bool {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return false;
	}

	$invoice_logo_field = array(
		'key'          => 'field_invoice_logo',
		'label'        => __( 'Company Logo', 'app' ),
		'name'         => 'invoice_logo',
		'type'         => 'image',
		'instructions' => __( 'Upload the company logo to be displayed on the invoice.', 'app' ),
		'required'     => true,
		'wrapper'      => array(
			'width' => '50',
		),
	);

	$invoice_number_field = array(
		'key'          => 'field_invoice_number',
		'label'        => __( 'Invoice Number', 'app' ),
		'name'         => 'invoice_number',
		'type'         => 'text',
		'instructions' => __( 'Enter the invoice number.', 'app' ),
		'required'     => true,
		'wrapper'      => array(
			'width' => '50',
		),
	);

	$invoice_issue_date_field = array(
		'key'          => 'field_invoice_issue_date',
		'label'        => __( 'Invoice issue date', 'app' ),
		'name'         => 'invoice_issue_date',
		'type'         => 'date_picker',
		'instructions' => __( 'Select the date of the invoice.', 'app' ),
		'required'     => true,
		'wrapper'      => array(
			'width' => '50',
		),
	);

	$invoice_due_date_field = array(
		'key'          => 'field_invoice_due_date',
		'label'        => __( 'Invoice due date', 'app' ),
		'name'         => 'invoice_due_date',
		'type'         => 'date_picker',
		'instructions' => __( 'Select the due date of the invoice.', 'app' ),
		'required'     => true,
		'wrapper'      => array(
			'width' => '50',
		),
	);

	$invoice_notes_field = array(
		'key'          => 'field_invoice_notes',
		'label'        => __( 'Notes / Terms', 'app' ),
		'name'         => 'invoice_notes',
		'type'         => 'textarea',
		'rows'         => 3,
		'wrapper'      => array(
			'width' => '100',
		),
		'instructions' => __( 'Add any additional notes, payment terms, or instructions for the client.', 'app' ),
		'required'     => false,
	);

	$invoice_data_fields = array(
		$invoice_logo_field,
		$invoice_number_field,
		$invoice_issue_date_field,
		$invoice_due_date_field,
		$invoice_notes_field,
	);

	$invoice_data_group = array(
		'key'    => 'mody_invoice_data',
		'title'  => __( 'Invoice Data', 'app' ),
		'fields' => $invoice_data_fields,
		'position' => 'acf_after_title',
	);

	return acf_add_local_field_group( array_merge( $field_default_values, $invoice_data_group ) );
}

function invoice_client_group_fields( array $field_default_values ): bool {
	if(!function_exists('acf_add_local_field_group')) {
		return false;
	}

	$invoice_client_fields = array(
		array(
			'key' => 'field_mody_client_type',
			'label' => 'Tipo de cliente',
			'name' => 'mody_client_type',
			'type' => 'select',
			'instructions' => 'Selecciona el tipo de cliente.',
			'required' => 1,
			'choices' => array(
				'natural' => 'Natural',
				'juridico' => 'Jurídico',
			),
			'default_value' => 'natural',
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
		),
		// Campos para Persona Natural
		array(
			'key' => 'field_mody_client_first_name',
			'label' => 'Nombre',
			'name' => 'mody_client_first_name',
			'type' => 'text',
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_mody_client_type',
						'operator' => '==',
						'value' => 'natural',
					),
				),
			),
		),
		array(
			'key' => 'field_mody_client_last_name',
			'label' => 'Apellido',
			'name' => 'mody_client_last_name',
			'type' => 'text',
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_mody_client_type',
						'operator' => '==',
						'value' => 'natural',
					),
				),
			),
		),
		// Campo para Persona Jurídica
		array(
			'key' => 'field_mody_client_business_name',
			'label' => 'Razón Social',
			'name' => 'mody_client_business_name',
			'type' => 'text',
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_mody_client_type',
						'operator' => '==',
						'value' => 'juridico',
					),
				),
			),
		),
		// Campo NIF (común)
		array(
			'key' => 'field_mody_client_nif',
			'label' => 'NIF',
			'name' => 'mody_client_nif',
			'type' => 'text',
		),
		// Campos de Dirección (comunes)
		array(
			'key' => 'field_mody_client_address',
			'label' => 'Dirección',
			'name' => 'mody_client_address',
			'type' => 'text',
		),
		array(
			'key' => 'field_mody_client_city',
			'label' => 'Ciudad',
			'name' => 'mody_client_city',
			'type' => 'text',
		),
		array(
			'key' => 'field_mody_client_state',
			'label' => 'Estado',
			'name' => 'mody_client_state',
			'type' => 'text',
		),
		array(
			'key' => 'field_mody_client_postcode',
			'label' => 'Código Postal',
			'name' => 'mody_client_postcode',
			'type' => 'text',
		),
		array(
			'key' => 'field_mody_client_country',
			'label' => 'País',
			'name' => 'mody_client_country',
			'type' => 'text',
		),
	);
	$invoice_client_group = array(
		'key' => 'group_mody_client_info',
		'title' => 'Client info',
		'fields' => $invoice_client_fields,
	);

	return acf_add_local_field_group( array_merge( $field_default_values, $invoice_client_group ) );
}

function invoice_item_groups_fields( array $field_default_values ): bool {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return false;
	}

	$invoice_items_fields = array(
		array(
			'key'          => 'field_invoice_items_repeater',
			'label'        => __( 'Items', 'app' ),
			'name'         => 'invoice_items',
			'type'         => 'flexible_content',
			'instructions' => __( 'Add the products or services included in this invoice.', 'app' ),
			'required'     => true,
			'button_label' => __( 'Add item', 'app' ),
			'layouts'      => array(
				array(
					'key'        => 'layout_invoice_item',
					'name'       => 'invoice_item',
					'label'      => __( 'Invoice Item', 'app' ),
					'display'    => 'block',
					'sub_fields' => array(
						array(
							'key'      => 'field_invoice_item_description',
							'label'    => __( 'Description', 'app' ),
							'name'     => 'description',
							'type'     => 'text',
							'required' => true,
							'wrapper'  => array(
								'width' => '30',
							),
						),
						array(
							'key'      => 'field_invoice_item_quantity',
							'label'    => __( 'Quantity', 'app' ),
							'name'     => 'quantity',
							'type'     => 'number',
							'required' => true,
							'wrapper'  => array(
								'width' => '30',
							)
						),
						array(
							'key'         => 'field_invoice_item_taxable',
							'label'       => __( 'Taxable', 'app' ),
							'name'        => 'taxable',
							'type'        => 'true_false',
							'wrapper'     => array(
								'width' => '10',
							),
							'ui'          => true,
							'ui_on_text'  => __( 'Yes', 'app' ),
							'ui_off_text' => __( 'No', 'app' ),
						),
						array(
							'key'      => 'field_invoice_item_price',
							'label'    => __( 'Price', 'app' ),
							'name'     => 'price',
							'type'     => 'number',
							'required' => true,
							'wrapper'  => array(
								'width' => '30',
							)
						),
					),
				),
			),
		),
	);

	$invoice_items_group = array(
		'key'    => 'mody_invoice_items',
		'title'  => __( 'Invoice Items', 'app' ),
		'fields' => $invoice_items_fields,
		'style'  => 'seamless'
	);

	return acf_add_local_field_group( array_merge( $field_default_values, $invoice_items_group ) );
}

function invoice_status_group_fields( array $field_default_values ): bool {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return false;
	}

	$invoice_status_field = array(
		'key'             => 'field_invoice_status',
		'label'           => __( 'Invoice Status', 'app' ),
		'name'            => 'invoice_status',
		'type'            => 'taxonomy',
		'taxonomy'        => INVOICE_POST_STATUS_NAME,
		'field_type'      => 'select',
		'allow_null'      => true,
		'load_save_terms' => true,
		'instructions'    => __( 'Select the current status of the invoice.', 'app' ),
		'required'        => true,
		'return_format'   => 'id',
		'add_term'        => false,
	);

	$sidebar_status_group = array(
		'key'            => 'mody_invoice_sidebar_status',
		'title'          => __( 'Invoice Status', 'app' ),
		'fields'         => array(
			$invoice_status_field
		),
		'position'       => 'side',
		'hide_on_screen' => array( 'invoice-status' ),
	);

	return acf_add_local_field_group( array_merge( $field_default_values, $sidebar_status_group ) );
}

function invoice_sidebar_total_group_fields( array $field_default_values ): bool {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return false;
	}

	$invoice_total_fields = array(
		array(
			'key'          => 'field_invoice_subtotal',
			'label'        => __( 'Subtotal', 'app' ),
			'name'         => 'invoice_subtotal',
			'type'         => 'number',
			'readonly'     => true,
			'instructions' => __( 'The subtotal of all items.', 'app' ),
		),
		array(
			'key'          => 'field_invoice_tax',
			'label'        => __( 'Tax', 'app' ),
			'name'         => 'invoice_tax',
			'type'         => 'number',
			'readonly'     => true,
			'instructions' => __( 'The tax amount.', 'app' ),
		),
		array(
			'key'          => 'field_invoice_total',
			'label'        => __( 'Total', 'app' ),
			'name'         => 'invoice_total',
			'type'         => 'number',
			'readonly'     => true,
			'instructions' => __( 'The total amount due.', 'app' ),
		),
	);

	$sidebar_totals_group = array(
		'key'      => 'mody_invoice_sidebar_totals',
		'title'    => __( 'Invoice Totals', 'app' ),
		'fields'   => $invoice_total_fields,
		'position' => 'side',
	);

	return acf_add_local_field_group( array_merge( $field_default_values, $sidebar_totals_group ) );
}

function status_group_fields( array $field_status_default_values ): bool {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return false;
	}

	$status_color_field = array(
		'key'          => 'field_status_color',
		'label'        => __( 'Status Color', 'app' ),
		'name'         => 'status_color',
		'type'         => 'color_picker',
		'instructions' => __( 'Select a color to represent this status.', 'app' ),
		'required'     => false,
	);

	$status_fields = array(
		$status_color_field,
	);

	$status_group = array(
		'key'    => 'mody_invoice_status',
		'title'  => __( 'Status Details', 'app' ),
		'fields' => $status_fields,
	);

	return acf_add_local_field_group( array_merge( $field_status_default_values, $status_group ) );
}