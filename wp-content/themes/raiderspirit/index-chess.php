<?php
/**
 * The template for homepage posts with "Chess" style
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0
 */

raiderspirit_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	raiderspirit_show_layout(get_query_var('blog_archive_start'));

	$raiderspirit_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$raiderspirit_sticky_out = raiderspirit_get_theme_option('sticky_style')=='columns' 
							&& is_array($raiderspirit_stickies) && count($raiderspirit_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($raiderspirit_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	if (!$raiderspirit_sticky_out) {
		?><div class="chess_wrap posts_container"><?php
	}
	while ( have_posts() ) { the_post(); 
		if ($raiderspirit_sticky_out && !is_sticky()) {
			$raiderspirit_sticky_out = false;
			?></div><div class="chess_wrap posts_container"><?php
		}
		get_template_part( 'content', $raiderspirit_sticky_out && is_sticky() ? 'sticky' :'chess' );
	}
	
	?></div><?php

	raiderspirit_show_pagination();

	raiderspirit_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>