<?php

/**
 * Sort WPB Elements
 */

function eventerra_wpb_sort_elements() {
	$elements = array (
		'vc_row',
		'vc_section',
		'vc_column_text',
		'vc_icon',
		'vc_separator',
		'vc_text_separator',
		'vc_message',
		'vc_facebook',
		'vc_tweetmeme',
		'vc_googleplus',
		'vc_pinterest',
		'vc_toggle',
		'vc_single_image',
		'vc_gallery',
		'vc_images_carousel',
		'vc_tta_tabs',
		'vc_tta_tour',
		'vc_tta_accordion',
		'vc_tta_pageable',
		'vc_custom_heading',
		'vc_btn',
		'vc_cta',
		'vc_video',
		'vc_gmaps',
		'vc_raw_html',
		'vc_raw_js',
		'vc_flickr',
		'vc_progress_bar',
		'vc_pie',
		'vc_round_chart',
		'vc_line_chart',
		'vc_empty_space',
		'om_reduce_space',

		'om_agenda',
		'om_speakers',
		'om_testimonials',
		'om_logos',
		'om_posts',
		'om_html_table',
		'om_list',
		'om_click_box',
		'om_click_icon_box',
		'om_max_width',
		
		'contact-form-7',
	);
	
	$elements=array_reverse($elements);
	$w=10;
	foreach($elements as $v) {
		if(WPBMap::exists($v)) {
			vc_map_update($v, array( 'weight' => $w ));
			$w+=10;
		}
	}
}

add_action( 'init', 'eventerra_wpb_sort_elements' );

/**
 * Widget Titles
 */
 

function eventerra_wpb_widget_title( $title, $params = array( 'title' => '' ) ) {
	if ( $params['title'] == '' ) return;

	$extraclass = ( isset( $params['extraclass'] ) ) ? " " . $params['extraclass'] : "";
	$output = '<h3 class="wpb_heading' . $extraclass . '">' . $params['title'] . '</h3>';

	return $output;
}
add_filter('wpb_widget_title', 'eventerra_wpb_widget_title', 10, 2);

/**
 * Other shortcodes
 */

add_filter(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'eventerra_wpb_vc_shortcodes_css_class', 10, 3);

function eventerra_wpb_vc_shortcodes_css_class($class, $tag, $atts = array()) {

	switch($tag) {
		
		case 'vc_video':
			if(isset($atts['remove_margins']) && $atts['remove_margins'] == 'yes' && $atts['el_width'] == '100')
				$class.=' om-remove-margins';
		break;

		case 'vc_gmaps':
			if(isset($atts['remove_margins']) && $atts['remove_margins'] == 'yes')
				$class.=' om-remove-margins';
		break;
		
		case 'vc_round_chart':
		case 'vc_line_chart':

			if(isset($atts['max_width']))
				$class.=' om-max-width-'.$atts['max_width'];
		
		break;
		
		case 'vc_empty_space':
			if(isset($atts['mobile_hide']) && $atts['mobile_hide'] == 'yes')
				$class.=' om-mobile-hidden';
		break;
	}
	
	return $class;
	
}

/**
 * Deprecated animations
 */

function eventerra_wpb_add_deprecated_animations( $data ) {
	if(isset($data['settings']['custom'][0]['values'])) {
		$data['settings']['custom'][0]['values'] = array_merge( $data['settings']['custom'][0]['values'], array(
			esc_html__( 'Bounce', 'eventerra' )                => 'bounce',
			esc_html__( 'Fade In', 'eventerra' )               => 'fade-in',
			esc_html__( 'Zoom In', 'eventerra' )               => 'zoom-in',
			esc_html__( 'Zoom In Down', 'eventerra' )          => 'zoom-in-down',
			esc_html__( 'Zoom In Up', 'eventerra' )            => 'zoom-in-up',
			esc_html__( 'Zoom Out', 'eventerra' )              => 'zoom-out',
			esc_html__( 'Spin', 'eventerra' )                  => 'spin',
			esc_html__( 'Spin around Left Top', 'eventerra' )  => 'spin-lt',
			esc_html__( 'Spin around Right Top', 'eventerra' ) => 'spin-rt',
			esc_html__( 'Flip', 'eventerra' )                  => 'flip',
			esc_html__( 'Flip X', 'eventerra' )                => 'flip-x',
			esc_html__( 'Flip Y', 'eventerra' )                => 'flip-y',
		) );
	}

	return $data;
}
add_filter( 'vc_map_add_css_animation', 'eventerra_wpb_add_deprecated_animations' );