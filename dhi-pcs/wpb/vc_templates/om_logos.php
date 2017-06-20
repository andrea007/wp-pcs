<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if($img_size == '')
	$img_size = 'full';

if($images == '')
	return false;
	
$images=explode(',',$images);

if($el_class)
	$el_class=' '.$el_class;

if($onclick == 'custom_link')
	$custom_links=explode(',',$custom_links);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-logos wpb_content_element' . $el_class, $this->settings['base'], $atts );

if($layout)
	$css_class .= ' vc_om-logos-layout-'.$layout;

if($grayscale == 'yes')
	$css_class .= ' vc_om-logos-grayscale';
	
echo
	'<div class="'. $css_class .'">'.
		wpb_widget_title( array( 'title' => $title, 'extraclass' => 'vc_om-logos_heading' ) ) .
		'<div class="vc_om-logos-inner">' .
			'<div class="vc_om-logos-container">'
;
				foreach($images as $i=>$id) {
					$src = eventerra_img_any_resize($id, $img_size, false, false);
					if($src) {
				    if( get_option('eventerra_lazyload') == 'true' && $layout != 'carousel') {
				    	$img='<img width="'.$src[1].'" height="'.$src[2].'" src="'. EVENTERRA_TEMPLATE_DIR_URI .'/img/e.png" data-src="'.$src[0].'" alt="" class="lazyload" />';
				    } else {
				    	$img='<img width="'.$src[1].'" height="'.$src[2].'" src="'.$src[0].'" alt=""/>';
						}
						
						if($onclick == 'custom_link') {
							if(isset($custom_links[$i]))
							$img='<a href="'.esc_url($custom_links[$i]).'"'.($links_target ? ' target="'.$links_target.'"' : '').'>'.$img.'</a>';
						} elseif ($onclick == 'description') {
							$attachment=get_post($id);
							$href=trim($attachment->post_content);
							if($href) {
								$img='<a href="'.esc_url($href).'"'.($links_target ? ' target="'.$links_target.'"' : '').'>'.$img.'</a>';
							}
						}
						
						echo '<div class="vc_om-logos-item"><div class="vc_om-logos-img-w">'.$img.'</div></div>';
					}
				}
echo
			'</div>'.
		'</div>'.
	'</div>'
;
