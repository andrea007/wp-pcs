<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if($el_class)
	$el_class=' '.$el_class;

$icon_styles=array();
$tag_attributes=array();
$classes=array(apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-click-icon-box wpb_content_element' . $el_class, $this->settings['base'], $atts ));

$link = ( $link == '||' ) ? '' : $link;
$link = vc_build_link( $link );
$a_href = $link['url'];
$a_title = $link['title'];
$a_target = $link['target'];

$classes[]='om-cib-size-'.$size;
if($a_href) {
	$classes[]='om-cib-with-link';
}

if(in_array($color, array('om-accent-color-1', 'om-accent-color-2', 'om-accent-color-3'))) {
	$classes[]='om-cib-color-'.$color;
} else {
	if($color == 'custom') {
		if($custom_color) {
			$icon_styles[]='background-color:'.$custom_color;
		}
	} else {
		if($tmp=eventerra_wpb_get_std_color_code($color)) {
			$icon_styles[]='background-color:'.$tmp;
		}
	}
}


if($icon_color) {
	$icon_styles[]='color:'.$icon_color;
}

echo '<div class="'.implode(' ',$classes).'">';
if($a_href)
	echo '<a href="'. $a_href .'"'.($a_title != '' ? ' title="'. esc_attr( $a_title ) .'"' : '').($a_target ? ' target="'. $a_target .'"' : '').'>';
if($icon_type && isset( ${"icon_" . $icon_type} )) {
	vc_icon_element_fonts_enqueue( $icon_type );
	echo '<span class="om-cib-icon"'.(!empty($icon_styles) ? ' style="'.implode(';',$icon_styles).'"' : '').'><i class="'.${"icon_" . $icon_type}.'"></i></span>';
}
echo '<span class="om-cib-tc">';
if($title) {
	echo '<span class="om-cib-title">'.$title.'</span>';
}
if($content) {
	$content=wpb_js_remove_wpautop($content, true);
	$content=str_replace('<p>','<span class="om-p">',$content);
	$content=str_replace('</p>','</span>',$content);
	echo '<span class="om-cib-content">'.$content.'</span>';
}
echo '</span>';
if($a_href)
	echo '</a>';
echo '</div>';

