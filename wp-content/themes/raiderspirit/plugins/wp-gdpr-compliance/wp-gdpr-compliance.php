<?php
/* WP GDPR Compliance support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'raiderspirit_wp_gdpr_compliance_feed_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'raiderspirit_wp_gdpr_compliance_theme_setup9', 9 );
	function raiderspirit_wp_gdpr_compliance_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'raiderspirit_filter_tgmpa_required_plugins', 'raiderspirit_wp_gdpr_compliance_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'raiderspirit_wp_gdpr_compliance_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('raiderspirit_filter_tgmpa_required_plugins',	'raiderspirit_wp_gdpr_compliance_tgmpa_required_plugins');
	function raiderspirit_wp_gdpr_compliance_tgmpa_required_plugins( $list = array() ) {
		if ( raiderspirit_storage_isset( 'required_plugins', 'wp-gdpr-compliance' ) ) {
			$list[] = array(
				'name'     => raiderspirit_storage_get_array( 'required_plugins', 'wp-gdpr-compliance' ),
				'slug'     => 'wp-gdpr-compliance',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'raiderspirit_exists_wp_gdpr_compliance' ) ) {
	function raiderspirit_exists_wp_gdpr_compliance() {
		return class_exists( 'WPGDPRC\WPGDPRC' );
	}
}
