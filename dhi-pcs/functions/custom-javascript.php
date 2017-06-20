<?php

if ( !function_exists( 'eventerra_custom_front_javascript' ) ) {
	function eventerra_custom_front_javascript() {
		
		$jquery='';
		
		// Lightbox
		$lightbox=get_option('eventerra_prettyphoto_lightbox');
		if(!$lightbox)
			$lightbox='enabled';
			
		if($lightbox == 'enabled') {
			$social_tools=get_option('eventerra_prettyphoto_social_tools');
			$overlay_gallery=get_option('eventerra_prettyphoto_overlay_gallery');
			
			$args=array();
			if(get_option('eventerra_prettyphoto_social_tools') != 'true')
				$args[]='social_tools: ""';
			if(get_option('eventerra_prettyphoto_show_title') == 'false')
				$args[]='show_title: false';
			if(get_option('eventerra_prettyphoto_overlay_gallery') == 'true')
				$args[]='overlay_gallery: true';
			else
				$args[]='overlay_gallery: false';
				
			$jquery.='lightbox_init({'.implode(',',$args).'});';
		}
		
		// Sidebar Sliding
		if(get_option("eventerra_sidebar_sliding") == 'true') {
			$jquery.='sidebar_slide_init();';
		}
		
		// Page out animation
		if(get_option("eventerra_enable_page_out_animation") == 'true') {
			$jquery.='page_out_init();';
		}
		
		// Page out animation
		if(get_option('eventerra_enable_local_scroll') == 'true') {
			$jquery.='om_local_scroll_init();';
		}
		
		return 'jQuery(function(){'.$jquery.'});';
		
	}
}

function eventerra_custom_front_javascript_add_inline() {
	wp_add_inline_script('eventerra-custom', eventerra_custom_front_javascript());
}

function eventerra_custom_front_javascript_fallback() {
	echo '<script>'.eventerra_custom_front_javascript().'</script>';
}

if(function_exists('wp_add_inline_script')) {
	add_action('wp_enqueue_scripts', 'eventerra_custom_front_javascript_add_inline');
} else {
	add_action('wp_head', 'eventerra_custom_front_javascript_fallback');
}