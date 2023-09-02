<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0.06
 */

$raiderspirit_header_css = '';
$raiderspirit_header_image = get_header_image();
$raiderspirit_header_video = raiderspirit_get_header_video();
if (!empty($raiderspirit_header_image) && raiderspirit_trx_addons_featured_image_override(is_singular() || raiderspirit_storage_isset('blog_archive') || is_category())) {
	$raiderspirit_header_image = raiderspirit_get_current_mode_image($raiderspirit_header_image);
}

$raiderspirit_header_id = str_replace('header-custom-', '', raiderspirit_get_theme_option("header_style"));
if ((int) $raiderspirit_header_id == 0) {
	$raiderspirit_header_id = raiderspirit_get_post_id(array(
												'name' => $raiderspirit_header_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$raiderspirit_header_id = apply_filters('raiderspirit_filter_get_translated_layout', $raiderspirit_header_id);
}
$raiderspirit_header_meta = get_post_meta($raiderspirit_header_id, 'trx_addons_options', true);

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($raiderspirit_header_id); 
				?> top_panel_custom_<?php echo esc_attr(sanitize_title(get_the_title($raiderspirit_header_id)));
				echo !empty($raiderspirit_header_image) || !empty($raiderspirit_header_video) 
					? ' with_bg_image' 
					: ' without_bg_image';
				if ($raiderspirit_header_video!='') 
					echo ' with_bg_video';
				if ($raiderspirit_header_image!='') 
					echo ' '.esc_attr(raiderspirit_add_inline_css_class('background-image: url('.esc_url($raiderspirit_header_image).');'));
				if (!empty($raiderspirit_header_meta['margin']) != '') 
					echo ' '.esc_attr(raiderspirit_add_inline_css_class('margin-bottom: '.esc_attr(raiderspirit_prepare_css_value($raiderspirit_header_meta['margin'])).';'));
				if (is_single() && has_post_thumbnail()) 
					echo ' with_featured_image';
				if (raiderspirit_is_on(raiderspirit_get_theme_option('header_fullheight'))) 
					echo ' header_fullheight raiderspirit-full-height';
				if (!raiderspirit_is_inherit(raiderspirit_get_theme_option('header_scheme')))
					echo ' scheme_' . esc_attr(raiderspirit_get_theme_option('header_scheme'));
				?>"><?php

	// Background video
	if (!empty($raiderspirit_header_video)) {
		get_template_part( 'templates/header-video' );
	}
		
	// Custom header's layout
	do_action('raiderspirit_action_show_layout', $raiderspirit_header_id);

	// Header widgets area
	get_template_part( 'templates/header-widgets' );
		
?></header>