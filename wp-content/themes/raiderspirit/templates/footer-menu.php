<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0.10
 */

// Footer menu
$raiderspirit_menu_footer = raiderspirit_get_nav_menu(array(
											'location' => 'menu_footer',
											'class' => 'sc_layouts_menu sc_layouts_menu_default'
											));
if (!empty($raiderspirit_menu_footer)) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php raiderspirit_show_layout($raiderspirit_menu_footer); ?>
		</div>
	</div>
	<?php
}
?>