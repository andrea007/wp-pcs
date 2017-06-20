<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * @var $this WPBakeryShortCode_VC_Tta_Accordion|WPBakeryShortCode_VC_Tta_Tabs|WPBakeryShortCode_VC_Tta_Tour|WPBakeryShortCode_VC_Tta_Pageable
 */
$el_class = $css = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$tag=$this->getShortcode();

//if(!isset($atts['style']) || !in_array($atts['style'], array('classic', 'flat'))) {
//	$atts['style']='classic';
//}

$atts=array_merge($atts,array(
	'style' => 'classic',
	'shape' => 'square',
	//'color' => 'grey',
	'no_fill_content_area' => '',
	'spacing' => '',
	'gap' => '',
	'alignment' => 'left',
	'pagination_style' => '',
	'pagination_color' => '',
));

switch($tag) {
	case 'vc_tta_tabs':
		$atts=array_merge($atts,array(
			'tab_position' => 'top',
		));
	break;

	case 'vc_tta_tour':
		$atts=array_merge($atts,array(
			'tab_position' => 'left',
		));
	break;

	case 'vc_tta_accordion':
		$atts=array_merge($atts,array(
			//'style' => 'classic',
			'no_fill' => '',
			'c_align' => 'left',
			'c_icon' => 'plus',
			'c_position' => 'left',
		));
	break;
	
	case 'vc_tta_pageable':
		$atts=array_merge($atts,array(
			'pagination_style' => 'outline-round',
		));
	break;
}

$this->resetVariables( $atts, $content );


$this->setGlobalTtaInfo();

if(method_exists($this,'enqueueTtaStyles')){
	$this->enqueueTtaStyles();
}
$this->enqueueTtaScript();
wp_enqueue_script( 'eventerra_vc_accordion_script', EVENTERRA_TEMPLATE_WPB_DIR_URI . '/assets/js/vc-accordion.js', array( 'vc_accordion_script' ), EVENTERRA_THEME_VERSION, true );

// It is required to be before tabs-list-top/left/bottom/right for tabs/tours
$prepareContent = $this->getTemplateVariable( 'content' );

$class_to_filter = $this->getTtaGeneralClasses();
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
if(isset($atts['remove_margins']) && $atts['remove_margins']=='yes') {
	$class_to_filter.=' om-remove-margins';
}
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$output = '<div ' . $this->getWrapperAttributes() . '>';
$output .= $this->getTemplateVariable( 'title' );
$output .= '<div class="' . esc_attr( $css_class ) . '">';
$output .= $this->getTemplateVariable( 'tabs-list-top' );
$output .= $this->getTemplateVariable( 'tabs-list-left' );
$output .= '<div class="vc_tta-panels-container">';
$output .= $this->getTemplateVariable( 'pagination-top' );
$output .= '<div class="vc_tta-panels">';
$output .= $prepareContent;
$output .= '</div>';
$output .= $this->getTemplateVariable( 'pagination-bottom' );
$output .= '</div>';
$output .= $this->getTemplateVariable( 'tabs-list-bottom' );
$output .= $this->getTemplateVariable( 'tabs-list-right' );
$output .= '</div>';
$output .= '</div>';

echo $output;