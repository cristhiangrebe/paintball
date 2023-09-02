<div class="front_page_section front_page_section_about<?php
			$raiderspirit_scheme = raiderspirit_get_theme_option('front_page_about_scheme');
			if (!raiderspirit_is_inherit($raiderspirit_scheme)) echo ' scheme_'.esc_attr($raiderspirit_scheme);
			echo ' front_page_section_paddings_'.esc_attr(raiderspirit_get_theme_option('front_page_about_paddings'));
		?>"<?php
		$raiderspirit_css = '';
		$raiderspirit_bg_image = raiderspirit_get_theme_option('front_page_about_bg_image');
		if (!empty($raiderspirit_bg_image)) 
			$raiderspirit_css .= 'background-image: url('.esc_url(raiderspirit_get_attachment_url($raiderspirit_bg_image)).');';
		if (!empty($raiderspirit_css))
			echo ' style="' . esc_attr($raiderspirit_css) . '"';
?>><?php
	// Add anchor
	$raiderspirit_anchor_icon = raiderspirit_get_theme_option('front_page_about_anchor_icon');	
	$raiderspirit_anchor_text = raiderspirit_get_theme_option('front_page_about_anchor_text');	
	if ((!empty($raiderspirit_anchor_icon) || !empty($raiderspirit_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_about"'
										. (!empty($raiderspirit_anchor_icon) ? ' icon="'.esc_attr($raiderspirit_anchor_icon).'"' : '')
										. (!empty($raiderspirit_anchor_text) ? ' title="'.esc_attr($raiderspirit_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_about_inner<?php
			if (raiderspirit_get_theme_option('front_page_about_fullheight'))
				echo ' raiderspirit-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$raiderspirit_css = '';
			$raiderspirit_bg_mask = raiderspirit_get_theme_option('front_page_about_bg_mask');
			$raiderspirit_bg_color = raiderspirit_get_theme_option('front_page_about_bg_color');
			if (!empty($raiderspirit_bg_color) && $raiderspirit_bg_mask > 0)
				$raiderspirit_css .= 'background-color: '.esc_attr($raiderspirit_bg_mask==1
																	? $raiderspirit_bg_color
																	: raiderspirit_hex2rgba($raiderspirit_bg_color, $raiderspirit_bg_mask)
																).';';
			if (!empty($raiderspirit_css))
				echo ' style="' . esc_attr($raiderspirit_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_about_content_wrap content_wrap">
			<?php
			// Caption
			$raiderspirit_caption = raiderspirit_get_theme_option('front_page_about_caption');
			if (!empty($raiderspirit_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><h2 class="front_page_section_caption front_page_section_about_caption front_page_block_<?php echo !empty($raiderspirit_caption) ? 'filled' : 'empty'; ?>"><?php echo wp_kses_post($raiderspirit_caption); ?></h2><?php
			}
		
			// Description (text)
			$raiderspirit_description = raiderspirit_get_theme_option('front_page_about_description');
			if (!empty($raiderspirit_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_description front_page_section_about_description front_page_block_<?php echo !empty($raiderspirit_description) ? 'filled' : 'empty'; ?>"><?php echo wp_kses_post(wpautop($raiderspirit_description)); ?></div><?php
			}
			
			// Content
			$raiderspirit_content = raiderspirit_get_theme_option('front_page_about_content');
			if (!empty($raiderspirit_content) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_content front_page_section_about_content front_page_block_<?php echo !empty($raiderspirit_content) ? 'filled' : 'empty'; ?>"><?php
					$raiderspirit_page_content_mask = '%%CONTENT%%';
					if (strpos($raiderspirit_content, $raiderspirit_page_content_mask) !== false) {
						$raiderspirit_content = preg_replace(
									'/(\<p\>\s*)?'.$raiderspirit_page_content_mask.'(\s*\<\/p\>)/i',
									sprintf('<div class="front_page_section_about_source">%s</div>',
												apply_filters('the_content', get_the_content())),
									$raiderspirit_content
									);
					}
					raiderspirit_show_layout($raiderspirit_content);
				?></div><?php
			}
			?>
		</div>
	</div>
</div>