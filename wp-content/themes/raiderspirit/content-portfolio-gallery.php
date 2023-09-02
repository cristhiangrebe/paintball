<?php
/**
 * The Gallery template to display posts
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0
 */

$raiderspirit_blog_style = explode('_', raiderspirit_get_theme_option('blog_style'));
$raiderspirit_columns = empty($raiderspirit_blog_style[1]) ? 2 : max(2, $raiderspirit_blog_style[1]);
$raiderspirit_post_format = get_post_format();
$raiderspirit_post_format = empty($raiderspirit_post_format) ? 'standard' : str_replace('post-format-', '', $raiderspirit_post_format);
$raiderspirit_animation = raiderspirit_get_theme_option('blog_animation');
$raiderspirit_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_gallery post_layout_gallery_'.esc_attr($raiderspirit_columns).' post_format_'.esc_attr($raiderspirit_post_format) ); ?>
	<?php echo (!raiderspirit_is_off($raiderspirit_animation) ? ' data-animation="'.esc_attr(raiderspirit_get_animation_classes($raiderspirit_animation)).'"' : ''); ?>
	data-size="<?php if (!empty($raiderspirit_image[1]) && !empty($raiderspirit_image[2])) echo intval($raiderspirit_image[1]) .'x' . intval($raiderspirit_image[2]); ?>"
	data-src="<?php if (!empty($raiderspirit_image[0])) echo esc_url($raiderspirit_image[0]); ?>"
	>

	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	$raiderspirit_image_hover = 'icon';
	if (in_array($raiderspirit_image_hover, array('icons', 'zoom'))) $raiderspirit_image_hover = 'dots';
	$raiderspirit_components = raiderspirit_array_get_keys_by_value(raiderspirit_get_theme_option('meta_parts'));
	$raiderspirit_counters = raiderspirit_array_get_keys_by_value(raiderspirit_get_theme_option('counters'));
	raiderspirit_show_post_featured(array(
		'hover' => $raiderspirit_image_hover,
		'thumb_size' => raiderspirit_get_thumb_size( strpos(raiderspirit_get_theme_option('body_style'), 'full')!==false || $raiderspirit_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only' => true,
		'show_no_image' => true,
		'post_info' => '<div class="post_details">'
							. '<h2 class="post_title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) . '</a></h2>'
							. '<div class="post_description">'
								. (!empty($raiderspirit_components)
										? raiderspirit_show_post_meta(apply_filters('raiderspirit_filter_post_meta_args', array(
											'components' => $raiderspirit_components,
											'counters' => $raiderspirit_counters,
											'seo' => false,
											'echo' => false
											), $raiderspirit_blog_style[0], $raiderspirit_columns))
										: '')
								. '<div class="post_description_content">'
									. apply_filters('the_excerpt', get_the_excerpt())
								. '</div>'
								. '<a href="'.esc_url(get_permalink()).'" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__('Learn more', 'raiderspirit') . '</span></a>'
							. '</div>'
						. '</div>'
	));
	?>
</article>