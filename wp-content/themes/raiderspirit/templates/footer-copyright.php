<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage RAIDERSPIRIT
 * @since RAIDERSPIRIT 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap<?php
				if (!raiderspirit_is_inherit(raiderspirit_get_theme_option('copyright_scheme')))
					echo ' scheme_' . esc_attr(raiderspirit_get_theme_option('copyright_scheme'));
 				?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text"><?php
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$raiderspirit_copyright = raiderspirit_prepare_macros(raiderspirit_get_theme_option('copyright'));
				if (!empty($raiderspirit_copyright)) {
					// Replace {date_format} on the current date in the specified format
					if (preg_match("/(\\{[\\w\\d\\\\\\-\\:]*\\})/", $raiderspirit_copyright, $raiderspirit_matches)) {
						$raiderspirit_copyright = str_replace($raiderspirit_matches[1], date_i18n(str_replace(array('{', '}'), '', $raiderspirit_matches[1])), $raiderspirit_copyright);
						$raiderspirit_copyright = str_replace(array('{{Y}}', '{Y}'), date('Y'), $raiderspirit_copyright);
					}
					// Display copyright
					echo wp_kses_data(nl2br($raiderspirit_copyright));
				}
			?></div>
		</div>
	</div>
</div>
