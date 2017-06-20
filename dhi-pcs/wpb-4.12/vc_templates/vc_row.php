<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $equal_height
 * @var $columns_placement
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row
 */
$el_class = $full_height = $full_width = $equal_height = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = '';
$output = $after_output = $disable_element = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'wpb_composer_front_js' );

$el_class = $this->getExtraClass($el_class);

$css_classes = array(
	'vc_row',
	'wpb_row', //deprecated
	'vc_row-fluid',
	$el_class,
	//vc_shortcode_custom_css_class( $css ),
);

if ( 'yes' === $disable_element ) {
	if ( vc_is_page_editable() ) {
		$css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
	} else {
		return '';
	}
}

$style=array();
$style_wpb=array();
$om_css_class=array();
$om_wrapper_attributes=array();

if($font_color) {
	$style[]='color:'.$font_color;
}

if ( ! empty( $full_width ) ) {
	$om_wrapper_attributes[] = 'data-vc-full-width="true"';
	$om_wrapper_attributes[] = 'data-vc-full-width-init="false"';
	if ( 'stretch_row_content' === $full_width ) {
		$om_wrapper_attributes[] = 'data-vc-stretch-content="true"';
	} elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
		$om_wrapper_attributes[] = 'data-vc-stretch-content="true"';
		$om_css_class[] = 'vc_row-no-padding';
	}
}

if (!empty($atts['gap'])) {
	$css_classes[] = 'vc_column-gap-'.$atts['gap'];
}

if($bg_color) {
	if($bg_color == 'theme') {
		$bg_color=get_option('eventerra_hightlight_color');
	}
	$style[]='background-color:'.$bg_color;
	$om_css_class[]='om-with-background';
	$css_classes[]='vc_row-has-fill';
}

$parallax_html='';	
if($bg_type == 'image' && $bg_image && ( $image_url = wp_get_attachment_url( $bg_image, 'full' ) ) !== false ) {

	$om_css_class[]='om-with-background';
	$css_classes[]='vc_row-has-fill';
		
	if($bg_image_att == 'parallax' || $bg_image_att == 'parallax_down') {
		
		$om_css_class[]='om-parallax';
		
		if($bg_image_att == 'parallax')
			$om_wrapper_attributes[]='data-parallax-direction="up"';
		elseif($bg_image_att == 'parallax_down')
			$om_wrapper_attributes[]='data-parallax-direction="down"';
		
		$parallax_html .= '<div class="om-wpb-row-bg-parallax om-parallax-inner" style="background-image:url('.$image_url.');'.($bg_image_pos ? implode(';',eventerra_bg_img_pos_style($bg_image_pos)) : '').($bg_color_fallback ? ';background-color:'.$bg_color_fallback.';' : '').'"></div>';
		
	} else {
		$style[]='background-image:url('.$image_url.')';
		if($bg_image_pos)
			$style=array_merge($style,eventerra_bg_img_pos_style($bg_image_pos));
		$style[]='background-attachment:'.$bg_image_att;
		if($bg_color_fallback)
			$style[]='background-color:'.$bg_color_fallback;
	}

}

if($bg_type == 'gradient' && $bg_color && $bg_color2) {
	
	$om_css_class[]='om-with-background';
	$css_classes[]='vc_row-has-fill';

	if($gradient_type == 'horisontal') {
		$style[]=
			'background:'.$bg_color.';'.
			'background:-moz-linear-gradient(left, '.$bg_color.' 0%, '.$bg_color2.' 100%);'.
			'background:-webkit-linear-gradient(left, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:linear-gradient(to right, '.$bg_color.' 0%,'.$bg_color2.' 100%)'
		;
	}	elseif($gradient_type == 'diagonal1') {
		$style[]=
			'background:'.$bg_color.';'.
			'background:-moz-linear-gradient(45deg, '.$bg_color.' 0%, '.$bg_color2.' 100%);'.
			'background:-webkit-linear-gradient(45deg, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:linear-gradient(45deg, '.$bg_color.' 0%,'.$bg_color2.' 100%)'
		;
	}	elseif($gradient_type == 'diagonal2') {
		$style[]=
			'background:'.$bg_color.';'.
			'background:-moz-linear-gradient(-45deg, '.$bg_color.' 0%, '.$bg_color2.' 100%);'.
			'background:-webkit-linear-gradient(-45deg, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:linear-gradient(135deg, '.$bg_color.' 0%,'.$bg_color2.' 100%)'
		;
	}	elseif($gradient_type == 'radial') {
		$style[]=
			'background:'.$bg_color.';'.
			'background:-moz-radial-gradient(center, ellipse cover, '.$bg_color.' 20%, '.$bg_color2.' 100%);'.
			'background:-webkit-radial-gradient(center, ellipse cover, '.$bg_color.' 20%,'.$bg_color2.' 100%);'.
			'background:radial-gradient(ellipse at center, '.$bg_color.' 20%,'.$bg_color2.' 100%)'
		;
	}	else {
		$style[]=
			'background:'.$bg_color.';'.
			'background:-moz-linear-gradient(top, '.$bg_color.' 0%, '.$bg_color2.' 100%);'.
			'background:-webkit-linear-gradient(top, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:linear-gradient(to bottom, '.$bg_color.' 0%,'.$bg_color2.' 100%)'
		;
	}
}

if($padding_top != '') {
	if(is_numeric($padding_top))
		$padding_top.='px';
	$style_wpb[]='padding-top:'.$padding_top;
}
if($padding_bottom != '') {
	if(is_numeric($padding_bottom))
		$padding_bottom.='px';
	$style_wpb[]='padding-bottom:'.$padding_bottom;
}
if($margin_top != '') {
	if(is_numeric($margin_top))
		$margin_top.='px';
	$style[]='margin-top:'.$margin_top;
}
if($margin_bottom != '') {
	if(is_numeric($margin_bottom))
		$margin_bottom.='px';
	$style[]='margin-bottom:'.$margin_bottom;
}
if($custom_css){
	$custom_css=str_replace('"','',$custom_css);
	$style[]=$custom_css;
}

if(!empty($style))
	$style=' style="'.esc_attr(implode(';',$style)).'"';
else
	$style='';
	
if(!empty($style_wpb))
	$style_wpb=' style="'.esc_attr(implode(';',$style_wpb)).'"';
else
	$style_wpb='';

$video_html='';
if($bg_type == 'video') {
	if($bg_video_src || $bg_video_mp4 || $bg_video_m4v || $bg_video_webm || $bg_video_ogv || $bg_video_wmv || $bg_video_flv) {
		$om_css_class[]='om-with-background';
		$css_classes[]='vc_row-has-fill';
		
		$video_html .= '<div class="om-wpb-row-bg-video om-video-bg-container" style="'.($bg_color_fallback ? 'background-color:'.$bg_color_fallback.';' : '').($bg_image_fallback ? 'background-image:url('.wp_get_attachment_url( $bg_image_fallback, 'full' ).');' : '').'">';
		$video_html .= '<video loop="loop" autoplay="autoplay">'; // '.(($bg_image && $image_url)?' poster="'.$image_url.'"':'').'
		if($bg_video_src)
	 		$video_html.='<source src="'.$bg_video_src.'">';
		if($bg_video_mp4)
	 		$video_html.='<source src="'.$bg_video_mp4.'" type="video/mp4">';
		if($bg_video_m4v)
	 		$video_html.='<source src="'.$bg_video_m4v.'" type="video/mp4">';
		if($bg_video_webm)
	 		$video_html.='<source src="'.$bg_video_webm.'" type="video/webm">';
		if($bg_video_ogv)
	 		$video_html.='<source src="'.$bg_video_ogv.'" type="video/ogg">';
		if($bg_video_wmv)
	 		$video_html.='<source src="'.$bg_video_wmv.'" type="video/wmv">';
		if($bg_video_flv)
	 		$video_html.='<source src="'.$bg_video_flv.'" type="video/x-flv">';
		$video_html .= '</video>';
		$video_html .= '</div>';
	}
}

$dimming_html='';
if($bg_image_dimming != '') {
	$dimming_html.='<div class="om-wpb-row-bg-dimming" style="background-color:'.esc_attr($bg_image_dimming).'"></div>';
}


$fancy_edge_html='';
if($fancy_edge && $bg_type == 'color') {
	$om_css_class[]='om-with-fancy-edge';
	
	if($bg_color) {
		$_bg = $bg_color;
	} else {
	 	$_bg = '#ffffff';
	}
	
	$svg='';
	
	if($fancy_edge == 'diagonal_left') {
		$svg='<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="70" viewBox="0 0 100 100" preserveAspectRatio="none">'.($fancy_edge_t_color ? '<polygon points="0,-10 0,110 100,110 100,-10" fill="'.$fancy_edge_t_color.'" />':'').'<polygon points="0,-10 0,100 100,0 100,-10" fill="'.$_bg.'" /></svg>';
	} elseif($fancy_edge == 'diagonal_right') {
		$svg='<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="70" viewBox="0 0 100 100" preserveAspectRatio="none">'.($fancy_edge_t_color ? '<polygon points="0,-10 0,110 100,110 100,-10" fill="'.$fancy_edge_t_color.'" />':'').'<polygon points="0,-10 100,-10 100,100 0,0" fill="'.$_bg.'" /></svg>';
	} elseif($fancy_edge == 'corner_down') {
		$svg='<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="70" viewBox="0 0 100 100" preserveAspectRatio="none">'.($fancy_edge_t_color ? '<polygon points="0,-10 0,110 100,110 100,-10" fill="'.$fancy_edge_t_color.'" />':'').'<polygon points="0,-10 100,-10 100,0 50,100 0,0" fill="'.$_bg.'" /></svg>';
	} elseif($fancy_edge == 'corner_up') {
		$svg='<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="70" viewBox="0 0 100 100" preserveAspectRatio="none">'.($fancy_edge_t_color ? '<polygon points="0,-10 0,110 100,110 100,-10" fill="'.$fancy_edge_t_color.'" />':'').'<polygon points="0,-10 50,-10 50,0 0,100" fill="'.$_bg.'" /><polygon points="100,-10 50,-10 50,0 100,100" fill="'.$_bg.'" /></svg>';
	}
	
	if($svg != '') {
		//fallback BG - on some devices there is a pixel gap above or below SVG image, background gradient mask it
		$tmp='';
		if($fancy_edge_t_color) {
			$tmp=
				'background:'.$fancy_edge_t_color.';'.
				'background:-webkit-linear-gradient(top, '.$_bg.' 0%,'.$fancy_edge_t_color.' 100%);'.
				'background:linear-gradient(to bottom, '.$_bg.' 0%,'.$fancy_edge_t_color.' 100%)'
			;
		}
		$fancy_edge_html='<div class="om-vc_row-edge om-edge-'.$fancy_edge.' om-edge-size-'.$fancy_edge_size.'"'.($tmp != '' ? ' style="background:'.$tmp.'"' : '').'>'.$svg.'</div>';
	}
}

$animation=eventerra_wpb_get_animation($atts);

$om_css_class[]='om-vc_row';

$om_css_class=implode(' ',array_unique($om_css_class));



$vc_row_html = '';

if ( ! empty( $el_id ) ) {
	$om_wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

if ( ! empty( $equal_height ) ) {
	$flex_row = true;
	$css_classes[] = ' vc_row-o-equal-height';
}

if ( ! empty( $content_placement ) ) {
	$flex_row = true;
	$css_classes[] = ' vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$css_classes[] = ' vc_row-flex';
}

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );

if(empty($om_wrapper_attributes)) {
	$om_wrapper_attributes='';
} else {
	$om_wrapper_attributes=' '.implode(' ',$om_wrapper_attributes);
}

$vc_row_html .=
	'<div class="'.$om_css_class.$animation['classes'].'"'.$style.$om_wrapper_attributes.$animation['atts'].'>'.$video_html.$parallax_html.$dimming_html.
		'<div class="om-vc_row-inner">'.
			'<div class="'.$css_class.'"'.$style_wpb.'>'.
				wpb_js_remove_wpautop($content).
			'</div>'.$this->endBlockComment('row').
		'</div>'.
	'</div>'.
	$fancy_edge_html.
	( ! empty( $full_width ) ? '<div class="vc_row-full-width vc_clearfix"></div>' : '' )
;

echo $vc_row_html;

