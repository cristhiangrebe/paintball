<?php
/**
 * The default template to display the content of the single post, page or attachment
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0
 */

$raiderspirit_seo = raiderspirit_is_on(raiderspirit_get_theme_option('seo_snippets'));
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post_item_single post_type_'.esc_attr(get_post_type()) 
												. ' post_format_'.esc_attr(str_replace('post-format-', '', get_post_format())) 
												);
		if ($raiderspirit_seo) {
			?> itemscope="itemscope" 
			   itemprop="articleBody" 
			   itemtype="http://schema.org/<?php echo esc_attr(raiderspirit_get_markup_schema()); ?>" 
			   itemid="<?php echo esc_url(get_the_permalink()); ?>"
			   content="<?php echo esc_attr(get_the_title()); ?>"<?php
		}
?>><?php

	do_action('raiderspirit_action_before_post_data'); 

	// Structured data snippets
	if ($raiderspirit_seo)
		get_template_part('templates/seo');
	?><div class="new_post_cat"><?php
	// Post meta
	if (!raiderspirit_sc_layouts_showed('postmeta') && raiderspirit_is_on(raiderspirit_get_theme_option('show_post_meta'))) {
		raiderspirit_show_post_meta(apply_filters('raiderspirit_filter_post_meta_args', array(
				'components' => raiderspirit_array_get_keys_by_value(raiderspirit_get_theme_option('meta_parts')),
				'counters' => '',
				'seo' => raiderspirit_is_on(raiderspirit_get_theme_option('seo_snippets'))
			), 'single', 1)
		);
	}

	// Featured image
	if ( raiderspirit_is_off(raiderspirit_get_theme_option('hide_featured_on_single'))
			&& !raiderspirit_sc_layouts_showed('featured') 
			&& strpos(get_the_content(), '[trx_widget_banner]')===false) {
		do_action('raiderspirit_action_before_post_featured'); 
		raiderspirit_show_post_featured();
		do_action('raiderspirit_action_after_post_featured'); 
	} else if (has_post_thumbnail()) {
		?><meta itemprop="image" itemtype="http://schema.org/ImageObject" content="<?php echo esc_url(wp_get_attachment_url(get_post_thumbnail_id())); ?>"><?php
	}
		?></div><?php

	// Title and post meta
	if ( (!raiderspirit_sc_layouts_showed('title') || !raiderspirit_sc_layouts_showed('postmeta')) && !in_array(get_post_format(), array('link', 'aside', 'status', 'quote')) ) {
		do_action('raiderspirit_action_before_post_title'); 
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if (!raiderspirit_sc_layouts_showed('title')) {
				the_title( '<h3 class="post_title entry-title"'.($raiderspirit_seo ? ' itemprop="headline"' : '').'>', '</h3>' );
			}
			?><a class="author_link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php
				// Translators: Add the author's name in the <span>
				printf( esc_html__( 'by %s', 'raiderspirit' ), '<span class="author_name">' . esc_html(get_the_author()) . '</span>' );
				?></a><?php
			// Post meta
			if (!raiderspirit_sc_layouts_showed('postmeta') && raiderspirit_is_on(raiderspirit_get_theme_option('show_post_meta'))) {
				raiderspirit_show_post_meta(apply_filters('raiderspirit_filter_post_meta_args', array(
					'components' => raiderspirit_array_get_keys_by_value(raiderspirit_get_theme_option('meta_parts')),
					'counters' => raiderspirit_array_get_keys_by_value(raiderspirit_get_theme_option('counters')),
					'seo' => raiderspirit_is_on(raiderspirit_get_theme_option('seo_snippets'))
					), 'single', 1)
				);
			}
			?>
		</div><!-- .post_header -->
		<?php
		do_action('raiderspirit_action_after_post_title'); 
	}

	do_action('raiderspirit_action_before_post_content'); 

	// Post content
	?>
	<div class="post_content entry-content" itemprop="mainEntityOfPage">
		<?php
		the_content( );

		do_action('raiderspirit_action_before_post_pagination'); 

		wp_link_pages( array(
			'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'raiderspirit' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'raiderspirit' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );

		// Taxonomies and share
		if ( is_single() && !is_attachment() ) {
			
			do_action('raiderspirit_action_before_post_meta'); 

			?><div class="post_meta post_meta_single"><?php
				
				// Post taxonomies
				the_tags( '<span class="post_meta_item post_tags"><span class="post_meta_label">'.esc_html__('Tags:', 'raiderspirit').'</span> ', ', ', '</span>' );

				// Share
				if (raiderspirit_is_on(raiderspirit_get_theme_option('show_share_links'))) {
					raiderspirit_show_share_links(array(
							'type' => 'block',
							'caption' => '',
							'before' => '<span class="post_meta_item post_share">',
							'after' => '</span>'
						));
				}
			?></div><?php

			do_action('raiderspirit_action_after_post_meta'); 
		}
		?>
	</div><!-- .entry-content -->
	

	<?php
	do_action('raiderspirit_action_after_post_content'); 

	// Author bio.
	if ( raiderspirit_get_theme_option('show_author_info')==1 && is_single() && !is_attachment() && get_the_author_meta( 'description' ) ) {
		do_action('raiderspirit_action_before_post_author'); 
		get_template_part( 'templates/author-bio' );
		do_action('raiderspirit_action_after_post_author'); 
	}

	do_action('raiderspirit_action_after_post_data'); 
	?>
</article>
