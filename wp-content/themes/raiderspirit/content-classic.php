<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0
 */

$raiderspirit_blog_style = explode('_', raiderspirit_get_theme_option('blog_style'));
$raiderspirit_columns = empty($raiderspirit_blog_style[1]) ? 2 : max(2, $raiderspirit_blog_style[1]);
$raiderspirit_expanded = !raiderspirit_sidebar_present() && raiderspirit_is_on(raiderspirit_get_theme_option('expand_content'));
$raiderspirit_post_format = get_post_format();
$raiderspirit_post_format = empty($raiderspirit_post_format) ? 'standard' : str_replace('post-format-', '', $raiderspirit_post_format);
$raiderspirit_animation = raiderspirit_get_theme_option('blog_animation');
$raiderspirit_components = raiderspirit_array_get_keys_by_value(raiderspirit_get_theme_option('meta_parts'));
$raiderspirit_counters = raiderspirit_array_get_keys_by_value(raiderspirit_get_theme_option('counters'));

?><div class="<?php
if ( ! empty( $raiderspirit_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( 'classic' == $raiderspirit_blog_style[0] ? 'column' : 'masonry_item masonry_item' ) . '-1_' . esc_attr( $raiderspirit_columns );
}
?>"><article id="post-<?php the_ID(); ?>"
	<?php post_class( 'post_item post_format_'.esc_attr($raiderspirit_post_format)
					. ' post_layout_classic post_layout_classic_'.esc_attr($raiderspirit_columns)
					. ' post_layout_'.esc_attr($raiderspirit_blog_style[0]) 
					. ' post_layout_'.esc_attr($raiderspirit_blog_style[0]).'_'.esc_attr($raiderspirit_columns)
					); ?>
	<?php echo (!raiderspirit_is_off($raiderspirit_animation) ? ' data-animation="'.esc_attr(raiderspirit_get_animation_classes($raiderspirit_animation)).'"' : ''); ?>><div class="post_img">
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	do_action('raiderspirit_action_before_post_meta');

	// Post meta
	if (!empty($raiderspirit_components))
		raiderspirit_show_post_meta(apply_filters('raiderspirit_filter_post_meta_args', array(
				'components' => $raiderspirit_components,
				'counters' => '',
				'seo' => false
			), $raiderspirit_blog_style[0], $raiderspirit_columns)
		);

	do_action('raiderspirit_action_after_post_meta');

	// Featured image
	raiderspirit_show_post_featured( array( 'thumb_size' => raiderspirit_get_thumb_size($raiderspirit_blog_style[0] == 'classic'
													? (strpos(raiderspirit_get_theme_option('body_style'), 'full')!==false 
															? ( $raiderspirit_columns > 2 ? 'big' : 'huge' )
															: (	$raiderspirit_columns > 2
																? ($raiderspirit_expanded ? 'med' : 'small')
																: ($raiderspirit_expanded ? 'big' : 'med')
																)
														)
													: (strpos(raiderspirit_get_theme_option('body_style'), 'full')!==false 
															? ( $raiderspirit_columns > 2 ? 'masonry-big' : 'full' )
															: (	$raiderspirit_columns <= 2 && $raiderspirit_expanded ? 'masonry-big' : 'masonry')
														)
								) ) );?></div><?php

	if ( !in_array($raiderspirit_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php 
			do_action('raiderspirit_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );


			?>
		</div><!-- .entry-header -->
		<?php
	}		
	?>

	<div class="post_content entry-content">
		<div class="post_content_inner">
			<?php
			$raiderspirit_show_learn_more = false;
			if (has_excerpt()) {
				the_excerpt();
			} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
				the_content( '' );
			} else if (in_array($raiderspirit_post_format, array('link', 'aside', 'status'))) {
				the_content();
			} else if ($raiderspirit_post_format == 'quote') {
				if (($quote = raiderspirit_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
					raiderspirit_show_layout(wpautop($quote));
				else
					the_excerpt();
			} else if (substr(get_the_content(), 0, 1)!='[') {
				the_excerpt();
			}
			?>
		</div><div class="new_post_info">
		<?php
		do_action('raiderspirit_action_before_post_meta');

		// Post meta
		if (!empty($raiderspirit_components))
			raiderspirit_show_post_meta(apply_filters('raiderspirit_filter_post_meta_args', array(
					'components' => $raiderspirit_components,
					'counters' => $raiderspirit_counters,
					'seo' => false
				), $raiderspirit_blog_style[0], $raiderspirit_columns)
			);

		do_action('raiderspirit_action_after_post_meta');
		// More button
		if ( $raiderspirit_show_learn_more ) {
			?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'raiderspirit'); ?></a></p><?php
		}
		?></div>
	</div><!-- .entry-content -->

</article></div>