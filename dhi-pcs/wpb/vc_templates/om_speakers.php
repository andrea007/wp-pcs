<?php
global $post;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'wpb_composer_front_js' ); // shortcode may be used out of content area, for instance in widgets area, but it needs this file

$layout='grid';

$styles=array();
if($margin_top != '') {
	if(is_numeric($margin_top)) {
		$margin_top=trim($margin_top).'px';
	}
	$styles[]='margin-top:'.$margin_top.' !important';
}
if($margin_bottom != '') {
	if(is_numeric($margin_bottom)) {
		$margin_bottom=trim($margin_bottom).'px';
	}
	$styles[]='margin-bottom:'.$margin_bottom.' !important';
}

$classes=array('vc_om-speakers','wpb_content_element');
if($el_class) {
	$classes[]=$el_class;
}
$classes[]='vc_om-layout-'.$layout;

if($layout == 'grid') {
	if($description == 'next') {
		$columns=2;
	}
	
	$classes[]='vc_om-columns-'.$columns;
	$classes[]='vc_om-description-'.$description;
}

$args=array (
	'post_type' => 'om-persons',
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'posts_per_page' => -1
);
if($filter != 'id' && $order == 'alphabetical') {
	$args['orderby']='title';
}
if($filter == 'id' && $ids) {
	$args['post__in']=explode(',',$ids);
	$args['orderby']='post__in';
} elseif($filter == 'category' && $categories) {
	$categories=explode(',',$categories);
	if(!empty($categories)) {
		$args['tax_query']=array(
			array('taxonomy'=>'om-persons-type', 'terms' => $categories),
		);
		if(!is_numeric(trim($categories[0]))) {
			$args['tax_query'][0]['field']='slug';
		}
	}
}
/*if($randomize == 'yes') {
	$args['orderby']='rand';
}*/
$my_query = new WP_Query($args);

$contact_icons=function_exists('ompn_persons_contact_icons') ? ompn_persons_contact_icons() : array();

if($my_query->have_posts()) {
	
	?>
	<div class="<?php echo apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ',$classes), $this->settings['base'], $atts ) ?>"<?php echo (empty($styles) ? '' : ' style="'.implode(';',$styles).'"' )?>>
		<div class="om-speakers-items clearfix-a">
			<?php
			$i=1;
			while ( $my_query->have_posts() ) {
				$my_query->the_post(); // Get post from query
				echo '<div class="om-speakers-item'.( has_post_thumbnail() ?' with-pic':' no-pic'  ).($link_to_speaker == 'yes' ? ' with-link' : ' no-link').'">';
					$contacts=array();
					foreach($contact_icons as $k=>$v) {
						$icon=get_post_meta($post->ID, $v, true);
						if($icon != '') {
							$contacts[$k]=$icon;
						}
					}
		
					echo '<div class="om-speakers-pic-wrapper">';
						if ( has_post_thumbnail() ) {
							$img_args=array(
								'srcset' => array(
									'media-one-half-square',
									'media-mobile-square',
								),
								'sizes'=>'(max-width: 768px) 728px, {media-one-half-square}px',
							);
							if($description == 'next') {
								$img_args=array(
									'srcset' => array(
										'media-one-fourth-square',
										'media-mobile-square',
									),
									'sizes'=>'(max-width: 959px) 728px, {media-one-fourth-square}px',
								);
							} elseif($columns == 4) {
								$img_args=array(
									'srcset' => array(
										'media-one-fourth-square',
										'media-mobile-square',
									),
									'sizes'=>'(max-width: 768px) 728px, {media-one-fourth-square}px',
								);
							} else if($columns == 3) {
								$img_args=array(
									'srcset' => array(
										'media-one-third-square',
										'media-mobile-square',
									),
									'sizes'=>'(max-width: 768px) 728px, {media-one-third-square}px',
								);
							}
							$img=eventerra_get_post_thumbnail($img_args);
							if($description == 'no' && $link_to_speaker == 'yes') {
								echo '<div class="om-speakers-pic">'. eventerra_hover_extras($img, false, get_permalink()) .'</div>';
							} else {
								echo '<div class="om-speakers-pic">'. $img .'</div>';
							}
						} else {
							echo '<div class="om-speakers-pic om-pic-empty"></div>';
						}
						if(!empty($contacts)) {
							echo '<div class="om-speakers-contacts">';
							foreach($contacts as $k=>$v) {
								echo '<a href="'.esc_url(($k == 'envelope' ? 'mailto:' : '').($k == 'skype' ? 'skype:' : '').$v, array_merge(wp_allowed_protocols(),array('skype'))).'" class="om-speakers-contact-icon om-'.$k.'" target="_blank"><i class="omfi omfi-'.$k.'"></i></a>';
							}
							echo '</div>';
						}
					echo '</div>';
					
					if($description != 'no') {
						echo '<div class="om-speakers-body clearfix">';
							echo '<div class="om-speakers-body-npe">';
								echo '<div class="om-speakers-name-post">';
									echo '<h4 class="om-speakers-name">'; the_title(); echo '</h4>';
									$speaker_post=get_post_meta($post->ID, 'om_persons_post', true);
									if($speaker_post != '') {
										echo '<div class="om-speakers-post">'.esc_html($speaker_post).'</div>';
									}
								echo '</div>';
								echo '<div class="om-speakers-excerpt">';
									if( has_excerpt() ) {
										echo esc_html(get_the_excerpt());
									} else {
										the_content('');
									}
								echo '</div>';
							echo '</div>';
							if($link_to_speaker == 'yes') {
								echo '<div class="om-speakers-read-more">'. eventerra_more_link_tpl() .'</div>';
							}
						echo '</div>';
					}

				echo '</div>';
				
				if($layout == 'grid' && ($i % $columns) == 0) {
					echo '<div class="clearfix"></div>';
				}
				
				$i++;
			}
			?>
		</div>
	</div>
	<?php
	
	wp_reset_postdata();
}
