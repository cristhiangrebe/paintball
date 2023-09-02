<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0.22
 */

if (!defined("RAIDERSPIRIT_THEME_FREE")) define("RAIDERSPIRIT_THEME_FREE", false);
if (!defined("RAIDERSPIRIT_THEME_FREE_WP")) define("RAIDERSPIRIT_THEME_FREE_WP", false);

// Theme storage
$RAIDERSPIRIT_STORAGE = array(
	// Theme required plugin's slugs
	'required_plugins' => array_merge(

		// List of plugins for both - FREE and PREMIUM versions
		//-----------------------------------------------------
		array(
			// Required plugins
			// DON'T COMMENT OR REMOVE NEXT LINES!
			'trx_addons'					=> esc_html__('ThemeREX Addons', 'raiderspirit'),

			// Recommended (supported) plugins fot both (lite and full) versions
			// If plugin not need - comment (or remove) it
			'contact-form-7'				=> esc_html__('Contact Form 7', 'raiderspirit'),
			'woocommerce'					=> esc_html__('WooCommerce', 'raiderspirit')
		),

		// List of plugins for the FREE version only
		//-----------------------------------------------------
		RAIDERSPIRIT_THEME_FREE 
			? array() : array(
					// Recommended (supported) plugins for the PRO (full) version
					// If plugin not need - comment (or remove) it
					'booked'					=> esc_html__('Booked Appointments', 'raiderspirit'),
					'essential-grid'			=> esc_html__('Essential Grid', 'raiderspirit'),
					'revslider'					=> esc_html__('Revolution Slider', 'raiderspirit'),
                    'wp-gdpr-compliance'		=> esc_html__('WP GDPR Compliance', 'raiderspirit'),
					'js_composer'				=> esc_html__('WPBakery Page Builder', 'raiderspirit'),
					'vc-extensions-bundle'		=> esc_html__('WPBakery Page Builder extensions bundle', 'raiderspirit'),
					)
	),

	// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
	'theme_pro_key'		=> 'env-themerex',

	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url'	=> 'http://raider-spirit.themerex.net',
	'theme_doc_url'		=> 'http://raider-spirit.themerex.net/doc',
	'theme_download_url'=> 'https://themeforest.net/item/raider-spirit-airsoft-club-paintball-wordpress-theme/22711235',

	'theme_support_url'	=> 'http://themerex.ticksy.com',								// ThemeREX

	'theme_video_url'	=> 'https://www.youtube.com/channel/UCnFisBimrK2aIE-hnY70kCA',	// ThemeREX

	// Responsive resolutions
	// Parameters to create css media query: min, max, 
	'responsive' => array(
						// By device
						'desktop'	=> array('min' => 1680),
						'notebook'	=> array('min' => 1280, 'max' => 1679),
						'tablet'	=> array('min' =>  768, 'max' => 1279),
						'mobile'	=> array('max' =>  767),
						// By size
						'xxl'		=> array('max' => 1679),
						'xl'		=> array('max' => 1439),
						'lg'		=> array('max' => 1279),
						'md'		=> array('max' => 1023),
						'sm'		=> array('max' =>  767),
						'sm_wp'		=> array('max' =>  600),
						'xs'		=> array('max' =>  479)
						)
);

// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( !function_exists('raiderspirit_customizer_theme_setup1') ) {
	add_action( 'after_setup_theme', 'raiderspirit_customizer_theme_setup1', 1 );
	function raiderspirit_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		raiderspirit_storage_set('settings', array(
			
			'duplicate_options'		=> 'child',		// none  - use separate options for the main and the child-theme
													// child - duplicate theme options from the main theme to the child-theme only
													// both  - sinchronize changes in the theme options between main and child themes

			'customize_refresh'		=> 'auto',		// Refresh method for preview area in the Appearance - Customize:
													// auto - refresh preview area on change each field with Theme Options
													// manual - refresh only obn press button 'Refresh' at the top of Customize frame

			'max_load_fonts'		=> 5,			// Max fonts number to load from Google fonts or from uploaded fonts

			'comment_maxlength'		=> 1000,		// Max length of the message from contact form

			'comment_after_name'	=> true,		// Place 'comment' field before the 'name' and 'email'

			'socials_type'			=> 'icons',		// Type of socials:
													// icons - use font icons to present social networks
													// images - use images from theme's folder trx_addons/css/icons.png

			'icons_type'			=> 'icons',		// Type of other icons:
													// icons - use font icons to present icons
													// images - use images from theme's folder trx_addons/css/icons.png

			'icons_selector'		=> 'internal',	// Icons selector in the shortcodes:
													// vc (default) - standard VC icons selector (very slow and don't support images)
													// internal - internal popup with plugin's or theme's icons list (fast)
			'check_min_version'		=> true,		// Check if exists a .min version of .css and .js and return path to it
													// instead the path to the original file
													// (if debug_mode is off and modification time of the original file < time of the .min file)
			'autoselect_menu'		=> false,		// Show any menu if no menu selected in the location 'main_menu'
													// (for example, the theme is just activated)
			'disable_jquery_ui'		=> false,		// Prevent loading custom jQuery UI libraries in the third-party plugins
		
			'use_mediaelements'		=> true,		// Load script "Media Elements" to play video and audio
			
			'tgmpa_upload'			=> false,		// Allow upload not pre-packaged plugins via TGMPA
			
			'allow_no_image'		=> false		// Allow use image placeholder if no image present in the blog, related posts, post navigation, etc.
		));


		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------
		
		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// For example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		raiderspirit_storage_set('load_fonts', array(
			// Google font
			array(
				'name'	 => 'Monda',
				'family' => 'sans-serif',
				'styles' => '400,700'		// Parameter 'style' used only for the Google fonts
				),
			array(
				'name'	 => 'Roboto Condensed',
				'family' => 'sans-serif',
				'styles' => '300,400,700'		// Parameter 'style' used only for the Google fonts
			)
		));
		
		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		raiderspirit_storage_set('load_fonts_subset', 'latin,latin-ext');
		
		// Settings of the main tags
		// Attention! Font name in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!

		raiderspirit_storage_set('theme_fonts', array(
			'p' => array(
				'title'				=> esc_html__('Main text', 'raiderspirit'),
				'description'		=> esc_html__('Font settings of the main text of the site. Attention! For correct display of the site on mobile devices, use only units "rem", "em" or "ex"', 'raiderspirit'),
				'font-family'		=> '"Monda",sans-serif',
				'font-size' 		=> '1rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.438em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '',
				'margin-top'		=> '0em',
				'margin-bottom'		=> '1.4em'
				),
			'h1' => array(
				'title'				=> esc_html__('Heading 1', 'raiderspirit'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '3rem',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '3.218rem',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '2.0417em',
				'margin-bottom'		=> '0.74em'
				),
			'h2' => array(
				'title'				=> esc_html__('Heading 2', 'raiderspirit'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '2.25rem',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '2.538rem',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '2.5952em',
				'margin-bottom'		=> '0.7619em'
				),
			'h3' => array(
				'title'				=> esc_html__('Heading 3', 'raiderspirit'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '1.875rem',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '2.198rem',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '2.4545em',
				'margin-bottom'		=> '0.71em'
				),
			'h4' => array(
				'title'				=> esc_html__('Heading 4', 'raiderspirit'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '1.5rem',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.805rem',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1.46px',
				'margin-top'		=> '2.78em',
				'margin-bottom'		=> '0.74em'
				),
			'h5' => array(
				'title'				=> esc_html__('Heading 5', 'raiderspirit'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '1.125rem',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.519rem',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '3.1em',
				'margin-bottom'		=> '0.9em'
				),
			'h6' => array(
				'title'				=> esc_html__('Heading 6', 'raiderspirit'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '0.938rem',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.271rem',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0.71px',
				'margin-top'		=> '2.7em',
				'margin-bottom'		=> '0.9412em'
				),
			'logo' => array(
				'title'				=> esc_html__('Logo text', 'raiderspirit'),
				'description'		=> esc_html__('Font settings of the text case of the logo', 'raiderspirit'),
				'font-family'		=> '"Montserrat",sans-serif',
				'font-size' 		=> '1.8em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px'
				),
			'button' => array(
				'title'				=> esc_html__('Buttons', 'raiderspirit'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '15px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5rem',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0'
				),
			'input' => array(
				'title'				=> esc_html__('Input fields', 'raiderspirit'),
				'description'		=> esc_html__('Font settings of the input fields, dropdowns and textareas', 'raiderspirit'),
				'font-family'		=> 'inherit',
				'font-size' 		=> '14px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5rem',	// Attention! Firefox don't allow line-height less then 1.5em in the select
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				),
			'info' => array(
				'title'				=> esc_html__('Post meta', 'raiderspirit'),
				'description'		=> esc_html__('Font settings of the post meta: date, counters, share, etc.', 'raiderspirit'),
				'font-family'		=> 'inherit',
				'font-size' 		=> '14px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '0.4em',
				'margin-bottom'		=> ''
				),
			'menu' => array(
				'title'				=> esc_html__('Main menu', 'raiderspirit'),
				'description'		=> esc_html__('Font settings of the main menu items', 'raiderspirit'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '15px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0.91px'
				),
			'submenu' => array(
				'title'				=> esc_html__('Dropdown menu', 'raiderspirit'),
				'description'		=> esc_html__('Font settings of the dropdown menu items', 'raiderspirit'),
				'font-family'		=> '"Roboto Condensed",sans-serif',
				'font-size' 		=> '15px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0.91px'
				)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		raiderspirit_storage_set('scheme_color_groups', array(
			'main'	=> array(
							'title'			=> esc_html__('Main', 'raiderspirit'),
							'description'	=> esc_html__('Colors of the main content area', 'raiderspirit')
							),
			'alter'	=> array(
							'title'			=> esc_html__('Alter', 'raiderspirit'),
							'description'	=> esc_html__('Colors of the alternative blocks (sidebars, etc.)', 'raiderspirit')
							),
			'extra'	=> array(
							'title'			=> esc_html__('Extra', 'raiderspirit'),
							'description'	=> esc_html__('Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'raiderspirit')
							),
			'inverse' => array(
							'title'			=> esc_html__('Inverse', 'raiderspirit'),
							'description'	=> esc_html__('Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'raiderspirit')
							),
			'input'	=> array(
							'title'			=> esc_html__('Input', 'raiderspirit'),
							'description'	=> esc_html__('Colors of the form fields (text field, textarea, select, etc.)', 'raiderspirit')
							),
			)
		);
		raiderspirit_storage_set('scheme_color_names', array(
			'bg_color'	=> array(
							'title'			=> esc_html__('Background color', 'raiderspirit'),
							'description'	=> esc_html__('Background color of this block in the normal state', 'raiderspirit')
							),
			'bg_hover'	=> array(
							'title'			=> esc_html__('Background hover', 'raiderspirit'),
							'description'	=> esc_html__('Background color of this block in the hovered state', 'raiderspirit')
							),
			'bd_color'	=> array(
							'title'			=> esc_html__('Border color', 'raiderspirit'),
							'description'	=> esc_html__('Border color of this block in the normal state', 'raiderspirit')
							),
			'bd_hover'	=>  array(
							'title'			=> esc_html__('Border hover', 'raiderspirit'),
							'description'	=> esc_html__('Border color of this block in the hovered state', 'raiderspirit')
							),
			'text'		=> array(
							'title'			=> esc_html__('Text', 'raiderspirit'),
							'description'	=> esc_html__('Color of the plain text inside this block', 'raiderspirit')
							),
			'text_dark'	=> array(
							'title'			=> esc_html__('Text dark', 'raiderspirit'),
							'description'	=> esc_html__('Color of the dark text (bold, header, etc.) inside this block', 'raiderspirit')
							),
			'text_light'=> array(
							'title'			=> esc_html__('Text light', 'raiderspirit'),
							'description'	=> esc_html__('Color of the light text (post meta, etc.) inside this block', 'raiderspirit')
							),
			'text_link'	=> array(
							'title'			=> esc_html__('Link', 'raiderspirit'),
							'description'	=> esc_html__('Color of the links inside this block', 'raiderspirit')
							),
			'text_hover'=> array(
							'title'			=> esc_html__('Link hover', 'raiderspirit'),
							'description'	=> esc_html__('Color of the hovered state of links inside this block', 'raiderspirit')
							),
			'text_link2'=> array(
							'title'			=> esc_html__('Link 2', 'raiderspirit'),
							'description'	=> esc_html__('Color of the accented texts (areas) inside this block', 'raiderspirit')
							),
			'text_hover2'=> array(
							'title'			=> esc_html__('Link 2 hover', 'raiderspirit'),
							'description'	=> esc_html__('Color of the hovered state of accented texts (areas) inside this block', 'raiderspirit')
							),
			'text_link3'=> array(
							'title'			=> esc_html__('Link 3', 'raiderspirit'),
							'description'	=> esc_html__('Color of the other accented texts (buttons) inside this block', 'raiderspirit')
							),
			'text_hover3'=> array(
							'title'			=> esc_html__('Link 3 hover', 'raiderspirit'),
							'description'	=> esc_html__('Color of the hovered state of other accented texts (buttons) inside this block', 'raiderspirit')
							)
			)
		);
		raiderspirit_storage_set('schemes', array(
		
			// Color scheme: 'default'
			'default' => array(
				'title'	 => esc_html__('Default', 'raiderspirit'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#ffffff',
					'bd_color'			=> '#f2ede8',  //+
		
					// Text and links colors
					'text'				=> '#86807c',  //+
					'text_light'		=> '#a3978d',  //+
					'text_dark'			=> '#37281c',  //+
					'text_link'			=> '#e5a40f',  //+
					'text_hover'		=> '#37281c',  //+
					'text_link2'		=> '#ebe4de',  //+
					'text_hover2'		=> '#e5a40f',  //+
					'text_link3'		=> '#ddb837',
					'text_hover3'		=> '#eec432',
		
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#f3ede8',  //+
					'alter_bg_hover'	=> '#eceae8',  //+
					'alter_bd_color'	=> '#e5e5e5',
					'alter_bd_hover'	=> '#dadada',
					'alter_text'		=> '#333333',
					'alter_light'		=> '#b7b7b7',
					'alter_dark'		=> '#140b03',  //+
					'alter_link'		=> '#e5a40f',
					'alter_hover'		=> '#e5a40f',
					'alter_link2'		=> '#e5a40f',
					'alter_hover2'		=> '#e5a40f',
					'alter_link3'		=> '#37281c',  //+
					'alter_hover3'		=> '#ddb837',
		
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#251c14',  //+
					'extra_bg_hover'	=> '#ebe4de',  //+
					'extra_bd_color'	=> '#e2dbd4',  //+
					'extra_bd_hover'	=> '#3d3d3d',  //+
					'extra_text'		=> '#bfbfbf',
					'extra_light'		=> '#aaa8a7',  //+
					'extra_dark'		=> '#ffffff',  //+
					'extra_link'		=> '#e5a40f',  //+
					'extra_hover'		=> '#37281c',  //+
					'extra_link2'		=> '#e5a40f',
					'extra_hover2'		=> '#e5a40f',
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',
		
					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#f8f6f4',  //+
					'input_bg_hover'	=> '#f8f6f4',
					'input_bd_color'	=> '#eeeae7',  //+
					'input_bd_hover'	=> '#37281c',  //+
					'input_text'		=> '#37281c',  //+
					'input_light'		=> '#86807c',  //+
					'input_dark'		=> '#37281c',  //+
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#333333',
					'inverse_bd_hover'	=> '#333333',
					'inverse_text'		=> '#1d1d1d',
					'inverse_light'		=> '#333333',
					'inverse_dark'		=> '#000000',
					'inverse_link'		=> '#ffffff',
					'inverse_hover'		=> '#1d1d1d'
				)
			),
		
			// Color scheme: 'dark'
			'dark' => array(
				'title'  => esc_html__('Dark', 'raiderspirit'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#0e0d12',
					'bd_color'			=> '#2e2c33',
		
					// Text and links colors
					'text'				=> '#ffffff',  //+
					'text_light'		=> '#ffffff',  //+
					'text_dark'			=> '#ffffff',
					'text_link'			=> '#37281c',  //+
					'text_hover'		=> '#ffffff',  //+
					'text_link2'		=> '#ebe4de',
					'text_hover2'		=> '#e5a40f',  //+
					'text_link3'		=> '#e5a40f',  //+
					'text_hover3'		=> '#ebe4de',  //+

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#1e1d22',
					'alter_bg_hover'	=> '#333333',
					'alter_bd_color'	=> '#464646',
					'alter_bd_hover'	=> '#4a4a4a',
					'alter_text'		=> '#928e8a',  //+
					'alter_light'		=> '#5f5f5f',
					'alter_dark'		=> '#ffffff',
					'alter_link'		=> '#ffaa5f',
					'alter_hover'		=> '#fe7259',
					'alter_link2'		=> '#8be77c',
					'alter_hover2'		=> '#80d572',
					'alter_link3'		=> '#aaa8a7',  //+
					'alter_hover3'		=> '#ddb837',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#ffffff',
					'extra_bg_hover'	=> '#28272e',
					'extra_bd_color'	=> '#464646',
					'extra_bd_hover'	=> '#4a4a4a',
					'extra_text'		=> '#a6a6a6',
					'extra_light'		=> '#5f5f5f',
					'extra_dark'		=> '#ffffff',
					'extra_link'		=> '#ffaa5f',
					'extra_hover'		=> '#fe7259',
					'extra_link2'		=> '#80d572',
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#2e2d32',
					'input_bg_hover'	=> '#2e2d32',
					'input_bd_color'	=> '#2e2d32',
					'input_bd_hover'	=> '#353535',
					'input_text'		=> '#ffffff',  //+
					'input_light'		=> '#ffffff',  //+
					'input_dark'		=> '#ffffff',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#e36650',
					'inverse_bd_hover'	=> '#cb5b47',
					'inverse_text'		=> '#1d1d1d',
					'inverse_light'		=> '#5f5f5f',
					'inverse_dark'		=> '#000000',
					'inverse_link'		=> '#ffffff',
					'inverse_hover'		=> '#1d1d1d'
				)
			)
		
		));
		
		// Simple schemes substitution
		raiderspirit_storage_set('schemes_simple', array(
			// Main color	// Slave elements and it's darkness koef.
			'text_link'		=> array('alter_hover' => 1,	'extra_link' => 1, 'inverse_bd_color' => 0.85, 'inverse_bd_hover' => 0.7),
			'text_hover'	=> array('alter_link' => 1,		'extra_hover' => 1),
			'text_link2'	=> array('alter_hover2' => 1,	'extra_link2' => 1),
			'text_hover2'	=> array('alter_link2' => 1,	'extra_hover2' => 1),
			'text_link3'	=> array('alter_hover3' => 1,	'extra_link3' => 1),
			'text_hover3'	=> array('alter_link3' => 1,	'extra_hover3' => 1)
		));

		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		raiderspirit_storage_set('scheme_colors_add', array(
			'bg_color_0'		=> array('color' => 'bg_color',			'alpha' => 0),
			'bg_color_02'		=> array('color' => 'bg_color',			'alpha' => 0.2),
			'bg_color_07'		=> array('color' => 'bg_color',			'alpha' => 0.7),
			'bg_color_08'		=> array('color' => 'bg_color',			'alpha' => 0.8),
			'bg_color_09'		=> array('color' => 'bg_color',			'alpha' => 0.9),
			'bg_color_05'		=> array('color' => 'bg_color',			'alpha' => 0.5),
			'alter_bg_color_07'	=> array('color' => 'alter_bg_color',	'alpha' => 0.7),
			'alter_bg_color_04'	=> array('color' => 'alter_bg_color',	'alpha' => 0.4),
			'alter_bg_color_02'	=> array('color' => 'alter_bg_color',	'alpha' => 0.2),
			'alter_bd_color_02'	=> array('color' => 'alter_bd_color',	'alpha' => 0.2),
			'alter_link_02'		=> array('color' => 'alter_link',		'alpha' => 0.2),
			'alter_link_07'		=> array('color' => 'alter_link',		'alpha' => 0.7),
			'extra_bg_color_07'	=> array('color' => 'extra_bg_color',	'alpha' => 0.7),
			'extra_bg_color_01'	=> array('color' => 'extra_bg_color',	'alpha' => 0.1),
			'extra_link_02'		=> array('color' => 'extra_link',		'alpha' => 0.2),
			'extra_link_07'		=> array('color' => 'extra_link',		'alpha' => 0.7),
			'text_dark_07'		=> array('color' => 'text_dark',		'alpha' => 0.7),
			'text_link_02'		=> array('color' => 'text_link',		'alpha' => 0.2),
			'text_link_07'		=> array('color' => 'text_link',		'alpha' => 0.7),
			'alter_dark_04'		=> array('color' => 'alter_dark',		'alpha' => 0.4),
			'inverse_text_07'	=> array('color' => 'inverse_text',		'alpha' => 0.7),
			'text_link_blend'	=> array('color' => 'text_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5),
			'alter_link_blend'	=> array('color' => 'alter_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme specific thumb sizes
		// -----------------------------------------------------------------
		raiderspirit_storage_set('theme_thumbs', apply_filters('raiderspirit_filter_add_thumb_sizes', array(
			'raiderspirit-thumb-huge'		=> array(
												'size'	=> array(1170, 658, true),
												'title' => esc_html__( 'Huge image', 'raiderspirit' ),
												'subst'	=> 'trx_addons-thumb-huge'
												),
			'raiderspirit-thumb-big' 		=> array(
												'size'	=> array( 770, 466, true),
												'title' => esc_html__( 'Large image', 'raiderspirit' ),
												'subst'	=> 'trx_addons-thumb-big'
												),

			'raiderspirit-thumb-med' 		=> array(
												'size'	=> array( 370, 208, true),
												'title' => esc_html__( 'Medium image', 'raiderspirit' ),
												'subst'	=> 'trx_addons-thumb-medium'
												),

			'raiderspirit-thumb-tiny' 		=> array(
												'size'	=> array(  180,  180, true),
												'title' => esc_html__( 'Small square avatar', 'raiderspirit' ),
												'subst'	=> 'trx_addons-thumb-tiny'
												),
				'raiderspirit-thumb-testim' 		=> array(
					'size'	=> array(  140,  140, true),
					'title' => esc_html__( 'Testimonials avatar', 'raiderspirit' ),
					'subst'	=> 'trx_addons-thumb-testim'
				),
				'raiderspirit-thumb-related' 		=> array(
					'size'	=> array(  740,  466, true),
					'title' => esc_html__( 'Related post avatar', 'raiderspirit' ),
					'subst'	=> 'trx_addons-thumb-related'
				),

			'raiderspirit-thumb-masonry-big' => array(
												'size'	=> array( 760,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry Large (scaled)', 'raiderspirit' ),
												'subst'	=> 'trx_addons-thumb-masonry-big'
												),

			'raiderspirit-thumb-masonry'		=> array(
												'size'	=> array( 370,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry (scaled)', 'raiderspirit' ),
												'subst'	=> 'trx_addons-thumb-masonry'
												)
			))
		);
	}
}




//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( !function_exists( 'raiderspirit_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'raiderspirit_importer_set_options', 9 );
	function raiderspirit_importer_set_options($options=array()) {
		if (is_array($options)) {
			// Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Prepare demo data
			$options['demo_url'] = esc_url(raiderspirit_get_protocol() . '://demofiles.themerex.net/raiderspirit/');
			// Required plugins
			$options['required_plugins'] = array_keys(raiderspirit_storage_get('required_plugins'));
			// Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 3;
			// Default demo
			$options['files']['default']['title'] = esc_html__('RaiderSpirit Demo', 'raiderspirit');
			$options['files']['default']['domain_dev'] = 'http://raider-spirit.dv.ancorathemes.com';		// Developers domain
			$options['files']['default']['domain_demo']= 'http://raider-spirit.themerex.net';		// Demo-site domain
			// If theme need more demo - just copy 'default' and change required parameter
			// Banners
			$options['banners'] = array(
				array(
					'image' => raiderspirit_get_file_url('theme-specific/theme-about/images/frontpage.png'),
					'title' => esc_html__('Front Page Builder', 'raiderspirit'),
					'content' => wp_kses_post(__("Create your front page right in the WordPress Customizer. There's no need in WPBakery Page Builder, or any other builder. Simply enable/disable sections, fill them out with content, and customize to your liking.", 'raiderspirit')),
					'link_url' => esc_url('//www.youtube.com/watch?v=VT0AUbMl_KA'),
					'link_caption' => esc_html__('Watch Video Introduction', 'raiderspirit'),
					'duration' => 20
					),
				array(
					'image' => raiderspirit_get_file_url('theme-specific/theme-about/images/layouts.png'),
					'title' => esc_html__('Layouts Builder', 'raiderspirit'),
					'content' => wp_kses_post(__('Use Layouts Bulder to create and customize header and footer styles for your website. With a flexible page builder interface and custom shortcodes, you can create as many header and footer layouts as you want with ease.', 'raiderspirit')),
					'link_url' => esc_url('//www.youtube.com/watch?v=pYhdFVLd7y4'),
					'link_caption' => esc_html__('Learn More', 'raiderspirit'),
					'duration' => 20
					),
				array(
					'image' => raiderspirit_get_file_url('theme-specific/theme-about/images/documentation.png'),
					'title' => esc_html__('Read Full Documentation', 'raiderspirit'),
					'content' => wp_kses_post(__('Need more details? Please check our full online documentation for detailed information on how to use RaiderSpirit.', 'raiderspirit')),
					'link_url' => esc_url(raiderspirit_storage_get('theme_doc_url')),
					'link_caption' => esc_html__('Online Documentation', 'raiderspirit'),
					'duration' => 15
					),
				array(
					'image' => raiderspirit_get_file_url('theme-specific/theme-about/images/video-tutorials.png'),
					'title' => esc_html__('Video Tutorials', 'raiderspirit'),
					'content' => wp_kses_post(__('No time for reading documentation? Check out our video tutorials and learn how to customize RaiderSpirit in detail.', 'raiderspirit')),
					'link_url' => esc_url(raiderspirit_storage_get('theme_video_url')),
					'link_caption' => esc_html__('Video Tutorials', 'raiderspirit'),
					'duration' => 15
					),
				array(
					'image' => raiderspirit_get_file_url('theme-specific/theme-about/images/studio.png'),
					'title' => esc_html__('Website Customization', 'raiderspirit'),
					'content' => wp_kses_post(__("Need a website fast? Order our custom service, and we'll build a website based on this theme for a very fair price. We can also implement additional functionality such as website translation, setting up WPML, and much more.", 'raiderspirit')),
					'link_url' => esc_url('//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themedash'),
					'link_caption' => esc_html__('Contact Us', 'raiderspirit'),
					'duration' => 25
					)
				);
		}
		return $options;
	}
}




// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if (!function_exists('raiderspirit_create_theme_options')) {

	function raiderspirit_create_theme_options() {

		// Message about options override. 
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = __('<b>Attention!</b> Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages', 'raiderspirit');

		raiderspirit_storage_set('options', array(
		
			// 'Logo & Site Identity'
			'title_tagline' => array(
				"title" => esc_html__('Logo & Site Identity', 'raiderspirit'),
				"desc" => '',
				"priority" => 10,
				"type" => "section"
				),
			'logo_info' => array(
				"title" => esc_html__('Logo in the header', 'raiderspirit'),
				"desc" => '',
				"priority" => 20,
				"type" => "info",
				),
			'logo_text' => array(
				"title" => esc_html__('Use Site Name as Logo', 'raiderspirit'),
				"desc" => wp_kses_data( __('Use the site title and tagline as a text logo if no image is selected', 'raiderspirit') ),
				"class" => "raiderspirit_column-1_2 raiderspirit_new_row",
				"priority" => 30,
				"std" => 1,
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_retina_enabled' => array(
				"title" => esc_html__('Allow retina display logo', 'raiderspirit'),
				"desc" => wp_kses_data( __('Show fields to select logo images for Retina display', 'raiderspirit') ),
				"class" => "raiderspirit_column-1_2",
				"priority" => 40,
				"refresh" => false,
				"std" => 0,
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_zoom' => array(
				"title" => esc_html__('Logo zoom', 'raiderspirit'),
				"desc" => wp_kses_data( __("Zoom the logo. 1 - original size. Maximum size of logo depends on the actual size of the picture", 'raiderspirit') ),
				"std" => 1,
				"min" => 0.2,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "slider"
				),
			// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
			'logo_retina' => array(
				"title" => esc_html__('Logo for Retina', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'raiderspirit') ),
				"class" => "raiderspirit_column-1_2",
				"priority" => 70,
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile_header' => array(
				"title" => esc_html__('Logo for the mobile header', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'raiderspirit') ),
				"class" => "raiderspirit_column-1_2 raiderspirit_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_header_retina' => array(
				"title" => esc_html__('Logo for the mobile header for Retina', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'raiderspirit') ),
				"class" => "raiderspirit_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile' => array(
				"title" => esc_html__('Logo mobile', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile menu', 'raiderspirit') ),
				"class" => "raiderspirit_column-1_2 raiderspirit_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_retina' => array(
				"title" => esc_html__('Logo mobile for Retina', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'raiderspirit') ),
				"class" => "raiderspirit_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "image"
				),
			'logo_side' => array(
				"title" => esc_html__('Logo side', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu', 'raiderspirit') ),
				"class" => "raiderspirit_column-1_2 raiderspirit_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_side_retina' => array(
				"title" => esc_html__('Logo side for Retina', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'raiderspirit') ),
				"class" => "raiderspirit_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "image"
				),
			
		
		
			// 'General settings'
			'general' => array(
				"title" => esc_html__('General Settings', 'raiderspirit'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 20,
				"type" => "section",
				),

			'general_layout_info' => array(
				"title" => esc_html__('Layout', 'raiderspirit'),
				"desc" => '',
				"type" => "info",
				),
			'body_style' => array(
				"title" => esc_html__('Body style', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select width of the body content', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'raiderspirit')
				),
				"refresh" => false,
				"std" => 'wide',
				"options" => raiderspirit_get_list_body_styles(),
				"type" => "select"
				),
			'boxed_bg_image' => array(
				"title" => esc_html__('Boxed bg image', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select or upload image, used as background in the boxed body', 'raiderspirit') ),
				"dependency" => array(
					'body_style' => array('boxed')
				),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'raiderspirit')
				),
				"std" => '',
				"hidden" => true,
				"type" => "image"
				),
			'remove_margins' => array(
				"title" => esc_html__('Remove margins', 'raiderspirit'),
				"desc" => wp_kses_data( __('Remove margins above and below the content area', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'raiderspirit')
				),
				"refresh" => false,
				"std" => 0,
				"type" => "checkbox"
				),

			'general_sidebar_info' => array(
				"title" => esc_html__('Sidebar', 'raiderspirit'),
				"desc" => '',
				"type" => "info",
				),
			'sidebar_position' => array(
				"title" => esc_html__('Sidebar position', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select position to show sidebar', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'raiderspirit')
				),
				"std" => 'right',
				"options" => array(),
				"type" => "switch"
				),
			'sidebar_widgets' => array(
				"title" => esc_html__('Sidebar widgets', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'raiderspirit')
				),
				"dependency" => array(
					'sidebar_position' => array('left', 'right')
				),
				"std" => 'sidebar_widgets',
				"options" => array(),
				"type" => "select"
				),
			'expand_content' => array(
				"title" => esc_html__('Expand content', 'raiderspirit'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'raiderspirit') ),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),


			'general_widgets_info' => array(
				"title" => esc_html__('Additional widgets', 'raiderspirit'),
				"desc" => '',
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "info",
				),
			'widgets_above_page' => array(
				"title" => esc_html__('Widgets at the top of the page', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'raiderspirit')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "select"
				),
			'widgets_above_content' => array(
				"title" => esc_html__('Widgets above the content', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'raiderspirit')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_content' => array(
				"title" => esc_html__('Widgets below the content', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'raiderspirit')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_page' => array(
				"title" => esc_html__('Widgets at the bottom of the page', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'raiderspirit')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "select"
				),

			'general_effects_info' => array(
				"title" => esc_html__('Design & Effects', 'raiderspirit'),
				"desc" => '',
				"type" => "info",
				),
			'border_radius' => array(
				"title" => esc_html__('Border radius', 'raiderspirit'),
				"desc" => wp_kses_data( __('Specify the border radius of the form fields and buttons in pixels or other valid CSS units', 'raiderspirit') ),
				"std" => 0,
				"type" => "text"
				),

			'general_misc_info' => array(
				"title" => esc_html__('Miscellaneous', 'raiderspirit'),
				"desc" => '',
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "info",
				),
			'seo_snippets' => array(
				"title" => esc_html__('SEO snippets', 'raiderspirit'),
				"desc" => wp_kses_data( __('Add structured data markup to the single posts and pages', 'raiderspirit') ),
				"std" => 0,
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checkbox"
				),
            'privacy_text' => array(
                "title" => esc_html__("Text with Privacy Policy link", 'raiderspirit'),
                "desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'raiderspirit') ),
                "std"   => wp_kses_post( __( 'I agree that my submitted data is being collected and stored.', 'raiderspirit') ),
                "type"  => "text"
            ),
		
		
			// 'Header'
			'header' => array(
				"title" => esc_html__('Header', 'raiderspirit'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 30,
				"type" => "section"
				),

			'header_style_info' => array(
				"title" => esc_html__('Header style', 'raiderspirit'),
				"desc" => '',
				"type" => "info"
				),
			'header_type' => array(
				"title" => esc_html__('Header style', 'raiderspirit'),
				"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'raiderspirit')
				),
				"std" => 'default',
				"options" => raiderspirit_get_list_header_footer_types(),
				"type" => RAIDERSPIRIT_THEME_FREE || !raiderspirit_exists_trx_addons() ? "hidden" : "switch"
				),
			'header_style' => array(
				"title" => esc_html__('Select custom layout', 'raiderspirit'),
				"desc" => wp_kses_post( __("Select custom header from Layouts Builder", 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'raiderspirit')
				),
				"dependency" => array(
					'header_type' => array('custom')
				),
				"std" => RAIDERSPIRIT_THEME_FREE ? 'header-custom-sow-header-default' : 'header-custom-header-default',
				"options" => array(),
				"type" => "select"
				),
			'header_position' => array(
				"title" => esc_html__('Header position', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select position to display the site header', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'raiderspirit')
				),
				"std" => 'default',
				"options" => array(),
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "switch"
				),
			'header_fullheight' => array(
				"title" => esc_html__('Header fullheight', 'raiderspirit'),
				"desc" => wp_kses_data( __("Enlarge header area to fill whole screen. Used only if header have a background image", 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'raiderspirit')
				),
				"std" => 0,
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_zoom' => array(
				"title" => esc_html__('Header zoom', 'raiderspirit'),
				"desc" => wp_kses_data( __("Zoom the header title. 1 - original size", 'raiderspirit') ),
				"std" => 1,
				"min" => 0.3,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "slider"
				),
			'header_wide' => array(
				"title" => esc_html__('Header fullwidth', 'raiderspirit'),
				"desc" => wp_kses_data( __('Do you want to stretch the header widgets area to the entire window width?', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'raiderspirit')
				),
				"dependency" => array(
					'header_type' => array('default')
				),
				"std" => 1,
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_widgets_info' => array(
				"title" => esc_html__('Header widgets', 'raiderspirit'),
				"desc" => wp_kses_data( __('Here you can place a widget slider, advertising banners, etc.', 'raiderspirit') ),
				"type" => "info"
				),
			'header_widgets' => array(
				"title" => esc_html__('Header widgets', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on each page', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'raiderspirit'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on this page', 'raiderspirit') ),
				),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'header_columns' => array(
				"title" => esc_html__('Header columns', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'raiderspirit')
				),
				"dependency" => array(
					'header_type' => array('default'),
					'header_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => raiderspirit_get_list_range(0,6),
				"type" => "select"
				),

			'menu_info' => array(
				"title" => esc_html__('Main menu', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select main menu style, position, color scheme and other parameters', 'raiderspirit') ),
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "info"
				),
			'menu_style' => array(
				"title" => esc_html__('Menu position', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select position of the main menu', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'raiderspirit')
				),
				"std" => 'top',
				"options" => array(
					'top'	=> esc_html__('Top',	'raiderspirit'),
					'left'	=> esc_html__('Left',	'raiderspirit'),
					'right'	=> esc_html__('Right',	'raiderspirit')
				),
				"type" => RAIDERSPIRIT_THEME_FREE || !raiderspirit_exists_trx_addons() ? "hidden" : "switch"
				),
			'menu_side_stretch' => array(
				"title" => esc_html__('Stretch sidemenu', 'raiderspirit'),
				"desc" => wp_kses_data( __('Stretch sidemenu to window height (if menu items number >= 5)', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'raiderspirit')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 0,
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_side_icons' => array(
				"title" => esc_html__('Iconed sidemenu', 'raiderspirit'),
				"desc" => wp_kses_data( __('Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'raiderspirit')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 1,
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_mobile_fullscreen' => array(
				"title" => esc_html__('Mobile menu fullscreen', 'raiderspirit'),
				"desc" => wp_kses_data( __('Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'raiderspirit') ),
				"std" => 1,
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_image_info' => array(
				"title" => esc_html__('Header image', 'raiderspirit'),
				"desc" => '',
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "info"
				),
			'header_image_override' => array(
				"title" => esc_html__('Header image override', 'raiderspirit'),
				"desc" => wp_kses_data( __("Allow override the header image with the page's/post's/product's/etc. featured image", 'raiderspirit') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'raiderspirit')
				),
				"std" => 0,
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_mobile_info' => array(
				"title" => esc_html__('Mobile header', 'raiderspirit'),
				"desc" => wp_kses_data( __("Configure the mobile version of the header", 'raiderspirit') ),
				"priority" => 500,
				"dependency" => array(
					'header_type' => array('default')
				),
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "info"
				),
			'header_mobile_enabled' => array(
				"title" => esc_html__('Enable the mobile header', 'raiderspirit'),
				"desc" => wp_kses_data( __("Use the mobile version of the header (if checked) or relayout the current header on mobile devices", 'raiderspirit') ),
				"dependency" => array(
					'header_type' => array('default')
				),
				"std" => 0,
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_additional_info' => array(
				"title" => esc_html__('Additional info', 'raiderspirit'),
				"desc" => wp_kses_data( __('Additional info to show at the top of the mobile header', 'raiderspirit') ),
				"std" => '',
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"refresh" => false,
				"teeny" => false,
				"rows" => 20,
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "text_editor"
				),
			'header_mobile_hide_info' => array(
				"title" => esc_html__('Hide additional info', 'raiderspirit'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_logo' => array(
				"title" => esc_html__('Hide logo', 'raiderspirit'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_login' => array(
				"title" => esc_html__('Hide login/logout', 'raiderspirit'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_search' => array(
				"title" => esc_html__('Hide search', 'raiderspirit'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_cart' => array(
				"title" => esc_html__('Hide cart', 'raiderspirit'),
				"std" => 0,
				"dependency" => array(
					'header_type' => array('default'),
					'header_mobile_enabled' => array(1)
				),
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checkbox"
				),


		
			// 'Footer'
			'footer' => array(
				"title" => esc_html__('Footer', 'raiderspirit'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 50,
				"type" => "section"
				),
			'footer_type' => array(
				"title" => esc_html__('Footer style', 'raiderspirit'),
				"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'raiderspirit')
				),
				"std" => 'default',
				"options" => raiderspirit_get_list_header_footer_types(),
				"type" => RAIDERSPIRIT_THEME_FREE || !raiderspirit_exists_trx_addons() ? "hidden" : "switch"
				),
			'footer_style' => array(
				"title" => esc_html__('Select custom layout', 'raiderspirit'),
				"desc" => wp_kses_post( __("Select custom footer from Layouts Builder", 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'raiderspirit')
				),
				"dependency" => array(
					'footer_type' => array('custom')
				),
				"std" => RAIDERSPIRIT_THEME_FREE ? 'footer-custom-sow-footer-default' : 'footer-custom-footer-default',
				"options" => array(),
				"type" => "select"
				),
			'footer_widgets' => array(
				"title" => esc_html__('Footer widgets', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'raiderspirit')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 'footer_widgets',
				"options" => array(),
				"type" => "select"
				),
			'footer_columns' => array(
				"title" => esc_html__('Footer columns', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'raiderspirit')
				),
				"dependency" => array(
					'footer_type' => array('default'),
					'footer_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => raiderspirit_get_list_range(0,6),
				"type" => "select"
				),
			'footer_wide' => array(
				"title" => esc_html__('Footer fullwidth', 'raiderspirit'),
				"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'raiderspirit') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'raiderspirit')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_in_footer' => array(
				"title" => esc_html__('Show logo', 'raiderspirit'),
				"desc" => wp_kses_data( __('Show logo in the footer', 'raiderspirit') ),
				'refresh' => false,
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_footer' => array(
				"title" => esc_html__('Logo for footer', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the footer', 'raiderspirit') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1)
				),
				"std" => '',
				"type" => "image"
				),
			'logo_footer_retina' => array(
				"title" => esc_html__('Logo for footer (Retina)', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'raiderspirit') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1),
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "image"
				),
			'socials_in_footer' => array(
				"title" => esc_html__('Show social icons', 'raiderspirit'),
				"desc" => wp_kses_data( __('Show social icons in the footer (under logo or footer widgets)', 'raiderspirit') ),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => !raiderspirit_exists_trx_addons() ? "hidden" : "checkbox"
				),
			'copyright' => array(
				"title" => esc_html__('Copyright', 'raiderspirit'),
				"desc" => wp_kses_data( __('Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'raiderspirit') ),
				"translate" => true,
				"std" => esc_html__('Copyright &copy; {Y} by ThemeREX. All rights reserved.', 'raiderspirit'),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"refresh" => false,
				"type" => "textarea"
				),
			
		
		
			// 'Blog'
			'blog' => array(
				"title" => esc_html__('Blog', 'raiderspirit'),
				"desc" => wp_kses_data( __('Options of the the blog archive', 'raiderspirit') ),
				"priority" => 70,
				"type" => "panel",
				),
		
				// Blog - Posts page
				'blog_general' => array(
					"title" => esc_html__('Posts page', 'raiderspirit'),
					"desc" => wp_kses_data( __('Style and components of the blog archive', 'raiderspirit') ),
					"type" => "section",
					),
				'blog_general_info' => array(
					"title" => esc_html__('General settings', 'raiderspirit'),
					"desc" => '',
					"type" => "info",
					),
				'blog_style' => array(
					"title" => esc_html__('Blog style', 'raiderspirit'),
					"desc" => '',
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'raiderspirit')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"std" => 'excerpt',
					"options" => array(),
					"type" => "select"
					),
				'first_post_large' => array(
					"title" => esc_html__('First post large', 'raiderspirit'),
					"desc" => wp_kses_data( __('Make your first post stand out by making it bigger', 'raiderspirit') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'raiderspirit')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array('classic', 'masonry')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				"blog_content" => array( 
					"title" => esc_html__('Posts content', 'raiderspirit'),
					"desc" => wp_kses_data( __("Display either post excerpts or the full post content", 'raiderspirit') ),
					"std" => "excerpt",
					"dependency" => array(
						'blog_style' => array('excerpt')
					),
					"options" => array(
						'excerpt'	=> esc_html__('Excerpt',	'raiderspirit'),
						'fullpost'	=> esc_html__('Full post',	'raiderspirit')
					),
					"type" => "switch"
					),
				'excerpt_length' => array(
					"title" => esc_html__('Excerpt length', 'raiderspirit'),
					"desc" => wp_kses_data( __("Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged", 'raiderspirit') ),
					"dependency" => array(
						'blog_style' => array('excerpt'),
						'blog_content' => array('excerpt')
					),
					"std" => 60,
					"type" => "text"
					),
				'blog_columns' => array(
					"title" => esc_html__('Blog columns', 'raiderspirit'),
					"desc" => wp_kses_data( __('How many columns should be used in the blog archive (from 2 to 4)?', 'raiderspirit') ),
					"std" => 2,
					"options" => raiderspirit_get_list_range(2,4),
					"type" => "hidden"
					),
				'post_type' => array(
					"title" => esc_html__('Post type', 'raiderspirit'),
					"desc" => wp_kses_data( __('Select post type to show in the blog archive', 'raiderspirit') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'raiderspirit')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"linked" => 'parent_cat',
					"refresh" => false,
					"hidden" => true,
					"std" => 'post',
					"options" => array(),
					"type" => "select"
					),
				'parent_cat' => array(
					"title" => esc_html__('Category to show', 'raiderspirit'),
					"desc" => wp_kses_data( __('Select category to show in the blog archive', 'raiderspirit') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'raiderspirit')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"refresh" => false,
					"hidden" => true,
					"std" => '0',
					"options" => array(),
					"type" => "select"
					),
				'posts_per_page' => array(
					"title" => esc_html__('Posts per page', 'raiderspirit'),
					"desc" => wp_kses_data( __('How many posts will be displayed on this page', 'raiderspirit') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'raiderspirit')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"hidden" => true,
					"std" => '',
					"type" => "text"
					),
				"blog_pagination" => array( 
					"title" => esc_html__('Pagination style', 'raiderspirit'),
					"desc" => wp_kses_data( __('Show Older/Newest posts or Page numbers below the posts list', 'raiderspirit') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'raiderspirit')
					),
					"std" => "pages",
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"options" => array(
						'pages'	=> esc_html__("Page numbers", 'raiderspirit'),
						'links'	=> esc_html__("Older/Newest", 'raiderspirit'),
						'more'	=> esc_html__("Load more", 'raiderspirit'),
						'infinite' => esc_html__("Infinite scroll", 'raiderspirit')
					),
					"type" => "select"
					),
				'show_filters' => array(
					"title" => esc_html__('Show filters', 'raiderspirit'),
					"desc" => wp_kses_data( __('Show categories as tabs to filter posts', 'raiderspirit') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'raiderspirit')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array('portfolio', 'gallery')
					),
					"hidden" => true,
					"std" => 0,
					"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checkbox"
					),
	
				'blog_sidebar_info' => array(
					"title" => esc_html__('Sidebar', 'raiderspirit'),
					"desc" => '',
					"type" => "info",
					),
				'sidebar_position_blog' => array(
					"title" => esc_html__('Sidebar position', 'raiderspirit'),
					"desc" => wp_kses_data( __('Select position to show sidebar', 'raiderspirit') ),
					"std" => 'right',
					"options" => array(),
					"type" => "switch"
					),
				'sidebar_widgets_blog' => array(
					"title" => esc_html__('Sidebar widgets', 'raiderspirit'),
					"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'raiderspirit') ),
					"dependency" => array(
						'sidebar_position_blog' => array('left', 'right')
					),
					"std" => 'sidebar_widgets',
					"options" => array(),
					"type" => "select"
					),
				'expand_content_blog' => array(
					"title" => esc_html__('Expand content', 'raiderspirit'),
					"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'raiderspirit') ),
					"refresh" => false,
					"std" => 1,
					"type" => "checkbox"
					),
	
	
				'blog_widgets_info' => array(
					"title" => esc_html__('Additional widgets', 'raiderspirit'),
					"desc" => '',
					"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "info",
					),
				'widgets_above_page_blog' => array(
					"title" => esc_html__('Widgets at the top of the page', 'raiderspirit'),
					"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'raiderspirit') ),
					"std" => 'hide',
					"options" => array(),
					"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "select"
					),
				'widgets_above_content_blog' => array(
					"title" => esc_html__('Widgets above the content', 'raiderspirit'),
					"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'raiderspirit') ),
					"std" => 'hide',
					"options" => array(),
					"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_content_blog' => array(
					"title" => esc_html__('Widgets below the content', 'raiderspirit'),
					"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'raiderspirit') ),
					"std" => 'hide',
					"options" => array(),
					"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_page_blog' => array(
					"title" => esc_html__('Widgets at the bottom of the page', 'raiderspirit'),
					"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'raiderspirit') ),
					"std" => 'hide',
					"options" => array(),
					"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "select"
					),

				'blog_advanced_info' => array(
					"title" => esc_html__('Advanced settings', 'raiderspirit'),
					"desc" => '',
					"type" => "info",
					),
				'no_image' => array(
					"title" => esc_html__('Image placeholder', 'raiderspirit'),
					"desc" => wp_kses_data( __('Select or upload an image used as placeholder for posts without a featured image', 'raiderspirit') ),
					"std" => '',
					"type" => "image"
					),
				'time_diff_before' => array(
					"title" => esc_html__('Easy Readable Date Format', 'raiderspirit'),
					"desc" => wp_kses_data( __("For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'raiderspirit') ),
					"std" => 5,
					"type" => "text"
					),
				'sticky_style' => array(
					"title" => esc_html__('Sticky posts style', 'raiderspirit'),
					"desc" => wp_kses_data( __('Select style of the sticky posts output', 'raiderspirit') ),
					"std" => 'inherit',
					"options" => array(
						'inherit' => esc_html__('Decorated posts', 'raiderspirit'),
						'columns' => esc_html__('Mini-cards',	'raiderspirit')
					),
					"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "select"
					),
				"blog_animation" => array( 
					"title" => esc_html__('Animation for the posts', 'raiderspirit'),
					"desc" => wp_kses_data( __('Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'raiderspirit') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'raiderspirit')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"std" => "none",
					"options" => array(),
					"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "select"
					),
				'meta_parts' => array(
					"title" => esc_html__('Post meta', 'raiderspirit'),
					"desc" => wp_kses_data( __("If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page. Counters and Share Links are available only if plugin ThemeREX Addons is active", 'raiderspirit') )
								. '<br>'
								. wp_kses_data( __("<b>Tip:</b> Drag items to change their order.", 'raiderspirit') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'raiderspirit')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=1|date=1|counters=1|author=0|share=0|edit=1',
					"options" => array(
						'categories' => esc_html__('Categories', 'raiderspirit'),
						'date'		 => esc_html__('Post date', 'raiderspirit'),
						'author'	 => esc_html__('Post author', 'raiderspirit'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'raiderspirit'),
						'share'		 => esc_html__('Share links', 'raiderspirit'),
						'edit'		 => esc_html__('Edit link', 'raiderspirit')
					),
					"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checklist"
				),
				'counters' => array(
					"title" => esc_html__('Views, Likes and Comments', 'raiderspirit'),
					"desc" => wp_kses_data( __("Likes and Views are available only if ThemeREX Addons is active", 'raiderspirit') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'raiderspirit')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=1|likes=1|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'raiderspirit'),
						'likes' => esc_html__('Likes', 'raiderspirit'),
						'comments' => esc_html__('Comments', 'raiderspirit')
					),
					"type" => RAIDERSPIRIT_THEME_FREE || !raiderspirit_exists_trx_addons() ? "hidden" : "checklist"
				),

				
				// Blog - Single posts
				'blog_single' => array(
					"title" => esc_html__('Single posts', 'raiderspirit'),
					"desc" => wp_kses_data( __('Settings of the single post', 'raiderspirit') ),
					"type" => "section",
					),
				'hide_featured_on_single' => array(
					"title" => esc_html__('Hide featured image on the single post', 'raiderspirit'),
					"desc" => wp_kses_data( __("Hide featured image on the single post's pages", 'raiderspirit') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'raiderspirit')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				'hide_sidebar_on_single' => array(
					"title" => esc_html__('Hide sidebar on the single post', 'raiderspirit'),
					"desc" => wp_kses_data( __("Hide sidebar on the single post's pages", 'raiderspirit') ),
					"std" => 0,
					"type" => "checkbox"
					),
				'show_post_meta' => array(
					"title" => esc_html__('Show post meta', 'raiderspirit'),
					"desc" => wp_kses_data( __("Display block with post's meta: date, categories, counters, etc.", 'raiderspirit') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'meta_parts_post' => array(
					"title" => esc_html__('Post meta', 'raiderspirit'),
					"desc" => wp_kses_data( __("Meta parts for single posts. Counters and Share Links are available only if plugin ThemeREX Addons is active", 'raiderspirit') )
								. '<br>'
								. wp_kses_data( __("<b>Tip:</b> Drag items to change their order.", 'raiderspirit') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=1|date=1|counters=1|author=0|share=0|edit=1',
					"options" => array(
						'categories' => esc_html__('Categories', 'raiderspirit'),
						'date'		 => esc_html__('Post date', 'raiderspirit'),
						'author'	 => esc_html__('Post author', 'raiderspirit'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'raiderspirit'),
						'share'		 => esc_html__('Share links', 'raiderspirit'),
						'edit'		 => esc_html__('Edit link', 'raiderspirit')
					),
					"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checklist"
				),
				'counters_post' => array(
					"title" => esc_html__('Views, Likes and Comments', 'raiderspirit'),
					"desc" => wp_kses_data( __("Likes and Views are available only if plugin ThemeREX Addons is active", 'raiderspirit') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=1|likes=1|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'raiderspirit'),
						'likes' => esc_html__('Likes', 'raiderspirit'),
						'comments' => esc_html__('Comments', 'raiderspirit')
					),
					"type" => RAIDERSPIRIT_THEME_FREE || !raiderspirit_exists_trx_addons() ? "hidden" : "checklist"
				),
				'show_share_links' => array(
					"title" => esc_html__('Show share links', 'raiderspirit'),
					"desc" => wp_kses_data( __("Display share links on the single post", 'raiderspirit') ),
					"std" => 1,
					"type" => !raiderspirit_exists_trx_addons() ? "hidden" : "checkbox"
					),
				'show_author_info' => array(
					"title" => esc_html__('Show author info', 'raiderspirit'),
					"desc" => wp_kses_data( __("Display block with information about post's author", 'raiderspirit') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'blog_single_related_info' => array(
					"title" => esc_html__('Related posts', 'raiderspirit'),
					"desc" => '',
					"type" => "info",
					),
				'show_related_posts' => array(
					"title" => esc_html__('Show related posts', 'raiderspirit'),
					"desc" => wp_kses_data( __("Show section 'Related posts' on the single post's pages", 'raiderspirit') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'raiderspirit')
					),
					"std" => 1,
					"type" => "checkbox"
					),
				'related_posts' => array(
					"title" => esc_html__('Related posts', 'raiderspirit'),
					"desc" => wp_kses_data( __('How many related posts should be displayed in the single post? If 0 - no related posts are shown.', 'raiderspirit') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => raiderspirit_get_list_range(1,9),
					"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "select"
					),
				'related_columns' => array(
					"title" => esc_html__('Related columns', 'raiderspirit'),
					"desc" => wp_kses_data( __('How many columns should be used to output related posts in the single page (from 2 to 4)?', 'raiderspirit') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => raiderspirit_get_list_range(1,4),
					"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "switch"
					),
				'related_style' => array(
					"title" => esc_html__('Related posts style', 'raiderspirit'),
					"desc" => wp_kses_data( __('Select style of the related posts output', 'raiderspirit') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => raiderspirit_get_list_styles(1,2),
					"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "switch"
					),
			'blog_end' => array(
				"type" => "panel_end",
				),
			
		
		
			// 'Colors'
			'panel_colors' => array(
				"title" => esc_html__('Colors', 'raiderspirit'),
				"desc" => '',
				"priority" => 300,
				"type" => "section"
				),

			'color_schemes_info' => array(
				"title" => esc_html__('Color schemes', 'raiderspirit'),
				"desc" => wp_kses_data( __('Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'raiderspirit') ),
				"type" => "info",
				),
			'color_scheme' => array(
				"title" => esc_html__('Site Color Scheme', 'raiderspirit'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'raiderspirit')
				),
				"std" => 'default',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'header_scheme' => array(
				"title" => esc_html__('Header Color Scheme', 'raiderspirit'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'raiderspirit')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'menu_scheme' => array(
				"title" => esc_html__('Sidemenu Color Scheme', 'raiderspirit'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'raiderspirit')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "switch"
				),
			'sidebar_scheme' => array(
				"title" => esc_html__('Sidebar Color Scheme', 'raiderspirit'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'raiderspirit')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'footer_scheme' => array(
				"title" => esc_html__('Footer Color Scheme', 'raiderspirit'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'raiderspirit')
				),
				"std" => 'dark',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),

			'color_scheme_editor_info' => array(
				"title" => esc_html__('Color scheme editor', 'raiderspirit'),
				"desc" => wp_kses_data(__('Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'raiderspirit') ),
				"type" => "info",
				),
			'scheme_storage' => array(
				"title" => esc_html__('Color scheme editor', 'raiderspirit'),
				"desc" => '',
				"std" => '$raiderspirit_get_scheme_storage',
				"refresh" => false,
				"colorpicker" => "tiny",
				"type" => "scheme_editor"
				),


			// 'Hidden'
			'media_title' => array(
				"title" => esc_html__('Media title', 'raiderspirit'),
				"desc" => wp_kses_data( __('Used as title for the audio and video item in this post', 'raiderspirit') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'raiderspirit')
				),
				"hidden" => true,
				"std" => '',
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "text"
				),
			'media_author' => array(
				"title" => esc_html__('Media author', 'raiderspirit'),
				"desc" => wp_kses_data( __('Used as author name for the audio and video item in this post', 'raiderspirit') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'raiderspirit')
				),
				"hidden" => true,
				"std" => '',
				"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "text"
				),


			// Internal options.
			// Attention! Don't change any options in the section below!
			// Use huge priority to call render this elements after all options!
			'reset_options' => array(
				"title" => '',
				"desc" => '',
				"std" => '0',
				"priority" => 10000,
				"type" => "hidden",
				),

			'last_option' => array(		// Need to manually call action to include Tiny MCE scripts
				"title" => '',
				"desc" => '',
				"std" => 1,
				"type" => "hidden",
				),

		));


		// Prepare panel 'Fonts'
		$fonts = array(
		
			// 'Fonts'
			'fonts' => array(
				"title" => esc_html__('Typography', 'raiderspirit'),
				"desc" => '',
				"priority" => 200,
				"type" => "panel"
				),

			// Fonts - Load_fonts
			'load_fonts' => array(
				"title" => esc_html__('Load fonts', 'raiderspirit'),
				"desc" => wp_kses_data( __('Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'raiderspirit') )
						. '<br>'
						. wp_kses_data( __('<b>Attention!</b> Press "Refresh" button to reload preview area after the all fonts are changed', 'raiderspirit') ),
				"type" => "section"
				),
			'load_fonts_subset' => array(
				"title" => esc_html__('Google fonts subsets', 'raiderspirit'),
				"desc" => wp_kses_data( __('Specify comma separated list of the subsets which will be load from Google fonts', 'raiderspirit') )
						. '<br>'
						. wp_kses_data( __('Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'raiderspirit') ),
				"class" => "raiderspirit_column-1_3 raiderspirit_new_row",
				"refresh" => false,
				"std" => '$raiderspirit_get_load_fonts_subset',
				"type" => "text"
				)
		);

		for ($i=1; $i<=raiderspirit_get_theme_setting('max_load_fonts'); $i++) {
			if (raiderspirit_get_value_gp('page') != 'theme_options') {
				$fonts["load_fonts-{$i}-info"] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					"title" => esc_html(sprintf(__('Font %s', 'raiderspirit'), $i)),
					"desc" => '',
					"type" => "info",
					);
			}
			$fonts["load_fonts-{$i}-name"] = array(
				"title" => esc_html__('Font name', 'raiderspirit'),
				"desc" => '',
				"class" => "raiderspirit_column-1_3 raiderspirit_new_row",
				"refresh" => false,
				"std" => '$raiderspirit_get_load_fonts_option',
				"type" => "text"
				);
			$fonts["load_fonts-{$i}-family"] = array(
				"title" => esc_html__('Font family', 'raiderspirit'),
				"desc" => $i==1 
							? wp_kses_data( __('Select font family to use it if font above is not available', 'raiderspirit') )
							: '',
				"class" => "raiderspirit_column-1_3",
				"refresh" => false,
				"std" => '$raiderspirit_get_load_fonts_option',
				"options" => array(
					'inherit' => esc_html__("Inherit", 'raiderspirit'),
					'serif' => esc_html__('serif', 'raiderspirit'),
					'sans-serif' => esc_html__('sans-serif', 'raiderspirit'),
					'monospace' => esc_html__('monospace', 'raiderspirit'),
					'cursive' => esc_html__('cursive', 'raiderspirit'),
					'fantasy' => esc_html__('fantasy', 'raiderspirit')
				),
				"type" => "select"
				);
			$fonts["load_fonts-{$i}-styles"] = array(
				"title" => esc_html__('Font styles', 'raiderspirit'),
				"desc" => $i==1 
							? wp_kses_data( __('Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'raiderspirit') )
								. '<br>'
								. wp_kses_data( __('<b>Attention!</b> Each weight and style increase download size! Specify only used weights and styles.', 'raiderspirit') )
							: '',
				"class" => "raiderspirit_column-1_3",
				"refresh" => false,
				"std" => '$raiderspirit_get_load_fonts_option',
				"type" => "text"
				);
		}
		$fonts['load_fonts_end'] = array(
			"type" => "section_end"
			);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = raiderspirit_get_theme_fonts();
		foreach ($theme_fonts as $tag=>$v) {
			$fonts["{$tag}_section"] = array(
				"title" => !empty($v['title']) 
								? $v['title'] 
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html(sprintf(__('%s settings', 'raiderspirit'), $tag)),
				"desc" => !empty($v['description']) 
								? $v['description'] 
								// Translators: Add tag's name to make description
								: wp_kses_post( sprintf(__('Font settings of the "%s" tag.', 'raiderspirit'), $tag) ),
				"type" => "section",
				);
	
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				$options = '';
				$type = 'text';
				$load_order = 1;
				$title = ucfirst(str_replace('-', ' ', $css_prop));
				if ($css_prop == 'font-family') {
					$type = 'select';
					$options = array();
					$load_order = 2;		// Load this option's value after all options are loaded (use option 'load_fonts' to build fonts list)
				} else if ($css_prop == 'font-weight') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'raiderspirit'),
						'100' => esc_html__('100 (Light)', 'raiderspirit'), 
						'200' => esc_html__('200 (Light)', 'raiderspirit'), 
						'300' => esc_html__('300 (Thin)',  'raiderspirit'),
						'400' => esc_html__('400 (Normal)', 'raiderspirit'),
						'500' => esc_html__('500 (Semibold)', 'raiderspirit'),
						'600' => esc_html__('600 (Semibold)', 'raiderspirit'),
						'700' => esc_html__('700 (Bold)', 'raiderspirit'),
						'800' => esc_html__('800 (Black)', 'raiderspirit'),
						'900' => esc_html__('900 (Black)', 'raiderspirit')
					);
				} else if ($css_prop == 'font-style') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'raiderspirit'),
						'normal' => esc_html__('Normal', 'raiderspirit'), 
						'italic' => esc_html__('Italic', 'raiderspirit')
					);
				} else if ($css_prop == 'text-decoration') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'raiderspirit'),
						'none' => esc_html__('None', 'raiderspirit'), 
						'underline' => esc_html__('Underline', 'raiderspirit'),
						'overline' => esc_html__('Overline', 'raiderspirit'),
						'line-through' => esc_html__('Line-through', 'raiderspirit')
					);
				} else if ($css_prop == 'text-transform') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'raiderspirit'),
						'none' => esc_html__('None', 'raiderspirit'), 
						'uppercase' => esc_html__('Uppercase', 'raiderspirit'),
						'lowercase' => esc_html__('Lowercase', 'raiderspirit'),
						'capitalize' => esc_html__('Capitalize', 'raiderspirit')
					);
				}
				$fonts["{$tag}_{$css_prop}"] = array(
					"title" => $title,
					"desc" => '',
					"class" => "raiderspirit_column-1_5",
					"refresh" => false,
					"load_order" => $load_order,
					"std" => '$raiderspirit_get_theme_fonts_option',
					"options" => $options,
					"type" => $type
				);
			}
			
			$fonts["{$tag}_section_end"] = array(
				"type" => "section_end"
				);
		}

		$fonts['fonts_end'] = array(
			"type" => "panel_end"
			);

		// Add fonts parameters to Theme Options
		raiderspirit_storage_set_array_before('options', 'panel_colors', $fonts);

		// Add Header Video if WP version < 4.7
		if (!function_exists('get_header_video_url')) {
			raiderspirit_storage_set_array_after('options', 'header_image_override', 'header_video', array(
				"title" => esc_html__('Header video', 'raiderspirit'),
				"desc" => wp_kses_data( __("Select video to use it as background for the header", 'raiderspirit') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'raiderspirit')
				),
				"std" => '',
				"type" => "video"
				)
			);
		}

		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is 'Theme Options'
		if (!function_exists('the_custom_logo') || (isset($_REQUEST['page']) && $_REQUEST['page']=='theme_options')) {
			raiderspirit_storage_set_array_before('options', 'logo_retina', function_exists('the_custom_logo') ? 'custom_logo' : 'logo', array(
				"title" => esc_html__('Logo', 'raiderspirit'),
				"desc" => wp_kses_data( __('Select or upload the site logo', 'raiderspirit') ),
				"class" => "raiderspirit_column-1_2 raiderspirit_new_row",
				"priority" => 60,
				"std" => '',
				"type" => "image"
				)
			);
		}
	}
}


// Returns a list of options that can be overridden for CPT
if (!function_exists('raiderspirit_options_get_list_cpt_options')) {
	function raiderspirit_options_get_list_cpt_options($cpt, $title='') {
		if (empty($title)) $title = ucfirst($cpt);
		return array(
					"header_info_{$cpt}" => array(
						"title" => esc_html__('Header', 'raiderspirit'),
						"desc" => '',
						"type" => "info",
						),
					"header_type_{$cpt}" => array(
						"title" => esc_html__('Header style', 'raiderspirit'),
						"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'raiderspirit') ),
						"std" => 'inherit',
						"options" => raiderspirit_get_list_header_footer_types(true),
						"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "switch"
						),
					"header_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'raiderspirit'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select custom layout to display the site header on the %s pages', 'raiderspirit'), $title) ),
						"dependency" => array(
							"header_type_{$cpt}" => array('custom')
						),
						"std" => 'inherit',
						"options" => array(),
						"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "select"
						),
					"header_position_{$cpt}" => array(
						"title" => esc_html__('Header position', 'raiderspirit'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to display the site header on the %s pages', 'raiderspirit'), $title) ),
						"std" => 'inherit',
						"options" => array(),
						"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "switch"
						),
					"header_image_override_{$cpt}" => array(
						"title" => esc_html__('Header image override', 'raiderspirit'),
						"desc" => wp_kses_data( __("Allow override the header image with the post's featured image", 'raiderspirit') ),
						"std" => 0,
						"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "checkbox"
						),
					"header_widgets_{$cpt}" => array(
						"title" => esc_html__('Header widgets', 'raiderspirit'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select set of widgets to show in the header on the %s pages', 'raiderspirit'), $title) ),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
						
					"sidebar_info_{$cpt}" => array(
						"title" => esc_html__('Sidebar', 'raiderspirit'),
						"desc" => '',
						"type" => "info",
						),
					"sidebar_position_{$cpt}" => array(
						"title" => esc_html__('Sidebar position', 'raiderspirit'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to show sidebar on the %s pages', 'raiderspirit'), $title) ),
						"std" => 'left',
						"options" => array(),
						"type" => "switch"
						),
					"sidebar_widgets_{$cpt}" => array(
						"title" => esc_html__('Sidebar widgets', 'raiderspirit'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select sidebar to show on the %s pages', 'raiderspirit'), $title) ),
						"dependency" => array(
							"sidebar_position_{$cpt}" => array('left', 'right')
						),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
					"hide_sidebar_on_single_{$cpt}" => array(
						"title" => esc_html__('Hide sidebar on the single pages', 'raiderspirit'),
						"desc" => wp_kses_data( __("Hide sidebar on the single page", 'raiderspirit') ),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"footer_info_{$cpt}" => array(
						"title" => esc_html__('Footer', 'raiderspirit'),
						"desc" => '',
						"type" => "info",
						),
					"footer_type_{$cpt}" => array(
						"title" => esc_html__('Footer style', 'raiderspirit'),
						"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'raiderspirit') ),
						"std" => 'inherit',
						"options" => raiderspirit_get_list_header_footer_types(true),
						"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "switch"
						),
					"footer_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'raiderspirit'),
						"desc" => wp_kses_data( __('Select custom layout to display the site footer', 'raiderspirit') ),
						"std" => 'inherit',
						"dependency" => array(
							"footer_type_{$cpt}" => array('custom')
						),
						"options" => array(),
						"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "select"
						),
					"footer_widgets_{$cpt}" => array(
						"title" => esc_html__('Footer widgets', 'raiderspirit'),
						"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'raiderspirit') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 'footer_widgets',
						"options" => array(),
						"type" => "select"
						),
					"footer_columns_{$cpt}" => array(
						"title" => esc_html__('Footer columns', 'raiderspirit'),
						"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'raiderspirit') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default'),
							"footer_widgets_{$cpt}" => array('^hide')
						),
						"std" => 0,
						"options" => raiderspirit_get_list_range(0,6),
						"type" => "select"
						),
					"footer_wide_{$cpt}" => array(
						"title" => esc_html__('Footer fullwidth', 'raiderspirit'),
						"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'raiderspirit') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"widgets_info_{$cpt}" => array(
						"title" => esc_html__('Additional panels', 'raiderspirit'),
						"desc" => '',
						"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "info",
						),
					"widgets_above_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the top of the page', 'raiderspirit'),
						"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'raiderspirit') ),
						"std" => 'hide',
						"options" => array(),
						"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "select"
						),
					"widgets_above_content_{$cpt}" => array(
						"title" => esc_html__('Widgets above the content', 'raiderspirit'),
						"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'raiderspirit') ),
						"std" => 'hide',
						"options" => array(),
						"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_content_{$cpt}" => array(
						"title" => esc_html__('Widgets below the content', 'raiderspirit'),
						"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'raiderspirit') ),
						"std" => 'hide',
						"options" => array(),
						"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the bottom of the page', 'raiderspirit'),
						"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'raiderspirit') ),
						"std" => 'hide',
						"options" => array(),
						"type" => RAIDERSPIRIT_THEME_FREE ? "hidden" : "select"
						)
					);
	}
}


// Return lists with choises when its need in the admin mode
if (!function_exists('raiderspirit_options_get_list_choises')) {
	add_filter('raiderspirit_filter_options_get_list_choises', 'raiderspirit_options_get_list_choises', 10, 2);
	function raiderspirit_options_get_list_choises($list, $id) {
		if (is_array($list) && count($list)==0) {
			if (strpos($id, 'header_style')===0)
				$list = raiderspirit_get_list_header_styles(strpos($id, 'header_style_')===0);
			else if (strpos($id, 'header_position')===0)
				$list = raiderspirit_get_list_header_positions(strpos($id, 'header_position_')===0);
			else if (strpos($id, 'header_widgets')===0)
				$list = raiderspirit_get_list_sidebars(strpos($id, 'header_widgets_')===0, true);
			else if (strpos($id, '_scheme') > 0)
				$list = raiderspirit_get_list_schemes($id!='color_scheme');
			else if (strpos($id, 'sidebar_widgets')===0)
				$list = raiderspirit_get_list_sidebars(strpos($id, 'sidebar_widgets_')===0, true);
			else if (strpos($id, 'sidebar_position')===0)
				$list = raiderspirit_get_list_sidebars_positions(strpos($id, 'sidebar_position_')===0);
			else if (strpos($id, 'widgets_above_page')===0)
				$list = raiderspirit_get_list_sidebars(strpos($id, 'widgets_above_page_')===0, true);
			else if (strpos($id, 'widgets_above_content')===0)
				$list = raiderspirit_get_list_sidebars(strpos($id, 'widgets_above_content_')===0, true);
			else if (strpos($id, 'widgets_below_page')===0)
				$list = raiderspirit_get_list_sidebars(strpos($id, 'widgets_below_page_')===0, true);
			else if (strpos($id, 'widgets_below_content')===0)
				$list = raiderspirit_get_list_sidebars(strpos($id, 'widgets_below_content_')===0, true);
			else if (strpos($id, 'footer_style')===0)
				$list = raiderspirit_get_list_footer_styles(strpos($id, 'footer_style_')===0);
			else if (strpos($id, 'footer_widgets')===0)
				$list = raiderspirit_get_list_sidebars(strpos($id, 'footer_widgets_')===0, true);
			else if (strpos($id, 'blog_style')===0)
				$list = raiderspirit_get_list_blog_styles(strpos($id, 'blog_style_')===0);
			else if (strpos($id, 'post_type')===0)
				$list = raiderspirit_get_list_posts_types();
			else if (strpos($id, 'parent_cat')===0)
				$list = raiderspirit_array_merge(array(0 => esc_html__('- Select category -', 'raiderspirit')), raiderspirit_get_list_categories());
			else if (strpos($id, 'blog_animation')===0)
				$list = raiderspirit_get_list_animations_in();
			else if ($id == 'color_scheme_editor')
				$list = raiderspirit_get_list_schemes();
			else if (strpos($id, '_font-family') > 0)
				$list = raiderspirit_get_list_load_fonts(true);
		}
		return $list;
	}
}
?>