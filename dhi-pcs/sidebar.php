<?php

	if($post)
		$sidebar_type=get_post_meta($post->ID, 'eventerra_sidebar_show', true);
	else
		$sidebar_type='';

	if($sidebar_type == 'hide') {
		// no sidebar
	} else {
		?>
			<div class="content-column-sidebar">
				<div class="content-columns-inner">
					<aside>
					<?php
						// alternative sidebar
						if($post)
							$alt_sidebar=get_post_meta($post->ID, 'eventerra_sidebar', true);
						else
							$alt_sidebar=false;
	
						if($alt_sidebar)
							$sidebars=get_option("eventerra_extra_sidebars");
							
						if( $alt_sidebar && isset($sidebars[$alt_sidebar]) ) {
							dynamic_sidebar( 'extra-'.$alt_sidebar ); 
						} else {
							dynamic_sidebar();
						}
					?>
					</aside>
				</div>
			</div>
		<?php
	}