<?php

$queried_object=get_queried_object();

$layout_page_id=false;
$blog = false;

if(is_object($queried_object)) {
	
	$blog_page_id=get_option('page_for_posts');
	if($blog_page_id) {
		$blog = get_post($blog_page_id);
		$layout_page_id =	$blog_page_id;
	}
		
} else {
	$settings_page=get_option('eventerra_front_page_settings');
	if($settings_page && function_exists('icl_object_id'))
		$settings_page=icl_object_id($settings_page, 'page', true);
	
	if($settings_page)	
		$layout_page_id =	$settings_page;
}

eventerra_custom_sidebar_setup($layout_page_id);
$page_slider=eventerra_get_page_slider($layout_page_id);
get_header();

$blog_layout=false;
if($layout_page_id) {
	$blog_layout=get_post_meta($layout_page_id, 'eventerra_blog_layout', true);
}
if(!$blog_layout) {
	$blog_layout='large';
}
$blog_small_cut=false;
if($blog_layout=='small') {
	if(get_post_meta($layout_page_id, 'eventerra_blog_grid_cut', true)) {
		$blog_small_cut=true;
	}
}
	
?>
	<div class="content">
		<?php if(isset($page_slider) && $page_slider && $page_slider['layout'] != 'below') eventerra_tpl_header_slider($page_slider) ?>
		<?php if($blog) eventerra_tpl_page_title($blog->ID, $blog->post_title) ?>
		<?php if(isset($page_slider) && $page_slider && $page_slider['layout'] == 'below') eventerra_tpl_header_slider($page_slider) ?>
		<div class="content-columns-wrapper clearfix-a">
			<div class="content-column-content">
				<div class="content-columns-inner">

					<?php if (have_posts()) : ?>
				
						<div class="blog-posts layout-<?php echo esc_attr($blog_layout) ?><?php echo ($blog_small_cut ? ' sublayout-cut' : '' )?>">
						<section>
	
							<?php while (have_posts()) : the_post(); ?>
							
						    <?php 
			
									$format = get_post_format(); 
									if( false === $format ) {
										$format = 'standard';
									}
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

				</div>
			</div>
							
			<?php
				if($blog)
					$post=$blog;
				elseif($layout_page_id)
					$post=get_post($layout_page_id);
				else
					$post=false;
				get_sidebar();
			?>
		</div>
	</div>
<?php get_footer(); ?>