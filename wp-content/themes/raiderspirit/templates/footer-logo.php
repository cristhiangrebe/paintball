<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0.10
 */

// Logo
if (raiderspirit_is_on(raiderspirit_get_theme_option('logo_in_footer'))) {
	$raiderspirit_logo_image = '';
	if (raiderspirit_is_on(raiderspirit_get_theme_option('logo_retina_enabled')) && raiderspirit_get_retina_multiplier(2) > 1)
		$raiderspirit_logo_image = raiderspirit_get_theme_option( 'logo_footer_retina' );
	if (empty($raiderspirit_logo_image)) 
		$raiderspirit_logo_image = raiderspirit_get_theme_option( 'logo_footer' );
	$raiderspirit_logo_text   = get_bloginfo( 'name' );
	if (!empty($raiderspirit_logo_image) || !empty($raiderspirit_logo_text)) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if (!empty($raiderspirit_logo_image)) {
					$raiderspirit_attr = raiderspirit_getimagesize($raiderspirit_logo_image);
					echo '<a href="'.esc_url(home_url('/')).'"><img src="'.esc_url($raiderspirit_logo_image).'" class="logo_footer_image" alt="' .  esc_attr__('Icon', 'raiderspirit') . '"'.(!empty($raiderspirit_attr[3]) ? ' ' . wp_kses_data($raiderspirit_attr[3]) : '').'></a>' ;
				} else if (!empty($raiderspirit_logo_text)) {
					echo '<h1 class="logo_footer_text"><a href="'.esc_url(home_url('/')).'">' . esc_html($raiderspirit_logo_text) . '</a></h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
?>