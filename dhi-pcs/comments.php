<?php
	$post_type=get_post_type();
	if($post_type != 'post' && $post_type != 'portfolio')
		$post_type='page';

	$fb_comments=false;
	if(function_exists('eventerra_facebook_comments') && get_option('eventerra_fb_comments_'.$post_type) == 'true') {
		if(get_option('eventerra_fb_comments_position') == 'after')
			$fb_comments='after';
		else
			$fb_comments='before';
	}
	
	$native_comments=(get_option('eventerra_hide_comments_'.$post_type) != 'true');

	if($native_comments && !comments_open() && !have_comments() )
		$native_comments=false;

	if($fb_comments || $native_comments) { ?>
								
		<div class="comments-section">
			
			<h3 class="comments-title"><?php esc_html_e('Comments', 'eventerra') ?></h3>
	
			<?php if($fb_comments == 'before') { eventerra_facebook_comments();	} ?>
			
			<?php if($native_comments) : ?>
	
				<!-- Native Comments -->
					<?php
					if ( post_password_required() ) {
						?><p class="nocomments"><?php esc_html_e('This post is password protected. Enter the password to view comments.', 'eventerra') ?></p><?php
					} else {
					
						?><div class="discussion" id="comments"><div class="discussion-comments"><?php
				
						/*************************************************************************************
						 *	New Comment Form
						 *************************************************************************************/
						
						if ( comments_open() ) {
					
							comment_form(array(
								'comment_field' => '<div class="commentform-textarea commentform-line"><textarea name="comment" id="comment" rows="4" tabindex="4" placeholder="' . esc_attr(esc_html__('Leave your message here', 'eventerra') . esc_html__("*", 'eventerra')) . '" class="required"></textarea></div><div class="clear"></div>',
								'comment_notes_before' => '',
								'comment_notes_after' => '',
								'title_reply' => '',
							));
							
						}
											
						/*************************************************************************************
						 *	Display comments
						 *************************************************************************************/	
						if ( have_comments() ) {
							
							if ( ! empty($comments_by_type['comment']) ) { // if there are normal comments 
								wp_list_comments(array(
									'type' => 'comment',
									'style' => 'div',
									'callback' => 'eventerra_comment'
								));
							}
						  
						  if ( ! empty($comments_by_type['pings']) ) { // if there are pings 
						
								?><h3 id="pings"><?php esc_html_e('Trackbacks for this post', 'eventerra') ?></h3><?php
						
						  	wp_list_comments(array(
						  		'type' => 'pings',
						  		'style' => 'div',
						  		'callback' => 'eventerra_pings_list'
						  	));
							}
						
							$nav_prev=get_previous_comments_link(esc_html__('Older Comments','eventerra'));
							$nav_next=get_next_comments_link(esc_html__('Newer Comments','eventerra'));
							if( $nav_prev || $nav_next ) {
								echo eventerra_prev_next_nav($nav_prev, $nav_next);
							}
						
							/*************************************************************************************
							 *	No comments or closed
							 *************************************************************************************/
						
							if ('closed' == $post->comment_status ) { // if the post has comments but comments are now closed 
								?><p class="nocomments"><?php esc_html_e('Comments are closed.', 'eventerra') ?></p><?php
							}
						}
						?>
						</div>
						<?php // <div class="discussion-comments">
						
						?></div><?php // <div class="discussion" id="comments">
					}
					?>
				<!-- / Native Comments -->
	
			<?php endif; ?>		
			
			<?php if($fb_comments == 'after') { eventerra_facebook_comments();	} ?>
		
		</div>
	<?php
	
	}