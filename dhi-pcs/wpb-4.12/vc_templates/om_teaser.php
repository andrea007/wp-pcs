<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if(!$img_size)
	$img_size='full';

if($el_class)
	$el_class=' '.$el_class;

$styles=array();
$tag_attributes=array();
$classes=array(apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-teaser wpb_content_element' . $el_class, $this->settings['base'], $atts ));

if($align)
	$classes[]='om-t-align-'.$align;

if($add_shadow=='yes')
	$classes[]='om-std-shadow';
	
$link = ( $link == '||' ) ? '' : $link;
$link = vc_build_link( $link );
$a_href = $link['url'];
$a_title = $link['title'];
$a_target = $link['target'];

if($bg_image) {
	$bg_image = eventerra_img_any_resize($bg_image, $img_size, true);
}

if($text_color)
	$styles[]='color:'.$text_color;
	
$height=intval($height);

echo '<div class="'.implode(' ',$classes).'"'.(!empty($styles)?' style="'.implode(';',$styles).'"':'').'>';
	echo '<span class="om-t-bg"'.($bg_image ? ' style="background-image:url('.$bg_image.')"':'').'></span>';
	echo '<span class="om-t-inner"><span class="om-t-tc-uwrapper"><span class="om-t-tc-wrapper"'.($height ? ' style="height:'.$height.'px"' : '').'><span class="om-t-tc">';
		if($title)
			echo '<span class="om-t-title">'.$title.'</span>';
		if($content) {
			$content=wpb_js_remove_wpautop($content, true);
			$content=str_replace('<p>','<span class="om-p">',$content);
			$content=str_replace('</p>','</span>',$content);
			echo '<span class="om-t-content">'.$content.'</span>';
		}
	echo '</span></span></span></span>';

	if($a_href)
		echo '<a href="'. esc_url($a_href) .'"'.($a_title != '' ? ' title="'. esc_attr( $a_title ) .'"' : '').($a_target ? ' target="'. $a_target .'"' : '').' class="om-t-link"></a>';
echo '</div>';

