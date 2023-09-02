<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0
 */

$raiderspirit_columns = max(1, min(3, count(get_option( 'sticky_posts' ))));
$raiderspirit_post_format = get_post_format();
$raiderspirit_post_format = empty($raiderspirit_post_format) ? 'standard' : str_replace('post-format-', '', $raiderspirit_post_format);
$raiderspirit_animation = raiderspirit_get_theme_option('blog_animation');

?><div class="column-1_<?php echo esc_attr($raiderspirit_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_'.esc_attr($raiderspirit_post_format) ); ?>
	<?php echo (!raiderspirit_is_off($raiderspirit_animation) ? ' data-animation="'.esc_attr(raiderspirit_get_animation_classes($raiderspirit_animation)).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	raiderspirit_show_post_featured(array(
		'thumb_size' => raiderspirit_get_thumb_size($raiderspirit_columns==1 ? 'big' : ($raiderspirit_columns==2 ? 'med' : 'avatar'))
	));

	if ( !in_array($raiderspirit_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			raiderspirit_show_post_meta(apply_filters('raiderspirit_filter_post_meta_args', array(), 'sticky', $raiderspirit_columns));
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div>