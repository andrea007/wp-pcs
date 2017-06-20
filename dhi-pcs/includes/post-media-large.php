	<?php if(has_post_thumbnail()) { ?>
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
