<?php
eventerra_custom_sidebar_setup(false);
get_header(); ?>

	<div class="content">
		<?php eventerra_tpl_page_title(false, esc_html__('Search', 'eventerra')) ?>
		<div class="content-columns-wrapper clearfix-a">
			<div class="content-column-content">
				<div class="content-columns-inner">

						<?php 
							/*
							// set page to load all returned results
							global $query_string;
							query_posts( $query_string . '&posts_per_page=-1' );
							*/
							if( have_posts() ) {
								?>
								<p class="search-results-note"><?php printf( esc_html__('Search Results for: &ldquo;%s&rdquo;', 'eventerra'), get_search_query()); ?></p>
								<ol class="search-results-list">
									<?php
			
									// All Posts in one List
									while( have_posts() ) {
										the_post(); 
			            	if(has_post_thumbnail()) {
			            		$thumbnail=eventerra_get_post_thumbnail('media-one-fourth-square');
			            		$thumbnail='<div class="search-results-thumbnail"><a href="%1$s">'.$thumbnail.'</a></div>';
			            	} else {
			            		$thumbnail='';
			            	}
					          echo sprintf('<li class="clearfix-a'.($thumbnail ? ' with-thumbnail' : '').'">'.$thumbnail.'<div class="search-results-desc"><h4 class="search-result-title"><a href="%1$s">%2$s</a></h4><p>%3$s</p></div></li>', esc_url( get_permalink() ), get_the_title(), get_the_excerpt()); 
							    }
							  ?>
								</ol>
						    <?php						

							  echo eventerra_wrap_paginate_links ( paginate_links( eventerra_paginate_links_args() ) );
			         
			  			} else {
								?>
								<p><?php printf( esc_html__('Your search for "%s" did not match any entries','eventerra'), '<em>'.get_search_query().'</em>' ); ?></p>
			
			  				<?php get_search_form(); ?>
			  				<p><?php esc_html_e('Suggestions:','eventerra') ?></p>
			  				<ul>
			  					<li><?php esc_html_e('Make sure all words are spelled correctly.', 'eventerra') ?></li>
			  					<li><?php esc_html_e('Try different keywords.', 'eventerra') ?></li>
			  					<li><?php esc_html_e('Try more general keywords.', 'eventerra') ?></li>
			  				</ul>
								<?php
							}
						?>
				      							
				</div>
			</div>
							
		</div>
	</div>
<?php get_footer(); ?>