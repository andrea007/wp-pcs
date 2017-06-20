<?php get_template_part( 'includes/post-header-single' ); ?>

	<?php if(has_post_thumbnail() && get_option('eventerra_post_single_show_thumb') == 'true') { ?>
		<div class="post-media">
			<?php eventerra_post_thumbnail('post-media-large'); ?>
		</div>
	<?php } ?>

<?php get_template_part( 'includes/post-footer-single' ); ?>