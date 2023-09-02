<div class="front_page_section front_page_section_woocommerce<?php
			$raiderspirit_scheme = raiderspirit_get_theme_option('front_page_woocommerce_scheme');
			if (!raiderspirit_is_inherit($raiderspirit_scheme)) echo ' scheme_'.esc_attr($raiderspirit_scheme);
			echo ' front_page_section_paddings_'.esc_attr(raiderspirit_get_theme_option('front_page_woocommerce_paddings'));
		?>"<?php
		$raiderspirit_css = '';
		$raiderspirit_bg_image = raiderspirit_get_theme_option('front_page_woocommerce_bg_image');
		if (!empty($raiderspirit_bg_image)) 
			$raiderspirit_css .= 'background-image: url('.esc_url(raiderspirit_get_attachment_url($raiderspirit_bg_image)).');';
		if (!empty($raiderspirit_css))
			echo ' style="' . esc_attr($raiderspirit_css) . '"';
?>><?php
	// Add anchor
	$raiderspirit_anchor_icon = raiderspirit_get_theme_option('front_page_woocommerce_anchor_icon');	
	$raiderspirit_anchor_text = raiderspirit_get_theme_option('front_page_woocommerce_anchor_text');	
	if ((!empty($raiderspirit_anchor_icon) || !empty($raiderspirit_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_woocommerce"'
										. (!empty($raiderspirit_anchor_icon) ? ' icon="'.esc_attr($raiderspirit_anchor_icon).'"' : '')
										. (!empty($raiderspirit_anchor_text) ? ' title="'.esc_attr($raiderspirit_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_woocommerce_inner<?php
			if (raiderspirit_get_theme_option('front_page_woocommerce_fullheight'))
				echo ' raiderspirit-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$raiderspirit_css = '';
			$raiderspirit_bg_mask = raiderspirit_get_theme_option('front_page_woocommerce_bg_mask');
			$raiderspirit_bg_color = raiderspirit_get_theme_option('front_page_woocommerce_bg_color');
			if (!empty($raiderspirit_bg_color) && $raiderspirit_bg_mask > 0)
				$raiderspirit_css .= 'background-color: '.esc_attr($raiderspirit_bg_mask==1
																	? $raiderspirit_bg_color
																	: raiderspirit_hex2rgba($raiderspirit_bg_color, $raiderspirit_bg_mask)
																).';';
			if (!empty($raiderspirit_css))
				echo ' style="' . esc_attr($raiderspirit_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
			<?php
			// Content wrap with title and description
			$raiderspirit_caption = raiderspirit_get_theme_option('front_page_woocommerce_caption');
			$raiderspirit_description = raiderspirit_get_theme_option('front_page_woocommerce_description');
			if (!empty($raiderspirit_caption) || !empty($raiderspirit_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				// Caption
				if (!empty($raiderspirit_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo !empty($raiderspirit_caption) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses_post($raiderspirit_caption);
					?></h2><?php
				}
			
				// Description (text)
				if (!empty($raiderspirit_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo !empty($raiderspirit_description) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses_post(wpautop($raiderspirit_description));
					?></div><?php
				}
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs"><?php 
				$raiderspirit_woocommerce_sc = raiderspirit_get_theme_option('front_page_woocommerce_products');
				if ($raiderspirit_woocommerce_sc == 'products') {
					$raiderspirit_woocommerce_sc_ids = raiderspirit_get_theme_option('front_page_woocommerce_products_per_page');
					$raiderspirit_woocommerce_sc_per_page = count(explode(',', $raiderspirit_woocommerce_sc_ids));
				} else {
					$raiderspirit_woocommerce_sc_per_page = max(1, (int) raiderspirit_get_theme_option('front_page_woocommerce_products_per_page'));
				}
				$raiderspirit_woocommerce_sc_columns = max(1, min($raiderspirit_woocommerce_sc_per_page, (int) raiderspirit_get_theme_option('front_page_woocommerce_products_columns')));
				echo do_shortcode("[{$raiderspirit_woocommerce_sc}"
									. ($raiderspirit_woocommerce_sc == 'products' 
											? ' ids="'.esc_attr($raiderspirit_woocommerce_sc_ids).'"' 
											: '')
									. ($raiderspirit_woocommerce_sc == 'product_category' 
											? ' category="'.esc_attr(raiderspirit_get_theme_option('front_page_woocommerce_products_categories')).'"' 
											: '')
									. ($raiderspirit_woocommerce_sc != 'best_selling_products' 
											? ' orderby="'.esc_attr(raiderspirit_get_theme_option('front_page_woocommerce_products_orderby')).'"'
											  . ' order="'.esc_attr(raiderspirit_get_theme_option('front_page_woocommerce_products_order')).'"' 
											: '')
									. ' per_page="'.esc_attr($raiderspirit_woocommerce_sc_per_page).'"' 
									. ' columns="'.esc_attr($raiderspirit_woocommerce_sc_columns).'"' 
									. ']');
			?></div>
		</div>
	</div>
</div>