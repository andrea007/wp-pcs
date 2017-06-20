<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script('om_vc_pie');

$color=trim($color);
$set_back_color=false;

if($color == 'om-accent-color-1') {
	$color=get_option('eventerra_accent_color1');
	$set_back_color=true;
} elseif($color == 'om-accent-color-2') {
	$color=get_option('eventerra_accent_color2');
	$set_back_color=true;
} elseif($color == 'om-accent-color-3') {
	$color=get_option('eventerra_accent_color3');
	$set_back_color=true;
} elseif($color == 'custom') {
	$color=$custom_color;
	$set_back_color=true;
} else {
	$color=eventerra_wpb_get_std_color_code($color);
}
if(substr($color, 0, 1) == '#') {
	$color=omfw_Color::rgba2string(omfw_Color::hex2rgb($color));
}
if(is_numeric($width))
	$width.='px';
	
$animate_label=1;
if($label_type == 'title' || $label_type == 'icon') {
	$animate_label=0;
}

$vc_pie_chart_value='';
if($label_type == 'title') {
	$vc_pie_chart_value=$title;
} elseif($label_type == 'icon') {
	$iconClass = isset( ${"icon_" . $icon_type} ) ? ${"icon_" . $icon_type} : '';
	if($iconClass) {
		vc_icon_element_fonts_enqueue( $icon_type );
		$vc_pie_chart_value='<i class="'.$iconClass.'"></i>';
	}
}

if($font_size != '') {
	$font_size=trim($font_size);
	if(is_numeric($font_size)) {
		$font_size.='px';
	}
}

$el_class = $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_pie_chart wpb_content_element' . $el_class, $this->settings['base'], $atts );
$css_class.= ' vc_pie_label-'.$label_type;
$output = '<div class= "'.$css_class.'" data-pie-value="'.$value.'" data-pie-animate-label="'.$animate_label.'" data-pie-label-value="'.$label_value.'" data-pie-units="'.$units.'" data-pie-color="'.esc_attr($color).'"'.($width?' style="max-width:'.$width.'"':'').'>';
    $output .= '<div class="wpb_wrapper">';
        $output .= '<div class="vc_pie_wrapper">';
            $output .= '<span class="vc_pie_chart_back"'.($set_back_color?' style="border-color:'.esc_attr($color).'"':'').'></span>';
            $output .= '<span class="vc_pie_chart_value"'.($font_size != '' ? ' style="font-size:'.$font_size.'"' : '').'>'.$vc_pie_chart_value.'</span>';
            $output .= '<canvas width="101" height="101"></canvas>';
        $output .= '</div>';
        if($label_type != 'title')
        	$output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_pie_chart_heading'));
    $output .= '</div>'.$this->endBlockComment('.wpb_wrapper');
    $output .= '</div>'.$this->endBlockComment('.wpb_pie_chart')."\n";

echo $output;