<?php get_template_part( 'includes/post-header-single' ); ?>

	<?php
		$media = get_media_embedded_in_content( apply_filters( 'the_content', get_the_content() ), array( 'video', 'iframe' ) );
	?>
	<?php if(!empty($media)) { ?>
		<div class="post-media">
			<?php
			$is_iframe = strpos($media[0], '<iframe') !== false;
			echo ( $is_iframe ? '<div class="responsive-embed">' : '' ) . $media[0] . ( $is_iframe ? '</div>' : '' );
			?>
		</div>
	<?php } elseif($video = get_post_meta($post->ID, 'eventerra_post_video', true)) { ?>
		<div class="post-media">
			<?php
				global $wp_embed;
				echo $wp_embed->run_shortcode('[embed]'.esc_url($video).'[/embed]');
			?>
		</div>
	<?php } elseif(has_post_thumbnail() && get_option('eventerra_post_single_show_thumb') == 'true') { ?>
		<div class="post-media">
			<?php eventerra_post_thumbnail('post-media-large'); ?>
		</div>
	<?php } ?>

<?php get_template_part( 'includes/post-footer-single', 'video' ); ?>