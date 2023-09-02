<?php
/**
 * The template for homepage posts with "Portfolio" style
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
	
	// Show filters
	$raiderspirit_cat = raiderspirit_get_theme_option('parent_cat');
	$raiderspirit_post_type = raiderspirit_get_theme_option('post_type');
	$raiderspirit_taxonomy = raiderspirit_get_post_type_taxonomy($raiderspirit_post_type);
	$raiderspirit_show_filters = raiderspirit_get_theme_option('show_filters');
	$raiderspirit_tabs = array();
	if (!raiderspirit_is_off($raiderspirit_show_filters)) {
		$raiderspirit_args = array(
			'type'			=> $raiderspirit_post_type,
			'child_of'		=> $raiderspirit_cat,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'exclude'		=> '',
			'include'		=> '',
			'number'		=> '',
			'taxonomy'		=> $raiderspirit_taxonomy,
			'pad_counts'	=> false
		);
		$raiderspirit_portfolio_list = get_terms($raiderspirit_args);
		if (is_array($raiderspirit_portfolio_list) && count($raiderspirit_portfolio_list) > 0) {
			$raiderspirit_tabs[$raiderspirit_cat] = esc_html__('All', 'raiderspirit');
			foreach ($raiderspirit_portfolio_list as $raiderspirit_term) {
				if (isset($raiderspirit_term->term_id)) $raiderspirit_tabs[$raiderspirit_term->term_id] = $raiderspirit_term->name;
			}
		}
	}
	if (count($raiderspirit_tabs) > 0) {
		$raiderspirit_portfolio_filters_ajax = true;
		$raiderspirit_portfolio_filters_active = $raiderspirit_cat;
		$raiderspirit_portfolio_filters_id = 'portfolio_filters';
		?>
		<div class="portfolio_filters raiderspirit_tabs raiderspirit_tabs_ajax">
			<ul class="portfolio_titles raiderspirit_tabs_titles">
				<?php
				foreach ($raiderspirit_tabs as $raiderspirit_id=>$raiderspirit_title) {
					?><li><a href="<?php echo esc_url(raiderspirit_get_hash_link(sprintf('#%s_%s_content', $raiderspirit_portfolio_filters_id, $raiderspirit_id))); ?>" data-tab="<?php echo esc_attr($raiderspirit_id); ?>"><?php echo esc_html($raiderspirit_title); ?></a></li><?php
				}
				?>
			</ul>
			<?php
			$raiderspirit_ppp = raiderspirit_get_theme_option('posts_per_page');
			if (raiderspirit_is_inherit($raiderspirit_ppp)) $raiderspirit_ppp = '';
			foreach ($raiderspirit_tabs as $raiderspirit_id=>$raiderspirit_title) {
				$raiderspirit_portfolio_need_content = $raiderspirit_id==$raiderspirit_portfolio_filters_active || !$raiderspirit_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr(sprintf('%s_%s_content', $raiderspirit_portfolio_filters_id, $raiderspirit_id)); ?>"
					class="portfolio_content raiderspirit_tabs_content"
					data-blog-template="<?php echo esc_attr(raiderspirit_storage_get('blog_template')); ?>"
					data-blog-style="<?php echo esc_attr(raiderspirit_get_theme_option('blog_style')); ?>"
					data-posts-per-page="<?php echo esc_attr($raiderspirit_ppp); ?>"
					data-post-type="<?php echo esc_attr($raiderspirit_post_type); ?>"
					data-taxonomy="<?php echo esc_attr($raiderspirit_taxonomy); ?>"
					data-cat="<?php echo esc_attr($raiderspirit_id); ?>"
					data-parent-cat="<?php echo esc_attr($raiderspirit_cat); ?>"
					data-need-content="<?php echo (false===$raiderspirit_portfolio_need_content ? 'true' : 'false'); ?>"
				>
					<?php
					if ($raiderspirit_portfolio_need_content) 
						raiderspirit_show_portfolio_posts(array(
							'cat' => $raiderspirit_id,
							'parent_cat' => $raiderspirit_cat,
							'taxonomy' => $raiderspirit_taxonomy,
							'post_type' => $raiderspirit_post_type,
							'page' => 1,
							'sticky' => $raiderspirit_sticky_out
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		raiderspirit_show_portfolio_posts(array(
			'cat' => $raiderspirit_cat,
			'parent_cat' => $raiderspirit_cat,
			'taxonomy' => $raiderspirit_taxonomy,
			'post_type' => $raiderspirit_post_type,
			'page' => 1,
			'sticky' => $raiderspirit_sticky_out
			)
		);
	}

	raiderspirit_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>