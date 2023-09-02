<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('raiderspirit_essential_grid_theme_setup9')) {
	add_action( 'after_setup_theme', 'raiderspirit_essential_grid_theme_setup9', 9 );
	function raiderspirit_essential_grid_theme_setup9() {
		
		add_filter( 'raiderspirit_filter_merge_styles',						'raiderspirit_essential_grid_merge_styles' );

		if (is_admin()) {
			add_filter( 'raiderspirit_filter_tgmpa_required_plugins',		'raiderspirit_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'raiderspirit_essential_grid_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('raiderspirit_filter_tgmpa_required_plugins',	'raiderspirit_essential_grid_tgmpa_required_plugins');
	function raiderspirit_essential_grid_tgmpa_required_plugins($list=array()) {
		if (raiderspirit_storage_isset('required_plugins', 'essential-grid')) {
			$path = raiderspirit_get_file_dir('plugins/essential-grid/essential-grid.zip');
			if (!empty($path) || raiderspirit_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
						'name' 		=> raiderspirit_storage_get_array('required_plugins', 'essential-grid'),
						'slug' 		=> 'essential-grid',
						'version'	=> '2.3.3',
						'source'	=> !empty($path) ? $path : 'upload://essential-grid.zip',
						'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'raiderspirit_exists_essential_grid' ) ) {
	function raiderspirit_exists_essential_grid() {
		return defined('EG_PLUGIN_PATH');
	}
}
	
// Merge custom styles
if ( !function_exists( 'raiderspirit_essential_grid_merge_styles' ) ) {
	//Handler of the add_filter('raiderspirit_filter_merge_styles', 'raiderspirit_essential_grid_merge_styles');
	function raiderspirit_essential_grid_merge_styles($list) {
		if (raiderspirit_exists_essential_grid()) {
			$list[] = 'plugins/essential-grid/_essential-grid.scss';
		}
		return $list;
	}
}
?>