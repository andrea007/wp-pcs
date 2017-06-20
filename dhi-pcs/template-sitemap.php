<?php
/*
Template Name: Sitemap
*/

$page_slider=eventerra_get_page_slider($post->ID);
eventerra_custom_sidebar_setup($post->ID);
eventerra_wpb_detect($post);
get_header();

the_post();
?>
	<div class="content">
		<?php if(isset($page_slider) && $page_slider && $page_slider['layout'] != 'below') eventerra_tpl_header_slider($page_slider) ?>
		<?php eventerra_tpl_page_title($post->ID, the_title('','',false)) ?>
		<?php if(isset($page_slider) && $page_slider && $page_slider['layout'] == 'below') eventerra_tpl_header_slider($page_slider) ?>
		<div class="content-columns-wrapper clearfix-a">
			<div class="content-column-content">
				<div class="content-columns-inner">			
					
					<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
						<?php the_content(); ?>
						<div class="clear"></div>
					</div>
					
	        <div class="sitemap">
	        	
	        	<?php
	        		$blocks=array();
	        		
	        		// Site Feeds
	        		ob_start();
							?>
								<h3><?php esc_html_e('Site Feeds','eventerra'); ?></h3>
								<ul>
									<li><a href="<?php bloginfo('rss2_url'); ?>"><?php esc_html_e('Main RSS Feed','eventerra'); ?></a></li>
									<li><a href="<?php bloginfo('comments_rss2_url'); ?>"><?php esc_html_e('Comments RSS Feed','eventerra'); ?></a></li>
								</ul>
							<?php					        		
							$buffer=trim(ob_get_clean());
	        		if(!empty($buffer))
	        			$blocks[]=$buffer;
	        			
	        		// Pages
	        		ob_start();
							?>
								<?php $list_safe=wp_list_pages('title_li=&echo=0'); ?>
								<?php if($list_safe) : ?>
									<h3><?php esc_html_e('Pages','eventerra'); ?></h3>
									<ul>
										<?php echo $list_safe ?>
									</ul>
								<?php endif; ?>
							<?php					        		
							$buffer=trim(ob_get_clean());
	        		if(!empty($buffer))
	        			$blocks[]=$buffer;
	        			
	        		// Posts
	        		ob_start();
							?>
								<?php $list_safe=get_posts('numberposts=-1&orderby=title&order=ASC'); ?>
								<?php if(!empty($list_safe)) : ?>
									<h3><?php esc_html_e('Posts','eventerra'); ?></h3>
									<ul>
										<?php
											foreach($list_safe as $item) {
												echo '<li><a href="'. esc_url(get_permalink($item->ID)) .'">'.esc_html($item->post_title).'</a></li>';
											}
										?>
									</ul>
								<?php endif; ?>		
							<?php					        		
							$buffer=trim(ob_get_clean());
	        		if(!empty($buffer))
	        			$blocks[]=$buffer;
	        			
	        		// Categories
	        		ob_start();
							?>
								<?php $list_safe=wp_list_categories('title_li=&echo=0'); ?>
								<?php if($list_safe) : ?>
									<h3><?php esc_html_e('Categories','eventerra'); ?></h3>
									<ul>
										<?php echo $list_safe; ?>
									</ul>
								<?php endif; ?>
							<?php					        		
							$buffer=trim(ob_get_clean());
	        		if(!empty($buffer))
	        			$blocks[]=$buffer;
	        			
	        		// Tags
	        		ob_start();
							?>
								<?php
									$tags = get_terms( 'post_tag' );
									if( !empty($tags) ) {
										?>
										<h3><?php esc_html_e('Tags','eventerra'); ?></h3>
										<ul>
										<?php
										foreach( $tags as $tag ) {
											echo '<li><a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">' . $tag->name . '</a></li>';
										}
										?>
										</ul>
										<?php
									}
								?>
							<?php					        		
							$buffer=trim(ob_get_clean());
	        		if(!empty($buffer))
	        			$blocks[]=$buffer;
	        			
	        		// Monthly Archives
	        		ob_start();
							?>
								<?php $list_safe=wp_get_archives('type=monthly&echo=0'); ?>
								<?php if($list_safe) : ?>
									<h3><?php esc_html_e('Monthly Archives','eventerra'); ?></h3>
									<ul>
										<?php echo $list_safe; ?>
									</ul>
								<?php endif; ?>
							<?php					        		
							$buffer=trim(ob_get_clean());
	        		if(!empty($buffer))
	        			$blocks[]=$buffer;
	        			
	        			
	        		// Speakers
	        		ob_start();
							?>
								<?php $list_safe=get_posts('numberposts=-1&orderby=title&order=ASC&post_type=om-persons'); ?>
								<?php if(!empty($list_safe)) : ?>
									<h3><?php esc_html_e('Speakers','eventerra'); ?></h3>
									<ul>
										<?php
											foreach($list_safe as $item) {
												echo '<li><a href="'. esc_url(get_permalink($item->ID)) .'">'.esc_html($item->post_title).'</a></li>';
											}
										?>
									</ul>
								<?php endif; ?>		
							<?php					        		
							$buffer=trim(ob_get_clean());
	        		if(!empty($buffer))
	        			$blocks[]=$buffer;
	        		
	        	?>
	
						<?php
							$columns_safe=array('','','');
							$columns_count=array(0,0,0);
							foreach($blocks as $block) {
								$k=reset(array_keys($columns_count, min($columns_count)));
								$columns_safe[$k].=$block;
								$columns_count[$k]+=substr_count($block,'<li');
							}
						?>
						<div class="om-columns">
							<div class="om-column om-one-third">
								<?php echo $columns_safe[0] ?>
							</div>
							
							<div class="om-column om-one-third">
								<?php echo $columns_safe[1] ?>
							</div>
							
							<div class="om-column om-one-third">
								<?php echo $columns_safe[2] ?>
							</div>	
						</div>	
						
						<div class="clear"></div>
						
					</div>					
				
					<?php eventerra_wp_link_pages();	?>
					
					<?php get_template_part( 'includes/comments' ); ?>

				</div>
			</div>
			
			<?php get_sidebar(); ?>		
		</div>
	</div>
<?php get_footer(); ?>