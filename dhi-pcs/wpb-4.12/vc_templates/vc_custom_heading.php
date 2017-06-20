<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $source
 * @var $text
 * @var $link
 * @var $google_fonts
 * @var $font_container
 * @var $el_class
 * @var $css
 * @var $font_container_data - returned from $this->getAttributes
 * @var $google_fonts_data - returned from $this->getAttributes
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Custom_heading
 */
$source = $text = $link = $google_fonts = $font_container = $el_class = $css = $font_container_data = $google_fonts_data = '';
// This is needed to extract $font_container_data and $google_fonts_data
extract( $this->getAttributes( $atts ) );

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

extract( $this->getStyles( $el_class, $css, $google_fonts_data, $font_container_data, $atts ) );

$settings = get_option( 'wpb_js_google_fonts_subsets' );
if ( is_array( $settings ) && ! empty( $settings ) ) {
	$subsets = '&subset=' . implode( ',', $settings );
} else {
	$subsets = '';
}

if ( isset( $google_fonts_data['values']['font_family'] ) && $use_theme_fonts != 'yes' ) {
	wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $google_fonts_data['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets );
}

if ( ! empty( $styles ) ) {
	$style = ' style="' . esc_attr( implode( ';', $styles ) ) . '"';
} else {
	$style = '';
}

if ( 'post_title' === $source ) {
	$text = get_the_title( get_the_ID() );
}

$text=preg_replace('/\(\(([\s\S]*?)\)\)/','<span class="vc_custom_heading-color om-primary-color">$1</span>',$text);

if ( ! empty( $link ) ) {
	$link = vc_build_link( $link );
	$text = '<a href="' . esc_url( $link['url'] ) . '"'
		. ( $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '"' : '' )
		. ( isset($link['rel']) && $link['rel'] ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '' )
		. ( $link['title'] ? ' title="' . esc_attr( $link['title'] ) . '"' : '' )
		. '>' . $text . '</a>';
}

if($text_additional != '') {
	$text.='<span class="vc_custom_heading-additional">'.$text_additional.'</span>';
}

if(isset($uppercase) && $uppercase == 'yes') {
	$css_class.=' apply-uppercase';
}

$use_wrapper=false;
$text_shadow_html='';

if(isset($add_shadow_text) && $add_shadow_text == 'yes' && isset($shadow_text) && $shadow_text != '') {
	$use_wrapper=true;
	$css_class.=' with-shadow';
	$text_shadow_html='<div class="vc_custom_heading-shadow"' . $style . '>'.$shadow_text.'</div>';
}

$text=preg_replace('/\(color1\)([\s\S]*?)\(\/color1\)/i','<span class="text-color-accent-1">$1</span>',$text);
$text=preg_replace('/\(color2\)([\s\S]*?)\(\/color2\)/i','<span class="text-color-accent-2">$1</span>',$text);
$text=preg_replace('/\(color3\)([\s\S]*?)\(\/color3\)/i','<span class="text-color-accent-3">$1</span>',$text);

$animation=eventerra_wpb_get_animation($atts);

$output = '';
if ( $use_wrapper || apply_filters( 'vc_custom_heading_template_use_wrapper', false ) ) {
	$output .= '<div class="' . esc_attr( $css_class ) . $animation['classes'] . '" >';
	$output .= $text_shadow_html;
	$output .= '<' . $font_container_data['values']['tag'] . ' ' . $style . ' class="vc_custom_heading-tag">';
	$output .= $text;
	$output .= '</' . $font_container_data['values']['tag'] . '>';
	$output .= '</div>';
} else {
	$output .= '<' . $font_container_data['values']['tag'] . ' ' . $style . ' class="' . esc_attr( $css_class ) . $animation['classes'] .'">';
	$output .= $text;
	$output .= '</' . $font_container_data['values']['tag'] . '>';
}

echo $output;
