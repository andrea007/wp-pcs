<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$classes=array('om-agenda-day');
if($el_class) {
	$classes[]=$el_class;
}
$classes[]='om-color-'.$color;

$classes=apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ',$classes), $this->settings['base'], $atts );

echo '<div class="'.$classes.'">';
	echo '<div class="om-agenda-day-inner">';
		echo '<div class="om-agenda-day-header clearfix-a">';
			echo '<div class="om-agenda-day-title">'.$title.'</div>';
			echo '<div class="om-agenda-day-date">'.$date.'</div>';
		echo '</div>';
		echo '<div class="om-agenda-day-items">';
			echo wpb_js_remove_wpautop($content);
		echo '</div>';
	echo '</div>';
echo '</div>';