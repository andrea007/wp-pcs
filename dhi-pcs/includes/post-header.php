<div <?php post_class('blog-post' . ( has_post_thumbnail() ? ' has-thumbnail' : '' ) . ( get_option('eventerra_post_hide_date') == 'true' ? ' no-date' : '' ) ); ?> id="post-<?php the_ID(); ?>">
	<div class="blog-post-inner">
