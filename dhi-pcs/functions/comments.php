<?php

/**
 * Comment form
 */
 
function eventerra_comment_form_before() {
	echo '<div class="new-comment"><div class="new-comment-pane">';
}
add_action('comment_form_before','eventerra_comment_form_before');

function eventerra_comment_form_after() {
	echo '</div></div>';
}
add_action('comment_form_after','eventerra_comment_form_after');

function eventerra_comment_form_logged_in($str) {
	return $str;
}
add_filter('comment_form_logged_in','eventerra_comment_form_logged_in');

function eventerra_comment_form_default_fields($fields) {

	$req = get_option( 'require_name_email' );
	$commenter = wp_get_current_commenter();
	
	$fields =  array(
		'author' => '
			<div class="om-column om-one-third">
				<div class="om-column-inner">
					<input type="text" name="author" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" tabindex="1" placeholder="'. esc_attr(esc_html__('Name', 'eventerra')) . ($req ? esc_attr(esc_html__("*", 'eventerra')) : '' ).'"'. ($req ? ' class="required"':'').' />
				</div>
			</div>
		',
		
		'email'  => '
			<div class="om-column om-one-third">
				<div class="om-column-inner">
					<input type="text" name="email" id="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" tabindex="2" placeholder="'. esc_attr(esc_html__('Email', 'eventerra')) . ($req ? esc_attr(esc_html__("*", 'eventerra')) : '' ).'"'. ($req ? ' class="required email"':'').' />
				</div>
			</div>
		',
		
		'url'    => '
			<div class="om-column om-one-third">
				<div class="om-column-inner">
					<input type="text" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="22" tabindex="3" placeholder="' . esc_attr(esc_html__('Website', 'eventerra')) . '" />
				</div>
			</div>
		',
	);
		
	return $fields;
}
add_filter('comment_form_default_fields','eventerra_comment_form_default_fields');

function eventerra_comment_form_before_fields() {
	echo '<div class="om-columns om-columns-s-pad commentform-line">';
}
add_action('comment_form_before_fields','eventerra_comment_form_before_fields');

function eventerra_comment_form_after_fields() {
	echo '</div>';
}
add_action('comment_form_after_fields','eventerra_comment_form_after_fields');

/**
 * Comments
 */

if( !function_exists( 'eventerra_comment' ) ) {
	
	function eventerra_comment($comment, $args, $depth) {
		
		$GLOBALS['comment'] = $comment; ?>
		<div class="comment" id="comment-<?php comment_ID() ?>">
			<div class="comment-inner depth-<?php echo esc_attr($depth); ?>" id="comment-inner-<?php comment_ID(); ?>">
				<div class="comment-meta clearfix-a">
					<div class="author"><cite class="fn"><?php comment_author_link() ?></cite></div>
					<div class="date"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(esc_html__('%1$s at %2$s','eventerra'), get_comment_date(),  get_comment_time()) ?></a></div>
					<?php
						$reply=get_comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'])));
						$reply=preg_replace('#<a([^>]*)>([\s\S]*)</a>#','<a$1><span>$2</span></a>',$reply);
						if($reply) {
							echo '<div class="reply">'.$reply.'</div>';
						}
					?>
					<?php edit_comment_link(esc_html__('(Edit)','eventerra'),'<div class="edit">','</div>') ?>
				</div>
				<div class="comment-text clearfix-a">
					<?php
						$avatar_safe=get_avatar( $comment->comment_author_email, 80 );
						if($avatar_safe) {
							?>
								<div class="pic clearfix-a">
									<div class="pic-inner">
										<?php echo $avatar_safe; ?>
									</div>
								</div>
							<?php
						}
					?>
					<div class="text<?php if($avatar_safe) echo ' with-avatar' ?>">
						<?php if ($comment->comment_approved == '0') : ?>
						   <p><em><?php esc_html_e('Your comment is awaiting moderation.','eventerra') ?></em></p>
						<?php endif; ?>
						<?php comment_text() ?>
					</div>
				</div>
			</div>
		<?php
	}
}

if( !function_exists( 'eventerra_pings_list' ) ) {
	function eventerra_pings_list($comment, $args, $depth) {
		
	  $GLOBALS['comment'] = $comment;
	  
	  ?><div id="comment-<?php comment_ID(); ?>"><?php comment_author_link();
	  
	}
}

?>