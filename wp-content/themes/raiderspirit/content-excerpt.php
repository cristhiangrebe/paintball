<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0
 */

$raiderspirit_post_format = get_post_format();
$raiderspirit_post_format = empty($raiderspirit_post_format) ? 'standard' : str_replace('post-format-', '', $raiderspirit_post_format);
$raiderspirit_animation = raiderspirit_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt post_format_'.esc_attr($raiderspirit_post_format) ); ?>
	<?php echo (!raiderspirit_is_off($raiderspirit_animation) ? ' data-animation="'.esc_attr(raiderspirit_get_animation_classes($raiderspirit_animation)).'"' : ''); ?>
	><?php
	// Sticky label
	if ( is_sticky() && !is_paged() ) {
	?><span class="post_label label_sticky"></span><?php
	}
	?><div class="post_img"><?php



	do_action('raiderspirit_action_before_post_meta');

	// Post meta
	$raiderspirit_components = raiderspirit_array_get_keys_by_value(raiderspirit_get_theme_option('meta_parts'));

	if (!empty($raiderspirit_components))
		raiderspirit_show_post_meta(apply_filters('raiderspirit_filter_post_meta_args', array(
				'components' => $raiderspirit_components,
				'counters' => '',
				'seo' => false
			), 'excerpt', 1)
		);
	// Featured image
	raiderspirit_show_post_featured(array( 'thumb_size' => raiderspirit_get_thumb_size( strpos(raiderspirit_get_theme_option('body_style'), 'full')!==false ? 'full' : 'big' ) ));

		?></div><?php

	// Title and post meta
	if (get_the_title() != '') {
		?>
		<div class="post_header entry-header">
			<?php
			do_action('raiderspirit_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h2 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );


			?>
		</div><!-- .post_header --><?php
	}
	
	// Post content
	?><div class="post_content entry-content"><?php
		if (raiderspirit_get_theme_option('blog_content') == 'fullpost') {
			// Post content area
			?><div class="post_content_inner"><?php
				the_content( '' );
			?></div><?php
			// Inner pages
			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'raiderspirit' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'raiderspirit' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

		} else {

			$raiderspirit_show_learn_more = !in_array($raiderspirit_post_format, array('link', 'aside', 'status', 'quote'));

			// Post content area
			?><div class="post_content_inner"><?php
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
			?></div><div class="new_post_info"><?php
			do_action('raiderspirit_action_before_post_meta');

			// Post meta
			$raiderspirit_components = raiderspirit_array_get_keys_by_value(raiderspirit_get_theme_option('meta_parts'));
			$raiderspirit_counters = raiderspirit_array_get_keys_by_value(raiderspirit_get_theme_option('counters'));

			if (!empty($raiderspirit_components))
				raiderspirit_show_post_meta(apply_filters('raiderspirit_filter_post_meta_args', array(
						'components' => $raiderspirit_components,
						'counters' => $raiderspirit_counters,
						'seo' => false
					), 'excerpt', 1)
				);
			// More button
			if ( $raiderspirit_show_learn_more ) {
				?><p><a class="more-btn" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'raiderspirit'); ?></a></p><?php
			}

		}
	?></div></div><!-- .entry-content -->
</article>