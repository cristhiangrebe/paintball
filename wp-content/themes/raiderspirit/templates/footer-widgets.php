<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0.10
 */

// Footer sidebar
$raiderspirit_footer_name = raiderspirit_get_theme_option('footer_widgets');
$raiderspirit_footer_present = !raiderspirit_is_off($raiderspirit_footer_name) && is_active_sidebar($raiderspirit_footer_name);
if ($raiderspirit_footer_present) { 
	raiderspirit_storage_set('current_sidebar', 'footer');
	$raiderspirit_footer_wide = raiderspirit_get_theme_option('footer_wide');
	ob_start();
	if ( is_active_sidebar($raiderspirit_footer_name) ) {
		dynamic_sidebar($raiderspirit_footer_name);
	}
	$raiderspirit_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($raiderspirit_out)) {
		$raiderspirit_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $raiderspirit_out);
		$raiderspirit_need_columns = true;
		if ($raiderspirit_need_columns) {
			$raiderspirit_columns = max(0, (int) raiderspirit_get_theme_option('footer_columns'));
			if ($raiderspirit_columns == 0) $raiderspirit_columns = min(4, max(1, substr_count($raiderspirit_out, '<aside ')));
			if ($raiderspirit_columns > 1)
				$raiderspirit_out = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($raiderspirit_columns).' widget', $raiderspirit_out);
			else
				$raiderspirit_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($raiderspirit_footer_wide) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php 
				if (!$raiderspirit_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($raiderspirit_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'raiderspirit_action_before_sidebar' );
				raiderspirit_show_layout($raiderspirit_out);
				do_action( 'raiderspirit_action_after_sidebar' );
				if ($raiderspirit_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$raiderspirit_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>