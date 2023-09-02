<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'RaiderSpirit_Theme_Updater' ) ) {

	if ( ! class_exists( 'WP_Upgrader_Skin' ) ) {
		include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader-skin.php' );
		include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
		include_once( RAIDERSPIRIT_THEME_DIR . 'includes/skin-installer/class-raiderspirit-upgrader-skin.php' );
	}


	class RaiderSpirit_Skin_Install{

		/**
		 * Updater settings.
		 *
		 * @var array
		 */
		protected $settings = array();

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Init class parameters.
		 *
		 * @since  1.0.0
		 */
		public function __construct() {
			add_filter( 'raiderspirit_skin_list', array( $this, 'return_skin_list' ) );
			add_action( 'admin_post_install_skin', array( $this, 'install_skin' ) );

			// Theme activation  and updates
			add_action('wp_ajax_raiderspirit_activate_theme', array( $this, 'activate_theme' ) );
			add_action('wp_ajax_raiderspirit_update_skin',    array( $this, 'update_skin' ) );
			add_action('raiderspirit_check_theme_updates', array( $this, 'check_theme_updates' ) );

		}


		//-------------------------------------------------------
		//-- Admin activate theme
		//-------------------------------------------------------

		// Activate theme
		function activate_theme() {
			// Init admin url and nonce
			$current_page = raiderspirit_get_value_gp('page');
			if (is_admin() && isset($current_page) && $current_page === 'raiderspirit_about') {
				// If submit form with activation code
				$nonce = raiderspirit_get_value_gp('nonce');
				$code  = raiderspirit_get_value_gp('raiderspirit_activate_theme_code');
				$response = array('status' => 'error', 'message' => esc_attr__('Security code is invalid! ', 'raiderspirit'));

				if ( !empty( $nonce ) ) {
					// Check nonce
					if ( !wp_verify_nonce( $nonce, admin_url('admin-ajax.php') ) ) {
						$response = array(
							'status' => 'error',
							'message' => esc_attr__('Security code is invalid! Theme is not activated!', 'raiderspirit')
						);
					} else if ( empty( $code ) ) {
						$response = array(
							'status' => 'error',
							'message' => esc_attr__('Please, specify the purchase code!', 'raiderspirit')
						);

						// Check code
					} else {
						$theme_info  = raiderspirit_get_theme_info();
						$upgrade_url = sprintf(
							'http://upgrade.themerex.net/upgrade.php?key=%1$s&src=%2$s&theme_slug=%3$s&theme_name=%4$s&action=check',
							urlencode( $code ),
							urlencode( raiderspirit_storage_get('theme_pro_key') ),
							urlencode( $theme_info['theme_slug'] ),
							urlencode( $theme_info['theme_market_name'] )
						);
						$result = raiderspirit_fgc( $upgrade_url );
						if ( substr( $result, 0, 5 ) == 'a:2:{' && substr( $result, -1, 1 ) == '}' ) {
							try {
								$result = raiderspirit_unserialize( $result );
							} catch ( Exception $e ) {
								$result = array(
									'error' => '',
									'data' => -1
								);
							}
							if ( $result['data'] === 1 ) {
								update_option('raiderspirit_theme_activated', true);
								update_option('raiderspirit_theme_code_activation', $code);

								$response = array(
									'status' => 'success',
									'message' => esc_attr__('Congratulations! Your theme is activated successfully.', 'raiderspirit')
								);

							} elseif ( $result['data'] === -1 ) {
								$response = array(
									'status' => 'error',
									'message' => esc_attr__('Bad server answer! Theme is not activated!', 'raiderspirit')
								);
							} else {
								$response = array(
									'status' => 'error',
									'message' => esc_attr__('Your purchase code is invalid! Theme is not activated!', 'raiderspirit')
								);
							}
						}
					}
				}

				echo json_encode($response);
				wp_die();
			}
		}

		public function return_skin_list() {
			$json = $this->get_skin_list( RAIDERSPIRIT_THEME_DIR . 'includes/skin-installer/config.json' );

			if( ! $json || empty( $json['skins'] ) ){
					return;
				}

				$action_url = get_site_url() . '/wp-admin/admin-post.php';
				$first_checked = true;

				$output_html = '<form method="POST" name="skin-installer" enctype="multipart/form-data" id="skin-installer" action="' . $action_url . '">';
				$output_html .= '<div class="raiderspirit_about_block_description">' . esc_html__('Select skins: ', 'raiderspirit') . '</div>';
				$output_html .= '<input name="action" type="hidden" value="install_skin">';
				$output_html .= '<input name="action_nonce" type="hidden" value="' . wp_create_nonce( 'install_skin_nonce' ) . '">';
				$output_html .= '<ul class="skin-list">';

				foreach ( $json['skins'] as $key => $value) {
					$theme = wp_get_theme( $key);

				$theme_is_installed = 'publish' === $theme->get('Status') ? 'disabled': '' ;
				$value = $theme_is_installed ? $value . esc_html__( ' ( Installed )', 'raiderspirit' ) : $value ;
				$checked = '';
				if( $first_checked && 'disabled' !== $theme_is_installed ) {
					$checked = 'checked';
					$first_checked = false;
				}

				$img_href = get_template_directory_uri() . '/includes/skin-installer/img/' . $key . '.jpg';
				$output_html .= sprintf('<li><input type="radio" name="theme_skin" value="%1$s" id="%1$s" %3$s %4$s><label for="%1$s"><img src="%5$s" alt="%2$s">%2$s</label></li>', $key, $value, $checked, $theme_is_installed, $img_href );

			}
			$disabled_button = $first_checked ? 'disabled': '' ;

			$output_html .= '</ul>';
			$output_html .= '<hr>';
			$output_html .= '<button class="button button-primary skin-installer" type="submit" form="skin-installer" ' . $disabled_button . '>' . esc_html__('Install Skin', 'raiderspirit') . '</button>';
			$output_html .= '</form>';

			return $output_html;
		}

		private function get_skin_list( $json_dir ) {

			if ( ! file_exists( $json_dir ) ) {
				wp_die( 'Dos not exist config file.' );

				return false;
			}

			return json_decode( raiderspirit_fgc( $json_dir ), true );
		}

		public function install_skin() {
			$theme_slug = empty( $_POST['theme_skin'] ) ? false :  wp_unslash($_POST['theme_skin']);

			if( ! $theme_slug || ! wp_verify_nonce( $_POST['action_nonce'], 'install_skin_nonce') || !raiderspirit_theme_is_active()){
				return;
			}

			$redirect_url = admin_url().'themes.php?page=raiderspirit_about';
			$theme_info  = raiderspirit_get_theme_info();
			$upgrade_url = sprintf(
				'http://upgrade.themerex.net/upgrade.php?key=%1$s&src=%2$s&theme_slug=%3$s&theme_name=%4$s&skin=%5$s&action=install_skin',
				urlencode( get_option('raiderspirit_theme_code_activation') ),
				urlencode( raiderspirit_storage_get('theme_pro_key') ),
				urlencode( $theme_info['theme_slug'] ),
				urlencode( $theme_info['theme_market_name'] ),
				urlencode( $theme_slug )
			);
			$result = raiderspirit_fgc( $upgrade_url );

			if ( substr( $result, 0, 5 ) == 'a:2:{' && substr( $result, -1, 1 ) == '}' ) {
				try {
					$result = raiderspirit_unserialize( $result );
				} catch ( Exception $e ) {
					$result = array(
						'error' => '',
						'data' => -1
					);
				}

				if ( !empty($result['error']) ) { return; }

				// Save ZIP
				$uploads = wp_upload_dir();
				$zip_dir = $uploads['basedir'] . '/' . $theme_info['theme_slug'] . '.zip';
				$url = $uploads['baseurl'] . '/' . $theme_info['theme_slug'] . '.zip';
				$res = raiderspirit_fpc( $zip_dir , $result['data']);

				if ( empty($res) ) { return; }

				// Install Skin
				$nonce = 'install-theme_' . $theme_slug;
				$upgrader = new Theme_Upgrader( new RaiderSpirit_Upgrader_Skin( compact( 'url', 'nonce' ) ) );

				$install_result = $upgrader->run( array(
					'package' => $url,
					'destination' => get_theme_root(),
					'clear_destination' => false, //Do not overwrite files.
					'clear_working' => true,
					'hook_extra' => array(
						'type' => 'theme',
						'action' => 'install',
					),
				) );

				// Remove downloaded zip
				raiderspirit_fs_delete($zip_dir);

				if( is_wp_error( $install_result ) ){
					$redirect_url = admin_url( 'themes.php' );
				}else{
					switch_theme( $install_result['destination_name'] );
				}

			}

			update_option( 'raiderspirit_about_page', 0 );
			wp_safe_redirect( $redirect_url );
			exit();
		}

		public function update_skin() {
			$theme_slug = empty( $_POST['theme_skin'] ) ? false :  wp_unslash($_POST['theme_skin']);
			$response = array('status' => 'error', 'message' => esc_attr__('Security code is invalid! ', 'raiderspirit'));

			if( ! $theme_slug || ! wp_verify_nonce( $_POST['nonce'], admin_url('admin-ajax.php')) || !raiderspirit_theme_is_active()){
				echo json_encode($response);
				wp_die();
			}

			$theme_info  = raiderspirit_get_theme_info();
			$upgrade_url = sprintf(
				'http://upgrade.themerex.net/upgrade.php?key=%1$s&src=%2$s&theme_slug=%3$s&theme_name=%4$s&skin=%5$s&action=install_skin',
				urlencode( get_option('raiderspirit_theme_code_activation') ),
				urlencode( raiderspirit_storage_get('theme_pro_key') ),
				urlencode( $theme_info['theme_slug'] ),
				urlencode( $theme_info['theme_market_name'] ),
				urlencode( $theme_slug )
			);
			$result = raiderspirit_fgc( $upgrade_url );

			if ( substr( $result, 0, 5 ) == 'a:2:{' && substr( $result, -1, 1 ) == '}' ) {
				try {
					$result = raiderspirit_unserialize( $result );
				} catch ( Exception $e ) {
					$result = array(
						'error' => '',
						'data' => -1
					);
				}

				if ( !empty($result['error']) ) { return; }

				// Save ZIP
				$uploads = wp_upload_dir();
				$zip_dir = $uploads['basedir'] . '/' . $theme_info['theme_slug'] . '.zip';
				$url = $uploads['baseurl'] . '/' . $theme_info['theme_slug'] . '.zip';
				$res = raiderspirit_fpc( $zip_dir , $result['data']);

				if ( empty($res) ) { return; }

				// Install Skin
				$nonce = 'install-theme_' . $theme_slug;
				$upgrader = new Theme_Upgrader( new RaiderSpirit_Upgrader_Skin( compact( 'url', 'nonce' ) ) );

				$install_result = $upgrader->run( array(
					'package' => $url,
					'destination' => get_theme_root(),
					'clear_destination' => true, //Overwrite files.
				) );

				if( is_wp_error( $install_result ) ){
					$response = array(
						'status' => 'success',
						'message' => '<p>'
							. sprintf( esc_attr__('<b>%s</b> update failed. ', 'raiderspirit'), $theme_slug)
							. '</p>'
					);
				} else {

					$update_list = get_transient( 'raiderspirit_skins_to_update' );
					unset( $update_list[ $theme_slug ] );
					set_transient( 'raiderspirit_skins_to_update', $update_list );

					$response = array(
						'status' => 'success',
						'message' => '<p>'
							. sprintf( __('<b>%s</b> updated successfully. ', 'raiderspirit'), $install_result['destination_name'])
							. '</p>'
					);
				}

				// Remove downloaded zip
				raiderspirit_fs_delete($zip_dir);

				echo json_encode($response);
				wp_die();
			}

			exit();
		}

		public function remote_skin_version( $skin ) {
			$theme_info  = raiderspirit_get_theme_info();
			$upgrade_url = sprintf(
				'http://upgrade.themerex.net/upgrade.php?theme_slug=%1$s&skin=%2$s&action=info_skin',
				urlencode( $theme_info['theme_slug'] ),
				urlencode( $skin )
			);
			$result = raiderspirit_fgc( $upgrade_url );
			$version = '0';
			if ( substr( $result, 0, 5 ) == 'a:2:{' && substr( $result, -1, 1 ) == '}' ) {
				try {
					$result = raiderspirit_unserialize($result);
					$version = json_decode( $result['data'] );
					$version = $version->version;
				} catch (Exception $e) {
					$result = array(
						'error' => '',
						'data' => -1
					);
				}
				if (!empty($result['error'])) {
					return 0;
				}
			}
			return $version;
		}

		public function check_theme_updates() {
			$all_skins = $this->get_skin_list( RAIDERSPIRIT_THEME_DIR . 'includes/skin-installer/config.json' );
			$update_list = array();

			if( ! $all_skins || empty( $all_skins['skins'] ) ){
				return;
			}

			foreach ( $all_skins['skins'] as $key => $value) {
				$theme = wp_get_theme( $key );
				$version_remote = $this->remote_skin_version( $key );
				$version_local = $theme->version;
				if ( version_compare( $version_remote, $version_local,'>') ) {
					$update_list[$key] = $value;
				}
			}
			set_transient( 'raiderspirit_skins_to_update', $update_list );
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}
	}

	/**
	 * Returns instanse.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function raiderspirit_skin_install() {
		return RaiderSpirit_Skin_Install::get_instance();
	}
	raiderspirit_skin_install();
}
