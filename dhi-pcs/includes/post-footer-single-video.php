	<?php get_template_part( 'includes/post-meta'); ?>
	
	<div class="post-content post-content-full entry-content">
		<?php
		add_filter('the_content', 'eventerra_content_remove_first_video', 99999);
		the_content();
		remove_filter('the_content', 'eventerra_content_remove_first_video', 99999);
		?>
	</div>
</div>