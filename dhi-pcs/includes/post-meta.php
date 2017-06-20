<?php 

$meta=array();

global $eventerra_wpb_shortcode_om_posts;

// date
if((get_option('eventerra_post_hide_date') != 'true' && is_single()) || isset($eventerra_wpb_shortcode_om_posts)) {
	$meta[]='<span class="post-date updated">'.get_the_time(get_option('date_format')) .'</span>';	
}

// categories
if(get_option('eventerra_post_hide_categories') != 'true') {
	if($post->post_type == 'portfolio') {
		$categories = get_the_term_list($post->ID, 'portfolio-type', '<span class="post-categories">', ', ', '</span>');
	} else {
		$categories = get_the_category_list(', ');
	}
	if($categories) {
		$categories='<span class="post-categories">'.$categories.'</span>';
		$meta[]=$categories;
	}
}
	
//tags
if(get_option('eventerra_post_hide_tags') != 'true') {
	$tags=get_the_tag_list('<span class="post-tags">', ', ', '</span>' );
	if($tags) {
		$meta[]=$tags;
	}
}

// comments
if(empty($post->post_password) && get_option('eventerra_hide_comments_post') != 'true' && get_option('eventerra_post_hide_comments') != 'true') {
	ob_start();
	comments_popup_link( '', '<span class="comments-count">1</span>', '<span class="comments-count">%</span>', '', '');
	$comments=ob_get_clean();
	if($comments && $comments != '<span></span>') {
		$comments='<span class="post-comments">'.$comments.'</span>';
		$meta[]=$comments;
	}
}

// author
if(get_option('eventerra_post_hide_author') != 'true') {
	ob_start();the_author_posts_link();$the_author_posts_link=ob_get_clean();
	$meta[]='<span class="post-author author vcard"><span>'. esc_html__('by','eventerra') .' </span><span class="fn">'. $the_author_posts_link .'</span></span>';
}


?>
<?php if(!empty($meta)) { ?>
	<div class="post-meta">
		<?php echo implode(' <span class="post-meta-divider"></span> ',$meta) ?>
	</div>
<?php } ?>
	