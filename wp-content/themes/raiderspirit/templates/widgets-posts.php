<?php
/**
 * The template to display posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0
 */

$raiderspirit_post_id    = get_the_ID();
$raiderspirit_post_date  = raiderspirit_get_date();
$raiderspirit_post_title = get_the_title();
$raiderspirit_post_link  = get_permalink();
$raiderspirit_post_author_id   = get_the_author_meta('ID');
$raiderspirit_post_author_name = get_the_author_meta('display_name');
$raiderspirit_post_author_url  = get_author_posts_url($raiderspirit_post_author_id, '');

$raiderspirit_args = get_query_var('raiderspirit_args_widgets_posts');
$raiderspirit_show_date = isset($raiderspirit_args['show_date']) ? (int) $raiderspirit_args['show_date'] : 1;
$raiderspirit_show_image = isset($raiderspirit_args['show_image']) ? (int) $raiderspirit_args['show_image'] : 1;
$raiderspirit_show_author = isset($raiderspirit_args['show_author']) ? (int) $raiderspirit_args['show_author'] : 1;
$raiderspirit_show_counters = isset($raiderspirit_args['show_counters']) ? (int) $raiderspirit_args['show_counters'] : 1;
$raiderspirit_show_categories = isset($raiderspirit_args['show_categories']) ? (int) $raiderspirit_args['show_categories'] : 1;

$raiderspirit_output = raiderspirit_storage_get('raiderspirit_output_widgets_posts');

$raiderspirit_post_counters_output = '';
if ( $raiderspirit_show_counters ) {
	$raiderspirit_post_counters_output = '<span class="post_info_item post_info_counters">'
								. raiderspirit_get_post_counters('comments')
							. '</span>';
}


$raiderspirit_output .= '<article class="post_item with_thumb">';

if ($raiderspirit_show_image) {
	$raiderspirit_post_thumb = get_the_post_thumbnail($raiderspirit_post_id, raiderspirit_get_thumb_size('tiny'), array(
		'alt' => get_the_title()
	));
	if ($raiderspirit_post_thumb) $raiderspirit_output .= '<div class="post_thumb">' . ($raiderspirit_post_link ? '<a href="' . esc_url($raiderspirit_post_link) . '">' : '') . ($raiderspirit_post_thumb) . ($raiderspirit_post_link ? '</a>' : '') . '</div>';
}

$raiderspirit_output .= '<div class="post_content">'
			. ($raiderspirit_show_categories 
					? '<div class="post_categories">'
						. raiderspirit_get_post_categories()
						. $raiderspirit_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($raiderspirit_post_link ? '<a href="' . esc_url($raiderspirit_post_link) . '">' : '') . ($raiderspirit_post_title) . ($raiderspirit_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('raiderspirit_filter_get_post_info', 
								'<div class="post_info">'
									. ($raiderspirit_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($raiderspirit_post_link ? '<a href="' . esc_url($raiderspirit_post_link) . '" class="post_info_date">' : '') 
											. esc_html($raiderspirit_post_date) 
											. ($raiderspirit_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($raiderspirit_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'raiderspirit') . ' ' 
											. ($raiderspirit_post_link ? '<a href="' . esc_url($raiderspirit_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($raiderspirit_post_author_name) 
											. ($raiderspirit_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$raiderspirit_show_categories && $raiderspirit_post_counters_output
										? $raiderspirit_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
raiderspirit_storage_set('raiderspirit_output_widgets_posts', $raiderspirit_output);
?>