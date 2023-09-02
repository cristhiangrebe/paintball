<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0.10
 */

$raiderspirit_footer_id = str_replace('footer-custom-', '', raiderspirit_get_theme_option("footer_style"));
if ((int) $raiderspirit_footer_id == 0) {
	$raiderspirit_footer_id = raiderspirit_get_post_id(array(
												'name' => $raiderspirit_footer_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$raiderspirit_footer_id = apply_filters('raiderspirit_filter_get_translated_layout', $raiderspirit_footer_id);
}
$raiderspirit_footer_meta = get_post_meta($raiderspirit_footer_id, 'trx_addons_options', true);
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr($raiderspirit_footer_id); 
						?> footer_custom_<?php echo esc_attr(sanitize_title(get_the_title($raiderspirit_footer_id))); 
						if (!empty($raiderspirit_footer_meta['margin']) != '') 
							echo ' '.esc_attr(raiderspirit_add_inline_css_class('margin-top: '.raiderspirit_prepare_css_value($raiderspirit_footer_meta['margin']).';'));
						if (!raiderspirit_is_inherit(raiderspirit_get_theme_option('footer_scheme')))
							echo ' scheme_' . esc_attr(raiderspirit_get_theme_option('footer_scheme'));
						?>">
	<?php
    // Custom footer's layout
    do_action('raiderspirit_action_show_layout', $raiderspirit_footer_id);
	?>
</footer><!-- /.footer_wrap -->
