<?php
/**
 * The Portfolio template to display the content
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

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($raiderspirit_columns).' post_format_'.esc_attr($raiderspirit_post_format).(is_sticky() && !is_paged() ? ' sticky' : '') ); ?>
	<?php echo (!raiderspirit_is_off($raiderspirit_animation) ? ' data-animation="'.esc_attr(raiderspirit_get_animation_classes($raiderspirit_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$raiderspirit_image_hover = raiderspirit_get_theme_option('image_hover');
	// Featured image
	raiderspirit_show_post_featured(array(
		'thumb_size' => raiderspirit_get_thumb_size(strpos(raiderspirit_get_theme_option('body_style'), 'full')!==false || $raiderspirit_columns < 3 
								? 'masonry-big' 
								: 'masonry'),
		'show_no_image' => true,
		'class' => $raiderspirit_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $raiderspirit_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>