<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if($el_width != '') {
	switch($el_width) {
		case 'xs':
			$el_width='50';
			break;
		case 'sm':
			$el_width='60';
			break;
		case 'md':
			$el_width='70';
			break;
		case 'lg':
			$el_width='80';
			break;
		case 'xl':
			$el_width='90';
			break;
		default:
			$el_width='';
			break;
	}
}
///

$class = "vc_call_to_action wpb_content_element";
// $position = 'left';
// $width = '90';
// $txt_align = 'right';
//$link = ($link=='||') ? '' : $link;

$class .= ($add_button!='') ? ' vc_cta_btn_pos_'.$add_button : '';
$class .= ($el_width!='') ? ' vc_el_width_'.$el_width : '';
$class .= ($txt_align!='') ? ' vc_txt_align_'.$txt_align : '';
$class .= ($remove_margins=='yes') ? ' om-remove-margins' : '';
$class .= ($add_stripes=='yes') ? ' om-bg-stripes' : '';

$inline_css='';
if($custom_background!='') {
	$inline_css .= vc_get_css_color('background', $custom_background).';';
}

$inline_css .= ($custom_text!='') ? 'color:'.$custom_text.';' : '';

$button_html='';
if($add_button) {
	$button_class='';
	$button_css='';
	
	if(in_array($btn_color, array('om-accent-color-1', 'om-accent-color-2', 'om-accent-color-3', 'custom'))) {
		$button_class .= ' vc_cta_button-color-' . $btn_color;
	} else {
		$tmp=eventerra_wpb_get_std_color_code($btn_color);
		if($tmp) {
			$button_css .= 'background-color:'.$tmp.';';
		}
		if(($btn_color == 'grey' || $btn_color == 'white') && $btn_text_color == 'auto' ) {
			$button_css .= 'color:#000;';
		}
	}
	
	if ( $btn_color == 'custom' && $btn_custom_color)
		$button_css .= 'background-color:'.$btn_custom_color.';';

	if ( $btn_text_color == 'custom' && $btn_text_custom_color )
		$button_css .= 'color:'.$btn_text_custom_color.';';

	$btn_link = ( $btn_link == '||' ) ? '' : $btn_link;
	$btn_link = vc_build_link( $btn_link );
	if ( strlen( $btn_link['url'] ) > 0 ) {
		$a_href = $btn_link['url'];
		$a_title = $btn_link['title'];
		$a_target = $btn_link['target'];
		$a_rel = ( isset( $btn_link['rel'] ) ? $btn_link['rel'] : '' );
	} else {
		$a_href=$a_title=$a_target=$a_rel='';
	}
	
	if ( $btn_uppercase == 'yes')
		$button_class .= ' apply-uppercase';
		
	$button_html='<a href="'. esc_url( $a_href ) .'" title="'. esc_attr( $a_title ) .'"'.( !empty($a_target) ? ' target="'. trim( esc_attr( $a_target ) ) .'"' : '' ).( !empty($a_rel) ? ' rel="'. trim( esc_attr( $a_rel ) ) .'"' : '' ).' class="vc_cta-button '.$button_class.'"'.($button_css != '' ? ' style="'.$button_css.'"' : '').'><span class="vc_cta_button-inner">'.$btn_title.'</span></a>';
	$class .= ' vc_with_btn';
}

$class .= $this->getExtraClass($el_class);
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );
$css_class .= $this->getCSSAnimation($css_animation);

?>
<div<?php echo ($inline_css ? ' style="'.$inline_css.'"' : '') ?> class="<?php echo esc_attr(trim($css_class)); ?>">
	<div class="vc_cta-inner">
		<?php if ($button_html && $add_button == 'left') echo '<div class="vc_cta-button-wrapper">'.$button_html.'</div>'; ?>
    <div class="vc_cta-text">
<?php if ($h2!='' || $h4!=''): ?>
      <?php if ($h2!=''): ?><h2 class="wpb_heading"><?php echo $h2; ?></h2><?php endif; ?>
      <?php if ($h4!=''): ?><h4 class="wpb_heading"><?php echo $h4; ?></h4><?php endif; ?>
<?php endif; ?>
    </div>
    <?php if ($button_html && $add_button != 'left') echo '<div class="vc_cta-button-wrapper">'.$button_html.'</div>'; ?>
  </div>
</div>
<?php $this->endBlockComment('.vc_call_to_action') . "\n";