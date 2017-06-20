<?php
/*
Template Name: Without Header/Footer
*/

$page_slider=eventerra_get_page_slider($post->ID);
eventerra_custom_sidebar_setup($post->ID);
eventerra_wpb_detect($post);
get_header('empty');

?>
	<div class="content">
		<?php if(isset($page_slider) && $page_slider && $page_slider['layout'] != 'below') eventerra_tpl_header_slider($page_slider) ?>
		<?php eventerra_tpl_page_title($post->ID, the_title('','',false)) ?>
		<?php if(isset($page_slider) && $page_slider && $page_slider['layout'] == 'below') eventerra_tpl_header_slider($page_slider) ?>
		<div class="content-columns-wrapper clearfix-a">
			<div class="content-column-content">
				<div class="content-columns-inner">
					<?php while (have_posts()) : the_post(); ?>
						<article>		
							<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
								<?php the_content(); ?>
							</div>
						</article>
					<?php endwhile; ?>

					<?php eventerra_wp_link_pages();	?>
					
					<?php get_template_part( 'includes/comments' ); ?>
				</div>
			</div>
		</div>
	</div>
<?php get_footer('empty');