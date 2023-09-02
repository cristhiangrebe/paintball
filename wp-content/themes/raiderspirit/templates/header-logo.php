<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0
 */

$raiderspirit_args = get_query_var('raiderspirit_logo_args');

// Site logo
$raiderspirit_logo_type   = isset($raiderspirit_args['type']) ? $raiderspirit_args['type'] : '';
$raiderspirit_logo_image  = raiderspirit_get_logo_image($raiderspirit_logo_type);
$raiderspirit_logo_text   = raiderspirit_is_on(raiderspirit_get_theme_option('logo_text')) ? get_bloginfo( 'name' ) : '';
$raiderspirit_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($raiderspirit_logo_image) || !empty($raiderspirit_logo_text)) {
	?><a class="sc_layouts_logo" href="<?php echo is_front_page() ? '#' : esc_url(home_url('/')); ?>"><?php
		if (!empty($raiderspirit_logo_image)) {
			if (empty($raiderspirit_logo_type) && function_exists('the_custom_logo') && (int) $raiderspirit_logo_image > 0) {
				the_custom_logo();
			} else {
				$raiderspirit_attr = raiderspirit_getimagesize($raiderspirit_logo_image);
				echo '<img src="'.esc_url($raiderspirit_logo_image).'" alt="logo"'.(!empty($raiderspirit_attr[3]) ? ' '.wp_kses_data($raiderspirit_attr[3]) : '').'>';
			}
		} else {
			raiderspirit_show_layout(raiderspirit_prepare_macros($raiderspirit_logo_text), '<span class="logo_text">', '</span>');
			raiderspirit_show_layout(raiderspirit_prepare_macros($raiderspirit_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>