<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$classes=array('vc_om-agenda','wpb_content_element');
if($el_class) {
	$classes[]=$el_class;
}
$classes[]='om-layout-'.$layout;
if($layout == 'grid') {
	wp_enqueue_script('om-isotope');
	$classes[]='om-columns-'.$columns;
}
if($description_expand == 'yes') {
	$classes[]='om-description-expand';
}
$classes[]='om-room-'.($display_room=='yes' ? 'display' : 'hide');
$classes[]='om-speakers-'.($display_speakers=='yes' ? 'display' : 'hide');

$classes=apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ',$classes), $this->settings['base'], $atts );

echo '<div class="'.$classes.'"><div class="om-agenda-inner">'.wpb_js_remove_wpautop($content).'</div></div>';