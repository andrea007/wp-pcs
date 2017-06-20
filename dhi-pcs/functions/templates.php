<?php

/**
 * Header Slider
 */

if(!function_exists('eventerra_tpl_header_slider')) {
	function eventerra_tpl_header_slider($slider) {
		
		include EVENTERRA_TEMPLATE_DIR . '/includes/header-slider.php';
		
	}
}

/**
 * Page title
 */

if(!function_exists('eventerra_tpl_page_title')) {
	function eventerra_tpl_page_title($post_id, $post_title) {
		
		include EVENTERRA_TEMPLATE_DIR . '/includes/page-title.php';
		
	}
}

/**
 * Blog post
 */

if(!function_exists('eventerra_tpl_blog_post')) {
	function eventerra_tpl_blog_post($layout, $format) {
		
		get_template_part( 'includes/post-header-'.$layout, $format );
		get_template_part( 'includes/post-media-'.$layout, $format );
		get_template_part( 'includes/post-footer-'.$layout, $format );
		
	}
}