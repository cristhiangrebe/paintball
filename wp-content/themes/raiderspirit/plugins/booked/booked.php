<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('raiderspirit_booked_theme_setup9')) {
	add_action( 'after_setup_theme', 'raiderspirit_booked_theme_setup9', 9 );
	function raiderspirit_booked_theme_setup9() {
		add_filter( 'raiderspirit_filter_merge_styles', 						'raiderspirit_booked_merge_styles' );
		if (is_admin()) {
			add_filter( 'raiderspirit_filter_tgmpa_required_plugins',		'raiderspirit_booked_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'raiderspirit_booked_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('raiderspirit_filter_tgmpa_required_plugins',	'raiderspirit_booked_tgmpa_required_plugins');
	function raiderspirit_booked_tgmpa_required_plugins($list=array()) {
		if (raiderspirit_storage_isset('required_plugins', 'booked')) {
			$path = raiderspirit_get_file_dir('plugins/booked/booked.zip');
			if (!empty($path) || raiderspirit_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> raiderspirit_storage_get_array('required_plugins', 'booked'),
					'slug' 		=> 'booked',
					'version'	=> '2.2.5',
					'source' 	=> !empty($path) ? $path : 'upload://booked.zip',
					'required' 	=> false
				);
			}
			$path = raiderspirit_get_file_dir('plugins/booked/booked-woocommerce-payments.zip');
			if (!empty($path) || raiderspirit_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> esc_html__('Booked Payments with WooCommerce', 'raiderspirit'),
					'slug' 		=> 'booked-woocommerce-payments',
					'source' 	=> !empty($path) ? $path : 'upload://booked-woocommerce-payments.zip',
					'required' 	=> false
				);
			}
			$path = raiderspirit_get_file_dir('plugins/booked/booked-calendar-feeds.zip');
			if (!empty($path) || raiderspirit_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> esc_html__('Booked Calendar Feeds', 'raiderspirit'),
					'slug' 		=> 'booked-calendar-feeds',
					'source' 	=> !empty($path) ? $path : 'upload://booked-calendar-feeds.zip',
					'required' 	=> false
				);
			}
			$path = raiderspirit_get_file_dir('plugins/booked/booked-frontend-agents.zip');
			if (!empty($path) || raiderspirit_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> esc_html__('Booked Front-End Agents', 'raiderspirit'),
					'slug' 		=> 'booked-frontend-agents',
					'source' 	=> !empty($path) ? $path : 'upload://booked-frontend-agents.zip',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'raiderspirit_exists_booked' ) ) {
	function raiderspirit_exists_booked() {
		return class_exists('booked_plugin');
	}
}
	
// Merge custom styles
if ( !function_exists( 'raiderspirit_booked_merge_styles' ) ) {
	//Handler of the add_filter('raiderspirit_filter_merge_styles', 'raiderspirit_booked_merge_styles');
	function raiderspirit_booked_merge_styles($list) {
		if (raiderspirit_exists_booked()) {
			$list[] = 'plugins/booked/_booked.scss';
		}
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (raiderspirit_exists_booked()) { require_once RAIDERSPIRIT_THEME_DIR . 'plugins/booked/booked-styles.php'; }
?>