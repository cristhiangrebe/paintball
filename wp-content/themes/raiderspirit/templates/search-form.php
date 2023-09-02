<?php
$raiderspirit_args = array_merge(array(
								'style' => 'normal',
								'class' => '',
								'ajax' => false
								), (array) get_query_var('raiderspirit_search_args'));
?><div class="search_wrap search_style_<?php
								echo esc_attr($raiderspirit_args['style']) 
									. (!empty($raiderspirit_args['class']) ? ' '.esc_attr($raiderspirit_args['class']) : '');
?>">
	<div class="search_form_wrap">
		<form role="search" method="get" class="search_form" action="<?php echo esc_url(home_url('/')); ?>">
			<input type="text" class="search_field fill_inited" placeholder="Buscar" value name="s"> 
			<button type="submit" class="search_submit trx_addons_icon-search"></button>
		</form>
	</div>
</div>