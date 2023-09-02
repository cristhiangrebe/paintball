<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0
 */

$raiderspirit_link = get_permalink();
$raiderspirit_post_format = get_post_format();
$raiderspirit_post_format = empty($raiderspirit_post_format) ? 'standard' : str_replace('post-format-', '', $raiderspirit_post_format);
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_1 post_format_'.esc_attr($raiderspirit_post_format) ); ?>><?php
	raiderspirit_show_post_featured(array(
		'thumb_size' => apply_filters('raiderspirit_filter_related_thumb_size', raiderspirit_get_thumb_size( (int) raiderspirit_get_theme_option('related_posts') == 1 ? 'huge' : 'big' )),
		'show_no_image' => raiderspirit_get_theme_setting('allow_no_image'),
		'singular' => false,
		'post_info' => '<div class="post_header entry-header">'
							. '<div class="post_categories">'.wp_kses_post(raiderspirit_get_post_categories('')).'</div>'
							. '<h6 class="post_title entry-title"><a href="'.esc_url($raiderspirit_link).'">'.esc_html(get_the_title()).'</a></h6>'
							. (in_array(get_post_type(), array('post', 'attachment'))
									? '<span class="post_date"><a href="'.esc_url($raiderspirit_link).'">'.wp_kses_data(raiderspirit_get_date()).'</a></span>'
									: '')
						. '</div>'
		)
	);
?></div>