<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0
 */

						// Widgets area inside page content
						raiderspirit_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					raiderspirit_create_widgets_area('widgets_below_page');

					$raiderspirit_body_style = raiderspirit_get_theme_option('body_style');
					if ($raiderspirit_body_style != 'fullscreen') {
						?></div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$raiderspirit_footer_type = raiderspirit_get_theme_option("footer_type");
			if ($raiderspirit_footer_type == 'custom' && !raiderspirit_is_layouts_available())
				$raiderspirit_footer_type = 'default';
			get_template_part( "templates/footer-{$raiderspirit_footer_type}");
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php if (raiderspirit_is_on(raiderspirit_get_theme_option('debug_mode')) && raiderspirit_get_file_dir('images/makeup.jpg')!='') { ?>
		<img src="<?php echo esc_url(raiderspirit_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>