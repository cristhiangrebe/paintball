<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the WordPress editor or any Page Builder to make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$raiderspirit_content = '';
$raiderspirit_blog_archive_mask = '%%CONTENT%%';
$raiderspirit_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $raiderspirit_blog_archive_mask);
if ( have_posts() ) {
	the_post();
	if (($raiderspirit_content = apply_filters('the_content', get_the_content())) != '') {
		if (($raiderspirit_pos = strpos($raiderspirit_content, $raiderspirit_blog_archive_mask)) !== false) {
			$raiderspirit_content = preg_replace('/(\<p\>\s*)?'.$raiderspirit_blog_archive_mask.'(\s*\<\/p\>)/i', $raiderspirit_blog_archive_subst, $raiderspirit_content);
		} else
			$raiderspirit_content .= $raiderspirit_blog_archive_subst;
		$raiderspirit_content = explode($raiderspirit_blog_archive_mask, $raiderspirit_content);
		// Add VC custom styles to the inline CSS
		$vc_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( !empty( $vc_custom_css ) ) raiderspirit_add_inline_css(strip_tags($vc_custom_css));
	}
}

// Prepare args for a new query
$raiderspirit_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$raiderspirit_args = raiderspirit_query_add_posts_and_cats($raiderspirit_args, '', raiderspirit_get_theme_option('post_type'), raiderspirit_get_theme_option('parent_cat'));
$raiderspirit_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($raiderspirit_page_number > 1) {
	$raiderspirit_args['paged'] = $raiderspirit_page_number;
	$raiderspirit_args['ignore_sticky_posts'] = true;
}
$raiderspirit_ppp = raiderspirit_get_theme_option('posts_per_page');
if ((int) $raiderspirit_ppp != 0)
	$raiderspirit_args['posts_per_page'] = (int) $raiderspirit_ppp;
// Make a new main query
$GLOBALS['wp_the_query']->query($raiderspirit_args);


// Add internal query vars in the new query!
if (is_array($raiderspirit_content) && count($raiderspirit_content) == 2) {
	set_query_var('blog_archive_start', $raiderspirit_content[0]);
	set_query_var('blog_archive_end', $raiderspirit_content[1]);
}

get_template_part('index');
?>