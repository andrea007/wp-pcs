<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if($el_class)
	$el_class=' '.$el_class;

$output='';

$classes=array(apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-list wpb_content_element' . $el_class, $this->settings['base'], $atts ));

if($icon_color == 'om-accent-color-1' || $icon_color == 'om-accent-color-2' || $icon_color == 'om-accent-color-3') {
	$classes[]='vc_om-color-'.$icon_color;
	$icon_custom_color='';
} elseif($icon_color == 'custom') {
	
} elseif($icon_color != '') {
	$icon_custom_color=eventerra_wpb_get_std_color_code($icon_color);
} else {
	$icon_custom_color='';
}

if($icon_type) {
	$iconClass = isset( ${"icon_" . $icon_type} ) ? ${"icon_" . $icon_type} : false;
	if($iconClass) {
		vc_icon_element_fonts_enqueue( $icon_type );
	}
} else {
	$iconClass=false;
}

$icon=($iconClass ? '<span class="om-list-icon"'.($icon_custom_color ? ' style="color:'.$icon_custom_color.'"' : '').'><i class="'.$iconClass.'"></i></span>' : '');

$output .= 
	'<div class="'.implode(' ',$classes).'">'.
		wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_om_list_heading' ) ).
		'<ul>';
			$list=explode("\n",$content);
			foreach($list as $line) {
				$line=trim($line);
				if($line != '')
					$output .= '<li>'.$icon.$line.'</li>';
			}
$output .=
		'</ul>'.
	'</div>'
;

echo $output;