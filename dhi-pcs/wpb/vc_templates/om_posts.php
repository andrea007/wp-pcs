<?php
wp_enqueue_script('om-isotope');

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if($el_class)
	$el_class=' '.$el_class;

$styles=array();
$classes=array(apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-posts wpb_content_element' . $el_class, $this->settings['base'], $atts ));

global $wp_query, $more;

$args=array('posts_per_page' => -1, 'ignore_sticky_posts' => true);

if($ids) {
	$args['post__in']=explode(',',str_replace(' ','',$ids));
	$args['orderby']='post__in';
} else {
	$count=intval($count);
	if(!$count)
		$count = -1;
	$args['posts_per_page']=$count;

	$category=explode(',',str_replace(' ','',$category));
	if(!in_array('0',$category)) {
		$category_=array();
		foreach($category as $c) {
			$c=intval($c);
			if($c)
				$category_[]=$c;
		}
		if(!empty($category_))
			$args['category__in']=$category_;
	}
}

if($randomize == 'yes') {
	$args['orderby']='rand';
}

$original_query = $wp_query;
$wp_query = new WP_Query($args);
$original_more = $more;
$more = 0;
						
if (have_posts()) {

	$columns = intval($columns);
	if(!in_array($columns, array(2,3))) {
		$columns=3;
	}

	global $eventerra_wpb_shortcode_om_posts;
	$eventerra_wpb_shortcode_om_posts=true;
	
	if($hide_meta == 'yes') {
		global $eventerra_wpb_shortcode_om_posts_hide_meta;
		$eventerra_wpb_shortcode_om_posts_hide_meta=true;
	}
	if($hide_excerpt == 'yes') {
		global $eventerra_wpb_shortcode_om_posts_hide_excerpt;
		$eventerra_wpb_shortcode_om_posts_hide_excerpt=true;
	}
	if($hide_thumbnail == 'yes') {
		global $eventerra_wpb_shortcode_om_posts_hide_thumbnail;
		$eventerra_wpb_shortcode_om_posts_hide_thumbnail=true;
	}

	?>
	<div class="<?php echo implode(' ',$classes) ?>">

		<div class="blog-posts layout-shortcode columns-<?php echo $columns ?>">
		<section>
		
			<?php $i=1; while (have_posts()) : the_post(); ?>
			
		    <?php 
					get_template_part( 'includes/post-header' );

					if(has_post_thumbnail() && $hide_thumbnail != 'yes') { ?>
						<div class="post-media">
							<?php
								$img_args=array(
									'srcset' => array(
										'media-one-half',
										'media-mobile',
									),
									'sizes'=>'(max-width: 768px) 728px, {media-one-half}px',
								);
								if($columns == 3) {
									$img_args=array(
										'srcset' => array(
											'media-one-third',
											'media-mobile',
										),
										'sizes'=>'(max-width: 768px) 728px, {media-one-third}px',
									);
								}
								$img=eventerra_get_post_thumbnail($img_args);
								echo eventerra_hover_extras($img, false, get_permalink());
							?>
						</div>
					<?php }

					get_template_part( 'includes/post-footer' );
					//echo ($i % $columns == 0 ? '<div class="clearfix"></div>' : '' );
		    ?>
			
			<?php $i++; endwhile; ?>		
				
		</section>
		</div>

	</div>
	<?php
	
	unset($eventerra_wpb_shortcode_om_posts);
	if(isset($eventerra_wpb_shortcode_om_posts_hide_meta))
		unset($eventerra_wpb_shortcode_om_posts_hide_meta);
	if(isset($eventerra_wpb_shortcode_om_posts_hide_excerpt))
		unset($eventerra_wpb_shortcode_om_posts_hide_excerpt);
	if(isset($eventerra_wpb_shortcode_om_posts_hide_thumbnail))
		unset($eventerra_wpb_shortcode_om_posts_hide_thumbnail);
}

$wp_query = $original_query;
wp_reset_postdata();
$more = $original_more;
