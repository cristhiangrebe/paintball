<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0
 */

// Page (category, tag, archive, author) title

if ( raiderspirit_need_page_title() ) {
	raiderspirit_sc_layouts_showed('title', true);
	raiderspirit_sc_layouts_showed('postmeta', true);
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() )  {
							?><div class="sc_layouts_title_meta"><?php
								raiderspirit_show_post_meta(apply_filters('raiderspirit_filter_post_meta_args', array(
									'components' => raiderspirit_array_get_keys_by_value(raiderspirit_get_theme_option('meta_parts')),
									'counters' => raiderspirit_array_get_keys_by_value(raiderspirit_get_theme_option('counters')),
									'seo' => raiderspirit_is_on(raiderspirit_get_theme_option('seo_snippets'))
									), 'header', 1)
								);
							?></div><?php
						}
						
						// Blog/Post title
						?><div class="sc_layouts_title_title"><?php
							$raiderspirit_blog_title = raiderspirit_get_blog_title();
							$raiderspirit_blog_title_text = $raiderspirit_blog_title_class = $raiderspirit_blog_title_link = $raiderspirit_blog_title_link_text = '';
							if (is_array($raiderspirit_blog_title)) {
								$raiderspirit_blog_title_text = $raiderspirit_blog_title['text'];
								$raiderspirit_blog_title_class = !empty($raiderspirit_blog_title['class']) ? ' '.$raiderspirit_blog_title['class'] : '';
								$raiderspirit_blog_title_link = !empty($raiderspirit_blog_title['link']) ? $raiderspirit_blog_title['link'] : '';
								$raiderspirit_blog_title_link_text = !empty($raiderspirit_blog_title['link_text']) ? $raiderspirit_blog_title['link_text'] : '';
							} else
								$raiderspirit_blog_title_text = $raiderspirit_blog_title;
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr($raiderspirit_blog_title_class); ?>"><?php
								$raiderspirit_top_icon = raiderspirit_get_category_icon();
								if (!empty($raiderspirit_top_icon)) {
									$raiderspirit_attr = raiderspirit_getimagesize($raiderspirit_top_icon);
									?><img src="<?php echo esc_url($raiderspirit_top_icon); ?>" alt="<?php esc_attr_e('Icon', 'raiderspirit'); ?>" <?php if (!empty($raiderspirit_attr[3])) raiderspirit_show_layout($raiderspirit_attr[3]);?>><?php
								}
								echo wp_kses_post($raiderspirit_blog_title_text);
							?></h1>
							<?php
							if (!empty($raiderspirit_blog_title_link) && !empty($raiderspirit_blog_title_link_text)) {
								?><a href="<?php echo esc_url($raiderspirit_blog_title_link); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html($raiderspirit_blog_title_link_text); ?></a><?php
							}
							
							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) 
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
		
						?></div><?php
	
						// Breadcrumbs
						?><div class="sc_layouts_title_breadcrumbs"><?php
							do_action( 'raiderspirit_action_breadcrumbs');
						?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>