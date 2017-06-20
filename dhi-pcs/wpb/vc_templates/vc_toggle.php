<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

/**
 * class wpb_toggle removed since 4.4
 * @since 4.4
 */
$elementClass = array(
	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_toggle', $this->settings['base'], $atts ),
	// TODO: check this code, don't know how to get base class names from params
	'color' => ( $color ) ? 'vc_toggle_color_' . $color : '',
	//'inverted' => ( $inverted ) ? 'vc_toggle_color_inverted' : '',
	//'size' => ( $size ) ? 'vc_toggle_size_' . $size : '',
	'open' => ( $open == 'true' ) ? 'vc_toggle_active' : '',
	'extra' => $this->getExtraClass( $el_class ),
	'css_animation' => $this->getCSSAnimation( $css_animation ), // @todo remove getCssAnimation as function in helpers
);

$elementClass = trim( implode( ' ', $elementClass ) );

?>
<div <?php echo isset( $el_id ) && ! empty( $el_id ) ? "id='" . esc_attr( $el_id ) . "'" : ""; ?>
	class="<?php echo esc_attr( $elementClass ); ?>">
	<div class="vc_toggle_title"><?php echo apply_filters( 'wpb_toggle_heading', '<h4>' . esc_html( $title ) . '</h4>', array(
			'title' => $title,
			'open' => $open
		) ); ?><i class="vc_toggle_icon"></i></div>
	<div class="vc_toggle_content"><?php echo wpb_js_remove_wpautop( apply_filters( 'the_content', $content ), true ); ?></div>
</div>