<?php

$tc_atts=array();
foreach($atts as $k=>$v) {
	if($k == 'size' || $k == 'alignment') {
		continue;
	}
	$tc_atts[]=$k.'="'.str_replace('"','``',$v).'"';
}
$tc_shortcode='[tc_ticket '.implode(' ',$tc_atts).']';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$css_classes=array('vc_om_tc_tickets');
$css_classes[]='om-size-'.$size;
$css_classes[]='om-alignment-'.$alignment;

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ',$css_classes), $this->settings['base'], $atts );

?><div class="<?php echo $css_class ?>"><?php echo do_shortcode($tc_shortcode)?></div>

