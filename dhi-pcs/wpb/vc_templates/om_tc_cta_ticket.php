<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$class = "vc_call_to_action om-tc-cta-ticket wpb_content_element";

$class .= ' vc_cta_btn_pos_'.$button_alignment;
$class .= ($txt_align!='') ? ' vc_txt_align_'.$txt_align : '';
$class .= ($remove_margins=='yes') ? ' om-remove-margins' : '';
$class .= ($add_stripes=='yes') ? ' om-bg-stripes' : '';
$class .= ' vc_with_btn';

$inline_css='';
if($custom_background!='') {
	$inline_css .= vc_get_css_color('background', $custom_background).';';
}

$inline_css .= ($custom_text!='') ? 'color:'.$custom_text.';' : '';

$button_html='';

// button
$button_class='';

$button_class .= ' om-btn-color-' . $btn_color;
if ( $btn_uppercase == 'yes') {
	$button_class .= ' apply-uppercase';
}

$button_html=do_shortcode('[tc_ticket id="'.$id.'" title="'.str_replace('"','``',$btn_title).'" soldout_message="'.str_replace('"','``',$soldout_message).'" type="buynow"]');

$class .= $this->getExtraClass($el_class);
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );
//$css_class .= $this->getCSSAnimation($css_animation);

?>
<div<?php echo ($inline_css ? ' style="'.$inline_css.'"' : '') ?> class="<?php echo esc_attr(trim($css_class)); ?>">
	<div class="vc_cta-inner">
		<?php if ($button_html && $button_alignment == 'left') echo '<div class="vc_cta-button-wrapper'.$button_class.'">'.$button_html.'</div>'; ?>
    <div class="vc_cta-text">
<?php if ($h2!='' || $h4!=''): ?>
      <?php if ($h2!=''): ?><h2 class="wpb_heading"><?php echo $h2; ?></h2><?php endif; ?>
      <?php if ($h4!=''): ?><h4 class="wpb_heading"><?php echo $h4; ?></h4><?php endif; ?>
<?php endif; ?>
    </div>
    <?php if ($button_html && $button_alignment != 'left') echo '<div class="vc_cta-button-wrapper'.$button_class.'">'.$button_html.'</div>'; ?>
  </div>
</div>
<?php $this->endBlockComment('.vc_call_to_action') . "\n";