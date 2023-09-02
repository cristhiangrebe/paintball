<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0
 */

if (raiderspirit_sidebar_present()) {
	ob_start();
	$raiderspirit_sidebar_name = raiderspirit_get_theme_option('sidebar_widgets');
	raiderspirit_storage_set('current_sidebar', 'sidebar');
	if ( is_active_sidebar($raiderspirit_sidebar_name) ) {
		dynamic_sidebar($raiderspirit_sidebar_name);
	}
	$raiderspirit_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($raiderspirit_out)) {
		$raiderspirit_sidebar_position = raiderspirit_get_theme_option('sidebar_position');
		?>
		<div class="sidebar <?php echo esc_attr($raiderspirit_sidebar_position); ?> widget_area<?php if (!raiderspirit_is_inherit(raiderspirit_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(raiderspirit_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'raiderspirit_action_before_sidebar' );
				raiderspirit_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $raiderspirit_out));
				do_action( 'raiderspirit_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>