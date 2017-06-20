<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$classes=apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-reduce_space', $this->settings['base'], $atts );
$height=trim($height);
if($height && is_numeric($height))
	$height.='px';

if($mobile_hide == 'yes')
	$classes.=' om-mobile-hidden';

echo '<div class="'.$classes.'"'.($height ? ' style="margin-top:-'.$height.'"' : '').'></div>';