<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if($el_class)
	$el_class=' '.$el_class;

$styles=array();
$classes=array(apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-click-box wpb_content_element' . $el_class, $this->settings['base'], $atts ));

if(in_array($color, array('om-accent-color-1', 'om-accent-color-2', 'om-accent-color-3'))) {
	$classes[]='om-bg-'.$color;
} else {
	if($color == 'custom') {
		$classes[]='om-bg-'.$color;
		if($custom_color) {
			$styles[]='background-color:'.$custom_color;
		}
	} else {
		if($tmp=eventerra_wpb_get_std_color_code($color)) {
			$styles[]='background-color:'.$tmp;
		}
	}
}

if($text_color) {
	$styles[]='color:'.$text_color;
}

$classes[]='om-cb-size-'.$size;

if($remove_margins=='yes') {
	$classes[]='om-remove-margins';
}

if($apply_uppercase=='yes') {
	$classes[]='apply-uppercase';
}	

$link = ( $link == '||' ) ? '' : $link;
$link = vc_build_link( $link );
$a_href = $link['url'];
$a_title = $link['title'];
$a_target = $link['target'];

echo '<div class="'.implode(' ',$classes).'"'.(!empty($styles)?' style="'.implode(';',$styles).'"':'').'>';
if($a_href)
	echo '<a href="'. esc_url($a_href) .'" title="'. esc_attr( $a_title ) .'" target="'. $a_target .'">';
echo '<span class="om-cb-inner">';
if($title != '') {
	echo '<span class="om-cb-title">'.$title.'</span>';
}
if($subtitle != '') {
	echo '<span class="om-cb-subtitle">'.$subtitle.'</span>';
}
echo '</span>';
if($a_href)
	echo '</a>';
echo '</div>';

