<?php

namespace mody\security\hooks;

add_action( 'admin_init', __NAMESPACE__ . '\\remove_core_update_nag' );
add_filter( 'pre_site_transient_update_core', __NAMESPACE__ . '\\disable_core_update_check' );

function remove_core_update_nag() : void {
	remove_action( 'admin_notices', 'update_nag', 3 );
	remove_action( 'network_admin_notices', 'update_nag', 3 );

	if ( ! current_user_can( 'update_core' ) ) {
		remove_action( 'admin_notices', 'update_nag', 3 );
		remove_action( 'network_admin_notices', 'update_nag', 3 );
		remove_action( 'user_admin_notices', 'update_nag', 3 );
	}
}

function disable_core_update_check( $value ) : bool | object {
	if ( isset( $value->last_checked ) && $value->last_checked < time() + DAY_IN_SECONDS * 2 ) {
		$value->response = [];

		return $value;
	}

	return false;
}