<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

//
$shape='square';
//

$inline_css = '';
$icon_wrapper = false;
$icon_html = false;

//parse link
$link = ( '||' === $link ) ? '' : $link;
$link = vc_build_link( $link );
$use_link = false;
if ( strlen( $link['url'] ) > 0 ) {
	$use_link = true;
	$a_href = $link['url'];
	$a_title = $link['title'];
	$a_target = $link['target'];
	$a_rel = ( isset($link['rel']) ? $link['rel'] : '' );
}

$el_class = $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' vc_btn3-container ' . $el_class, $this->settings['base'], $atts );
$css_class .= $this->getCSSAnimation( $css_animation );
$button_class = ' vc_btn3-size-' . $size . ' vc_btn3-shape-' . $shape . ' vc_btn3-style-' . $style;
$button_html = $title;

if ( '' == trim( $title ) ) {
	$button_class .= ' vc_btn3-o-empty';
	$button_html = '<span class="vc_btn3-placeholder">&nbsp;</span>';
}
if ( 'true' == $button_block && 'inline' != $align ) {
	$button_class .= ' vc_btn3-block';
}

$icon_inline_css='';
$icon_inner_inline_css='';

if(in_array($color, array('om-accent-color-1', 'om-accent-color-2', 'om-accent-color-3', 'custom'))) {
	$button_class .= ' vc_btn3-color-' . $color . ' ';
} else {
	$tmp=eventerra_wpb_get_std_color_code($color);
	if($style == 'classic') {
		if($tmp) {
			$inline_css .= 'background-color:'.$tmp.';';
		}
		if( ($color == 'grey' || $color == 'white') && $text_color == 'auto' ) {
			$inline_css .= 'color:#000;';
		}
	} elseif($style == 'flat') {
		if($tmp) {
			$icon_inline_css .= 'background-color:'.$tmp.';';
			$icon_inner_inline_css .= 'border-color:'.$tmp.';';
		}
	}
}
if ( $color == 'custom' && $custom_color) {
	if($style == 'classic') {
		$inline_css .= 'background-color:'.$custom_color.';';
	} elseif($style == 'flat') {
		$icon_inline_css .= 'background-color:'.$custom_color.';';
		$icon_inner_inline_css .= 'border-color:'.$custom_color.';';
	}
}

if ( 'true' === $add_icon ) {
	$button_class .= ' vc_btn3-icon-' . $i_align;
	vc_icon_element_fonts_enqueue( $i_type );

	if ( isset( ${"i_icon_" . $i_type} ) ) {
		$iconClass = ${"i_icon_" . $i_type};
	} else {
		$iconClass = 'fa fa-adjust';
	}
	
	if($icon_color == 'custom' && $icon_custom_color) {
		$icon_inline_css.='color:'.$icon_custom_color.';';
	}

	$icon_html = '<i class="vc_btn3-icon ' . esc_attr( $iconClass ) . '"'.($icon_inline_css ? ' style="'.$icon_inline_css.'"' : '').'><span class="vc_btn3-icon-effect"'.($icon_inner_inline_css ? ' style="'.$icon_inner_inline_css.'"' : '').'></span></i>';


	if ( $i_align == 'left' ) {
		$button_html = $icon_html . ' ' . $button_html;
	} else {
		$button_html .= ' ' . $icon_html;
	}
}

if(isset($uppercase) && $uppercase=='yes') {
	$button_class.=' apply-uppercase';
}

$inline_css .= ( $text_color == 'custom' && $text_custom_color ) ? 'color:'.$text_custom_color.' !important;' : '';

$attributes = array();

if ( $use_link ) {
	$attributes[] = 'href="' . trim( $a_href ) . '"';
	$attributes[] = 'title="' . esc_attr( trim( $a_title ) ) . '"';
	if ( ! empty( $a_target ) ) {
		$attributes[] = 'target="' . esc_attr( trim( $a_target ) ) . '"';
	}
	if ( ! empty( $a_rel ) ) {
		$attributes[] = 'rel="' . esc_attr( trim( $a_rel ) ) . '"';
	}
}

if ( ! empty( $custom_onclick ) && $custom_onclick_code ) {
	$attributes[] = 'onclick="' . esc_attr( $custom_onclick_code ) . '"';
}

$attributes[]='class="vc_general vc_btn3 '. esc_attr( trim( $button_class ) ) .'"';

if ( '' != $inline_css ) {
	$attributes[]='style="' . $inline_css . '"';
}

$attributes = implode( ' ', $attributes );

?>
	<span class="<?php echo esc_attr( trim( $css_class ) ); ?> vc_btn3-<?php echo esc_attr( $align ); ?>"><?php
if ( $use_link ):
	?><a <?php echo $attributes ?>><span class="vc_btn3-inner"><?php echo $button_html; ?></span></a><?php
else:
	?>
	<button <?php echo $attributes ?>><span class="vc_btn3-inner"><?php echo $button_html; ?></span></button><?php
endif; ?></span><?php echo $this->endBlockComment( 'vc_btn3' ) . "\n";
