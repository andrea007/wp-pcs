<?php
/*
Template Name: Blog
*/
$page_slider=eventerra_get_page_slider($post->ID);
eventerra_custom_sidebar_setup($post->ID);
eventerra_wpb_detect($post);
get_header();

$blog_layout=get_post_meta($post->ID, 'eventerra_blog_layout', true);
if(!$blog_layout) {
	$blog_layout='small';
}
$blog_small_cut=false;
if($blog_layout=='small') {
	if(get_post_meta($post->ID, 'eventerra_blog_grid_cut', true)) {
		$blog_small_cut=true;
	}
}
?>
	<div class="content">
		<?php if(isset($page_slider) && $page_slider && $page_slider['layout'] != 'below') eventerra_tpl_header_slider($page_slider) ?>
		<?php eventerra_tpl_page_title($post->ID, the_title('','',false)) ?>
		<?php if(isset($page_slider) && $page_slider && $page_slider['layout'] == 'below') eventerra_tpl_header_slider($page_slider) ?>
		<div class="content-columns-wrapper clearfix-a">
			<div class="content-column-content">
				<div class="content-columns-inner">
					<?php
						if ( get_query_var('paged') ) {
							$paged = get_query_var('paged');
						} elseif ( is_front_page() && get_query_var('page') ) {
							$paged = get_query_var('page');
						} else {
							$paged = 1;
						}
						$args=array(
							'posts_per_page' => get_option('posts_per_page'),
							'paged' => $paged,
						);
						
						$categories=get_post_meta($post->ID, 'eventerra_blog_categories', true);
						if($categories) {
							$categories_=array();
							$categories=explode(',',$categories);
							foreach($categories as $v) {
								$v=intval($v);
								if($v)
									$categories_[]=$v;
							}
							if(!empty($categories_))
								$args['cat']=implode(',',$categories_);
						}
					
						$original_query = $wp_query;
						$wp_query = null;
						$wp_query = new WP_Query($args);
						global $more;
						$original_more = $more;
						$more = 0;
					?>
					<?php if (have_posts()) : ?>
				
						<div class="blog-posts layout-<?php echo esc_attr($blog_layout) ?><?php echo ($blog_small_cut ? ' sublayout-cut' : '' )?>">
						<section>
	
							<?php while (have_posts()) : the_post(); ?>
							
						    <?php 
			
									$format = get_post_format(); 
									if( false === $format )
										$format = 'standard';
									eventerra_tpl_blog_post($blog_layout, $format);
									
						    ?>
							
							<?php endwhile; ?>		
							
						</section>
						</div>
						
						<?php
							if(get_option('eventerra_blog_pagination') == 'pages') {
		
								echo eventerra_wrap_paginate_links ( paginate_links( eventerra_paginate_links_args() ) );
		
							} else {
							
								$nav_newer=get_previous_posts_link(esc_html__('Newer Entries', 'eventerra'));
								$nav_older=get_next_posts_link(esc_html__('Older Entries', 'eventerra'));
								if( $nav_newer || $nav_older ) {
									echo eventerra_prev_next_nav ($nav_older, $nav_newer);
								}		
								
							}
						?>
					
					<?php else : ?>
		
								<h2><?php esc_html_e('Error 404 - Not Found', 'eventerra') ?></h2>
							
								<p><?php esc_html_e('Sorry, but you are looking for something that isn\'t here.', 'eventerra') ?></p>
					
					<?php endif; //if (have_posts()) ?>	
					
					<?php
						$wp_query = null;
						$wp_query = $original_query;
						wp_reset_postdata();
						$more = $original_more;
					?>
				</div>
			</div>
							
			<?php get_sidebar(); ?>
		</div>
	</div>
<?php get_footer(); ?>