<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if($el_class)
	$el_class=' '.$el_class;

$classes=array(apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-max-width' . $el_class, $this->settings['base'], $atts ));
$max_width=trim($max_width);
if($max_width && is_numeric($max_width))
	$max_width.='px';
if($align)
	$classes[]='om-mw-align-'.$align;
if($no_mobile == 'yes')
	$classes[]='om-mw-no-mobile';

echo '<div class="'.implode(' ',$classes).'"'.($max_width ? ' style="max-width:'.$max_width.'"' : '').'>'.wpb_js_remove_wpautop($content).'</div>';