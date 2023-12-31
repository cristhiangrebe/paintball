<?php
if (($raiderspirit_slider_sc = raiderspirit_get_theme_option('front_page_title_shortcode')) != '' && strpos($raiderspirit_slider_sc, '[')!==false && strpos($raiderspirit_slider_sc, ']')!==false) {

	?><div class="front_page_section front_page_section_title front_page_section_slider front_page_section_title_slider"><?php
		// Add anchor
		$raiderspirit_anchor_icon = raiderspirit_get_theme_option('front_page_title_anchor_icon');	
		$raiderspirit_anchor_text = raiderspirit_get_theme_option('front_page_title_anchor_text');	
		if ((!empty($raiderspirit_anchor_icon) || !empty($raiderspirit_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
			echo do_shortcode('[trx_sc_anchor id="front_page_section_title"'
											. (!empty($raiderspirit_anchor_icon) ? ' icon="'.esc_attr($raiderspirit_anchor_icon).'"' : '')
											. (!empty($raiderspirit_anchor_text) ? ' title="'.esc_attr($raiderspirit_anchor_text).'"' : '')
											. ']');
		}
		// Show slider (or any other content, generated by shortcode)
		echo do_shortcode($raiderspirit_slider_sc);
	?></div><?php

} else {

	?><div class="front_page_section front_page_section_title<?php
				$raiderspirit_scheme = raiderspirit_get_theme_option('front_page_title_scheme');
				if (!raiderspirit_is_inherit($raiderspirit_scheme)) echo ' scheme_'.esc_attr($raiderspirit_scheme);
				echo ' front_page_section_paddings_'.esc_attr(raiderspirit_get_theme_option('front_page_title_paddings'));
			?>"<?php
			$raiderspirit_css = '';
			$raiderspirit_bg_image = raiderspirit_get_theme_option('front_page_title_bg_image');
			if (!empty($raiderspirit_bg_image)) 
				$raiderspirit_css .= 'background-image: url('.esc_url(raiderspirit_get_attachment_url($raiderspirit_bg_image)).');';
			if (!empty($raiderspirit_css))
				echo ' style="' . esc_attr($raiderspirit_css) . '"';
	?>><?php
		// Add anchor
		$raiderspirit_anchor_icon = raiderspirit_get_theme_option('front_page_title_anchor_icon');	
		$raiderspirit_anchor_text = raiderspirit_get_theme_option('front_page_title_anchor_text');	
		if ((!empty($raiderspirit_anchor_icon) || !empty($raiderspirit_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
			echo do_shortcode('[trx_sc_anchor id="front_page_section_title"'
											. (!empty($raiderspirit_anchor_icon) ? ' icon="'.esc_attr($raiderspirit_anchor_icon).'"' : '')
											. (!empty($raiderspirit_anchor_text) ? ' title="'.esc_attr($raiderspirit_anchor_text).'"' : '')
											. ']');
		}
		?>
		<div class="front_page_section_inner front_page_section_title_inner<?php
			if (raiderspirit_get_theme_option('front_page_title_fullheight'))
				echo ' raiderspirit-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
				$raiderspirit_css = '';
				$raiderspirit_bg_mask = raiderspirit_get_theme_option('front_page_title_bg_mask');
				$raiderspirit_bg_color = raiderspirit_get_theme_option('front_page_title_bg_color');
				if (!empty($raiderspirit_bg_color) && $raiderspirit_bg_mask > 0)
					$raiderspirit_css .= 'background-color: '.esc_attr($raiderspirit_bg_mask==1
																		? $raiderspirit_bg_color
																		: raiderspirit_hex2rgba($raiderspirit_bg_color, $raiderspirit_bg_mask)
																	).';';
				if (!empty($raiderspirit_css))
					echo ' style="' . esc_attr($raiderspirit_css) . '"';
		?>>
			<div class="front_page_section_content_wrap front_page_section_title_content_wrap content_wrap">
				<?php
				// Caption
				$raiderspirit_caption = raiderspirit_get_theme_option('front_page_title_caption');
				if (!empty($raiderspirit_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h1 class="front_page_section_caption front_page_section_title_caption front_page_block_<?php echo !empty($raiderspirit_caption) ? 'filled' : 'empty'; ?>"><?php echo wp_kses_post($raiderspirit_caption); ?></h1><?php
				}
			
				// Description (text)
				$raiderspirit_description = raiderspirit_get_theme_option('front_page_title_description');
				if (!empty($raiderspirit_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_title_description front_page_block_<?php echo !empty($raiderspirit_description) ? 'filled' : 'empty'; ?>"><?php echo wp_kses_post(wpautop($raiderspirit_description)); ?></div><?php
				}
				
				// Buttons
				if (raiderspirit_get_theme_option('front_page_title_button1_link')!='' || raiderspirit_get_theme_option('front_page_title_button2_link')!='') {
					?><div class="front_page_section_buttons front_page_section_title_buttons"><?php
						raiderspirit_show_layout(raiderspirit_customizer_partial_refresh_front_page_title_button1_link());
						raiderspirit_show_layout(raiderspirit_customizer_partial_refresh_front_page_title_button2_link());
					?></div><?php
				}
				?>
			</div>
		</div>
	</div>
	<?php
}