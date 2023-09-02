<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0.14
 */
$raiderspirit_header_video = raiderspirit_get_header_video();
$raiderspirit_embed_video = '';
if (!empty($raiderspirit_header_video) && !raiderspirit_is_from_uploads($raiderspirit_header_video)) {
	if (raiderspirit_is_youtube_url($raiderspirit_header_video) && preg_match('/[=\/]([^=\/]*)$/', $raiderspirit_header_video, $matches) && !empty($matches[1])) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr($matches[1]); ?>"></div><?php
	} else {
		global $wp_embed;
		if (false && is_object($wp_embed)) {
			$raiderspirit_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($raiderspirit_header_video) . '[/embed]' ));
			$raiderspirit_embed_video = raiderspirit_make_video_autoplay($raiderspirit_embed_video);
		} else {
			$raiderspirit_header_video = str_replace('/watch?v=', '/embed/', $raiderspirit_header_video);
			$raiderspirit_header_video = raiderspirit_add_to_url($raiderspirit_header_video, array(
				'feature' => 'oembed',
				'controls' => 0,
				'autoplay' => 1,
				'showinfo' => 0,
				'modestbranding' => 1,
				'wmode' => 'transparent',
				'enablejsapi' => 1,
				'origin' => home_url(),
				'widgetid' => 1
			));
			$raiderspirit_embed_video = '<iframe src="' . esc_url($raiderspirit_header_video) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?><div id="background_video"><?php raiderspirit_show_layout($raiderspirit_embed_video); ?></div><?php
	}
}
?>