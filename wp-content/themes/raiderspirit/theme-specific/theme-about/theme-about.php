<?php
/**
 * Information about this theme
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0.30
 */


// Redirect to the 'About Theme' page after switch theme
if (!function_exists('raiderspirit_about_after_switch_theme')) {
	add_action('after_switch_theme', 'raiderspirit_about_after_switch_theme', 1000);
	function raiderspirit_about_after_switch_theme() {
		update_option('raiderspirit_about_page', 1);
	}
}
if ( !function_exists('raiderspirit_about_after_setup_theme') ) {
	add_action( 'init', 'raiderspirit_about_after_setup_theme', 1000 );
	function raiderspirit_about_after_setup_theme() {
		if (get_option('raiderspirit_about_page') == 1) {
			update_option('raiderspirit_about_page', 0);
			wp_safe_redirect(admin_url().'themes.php?page=raiderspirit_about');
			exit();
		}
	}
}


// Add 'About Theme' item in the Appearance menu
if (!function_exists('raiderspirit_about_add_menu_items')) {
	add_action( 'admin_menu', 'raiderspirit_about_add_menu_items' );
	function raiderspirit_about_add_menu_items() {
		$theme = wp_get_theme();
		$theme_name = $theme->name . (RAIDERSPIRIT_THEME_FREE ? ' ' . esc_html__('Free', 'raiderspirit') : '');
		add_theme_page(
			// Translators: Add theme name to the page title
			sprintf(esc_html__('About %s', 'raiderspirit'), $theme_name),	//page_title
			// Translators: Add theme name to the menu title
			sprintf(esc_html__('About %s', 'raiderspirit'), $theme_name),	//menu_title
			'manage_options',											//capability
			'raiderspirit_about',											//menu_slug
			'raiderspirit_about_page_builder'								//callback
		);

		if ( raiderspirit_theme_is_active()) {
			// Update skins

            $skins = (array)get_transient( 'raiderspirit_skins_to_update' );
            $skin_count = !empty($skins[0]) ? count( $skins ) : 0;
            

			$menu_label = empty($skins) ? esc_html__('Update skins', 'raiderspirit')
				: sprintf(esc_html__('Update skins %s', 'raiderspirit'),
					"<span class='update-plugins count-$skin_count'><span class='update-count'>" . number_format_i18n($skin_count) . "</span></span>"
				);

			add_theme_page(
			// Translators: Add theme name to the page title
				esc_html__('Update skins', 'raiderspirit'),	//page_title
				// Translators: Add theme name to the menu title
				$menu_label,												//menu_title
				'update_themes',									//capability
				'raiderspirit_update_skins',							//menu_slug
				'raiderspirit_update_skins_page_builder'				//callback

			);
		}
	}
}


// Load page-specific scripts and styles
if (!function_exists('raiderspirit_about_enqueue_scripts')) {
	add_action( 'admin_enqueue_scripts', 'raiderspirit_about_enqueue_scripts' );
	function raiderspirit_about_enqueue_scripts() {
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if (is_object($screen) && $screen->id == 'appearance_page_raiderspirit_about') {
			// Scripts
			wp_enqueue_script( 'jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true );
			
			if (function_exists('raiderspirit_plugins_installer_enqueue_scripts'))
				raiderspirit_plugins_installer_enqueue_scripts();
			
			// Styles
			wp_enqueue_style( 'fontello-style',  raiderspirit_get_file_url('css/font-icons/css/fontello-embedded.css'), array(), null );
			if ( ($fdir = raiderspirit_get_file_url('theme-specific/theme-about/theme-about.css')) != '' )
				wp_enqueue_style( 'raiderspirit-about',  $fdir, array(), null );
		}
	}
}


// Build 'About Theme' page
if (!function_exists('raiderspirit_about_page_builder')) {
	function raiderspirit_about_page_builder() {
		$theme = wp_get_theme();
		?>
		<div class="raiderspirit_about">
			<div class="raiderspirit_about_header">
				<div class="raiderspirit_about_logo"><?php
					$logo = raiderspirit_get_file_url('theme-specific/theme-about/logo.jpg');
					if (empty($logo)) $logo = raiderspirit_get_file_url('screenshot.jpg');
					if (!empty($logo)) {
						?><img src="<?php echo esc_url($logo); ?>"><?php
					}
				?></div>
				
				<?php if (RAIDERSPIRIT_THEME_FREE) { ?>
					<a href="<?php echo esc_url(raiderspirit_storage_get('theme_download_url')); ?>"
										   target="_blank"
										   class="raiderspirit_about_pro_link button button-primary"><?php
											esc_html_e('Get PRO version', 'raiderspirit');
										?></a>
				<?php } ?>
				<h1 class="raiderspirit_about_title"><?php
					// Translators: Add theme name and version to the 'Welcome' message
					echo esc_html(sprintf(__('Welcome to %1$s %2$s v.%3$s', 'raiderspirit'),
								$theme->name,
								RAIDERSPIRIT_THEME_FREE ? __('Free', 'raiderspirit') : '',
								$theme->version
								));
				?></h1>
				<div class="raiderspirit_about_description">
					<?php
					if (RAIDERSPIRIT_THEME_FREE) {
						?><p><?php
							// Translators: Add the download url and the theme name to the message
							echo wp_kses_data(sprintf(__('Now you are using Free version of <a href="%1$s">%2$s Pro Theme</a>.', 'raiderspirit'),
														esc_url(raiderspirit_storage_get('theme_download_url')),
														$theme->name
														)
												);
							// Translators: Add the theme name and supported plugins list to the message
							echo '<br>' . wp_kses_data(sprintf(__('This version is SEO- and Retina-ready. It also has a built-in support for parallax and slider with swipe gestures. %1$s Free is compatible with many popular plugins, such as %2$s', 'raiderspirit'),
														$theme->name,
														raiderspirit_about_get_supported_plugins()
														)
												);
						?></p>
						<p><?php
							// Translators: Add the download url to the message
							echo wp_kses_data(sprintf(__('We hope you have a great acquaintance with our themes. If you are looking for a fully functional website, you can get the <a href="%s">Pro Version here</a>', 'raiderspirit'),
														esc_url(raiderspirit_storage_get('theme_download_url'))
														)
												);
						?></p><?php
					} else {
						?><p><?php
							// Translators: Add the theme name to the message
							echo wp_kses_data(sprintf(__('%s is a Premium WordPress theme. It has a built-in support for parallax, slider with swipe gestures, and is SEO- and Retina-ready', 'raiderspirit'),
														$theme->name
														)
												);
						?></p>
						<p><?php
							// Translators: Add supported plugins list to the message
							echo wp_kses_data(sprintf(__('The Premium Theme is compatible with many popular plugins, such as %s', 'raiderspirit'),
														raiderspirit_about_get_supported_plugins()
														)
												);
						?></p><?php
					}
					?>
				</div>
			</div>
			<div id="raiderspirit_about_tabs" class="raiderspirit_tabs raiderspirit_about_tabs">
				<ul>
					<li><a href="#raiderspirit_about_section_start"><?php esc_html_e('Getting started', 'raiderspirit'); ?></a></li>
					<li><a href="#raiderspirit_about_section_actions"><?php esc_html_e('Recommended actions', 'raiderspirit'); ?></a></li>
					<?php if (RAIDERSPIRIT_THEME_FREE) { ?>
						<li><a href="#raiderspirit_about_section_pro"><?php esc_html_e('Free vs PRO', 'raiderspirit'); ?></a></li>
					<?php } ?>
				</ul>
				<div id="raiderspirit_about_section_start" class="raiderspirit_tabs_section raiderspirit_about_section"><?php

					// Install theme skin ?>
					<div class="raiderspirit_about_block raiderspirit_skin_block"><div class="raiderspirit_about_block_inner">
							<h2 class="raiderspirit_about_block_title">
								<i class="dashicons dashicons-images-alt2"></i>
								<?php esc_html_e('Install Another Theme Skin', 'raiderspirit'); ?>
							</h2>
							<div class="raiderspirit_about_block_description"><?php
								if ( raiderspirit_theme_is_active() ) {
									echo apply_filters( 'raiderspirit_skin_list', '' );
								} else {
									?><h2 class="raiderspirit_about_block_title"><?php
									esc_html_e('Specify the purchase code', 'raiderspirit');
									?></h2>
									<form method="post" id="theme_pro_form">
										<input type="hidden" name="ajax_nonce" value="<?php echo esc_attr(wp_create_nonce(admin_url())); ?>" />
										<input type="text" id="theme_activation_key" value="">
										<button class="raiderspirit_about_block_link button button-primary"><?php esc_html_e('Activate', 'raiderspirit'); ?></button>
									</form>
									<p>
										<?php esc_html_e('Please activate your copy of the theme in order to get access to skin downloading.', 'raiderspirit'); ?>
									</p>
									<?php
								}
								?></div>
						</div></div>
					<?php

					// Install required plugins
					if (!RAIDERSPIRIT_THEME_FREE_WP && !raiderspirit_exists_trx_addons()) {
						?><div class="raiderspirit_about_block"><div class="raiderspirit_about_block_inner">
							<h2 class="raiderspirit_about_block_title">
								<i class="dashicons dashicons-admin-plugins"></i>
								<?php esc_html_e('ThemeREX Addons', 'raiderspirit'); ?>
							</h2>
							<div class="raiderspirit_about_block_description"><?php
								esc_html_e('It is highly recommended that you install the companion plugin "ThemeREX Addons" to have access to the layouts builder, awesome shortcodes, team and testimonials, services and slider, and many other features ...', 'raiderspirit');
							?></div>
							<?php raiderspirit_plugins_installer_get_button_html('trx_addons'); ?>
						</div></div><?php
					}
					
					// Install recommended plugins
					?><div class="raiderspirit_about_block"><div class="raiderspirit_about_block_inner">
						<h2 class="raiderspirit_about_block_title">
							<i class="dashicons dashicons-admin-plugins"></i>
							<?php esc_html_e('Recommended plugins', 'raiderspirit'); ?>
						</h2>
						<div class="raiderspirit_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('Theme %s is compatible with a large number of popular plugins. You can install only those that are going to use in the near future.', 'raiderspirit'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>"
						   class="raiderspirit_about_block_link button button-primary"><?php
							esc_html_e('Install plugins', 'raiderspirit');
						?></a>
					</div></div><?php
					
					// Customizer or Theme Options
					?><div class="raiderspirit_about_block"><div class="raiderspirit_about_block_inner">
						<h2 class="raiderspirit_about_block_title">
							<i class="dashicons dashicons-admin-appearance"></i>
							<?php esc_html_e('Setup Theme options', 'raiderspirit'); ?>
						</h2>
						<div class="raiderspirit_about_block_description"><?php
							esc_html_e('Using the WordPress Customizer you can easily customize every aspect of the theme. If you want to use the standard theme settings page - open Theme Options and follow the same steps there.', 'raiderspirit');
						?></div>
						<a href="<?php echo esc_url(admin_url().'customize.php'); ?>"
						   class="raiderspirit_about_block_link button button-primary"><?php
							esc_html_e('Customizer', 'raiderspirit');
						?></a>
						<?php if (!RAIDERSPIRIT_THEME_FREE) { ?>
							<?php esc_html_e('or', 'raiderspirit'); ?>
							<a href="<?php echo esc_url(admin_url().'themes.php?page=theme_options'); ?>"
							   class="raiderspirit_about_block_link button"><?php
								esc_html_e('Theme Options', 'raiderspirit');
							?></a>
						<?php } ?>
					</div></div><?php
					
					// Documentation
					?><div class="raiderspirit_about_block"><div class="raiderspirit_about_block_inner">
						<h2 class="raiderspirit_about_block_title">
							<i class="dashicons dashicons-book"></i>
							<?php esc_html_e('Read Full Documentation', 'raiderspirit');	?>
						</h2>
						<div class="raiderspirit_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('Need more details? Please check our full online documentation for detailed information on how to use %s.', 'raiderspirit'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(raiderspirit_storage_get('theme_doc_url')); ?>"
						   target="_blank"
						   class="raiderspirit_about_block_link button button-primary"><?php
							esc_html_e('Documentation', 'raiderspirit');
						?></a>
					</div></div><?php
					
					// Video tutorials
					?><div class="raiderspirit_about_block"><div class="raiderspirit_about_block_inner">
						<h2 class="raiderspirit_about_block_title">
							<i class="dashicons dashicons-video-alt2"></i>
							<?php esc_html_e('Video Tutorials', 'raiderspirit');	?>
						</h2>
						<div class="raiderspirit_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('No time for reading documentation? Check out our video tutorials and learn how to customize %s in detail.', 'raiderspirit'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(raiderspirit_storage_get('theme_video_url')); ?>"
						   target="_blank"
						   class="raiderspirit_about_block_link button button-primary"><?php
							esc_html_e('Watch videos', 'raiderspirit');
						?></a>
					</div></div><?php
					
					// Support
					if (!RAIDERSPIRIT_THEME_FREE) {
						?><div class="raiderspirit_about_block"><div class="raiderspirit_about_block_inner">
							<h2 class="raiderspirit_about_block_title">
								<i class="dashicons dashicons-sos"></i>
								<?php esc_html_e('Support', 'raiderspirit'); ?>
							</h2>
							<div class="raiderspirit_about_block_description"><?php
								// Translators: Add the theme name to the message
								echo esc_html(sprintf(__('We want to make sure you have the best experience using %s and that is why we gathered here all the necessary informations for you.', 'raiderspirit'), $theme->name));
							?></div>
							<a href="<?php echo esc_url(raiderspirit_storage_get('theme_support_url')); ?>"
							   target="_blank"
							   class="raiderspirit_about_block_link button button-primary"><?php
								esc_html_e('Support', 'raiderspirit');
							?></a>
						</div></div><?php
					}
					
					// Online Demo
					?><div class="raiderspirit_about_block"><div class="raiderspirit_about_block_inner">
						<h2 class="raiderspirit_about_block_title">
							<i class="dashicons dashicons-images-alt2"></i>
							<?php esc_html_e('On-line demo', 'raiderspirit'); ?>
						</h2>
						<div class="raiderspirit_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('Visit the Demo Version of %s to check out all the features it has', 'raiderspirit'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(raiderspirit_storage_get('theme_demo_url')); ?>"
						   target="_blank"
						   class="raiderspirit_about_block_link button button-primary"><?php
							esc_html_e('View demo', 'raiderspirit');
						?></a>
					</div></div>
					
				</div>



				<div id="raiderspirit_about_section_actions" class="raiderspirit_tabs_section raiderspirit_about_section"><?php
				
					// Install required plugins
					if (!RAIDERSPIRIT_THEME_FREE_WP && !raiderspirit_exists_trx_addons()) {
						?><div class="raiderspirit_about_block"><div class="raiderspirit_about_block_inner">
							<h2 class="raiderspirit_about_block_title">
								<i class="dashicons dashicons-admin-plugins"></i>
								<?php esc_html_e('ThemeREX Addons', 'raiderspirit'); ?>
							</h2>
							<div class="raiderspirit_about_block_description"><?php
								esc_html_e('It is highly recommended that you install the companion plugin "ThemeREX Addons" to have access to the layouts builder, awesome shortcodes, team and testimonials, services and slider, and many other features ...', 'raiderspirit');
							?></div>
							<?php raiderspirit_plugins_installer_get_button_html('trx_addons'); ?>
						</div></div><?php
					}
					
					// Install recommended plugins
					?><div class="raiderspirit_about_block"><div class="raiderspirit_about_block_inner">
						<h2 class="raiderspirit_about_block_title">
							<i class="dashicons dashicons-admin-plugins"></i>
							<?php esc_html_e('Recommended plugins', 'raiderspirit'); ?>
						</h2>
						<div class="raiderspirit_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('Theme %s is compatible with a large number of popular plugins. You can install only those that are going to use in the near future.', 'raiderspirit'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>"
						   class="raiderspirit_about_block_link button button button-primary"><?php
							esc_html_e('Install plugins', 'raiderspirit');
						?></a>
					</div></div><?php
					
					// Customizer or Theme Options
					?><div class="raiderspirit_about_block"><div class="raiderspirit_about_block_inner">
						<h2 class="raiderspirit_about_block_title">
							<i class="dashicons dashicons-admin-appearance"></i>
							<?php esc_html_e('Setup Theme options', 'raiderspirit'); ?>
						</h2>
						<div class="raiderspirit_about_block_description"><?php
							esc_html_e('Using the WordPress Customizer you can easily customize every aspect of the theme. If you want to use the standard theme settings page - open Theme Options and follow the same steps there.', 'raiderspirit');
						?></div>
						<a href="<?php echo esc_url(admin_url().'customize.php'); ?>"
						   target="_blank"
						   class="raiderspirit_about_block_link button button-primary"><?php
							esc_html_e('Customizer', 'raiderspirit');
						?></a>
						<?php esc_html_e('or', 'raiderspirit'); ?>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=theme_options'); ?>"
						   class="raiderspirit_about_block_link button"><?php
							esc_html_e('Theme Options', 'raiderspirit');
						?></a>
					</div></div>
					
				</div>



				<?php if (RAIDERSPIRIT_THEME_FREE) { ?>
					<div id="raiderspirit_about_section_pro" class="raiderspirit_tabs_section raiderspirit_about_section">
						<table class="raiderspirit_about_table" cellpadding="0" cellspacing="0" border="0">
							<thead>
								<tr>
									<td class="raiderspirit_about_table_info">&nbsp;</td>
									<td class="raiderspirit_about_table_check"><?php
										// Translators: Show theme name with suffix 'Free'
										echo esc_html(sprintf(__('%s Free', 'raiderspirit'), $theme->name));
									?></td>
									<td class="raiderspirit_about_table_check"><?php
										// Translators: Show theme name with suffix 'PRO'
										echo esc_html(sprintf(__('%s PRO', 'raiderspirit'), $theme->name));
									?></td>
								</tr>
							</thead>
							<tbody>
	
	
								<?php
								// Responsive layouts
								?>
								<tr>
									<td class="raiderspirit_about_table_info">
										<h2 class="raiderspirit_about_table_info_title">
											<?php esc_html_e('Mobile friendly', 'raiderspirit'); ?>
										</h2>
										<div class="raiderspirit_about_table_info_description"><?php
											esc_html_e('Responsive layout. Looks great on any device.', 'raiderspirit');
										?></div>
									</td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Built-in slider
								?>
								<tr>
									<td class="raiderspirit_about_table_info">
										<h2 class="raiderspirit_about_table_info_title">
											<?php esc_html_e('Built-in posts slider', 'raiderspirit'); ?>
										</h2>
										<div class="raiderspirit_about_table_info_description"><?php
											esc_html_e('Allows you to add beautiful slides using the built-in shortcode/widget "Slider" with swipe gestures support.', 'raiderspirit');
										?></div>
									</td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Revolution slider
								if (raiderspirit_storage_isset('required_plugins', 'revslider')) {
								?>
								<tr>
									<td class="raiderspirit_about_table_info">
										<h2 class="raiderspirit_about_table_info_title">
											<?php esc_html_e('Revolution Slider Compatibility', 'raiderspirit'); ?>
										</h2>
										<div class="raiderspirit_about_table_info_description"><?php
											esc_html_e('Our built-in shortcode/widget "Slider" is able to work not only with posts, but also with slides created  in "Revolution Slider".', 'raiderspirit');
										?></div>
									</td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// SiteOrigin Panels
								if (raiderspirit_storage_isset('required_plugins', 'siteorigin-panels')) {
								?>
								<tr>
									<td class="raiderspirit_about_table_info">
										<h2 class="raiderspirit_about_table_info_title">
											<?php esc_html_e('Free PageBuilder', 'raiderspirit'); ?>
										</h2>
										<div class="raiderspirit_about_table_info_description"><?php
											esc_html_e('Full integration with a nice free page builder "SiteOrigin Panels".', 'raiderspirit');
										?></div>
									</td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<tr>
									<td class="raiderspirit_about_table_info">
										<h2 class="raiderspirit_about_table_info_title">
											<?php esc_html_e('Additional widgets pack', 'raiderspirit'); ?>
										</h2>
										<div class="raiderspirit_about_table_info_description"><?php
											esc_html_e('A number of useful widgets to create beautiful homepages and other sections of your website with SiteOrigin Panels.', 'raiderspirit');
										?></div>
									</td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// WPBakery Page Builder
								?>
								<tr>
									<td class="raiderspirit_about_table_info">
										<h2 class="raiderspirit_about_table_info_title">
											<?php esc_html_e('WPBakery Page Builder', 'raiderspirit'); ?>
										</h2>
										<div class="raiderspirit_about_table_info_description"><?php
											esc_html_e('Full integration with a very popular page builder "WPBakery Page Builder". A number of useful shortcodes and widgets to create beautiful homepages and other sections of your website.', 'raiderspirit');
										?></div>
									</td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<tr>
									<td class="raiderspirit_about_table_info">
										<h2 class="raiderspirit_about_table_info_title">
											<?php esc_html_e('Additional shortcodes pack', 'raiderspirit'); ?>
										</h2>
										<div class="raiderspirit_about_table_info_description"><?php
											esc_html_e('A number of useful shortcodes to create beautiful homepages and other sections of your website with WPBakery Page Builder.', 'raiderspirit');
										?></div>
									</td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Layouts builder
								?>
								<tr>
									<td class="raiderspirit_about_table_info">
										<h2 class="raiderspirit_about_table_info_title">
											<?php esc_html_e('Headers and Footers builder', 'raiderspirit'); ?>
										</h2>
										<div class="raiderspirit_about_table_info_description"><?php
											esc_html_e('Powerful visual builder of headers and footers! No manual code editing - use all the advantages of drag-and-drop technology.', 'raiderspirit');
										?></div>
									</td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// WooCommerce
								if (raiderspirit_storage_isset('required_plugins', 'woocommerce')) {
								?>
								<tr>
									<td class="raiderspirit_about_table_info">
										<h2 class="raiderspirit_about_table_info_title">
											<?php esc_html_e('WooCommerce Compatibility', 'raiderspirit'); ?>
										</h2>
										<div class="raiderspirit_about_table_info_description"><?php
											esc_html_e('Ready for e-commerce. You can build an online store with this theme.', 'raiderspirit');
										?></div>
									</td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// Easy Digital Downloads
								if (raiderspirit_storage_isset('required_plugins', 'easy-digital-downloads')) {
								?>
								<tr>
									<td class="raiderspirit_about_table_info">
										<h2 class="raiderspirit_about_table_info_title">
											<?php esc_html_e('Easy Digital Downloads Compatibility', 'raiderspirit'); ?>
										</h2>
										<div class="raiderspirit_about_table_info_description"><?php
											esc_html_e('Ready for digital e-commerce. You can build an online digital store with this theme.', 'raiderspirit');
										?></div>
									</td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// Other plugins
								?>
								<tr>
									<td class="raiderspirit_about_table_info">
										<h2 class="raiderspirit_about_table_info_title">
											<?php esc_html_e('Many other popular plugins compatibility', 'raiderspirit'); ?>
										</h2>
										<div class="raiderspirit_about_table_info_description"><?php
											esc_html_e('PRO version is compatible (was tested and has built-in support) with many popular plugins.', 'raiderspirit');
										?></div>
									</td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Support
								?>
								<tr>
									<td class="raiderspirit_about_table_info">
										<h2 class="raiderspirit_about_table_info_title">
											<?php esc_html_e('Support', 'raiderspirit'); ?>
										</h2>
										<div class="raiderspirit_about_table_info_description"><?php
											esc_html_e('Our premium support is going to take care of any problems, in case there will be any of course.', 'raiderspirit');
										?></div>
									</td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="raiderspirit_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Get PRO version
								?>
								<tr>
									<td class="raiderspirit_about_table_info">&nbsp;</td>
									<td class="raiderspirit_about_table_check" colspan="2">
										<a href="<?php echo esc_url(raiderspirit_storage_get('theme_download_url')); ?>"
										   target="_blank"
										   class="raiderspirit_about_block_link raiderspirit_about_pro_link button button-primary"><?php
											esc_html_e('Get PRO version', 'raiderspirit');
										?></a>
									</td>
								</tr>
	
							</tbody>
						</table>
					</div>
				<?php } ?>
				
			</div>
		</div>
		<?php
	}
}


// Build 'Update skins' page
if (!function_exists('raiderspirit_update_skins_page_builder')) {
	function raiderspirit_update_skins_page_builder() {
		$skins = get_transient( 'raiderspirit_skins_to_update' );
		?><div class="wrap"><form method="post" id="raiderspirit_skin_update_form">
			<p><input id="upgrade-themes" class="button" type="submit" value="<?php
				esc_html_e('Update Skins', 'raiderspirit');
				?>" name="upgrade"><span class="spinner"></span></p>

			<table class="widefat updates-table" id="update-themes-table">
				<thead>
				<tr>
					<td class="manage-column check-column"><input type="checkbox" id="themes-select-all"></td>
					<td class="manage-column"><label for="themes-select-all"><?php esc_html_e('Select All', 'raiderspirit'); ?></label></td>
				</tr>
				</thead>
				<tbody class="plugins">
				<?php if ( empty($skins) ) {
					?>
					<tr>
						<td class="check-column">
						</td>
						<td class="plugin-title">
							<p><?php
								esc_html_e('Your skins are all up to date.', 'raiderspirit');
								?></p>
						</td>
					</tr>
					<?php
				} else {
					foreach ( $skins as $skin => $value ) {
						$img_href = get_template_directory_uri() . '/includes/skin-installer/img/' . $skin . '.jpg';
						$new_version = RaiderSpirit_Skin_Install::get_instance()->remote_skin_version( $skin );
						?><tr>
						<td class="check-column">
							<input type="checkbox" name="checked[]" value="<?php echo esc_attr($skin);?>">
						</td>
						<td class="plugin-title"><p>
								<img src="<?php echo esc_url($img_href); ?>" width="85" height="64" class="updates-table-screenshot" alt="<?php echo esc_attr($skin);?>">
								<strong><?php echo esc_html($value) ?></strong>
								<?php echo sprintf( esc_html__('Update to %s.', 'raiderspirit'), $new_version ); ?></p>
						</td>
						</tr>
						<?php
					}
				} ?>
				</tbody>

				<tfoot>
				<tr>
					<td class="manage-column check-column"><input type="checkbox" id="themes-select-all-2"></td>
					<td class="manage-column"><label for="themes-select-all-2"><?php
							esc_html_e('Select All', 'raiderspirit');
							?></label></td>
				</tr>
				</tfoot>
			</table>
			<p><input id="upgrade-themes-2" class="button" type="submit" value="<?php
				esc_html_e('Update Skins', 'raiderspirit');
				?>" name="upgrade"><span class="spinner"></span></p>
		</form>
		</div>
		<?php
	}
}


// Utils
//------------------------------------

// Return supported plugin's names
if (!function_exists('raiderspirit_about_get_supported_plugins')) {
	function raiderspirit_about_get_supported_plugins() {
		return '"' . join('", "', array_values(raiderspirit_storage_get('required_plugins'))) . '"';
	}
}

require_once RAIDERSPIRIT_THEME_DIR . 'includes/plugins-installer/plugins-installer.php';
?>