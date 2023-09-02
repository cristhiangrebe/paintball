<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0.10
 */


// Socials
if ( raiderspirit_is_on(raiderspirit_get_theme_option('socials_in_footer')) && ($raiderspirit_output = raiderspirit_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php raiderspirit_show_layout($raiderspirit_output); ?>
		</div>
	</div>
	<?php
}
?>