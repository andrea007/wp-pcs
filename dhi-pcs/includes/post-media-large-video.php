	<?php
	global $more;
	$more_original = $more;
	$more = 1;
	$media = get_media_embedded_in_content( apply_filters( 'the_content', get_the_content() ), array( 'video', 'iframe' ) );
	$more = $more_original;
	?>
	<?php if(!empty($media)) { ?>
		<div class="post-media">
			<?php
			$is_iframe = strpos($media[0], '<iframe') !== false;
			echo ( $is_iframe ? '<div class="responsive-embed">' : '' ) . $media[0] . ( $is_iframe ? '</div>' : '' );
			?>
		</div>
	<?php } elseif($video = get_post_meta($post->ID, 'eventerra_post_video', true) ) { ?>
		<div class="post-media">
			<?php
			global $wp_embed;
			echo $wp_embed->run_shortcode('[embed]'.esc_url($video).'[/embed]');
			?>
		</div>
	<?php } elseif(has_post_thumbnail()) { ?>
		<div class="post-media">
			<?php
				$img=eventerra_get_post_thumbnail(array(
					'srcset' => array(
						'post-media-large',
						'post-media-large-mobile',
					),
					'sizes'=>'(max-width: 768px) 728px, {post-media-large}px',
				));
				echo eventerra_hover_extras($img, false, get_permalink());
			?>
		</div>
	<?php } ?>
