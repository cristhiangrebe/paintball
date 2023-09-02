<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('raiderspirit_revslider_theme_setup9')) {
	add_action( 'after_setup_theme', 'raiderspirit_revslider_theme_setup9', 9 );
	function raiderspirit_revslider_theme_setup9() {

		add_filter( 'raiderspirit_filter_merge_styles',				'raiderspirit_revslider_merge_styles' );
		
		if (is_admin()) {
			add_filter( 'raiderspirit_filter_tgmpa_required_plugins','raiderspirit_revslider_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'raiderspirit_revslider_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('raiderspirit_filter_tgmpa_required_plugins',	'raiderspirit_revslider_tgmpa_required_plugins');
	function raiderspirit_revslider_tgmpa_required_plugins($list=array()) {
		if (raiderspirit_storage_isset('required_plugins', 'revslider')) {
			$path = raiderspirit_get_file_dir('plugins/revslider/revslider.zip');
			if (!empty($path) || raiderspirit_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> raiderspirit_storage_get_array('required_plugins', 'revslider'),
					'slug' 		=> 'revslider',
					'version'	=> '6.1.1',
					'source'	=> !empty($path) ? $path : 'upload://revslider.zip',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'raiderspirit_exists_revslider' ) ) {
	function raiderspirit_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}
	
// Merge custom styles
if ( !function_exists( 'raiderspirit_revslider_merge_styles' ) ) {
	//Handler of the add_filter('raiderspirit_filter_merge_styles', 'raiderspirit_revslider_merge_styles');
	function raiderspirit_revslider_merge_styles($list) {
		if (raiderspirit_exists_revslider()) {
			$list[] = 'plugins/revslider/_revslider.scss';
		}
		return $list;
	}
}
?>