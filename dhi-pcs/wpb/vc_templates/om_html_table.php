<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass($el_class);
$content =  rawurldecode(omfw_Framework::str_decode(strip_tags($content)));
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-table wpb_content_element' . $el_class, $this->settings['base'], $atts );
if($style)
	$css_class .= ' vc_om-table-style-'.$style;
if($align)
	$css_class .= ' vc_om-table-align-'.$align;

echo '<div class="'.$css_class.'"><div class="wpb_wrapper">'.$content.'</div></div>';
