<div class="front_page_section front_page_section_blog<?php
			$raiderspirit_scheme = raiderspirit_get_theme_option('front_page_blog_scheme');
			if (!raiderspirit_is_inherit($raiderspirit_scheme)) echo ' scheme_'.esc_attr($raiderspirit_scheme);
			echo ' front_page_section_paddings_'.esc_attr(raiderspirit_get_theme_option('front_page_blog_paddings'));
		?>"<?php
		$raiderspirit_css = '';
		$raiderspirit_bg_image = raiderspirit_get_theme_option('front_page_blog_bg_image');
		if (!empty($raiderspirit_bg_image)) 
			$raiderspirit_css .= 'background-image: url('.esc_url(raiderspirit_get_attachment_url($raiderspirit_bg_image)).');';
		if (!empty($raiderspirit_css))
			echo ' style="' . esc_attr($raiderspirit_css) . '"';
?>><?php
	// Add anchor
	$raiderspirit_anchor_icon = raiderspirit_get_theme_option('front_page_blog_anchor_icon');	
	$raiderspirit_anchor_text = raiderspirit_get_theme_option('front_page_blog_anchor_text');	
	if ((!empty($raiderspirit_anchor_icon) || !empty($raiderspirit_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_blog"'
										. (!empty($raiderspirit_anchor_icon) ? ' icon="'.esc_attr($raiderspirit_anchor_icon).'"' : '')
										. (!empty($raiderspirit_anchor_text) ? ' title="'.esc_attr($raiderspirit_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_blog_inner<?php
			if (raiderspirit_get_theme_option('front_page_blog_fullheight'))
				echo ' raiderspirit-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$raiderspirit_css = '';
			$raiderspirit_bg_mask = raiderspirit_get_theme_option('front_page_blog_bg_mask');
			$raiderspirit_bg_color = raiderspirit_get_theme_option('front_page_blog_bg_color');
			if (!empty($raiderspirit_bg_color) && $raiderspirit_bg_mask > 0)
				$raiderspirit_css .= 'background-color: '.esc_attr($raiderspirit_bg_mask==1
																	? $raiderspirit_bg_color
																	: raiderspirit_hex2rgba($raiderspirit_bg_color, $raiderspirit_bg_mask)
																).';';
			if (!empty($raiderspirit_css))
				echo ' style="' . esc_attr($raiderspirit_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_blog_content_wrap content_wrap">
			<?php
			// Caption
			$raiderspirit_caption = raiderspirit_get_theme_option('front_page_blog_caption');
			if (!empty($raiderspirit_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><h2 class="front_page_section_caption front_page_section_blog_caption front_page_block_<?php echo !empty($raiderspirit_caption) ? 'filled' : 'empty'; ?>"><?php echo wp_kses_post($raiderspirit_caption); ?></h2><?php
			}
		
			// Description (text)
			$raiderspirit_description = raiderspirit_get_theme_option('front_page_blog_description');
			if (!empty($raiderspirit_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_description front_page_section_blog_description front_page_block_<?php echo !empty($raiderspirit_description) ? 'filled' : 'empty'; ?>"><?php echo wp_kses_post(wpautop($raiderspirit_description)); ?></div><?php
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_blog_output"><?php 
				if (is_active_sidebar('front_page_blog_widgets')) {
					dynamic_sidebar( 'front_page_blog_widgets' );
				} else if (current_user_can( 'edit_theme_options' )) {
					if (!raiderspirit_exists_trx_addons())
						raiderspirit_customizer_need_trx_addons_message();
					else
						raiderspirit_customizer_need_widgets_message('front_page_blog_caption', 'ThemeREX Addons - Blogger');
				}
			?></div>
		</div>
	</div>
</div>