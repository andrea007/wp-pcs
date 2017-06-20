<?php

	$custom_settings=false;	
	$post_title_layout=false;
	
	if($post_id) {
		$post_title_layout=get_post_meta($post_id, 'eventerra_page_title', true);
		if($post_title_layout) {
			$custom_settings=true;
		} else {
			$post_title_layout=get_option('eventerra_default_page_title');
		}
	} else {
		$post_title_layout=get_option('eventerra_default_page_title');
	}
	if(!$post_title_layout) {
		$post_title_layout='standard';
	}
	
	if($post_title_layout != 'hide') {

		if($custom_settings) {
			$post_title_align=get_post_meta($post_id, 'eventerra_title_align', true);
			$post_title_alternative_text=get_post_meta($post_id, 'eventerra_title_alternative_text', true);
			$post_title_subtitle=get_post_meta($post_id, 'eventerra_title_subtitle', true);
		} else {
			$post_title_align=get_option('eventerra_default_title_align');
			$post_title_alternative_text='';
			$post_title_subtitle='';
		}

		$classes=array(
			'page-title-wrapper',
		);
		$classes[]='tpl-'.$post_title_layout;
		
		if($post_title_align && $post_title_layout != 'shadow') {
			$classes[]='title-align-'.$post_title_align;
		}

		if($post_title_alternative_text != '') {
			$post_title_alternative_text=preg_replace('/\[color1\]([\s\S]*?)\[\/color1\]/i','<span class="text-color-accent-1">$1</span>',$post_title_alternative_text);
			$post_title_alternative_text=preg_replace('/\[color2\]([\s\S]*?)\[\/color2\]/i','<span class="text-color-accent-2">$1</span>',$post_title_alternative_text);
			$post_title_alternative_text=preg_replace('/\[color3\]([\s\S]*?)\[\/color3\]/i','<span class="text-color-accent-3">$1</span>',$post_title_alternative_text);
			$post_title=$post_title_alternative_text;
		}
		
		if($post_title_layout == 'shadow') {
			$post_title_shadow_text=get_post_meta($post_id, 'eventerra_title_shadow_text', true);
			if($post_title_shadow_text == '') {
				$post_title_shadow_text=preg_replace('/<[^>]*?>/','',$post_title);
			}
		}
		
		?>
			<div class="<?php echo esc_attr(implode(' ',$classes)) ?>">
				<?php if($post_title_layout == 'shadow') { ?>
					<div class="page-title-shadow"><?php echo esc_html($post_title_shadow_text) ?></div>
				<?php } ?>
				<div class="page-title-inner">
					<?php if(get_option('eventerra_show_breadcrumbs') == 'true') { ?>
						<?php eventerra_breadcrumbs(get_option('eventerra_breadcrumbs_caption')) ?>
					<?php } ?>
					<h1 class="page-title entry-title"><?php echo wp_kses($post_title,array('span' => array('class' => array()))) ?></h1>
					<?php if($post_title_subtitle != '') { ?>
						<div class="page-title-subtitle"><?php echo esc_html($post_title_subtitle) ?></div>
					<?php } ?>
				</div>
			</div>		
		<?php
		
	}
	
	
	