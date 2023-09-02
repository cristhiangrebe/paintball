<div class="front_page_section front_page_section_googlemap<?php
			$raiderspirit_scheme = raiderspirit_get_theme_option('front_page_googlemap_scheme');
			if (!raiderspirit_is_inherit($raiderspirit_scheme)) echo ' scheme_'.esc_attr($raiderspirit_scheme);
			echo ' front_page_section_paddings_'.esc_attr(raiderspirit_get_theme_option('front_page_googlemap_paddings'));
		?>"<?php
		$raiderspirit_css = '';
		$raiderspirit_bg_image = raiderspirit_get_theme_option('front_page_googlemap_bg_image');
		if (!empty($raiderspirit_bg_image)) 
			$raiderspirit_css .= 'background-image: url('.esc_url(raiderspirit_get_attachment_url($raiderspirit_bg_image)).');';
		if (!empty($raiderspirit_css))
			echo ' style="' . esc_attr($raiderspirit_css) . '"';
?>><?php
	// Add anchor
	$raiderspirit_anchor_icon = raiderspirit_get_theme_option('front_page_googlemap_anchor_icon');	
	$raiderspirit_anchor_text = raiderspirit_get_theme_option('front_page_googlemap_anchor_text');	
	if ((!empty($raiderspirit_anchor_icon) || !empty($raiderspirit_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_googlemap"'
										. (!empty($raiderspirit_anchor_icon) ? ' icon="'.esc_attr($raiderspirit_anchor_icon).'"' : '')
										. (!empty($raiderspirit_anchor_text) ? ' title="'.esc_attr($raiderspirit_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_googlemap_inner<?php
			if (raiderspirit_get_theme_option('front_page_googlemap_fullheight'))
				echo ' raiderspirit-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$raiderspirit_css = '';
			$raiderspirit_bg_mask = raiderspirit_get_theme_option('front_page_googlemap_bg_mask');
			$raiderspirit_bg_color = raiderspirit_get_theme_option('front_page_googlemap_bg_color');
			if (!empty($raiderspirit_bg_color) && $raiderspirit_bg_mask > 0)
				$raiderspirit_css .= 'background-color: '.esc_attr($raiderspirit_bg_mask==1
																	? $raiderspirit_bg_color
																	: raiderspirit_hex2rgba($raiderspirit_bg_color, $raiderspirit_bg_mask)
																).';';
			if (!empty($raiderspirit_css))
				echo ' style="' . esc_attr($raiderspirit_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap<?php
			$raiderspirit_layout = raiderspirit_get_theme_option('front_page_googlemap_layout');
			if ($raiderspirit_layout != 'fullwidth')
				echo ' content_wrap';
		?>">
			<?php
			// Content wrap with title and description
			$raiderspirit_caption = raiderspirit_get_theme_option('front_page_googlemap_caption');
			$raiderspirit_description = raiderspirit_get_theme_option('front_page_googlemap_description');
			if (!empty($raiderspirit_caption) || !empty($raiderspirit_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				if ($raiderspirit_layout == 'fullwidth') {
					?><div class="content_wrap"><?php
				}
					// Caption
					if (!empty($raiderspirit_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
						?><h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo !empty($raiderspirit_caption) ? 'filled' : 'empty'; ?>"><?php
							echo wp_kses_post($raiderspirit_caption);
						?></h2><?php
					}
				
					// Description (text)
					if (!empty($raiderspirit_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
						?><div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo !empty($raiderspirit_description) ? 'filled' : 'empty'; ?>"><?php
							echo wp_kses_post(wpautop($raiderspirit_description));
						?></div><?php
					}
				if ($raiderspirit_layout == 'fullwidth') {
					?></div><?php
				}
			}

			// Content (text)
			$raiderspirit_content = raiderspirit_get_theme_option('front_page_googlemap_content');
			if (!empty($raiderspirit_content) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				if ($raiderspirit_layout == 'columns') {
					?><div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} else if ($raiderspirit_layout == 'fullwidth') {
					?><div class="content_wrap"><?php
				}
	
				?><div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo !empty($raiderspirit_content) ? 'filled' : 'empty'; ?>"><?php
					echo wp_kses_post($raiderspirit_content);
				?></div><?php
	
				if ($raiderspirit_layout == 'columns') {
					?></div><div class="column-2_3"><?php
				} else if ($raiderspirit_layout == 'fullwidth') {
					?></div><?php
				}
			}
			
			// Widgets output
			?><div class="front_page_section_output front_page_section_googlemap_output"><?php 
				if (is_active_sidebar('front_page_googlemap_widgets')) {
					dynamic_sidebar( 'front_page_googlemap_widgets' );
				} else if (current_user_can( 'edit_theme_options' )) {
					if (!raiderspirit_exists_trx_addons())
						raiderspirit_customizer_need_trx_addons_message();
					else
						raiderspirit_customizer_need_widgets_message('front_page_googlemap_caption', 'ThemeREX Addons - Google map');
				}
			?></div><?php

			if ($raiderspirit_layout == 'columns' && (!empty($raiderspirit_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div></div><?php
			}
			?>			
		</div>
	</div>
</div>