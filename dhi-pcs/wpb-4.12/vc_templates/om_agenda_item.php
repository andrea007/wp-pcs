<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$classes=array('om-agenda-item');
if($el_class) {
	$classes[]=$el_class;
}
if($featured == 'yes') {
	$classes[]='om-featured';
}

$classes=apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ',$classes), $this->settings['base'], $atts );

//parse link
$link = ( $link == '||' ) ? '' : $link;
$link = vc_build_link( $link );
$a_href=false;
if ( strlen( $link['url'] ) > 0 ) {
	$a_href = $link['url'];
	$a_title = $link['title'];
	$a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
}

//speakers
$speakers=array();
if($speaker_ids) {
	$args=array (
		'post_type' => 'om-persons',
		'orderby' => 'post__in',
		'order' => 'ASC',
		'posts_per_page' => -1,
		'post__in' => explode(',',$speaker_ids),
	);
	$my_query = new WP_Query($args);
	
	if($my_query->have_posts()) {
		while ( $my_query->have_posts() ) {
			$my_query->the_post();
			$photo=false;
			if(has_post_thumbnail()) {
				$photo='<span class="om-agenda-item-speaker-photo">'.eventerra_get_post_thumbnail('media-one-fourth-square', array('nolazyload'=>true)).'</span>';
			}
			$name=preg_replace('/\s(\S+)$/', '&nbsp;$1' , the_title('','',false));
			if($speaker_links == 'yes') {
				$name='<a href="'.esc_url(get_permalink()).'">'.$name.'</a>';
			}
			$speakers[]='<span class="om-agenda-item-speaker">'.$name.$photo.'</span>';
		}
		wp_reset_postdata();
	}
}


$time=str_replace('-','&mdash;',$time);
$time=preg_replace('/\S+\s*(am|pm)/i','<span class="nowrap">$0</span>',$time);

echo '<div class="'.$classes.' clearfix-a">';
	echo '<div class="om-agenda-item-time-room">';
		echo '<div class="om-agenda-time-room-inner">';
			echo '<div class="om-agenda-item-icon">';
				if($icon_type && isset( ${"icon_" . $icon_type} )) {
					vc_icon_element_fonts_enqueue( $icon_type );
					echo '<i class="'.${"icon_" . $icon_type}.'"></i>';
				}
			echo '</div>';
			echo '<div class="om-agenda-item-time">' . ($time != '' ? $time : '&nbsp;') . '</div>';
			echo '<div class="om-agenda-item-room">' . $room . '</div>';
		echo '</div>';
	echo '</div>';
	echo '<div class="om-agenda-item-description">';
		echo '<div class="om-agenda-item-description-title">';
			echo $title;
		echo '</div>';
		if(trim($content) != '') {
			echo '<div class="om-agenda-item-description-more">';
				echo wpb_js_remove_wpautop($content, true);
				if ( $a_href !== false) {
					echo '<p>'.eventerra_more_link_tpl(array('href'=>$a_href, 'class'=>'om-agenda-item-read-more', 'attr'=>' title="'. esc_attr( $a_title ) .'" target="'. trim( esc_attr( $a_target ) ) .'"')).'</p>';
				}
			echo '</div>';
		}
	echo '</div>';
	echo '<div class="om-agenda-item-room-col">'.($room != '' ? '<div class="om-agenda-item-room-inner">' . $room . '</div>' : '' ).'</div>';
	echo '<div class="om-agenda-item-speakers">'.(!empty($speakers) ? '<div class="om-agenda-item-speakers-inner">' . implode(', ',$speakers) . '</div>' : '').'</div>';
	if ( $a_href !== false && trim($content) == '' ) {
		echo '<a class="om-agenda-item-link" href="'. esc_url( $a_href ) .'" title="'. esc_attr( $a_title ) .'" target="'. trim( esc_attr( $a_target ) ) .'"></a>';
	} elseif ( trim($content) != '' ) {
		echo '<a class="om-agenda-item-link om-agenda-item-expand"></a>';
	}

echo '</div>';