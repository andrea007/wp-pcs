<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $source
 * @var $type
 * @var $onclick
 * @var $custom_links
 * @var $custom_links_target
 * @var $img_size
 * @var $external_img_size
 * @var $images
 * @var $custom_srcs
 * @var $el_class
 * @var $interval
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_gallery
 */
$title = $source = $type = $onclick = $custom_links = $custom_links_target = $img_size = $external_img_size = $images = $custom_srcs = $el_class = $interval = $css = '';
$large_img_src = '';

$attributes = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $attributes );

$default_src = vc_asset_url( 'vc/no_image.png' );

$gal_images = '';
$link_start = '';
$link_end = '';
$el_start = '';
$el_end = '';
$slides_wrap_start = '';
$slides_wrap_end = '';

$img_size='full';
$source='media_library';
	
if(in_array($type, array('om','sliced','masonry','image_grid'))) {
	
	$mode=$type;
	if($mode == 'om')
		$mode='slider';
	elseif($mode == 'image_grid')
		$mode='grid';
	
	$link_to='file';
	$links=false;
	if($onclick == 'link_no' || $onclick == '') {
		$link_to='none';
	} elseif ( $onclick == 'custom_link' || $onclick == 'video_popup' ) {
		$link_to='custom_link';
		$custom_links = vc_value_from_safe( $custom_links );
		$links = explode( ',', $custom_links );
	}
	
	$args=array(
		'mode' => $mode,
		'show_captions' => ($captions == 'yes'),
		'link_to' => $link_to,
		'links' => $links,
		'url_link_target' => $custom_links_target,
		'columns' => $columns,
		'ratio' => $ratio,
	);
	
	/*
	if($hires == 'yes' && in_array($type, array('sliced','masonry','image_grid'))) {
		$args['hires'] = true;
	}
	*/

	if($source == 'media_library' && $images || $source == 'external_link' && $custom_srcs) {

		switch ( $source ) {
			case 'media_library':
				$images = explode( ',', $images );

				$attachments = get_posts(array(
					'post_type' => 'attachment',
					'orderby' => 'post__in', // (isset($atts['orderby']) && $atts['orderby'] == 'rand') ? 'rand' : 'post__in'
					'post__in' => $images,
					'post_mime_type' => 'image',
					'post_status' => null,
					'numberposts' => -1
				));	

				break;
		
			case 'external_link':
				$attachments=array(); // doesn't work with external urls
				break;
		}

		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_gallery wpb_content_element ' . $el_class . ' vc_clearfix', $this->settings['base'], $atts );

		if( $onclick == 'video_popup' ) {
			$css_class .= ' om_video_popup_links';
		}

		$output = 
			'<div class="'. $css_class .'">'.
				wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_gallery_heading' ) ) .
				eventerra_get_custom_gallery($attachments, $args).
			'</div>';
	}
	
} else {
	
	$el_class = $this->getExtraClass( $el_class );
	if ( 'nivo' === $type ) {
		$type = ' wpb_slider_nivo theme-default';
		wp_enqueue_script( 'nivo-slider' );
		wp_enqueue_style( 'nivo-slider-css' );
		wp_enqueue_style( 'nivo-slider-theme' );
	
		$slides_wrap_start = '<div class="nivoSlider">';
		$slides_wrap_end = '</div>';
	} else if ( 'flexslider' === $type || 'flexslider_fade' === $type || 'flexslider_slide' === $type || 'fading' === $type ) {
		$el_start = '<li>';
		$el_end = '</li>';
		$slides_wrap_start = '<ul class="slides">';
		$slides_wrap_end = '</ul>';
		wp_enqueue_style( 'flexslider' );
		wp_enqueue_script( 'flexslider' );
	} else if ( 'image_grid' === $type ) {
		//wp_enqueue_script( 'vc_grid-js-imagesloaded' );
		//wp_enqueue_script('om-isotope');
	
		$el_start = '<li class="isotope-item">';
		$el_end = '</li>';
		$slides_wrap_start = '<ul class="wpb_image_grid_ul">';
		$slides_wrap_end = '</ul>';
	}
	
	if ( 'link_image' === $onclick || 'video_popup' === $onclick ) {
		wp_enqueue_script( 'eventerra-prettyphoto' );
		wp_enqueue_style( 'eventerra-prettyphoto' );
	}
	
	$flex_fx = '';
	if ( 'flexslider' === $type || 'flexslider_fade' === $type || 'fading' === $type ) {
		$type = ' wpb_flexslider flexslider_fade flexslider';
		$flex_fx = ' data-flex_fx="fade"';
	} else if ( 'flexslider_slide' === $type ) {
		$type = ' wpb_flexslider flexslider_slide flexslider';
		$flex_fx = ' data-flex_fx="slide"';
	} else if ( 'image_grid' === $type ) {
		$type = ' wpb_image_grid';
	}
	
	if ( '' === $images ) {
		$images = '-1,-2,-3';
	}
	
	$pretty_rel_random = ' rel="prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']"';

	if ( 'custom_link' === $onclick || 'video_popup' === $onclick ) {
		$custom_links = vc_value_from_safe( $custom_links );
		$custom_links = explode( ',', $custom_links );
	}
	
	switch ( $source ) {
		case 'media_library':
			$images = explode( ',', $images );
			break;
	
		case 'external_link':
			$images = vc_value_from_safe( $custom_srcs );
			$images = explode( ',', $custom_srcs );
			break;
	}
	foreach ( $images as $i => $image ) {
		switch ( $source ) {
			case 'media_library':
				if ( $image > 0 ) {
					$img = wpb_getImageBySize( array( 'attach_id' => $image, 'thumb_size' => $img_size ) );
					$thumbnail = $img['thumbnail'];
					$large_img_src = $img['p_img_large'][0];
				} else {
					$large_img_src = $default_src;
					$thumbnail = '<img src="' . $default_src . '" />';
				}
				break;
	
			case 'external_link':
				$image = esc_attr( $image );
				$dimensions = vcExtractDimensions( $external_img_size );
				$hwstring = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';
				$thumbnail = '<img ' . $hwstring . ' src="' . $image . '" />';
				$large_img_src = $image;
				break;
		}
	
		$link_start = $link_end = '';
	
		switch ( $onclick ) {
			case 'img_link_large':
				$link_start = '<a href="' . esc_url($large_img_src) . '" target="' . $custom_links_target . '">';
				$link_end = '</a>';
				break;
	
			case 'link_image':
				$link_start = '<a class="prettyphoto" href="' . esc_url($large_img_src) . '"' . $pretty_rel_random . '>';
				$link_end = '</a>';
				break;
	
			case 'custom_link':
				if ( ! empty( $custom_links[ $i ] ) ) {
					$link_start = '<a href="' . esc_url($custom_links[ $i ]) . '"' . ( ! empty( $custom_links_target ) ? ' target="' . $custom_links_target . '"' : '' ) . '>';
					$link_end = '</a>';
				}
				break;

			case 'video_popup':
				if ( ! empty( $custom_links[ $i ] ) ) {
					$link_start = '<a href="' . esc_url($custom_links[ $i ]) . '" rel="prettyPhoto">';
					$link_end = '</a>';
				}
				break;
		}
	
		$gal_images .= $el_start . $link_start . $thumbnail . $link_end . $el_end;
	}
	
	$class_to_filter = 'wpb_gallery wpb_content_element vc_clearfix';
	$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

	
	$output = '';
	$output .= '<div class="' . $css_class . '">';
	$output .= '<div class="wpb_wrapper">';
	$output .= wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_gallery_heading' ) );
	$output .= '<div class="wpb_gallery_slides' . $type . '" data-interval="' . $interval . '"' . $flex_fx . '>' . $slides_wrap_start . $gal_images . $slides_wrap_end . '</div>';
	$output .= '</div>';
	$output .= '</div>';
	
}

echo $output;
