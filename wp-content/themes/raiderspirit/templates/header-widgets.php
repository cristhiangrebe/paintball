<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0
 */

// Header sidebar
$raiderspirit_header_name = raiderspirit_get_theme_option('header_widgets');
$raiderspirit_header_present = !raiderspirit_is_off($raiderspirit_header_name) && is_active_sidebar($raiderspirit_header_name);
if ($raiderspirit_header_present) { 
	raiderspirit_storage_set('current_sidebar', 'header');
	$raiderspirit_header_wide = raiderspirit_get_theme_option('header_wide');
	ob_start();
	if ( is_active_sidebar($raiderspirit_header_name) ) {
		dynamic_sidebar($raiderspirit_header_name);
	}
	$raiderspirit_widgets_output = ob_get_contents();
	ob_end_clean();
	if (!empty($raiderspirit_widgets_output)) {
		$raiderspirit_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $raiderspirit_widgets_output);
		$raiderspirit_need_columns = strpos($raiderspirit_widgets_output, 'columns_wrap')===false;
		if ($raiderspirit_need_columns) {
			$raiderspirit_columns = max(0, (int) raiderspirit_get_theme_option('header_columns'));
			if ($raiderspirit_columns == 0) $raiderspirit_columns = min(6, max(1, substr_count($raiderspirit_widgets_output, '<aside ')));
			if ($raiderspirit_columns > 1)
				$raiderspirit_widgets_output = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($raiderspirit_columns).' widget', $raiderspirit_widgets_output);
			else
				$raiderspirit_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($raiderspirit_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$raiderspirit_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($raiderspirit_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'raiderspirit_action_before_sidebar' );
				raiderspirit_show_layout($raiderspirit_widgets_output);
				do_action( 'raiderspirit_action_after_sidebar' );
				if ($raiderspirit_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$raiderspirit_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>