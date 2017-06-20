		<?php
		global $eventerra_wpb_shortcode_om_posts;
		
		if(get_option('eventerra_post_hide_date') != 'true' && !isset($eventerra_wpb_shortcode_om_posts)) {
			$date_format=get_option('eventerra_blog_date_format');
			if(empty($date_format) || $date_format == 'default') {
				$date_format=get_option('date_format');
			}
			if(strpos($date_format, '|') !== false) {
				$date_format_=explode('|',$date_format);
				$post_date=get_the_time($date_format_[0]);
				$post_date.='<span class="post-date-year">'.get_the_time($date_format_[1]).'</span>';
			} else {
				$post_date=get_the_time($date_format);
			}
			echo '<div class="post-date-wrapper"><span class="post-date" title="'.esc_attr(get_the_time(get_option('date_format'))).'">'. $post_date .'</span></div>';	
		}
		?>

		<div class="post-body-wrapper">

			<div class="post-body">

				<?php if( !in_array(get_post_format(), array('aside', 'status')) ) { ?>
					<div class="post-title"><h2><a href="<?php the_permalink(); ?>"><?php $title=get_the_title(); if($title) echo esc_html($title); else the_permalink(); ?></a></h2></div>
					<?php
						global $eventerra_wpb_shortcode_om_posts_hide_meta;
						if(isset($eventerra_wpb_shortcode_om_posts_hide_meta) && $eventerra_wpb_shortcode_om_posts_hide_meta) { //shortcode mode
							//
						} else {
							get_template_part( 'includes/post-meta'); 
						}
					?>
				<?php } ?>
	
				<?php
					global $eventerra_wpb_shortcode_om_posts_hide_excerpt;
					if(isset($eventerra_wpb_shortcode_om_posts_hide_excerpt) && $eventerra_wpb_shortcode_om_posts_hide_excerpt) { //shortcode mode
						//
					} else {
				?>
					<div class="post-content post-content-excerpt">
					<?php
							if( has_excerpt() ) {
								echo esc_html(get_the_excerpt());
							} else {
								if( get_option('eventerra_blog_excerpt_mode') == 'auto' ) {
									remove_filter('excerpt_length', 'eventerra_excerpt_length');
									add_filter('excerpt_length', 'eventerra_blog_excerpt_length');
									remove_filter('excerpt_more', 'eventerra_excerpt_more');
									add_filter('excerpt_more', 'eventerra_blog_excerpt_no_more');
									the_excerpt();
									remove_filter('excerpt_length', 'eventerra_blog_excerpt_length');
									add_filter('excerpt_length', 'eventerra_excerpt_length');
									remove_filter('excerpt_more', 'eventerra_blog_excerpt_no_more');
									add_filter('excerpt_more', 'eventerra_excerpt_more');
								} else {
									the_content( '' );
								}
							}
					?>
					</div>
				<?php 
					}
				?>
			</div>
			<?php if(!(isset($eventerra_wpb_shortcode_om_posts_hide_excerpt) && $eventerra_wpb_shortcode_om_posts_hide_excerpt)) {?><div class="post-read-more"><?php echo eventerra_more_link_tpl() ?></div><?php } ?>
		</div>
	</div>
</div>