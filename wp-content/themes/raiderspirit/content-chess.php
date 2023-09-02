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
$raiderspirit_columns = empty($raiderspirit_blog_style[1]) ? 1 : max(1, $raiderspirit_blog_style[1]);
$raiderspirit_expanded = !raiderspirit_sidebar_present() && raiderspirit_is_on(raiderspirit_get_theme_option('expand_content'));
$raiderspirit_post_format = get_post_format();
$raiderspirit_post_format = empty($raiderspirit_post_format) ? 'standard' : str_replace('post-format-', '', $raiderspirit_post_format);
$raiderspirit_animation = raiderspirit_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_chess post_layout_chess_'.esc_attr($raiderspirit_columns).' post_format_'.esc_attr($raiderspirit_post_format) ); ?>
	<?php echo (!raiderspirit_is_off($raiderspirit_animation) ? ' data-animation="'.esc_attr(raiderspirit_get_animation_classes($raiderspirit_animation)).'"' : ''); ?>>

	<?php
	// Add anchor
	if ($raiderspirit_columns == 1 && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="post_'.esc_attr(get_the_ID()).'" title="'.esc_attr(get_the_title()).'" icon="'.esc_attr(raiderspirit_get_post_icon()).'"]');
	}

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	raiderspirit_show_post_featured( array(
											'class' => $raiderspirit_columns == 1 ? 'raiderspirit-full-height' : '',
											'show_no_image' => true,
											'thumb_bg' => true,
											'thumb_size' => raiderspirit_get_thumb_size(
																	strpos(raiderspirit_get_theme_option('body_style'), 'full')!==false
																		? ( $raiderspirit_columns > 1 ? 'huge' : 'original' )
																		: (	$raiderspirit_columns > 2 ? 'big' : 'huge')
																	)
											) 
										);

	?><div class="post_inner"><div class="post_inner_content"><?php 

		?><div class="post_header entry-header"><?php 
			do_action('raiderspirit_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			
			do_action('raiderspirit_action_before_post_meta'); 

			// Post meta
			$raiderspirit_components = raiderspirit_array_get_keys_by_value(raiderspirit_get_theme_option('meta_parts'));
			$raiderspirit_counters = raiderspirit_array_get_keys_by_value(raiderspirit_get_theme_option('counters'));
			$raiderspirit_post_meta = empty($raiderspirit_components) 
										? '' 
										: raiderspirit_show_post_meta(apply_filters('raiderspirit_filter_post_meta_args', array(
												'components' => $raiderspirit_components,
												'counters' => $raiderspirit_counters,
												'seo' => false,
												'echo' => false
												), $raiderspirit_blog_style[0], $raiderspirit_columns)
											);
			raiderspirit_show_layout($raiderspirit_post_meta);
		?></div><!-- .entry-header -->
	
		<div class="post_content entry-content">
			<div class="post_content_inner">
				<?php
				$raiderspirit_show_learn_more = !in_array($raiderspirit_post_format, array('link', 'aside', 'status', 'quote'));
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
			</div>
			<?php
			// Post meta
			if (in_array($raiderspirit_post_format, array('link', 'aside', 'status', 'quote'))) {
				raiderspirit_show_layout($raiderspirit_post_meta);
			}
			// More button
			if ( $raiderspirit_show_learn_more ) {
				?><p><a class="more-btn" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'raiderspirit'); ?></a></p><?php
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article>