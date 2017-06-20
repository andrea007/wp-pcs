<?php

/*************************************************************************************
 *	Audio Player
 *************************************************************************************/

if ( !function_exists( 'eventerra_audio_player' ) ) {
	function eventerra_audio_player($post_id, $args=array()) {
		echo eventerra_get_audio_player($post_id, $args);
  }
}

if ( !function_exists( 'eventerra_get_audio_player' ) ) {
	function eventerra_get_audio_player($post_id, $args=array()) {
		
		$out='';
		
		$embed_code=get_post_meta($post_id, 'eventerra_audio_embed', true);
		if(trim($embed_code)) {
	
			$out.= '<div class="audio-block audio-block-embed">';
			
			if(stripos($embed_code, 'http://') === 0 || stripos($embed_code, 'https://') === 0) {
				global $wp_embed;
				$out.= '<div class="w-responsive-embed">'.$wp_embed->run_shortcode('[embed]'.esc_url($embed_code).'[/embed]').'</div>';
			} else {
				$out.= '<div class="w-responsive-embed">'.omfw_Framework::esc_embed($embed_code).'</div>';
			}
			
			$out.= '</div>';
			
		} else {
			
			$attr=array();
					
			$src_fields=array(
				'src' => 'eventerra_audio_src',
				'mp3' => 'eventerra_audio_mp3',
				'm4a' => 'eventerra_audio_m4a',
				'ogg' => 'eventerra_audio_ogg',
				'wav' => 'eventerra_audio_wav',
				'wma' => 'eventerra_audio_wma',
			);
			foreach($src_fields as $k=>$v) {
				$meta=get_post_meta($post_id, $v, true);
				if($meta) {
					$attr[$k]=$meta;
				}
			}
			
			if(!empty($attr)) {

				$out.= '<div class="audio-block audio-block-selfhosted">';
	
				$shortcode='[audio';
				foreach($attr as $k=>$v) {
					$shortcode.=' '.$k.'="'.esc_attr($v).'"';
				}
				$shortcode.=']';
				
				$out.= do_shortcode($shortcode);
				
				$out.= '</div>';
			}
			
		}
		
		return $out;
	}
}

/*************************************************************************************
 *	Video Player
 *************************************************************************************/

if ( !function_exists( 'eventerra_video_player' ) ) {
	function eventerra_video_player($post_id, $args=array()) {

		echo eventerra_get_video_player($post_id, $args);

  }
}

if ( !function_exists( 'eventerra_get_video_player' ) ) {
	function eventerra_get_video_player($post_id, $args=array()) {

		$out='';

		$embed_code=get_post_meta($post_id, 'eventerra_video_embed', true);
		if(trim($embed_code)) {
	
			$out.= '<div class="video-block video-block-embed">';
			
			if(stripos($embed_code, 'http://') === 0 || stripos($embed_code, 'https://') === 0) {
				global $wp_embed;
				$out.= '<div class="responsive-embed">'.$wp_embed->run_shortcode('[embed]'.esc_url($embed_code).'[/embed]').'</div>';
			} else {
				$out.= '<div class="responsive-embed">'.omfw_Framework::esc_embed($embed_code).'</div>';
			}
			
			$out.= '</div>';
			
		} else {
			
			$attr=array();
					
			$src_fields=array(
				'src' => 'eventerra_video_src',
				'mp4' => 'eventerra_video_mp4',
				'm4v' => 'eventerra_video_m4v',
				'webm' => 'eventerra_video_webm',
				'ogv' => 'eventerra_video_ogv',
				'wmv' => 'eventerra_video_wmv',
				'flv' => 'eventerra_video_flv',
			);
			foreach($src_fields as $k=>$v) {
				$meta=get_post_meta($post_id, $v, true);
				if($meta) {
					$attr[$k]=$meta;
				}
			}
			
			if(!empty($attr)) {
				
				$out.= '<div class="video-block video-block-selfhosted">';
				
				$poster=get_post_meta($post_id, 'eventerra_video_poster', true);
				if($poster) {
					$attr['poster']=$poster;
				}
				
				//$attr['width']=100;
				//$attr['height']=100;
				
				$shortcode='[video';
				foreach($attr as $k=>$v) {
					$shortcode.=' '.$k.'="'.esc_attr($v).'"';
				}
				$shortcode.=']';
				
				add_filter('wp_video_shortcode', 'eventerra_set_mediaelementplayer_video_100p');
				$out.= do_shortcode($shortcode);
				remove_filter('wp_video_shortcode', 'eventerra_set_mediaelementplayer_video_100p');

				$out.= '</div>';
			}

		}
		
		return $out;
	
  }
}

/**
 * Making native video player responsive
 */

if(!function_exists('eventerra_set_mediaelementplayer_video_100p')) {
	function eventerra_set_mediaelementplayer_video_100p($html) {
		
		if(preg_match('/width="([0-9]+)".*height="([0-9]+)"/',$html,$m) && $m[1]) {
			$html='<div class="om-wp-video-wrapper" style="padding-bottom:'.($m[2]/$m[1]*100).'%;" >'.$html.'</div>';
		}

		return $html;
	}
}

/*************************************************************************************
 * Archive Page Title
 *************************************************************************************/

if ( !function_exists( 'eventerra_get_archive_page_title' ) ) { 
	function eventerra_get_archive_page_title() {
		
		$out='';
		
		if (is_category()) { 
			$out = single_cat_title('',false);
		} elseif( is_tag() ) {
			$out = single_tag_title('',false);
		} elseif (is_day()) { 
			$out = esc_html__('Archive for', 'eventerra'); $out .= ' '.get_the_time('F jS, Y'); 
		} elseif (is_month()) { 
			$out = esc_html__('Archive for', 'eventerra'); $out .= ' '.get_the_time('F, Y'); 
		} elseif (is_year()) { 
			$out = esc_html__('Archive for', 'eventerra'); $out .= ' '.get_the_time('Y');
		} elseif (is_author()) { 
			if(get_query_var('author_name')) {
				$curauth = get_user_by('slug', get_query_var('author_name'));
			} else {
				$curauth = get_userdata(get_query_var('author'));
			}
			$out = esc_html__('All posts by', 'eventerra'); $out .= ' '.$curauth->nickname;
		} elseif( is_tax() ) {
			$out = single_term_title('',false);
		} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
			$out = esc_html__('Blog Archives', 'eventerra');
		} else { 
			$blog = get_post(get_option('page_for_posts'));
			$out = $blog->post_title;
		}
	 	
	 	return $out;
	}
}

/*************************************************************************************
 * Wrap paginate_links
 *************************************************************************************/

if ( !function_exists( 'eventerra_wrap_paginate_links' ) ) {  
	function eventerra_wrap_paginate_links($links) {
	
		if(!is_array($links))
			return '';
	
		$out='';
		$out.= '<div class="navigation-pages"><div class="navigation-pages-inner clearfix-a">';
		$out.= preg_replace('#(<a[^>]*>)(.*?)(</a>)#','$1<span>$2</span>$3',implode('',$links));
		$out.= '</div></div>';
	
		return $out;
	}
}

if ( !function_exists( 'eventerra_paginate_links_args' ) ) {  
	function eventerra_paginate_links_args($query=false) {

		if(!$query) {
			global $wp_query;
			$query=$wp_query;
		}

		return
			array(
				'base' => str_replace( '999999999', '%#%', esc_url( get_pagenum_link( '999999999' ) ) ),
				'format' => '?paged=%#%',
				'current' => $wp_query->query_vars['paged'] ? $wp_query->query_vars['paged'] : 1,
				'total' => $wp_query->max_num_pages,
				'type' => 'array',
				'prev_text' => '',
				'next_text' => '',
			);

	}
}

if ( !function_exists( 'eventerra_wp_link_pages' ) ) {  
	function eventerra_wp_link_pages($settings=array()) {
		
		$settings=array_merge(array(
			'echo' => true,
		),$settings);
		
		global $page;
		
		$links_safe=wp_link_pages(array(
			'before' => '<div class="navigation-pages wp-link-pages"><div class="navigation-pages-inner clearfix-a">',
			'after' => '</div></div>',
			'link_before' => '<span>', 
			'link_after' => '</span>', 
			'next_or_number' => 'number',
			'echo' => 0,
			'separator' => '',
		));
		
		if($page) {
			$links_safe=str_replace('<span>'.$page.'</span>','<span class="current">'.$page.'</span>',$links_safe);
		}
		
		if($settings['echo']) {
			echo $links_safe;
		} else {
		 	return $links_safe;
		}
	}
}


/*************************************************************************************
 * Prev/next pagination links
 *************************************************************************************/

function eventerra_prev_next_nav ($nav_prev=false, $nav_next=false) {
	
	if($nav_prev) {
		$nav_prev=preg_replace('/(<a[^>]*>)(.*?)(<\/a>)/', '$1<span class="navigation-a-inner">$2</span>$3', $nav_prev);
	}
	if($nav_next) {
		$nav_next=preg_replace('/(<a[^>]*>)(.*?)(<\/a>)/', '$1<span class="navigation-a-inner">$2</span>$3', $nav_next);
	}
	
	return '
		<div class="navigation-prev-next clearfix-a">
			'. ($nav_prev ? '<div class="navigation-prev">'. $nav_prev .'</div>' : '') .'
			'. ($nav_next ? '<div class="navigation-next">'. $nav_next .'</div>' : '') .'
		</div>
	';
	
}

/*************************************************************************************
 * Sidebar setup
 *************************************************************************************/

if( !function_exists( 'eventerra_custom_sidebar_setup' ) ) {
	function eventerra_custom_sidebar_setup($post_id) {

		if($post_id) {

			if(
				( get_post_type($post_id) == 'om-persons' && is_single($post_id) )
				//|| in_array(get_post_meta( $post_id, '_wp_page_template', true ), array('template-portfolio.php','template-flat.php'))
			) {
				$sidebar_type='hide';
			} else {
				$sidebar_type=get_post_meta($post_id, 'eventerra_sidebar_show', true);
			}
			
			$sidebar_pos=get_post_meta($post_id, 'eventerra_sidebar_custom_pos', true);

		} else {

			if(
				is_404()
				|| is_search()
				//|| is_tax('om-persons-type')
			) {
				$sidebar_type='hide';
			} else {
				$sidebar_type='';
			}
			$sidebar_pos='';
			
		}

		if($sidebar_type=='hide')
			omfw_Framework::body_add_class('sidebar-hidden');
		else
			omfw_Framework::body_add_class('sidebar-display');

		if($sidebar_pos == 'left')
			omfw_Framework::body_add_class('flip-sidebar');
		elseif($sidebar_pos == 'right')
			omfw_Framework::body_remove_class('flip-sidebar');
				
	}
}

/*************************************************************************************
 * Adjacent Custom Post
 *************************************************************************************/

function eventerra_get_previous_post($in_same_cat = false, $excluded_categories = '', $taxonomy='category', $orderby='post_date') {
	if((!$in_same_cat || $taxonomy=='category')  && $orderby == 'post_date')
		// use standard function for standard parameters - safer
		return get_previous_post($in_same_cat, $excluded_categories);
	else
		return eventerra_get_adjacent_post($in_same_cat, $excluded_categories, true, $taxonomy, $orderby);
}

function eventerra_get_next_post($in_same_cat = false, $excluded_categories = '', $taxonomy='category', $orderby='post_date') {
	if((!$in_same_cat || $taxonomy=='category') && $orderby == 'post_date')
		// use standard function for standard parameters - safer
		return get_next_post($in_same_cat, $excluded_categories);
	else
		return eventerra_get_adjacent_post($in_same_cat, $excluded_categories, false, $taxonomy, $orderby);
}

function eventerra_get_adjacent_post( $in_same_cat = false, $excluded_categories = '', $previous = true, $taxonomy='category', $orderby='post_date' ) {
	global $wpdb;

	if ( ! $post = get_post() )
		return null;

	$current_post_order_val = $post->$orderby;
	if($orderby == 'menu_order' && $current_post_order_val == 0) {
		$orderby = 'post_date';
		$current_post_order_val = $post->$orderby;
	}

	$join = '';
	$posts_in_ex_cats_sql = '';
	if ( $in_same_cat || ! empty( $excluded_categories ) ) {
		$join = " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";

		if ( $in_same_cat ) {
			if ( ! is_object_in_taxonomy( $post->post_type, $taxonomy ) )
				return '';
			$cat_array = wp_get_object_terms($post->ID, $taxonomy, array('fields' => 'ids'));
			if ( ! $cat_array || is_wp_error( $cat_array ) )
				return '';
			$join .= " AND tt.taxonomy = '".$taxonomy."' AND tt.term_id IN (" . implode(',', $cat_array) . ")";
		}

		$posts_in_ex_cats_sql = "AND tt.taxonomy = '".$taxonomy."'";
		if ( ! empty( $excluded_categories ) ) {
			if ( ! is_array( $excluded_categories ) ) {
				// back-compat, $excluded_categories used to be IDs separated by " and "
				if ( strpos( $excluded_categories, ' and ' ) !== false ) {
					$excluded_categories = explode( ' and ', $excluded_categories );
				} else {
					$excluded_categories = explode( ',', $excluded_categories );
				}
			}

			$excluded_categories = array_map( 'intval', $excluded_categories );

			if ( ! empty( $cat_array ) ) {
				$excluded_categories = array_diff($excluded_categories, $cat_array);
				$posts_in_ex_cats_sql = '';
			}

			if ( !empty($excluded_categories) ) {
				$posts_in_ex_cats_sql = " AND tt.taxonomy = '".$taxonomy."' AND tt.term_id NOT IN (" . implode($excluded_categories, ',') . ')';
			}
		}
	}

	$adjacent = $previous ? 'previous' : 'next';
	$op = $previous ? '<' : '>';
	$order = $previous ? 'DESC' : 'ASC';

	$join  = apply_filters( "get_{$adjacent}_post_join", $join, $in_same_cat, $excluded_categories );
	$where = apply_filters( "get_{$adjacent}_post_where", $wpdb->prepare("WHERE p.".$orderby." $op %s AND p.post_type = %s AND p.post_status = 'publish' $posts_in_ex_cats_sql", $current_post_order_val, $post->post_type), $in_same_cat, $excluded_categories );
	$sort  = apply_filters( "get_{$adjacent}_post_sort", "ORDER BY p.".$orderby." $order LIMIT 1" );

	$query = "SELECT p.id FROM $wpdb->posts AS p $join $where $sort";
	$query_key = 'adjacent_post_' . md5($query);
	$result = wp_cache_get($query_key, 'counts');
	if ( false !== $result ) {
		if ( $result )
			$result = get_post( $result );
		return $result;
	}

	$result = $wpdb->get_var( $query );
	if ( null === $result )
		$result = '';

	wp_cache_set($query_key, $result, 'counts');

	if ( $result )
		$result = get_post( $result );

	return $result;
}

/*************************************************************************************
 * Adjacent Custom Post Link
 *************************************************************************************/

function eventerra_previous_post_link($format='&laquo; %link', $link='%title', $in_same_cat = false, $excluded_categories = '', $taxonomy='category', $orderby='post_date') {
	if((!$in_same_cat || $taxonomy=='category') && $orderby == 'post_date')
		// use standard function for standard parameters - safer
		previous_post_link($format, $link, $in_same_cat, $excluded_categories);
	else
		eventerra_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, true, $taxonomy, $orderby);
}

function eventerra_next_post_link($format='%link &raquo;', $link='%title', $in_same_cat = false, $excluded_categories = '', $taxonomy='category', $orderby='post_date') {
	if((!$in_same_cat || $taxonomy=='category') && $orderby == 'post_date')
		// use standard function for standard parameters - safer
		next_post_link($format, $link, $in_same_cat, $excluded_categories);
	else
		eventerra_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, false, $taxonomy, $orderby);
}

function eventerra_adjacent_post_link( $format, $link, $in_same_cat = false, $excluded_categories = '', $previous = true, $taxonomy='category', $orderby='post_date' ) {
	if ( $previous && is_attachment() )
		$post = get_post( get_post()->post_parent );
	else
		$post = eventerra_get_adjacent_post( $in_same_cat, $excluded_categories, $previous, $taxonomy, $orderby );

	if ( ! $post ) {
		$output = '';
	} else {
		$title = $post->post_title;

		if ( empty( $post->post_title ) )
			$title = $previous ? esc_html__( 'Previous Post', 'eventerra') : esc_html__( 'Next Post', 'eventerra' );

		$title = apply_filters( 'the_title', $title, $post->ID );
		$date = mysql2date( get_option( 'date_format' ), $post->post_date );
		$rel = $previous ? 'prev' : 'next';

		$string = '<a href="' . esc_url( get_permalink( $post ) ) . '" rel="'.$rel.'">';
		$inlink = str_replace( '%title', $title, $link );
		$inlink = str_replace( '%date', $date, $inlink );
		$inlink = $string . $inlink . '</a>';

		$output = str_replace( '%link', $inlink, $format );
	}

	$adjacent = $previous ? 'previous' : 'next';

	echo apply_filters( "{$adjacent}_post_link", $output, $format, $link, $post );
}

/*************************************************************************************
 * Slider
 *************************************************************************************/

if( !function_exists( 'eventerra_get_page_slider' ) ) {  
	function eventerra_get_page_slider($post_id, $settings=array()) {
		
		if(!$post_id)
			return false;
			
		$settings=array_merge(array(
			'id_field' => 'eventerra_slider_id',
			'layout_field' => 'eventerra_slider_layout',
			'layout' => false,
		), $settings);
		
		$ret=array(
			'type'=>'',
			'id'=>'',
			'layout'=>'',
		);
		
		$slider_id=get_post_meta( $post_id, $settings['id_field'], true );
		if($slider_id == '')
			return false;
		
		if($settings['layout']) {
			$ret['layout']=$settings['layout'];
		} else {
			$ret['layout']=get_post_meta( $post_id, $settings['layout_field'], true );
			if(!$ret['layout']) {
				$ret['layout']='boxed';
			}
		}
		
		// revslider
		if(substr($slider_id,0,strlen('revslider_')) == 'revslider_') {
			if(!class_exists('RevSlider'))
				return false;
			
			$ret['type']='revslider';
			$ret['id']=substr($slider_id,strlen('revslider_'));
			return $ret;
		}
		
		// layer slider
		if(substr($slider_id,0,strlen('lslider_')) == 'lslider_') {
			if(!isset($GLOBALS['lsPluginVersion']) && !defined('LS_PLUGIN_VERSION'))
				return false;
			
			$ret['type']='lslider';
			$ret['id']=substr($slider_id,strlen('lslider_'));
			return $ret;
		}
		
		
		return false;
		
	}
}

if( !function_exists( 'eventerra_display_page_slider' ) ) {  
	function eventerra_display_page_slider($slider, $echo = true) {
		
		if($slider && is_array($slider) && isset($slider['type']) && isset($slider['id'])) {
			
			if(!$echo)
				ob_start();
			
			switch($slider['type']) {
				
				case 'lslider':
					eventerra_layerslider($slider['id']);
				break;

				case 'revslider':
					eventerra_putRevSlider($slider['id']);
				break;
								
			}
			
			if(!$echo) {
				$buffer=ob_get_clean();
				return $buffer;
			}
			
		}
		
	}
}

/*************************************************************************************
 * Background Position Style
 *************************************************************************************/

if( !function_exists( 'eventerra_get_bg_img_pos_options()' ) ) {  
	function eventerra_get_bg_img_pos_options() {
		return array(
    	'repeat' => 'Repeat image',
    	'repeat_x_top' => 'Repeat-x image top',
    	'repeat_x_center' => 'Repeat-x image center',
    	'repeat_x_bottom' => 'Repeat-x image bottom',
    	'repeat_y_left' => 'Repeat-y image left',
    	'repeat_y_center' => 'Repeat-y image center',
    	'repeat_y_right' => 'Repeat-y image right',
    	'cover' => 'Cover',
    	'100w_top' => '100% width, Top',
    	'100w_center' => '100% width, Center',
    	'100w_bottom' => '100% width, Bottom',
    	'100h_left' => '100% height, Left',
    	'100h_center' => '100% height, Center',
    	'100h_right' => '100% height, Right',
    	'no_repeat_center' => 'No-Repeat Center',
    	'no_repeat_left_top' => 'No-Repeat Left Top',
    	'no_repeat_top' => 'No-Repeat Top',
    	'no_repeat_right_top' => 'No-Repeat Right Top',
    	'no_repeat_right' => 'No-Repeat Right',
    	'no_repeat_right_bottom' => 'No-Repeat Right Bottom',
    	'no_repeat_bottom' => 'No-Repeat Bottom',
    	'no_repeat_left_bottom' => 'No-Repeat Left Bottom',
    	'no_repeat_left' => 'No-Repeat Left',
    );
 }
}

if( !function_exists( 'eventerra_bg_img_pos_style' ) ) {  
	function eventerra_bg_img_pos_style($bg_pos) {

		$style=array();

		switch($bg_pos) {
			case 'cover':
				$style[]='background-position:center center';
				$style[]='background-size:cover';
			break;
			case '100w_top':
				$style[]='background-position:center top';
				$style[]='background-size:100% auto';
				$style[]='background-repeat:no-repeat';
			break;
			case '100w_center':
				$style[]='background-position:center center';
				$style[]='background-size:100% auto';
				$style[]='background-repeat:no-repeat';
			break;
			case '100w_bottom':
				$style[]='background-position:center bottom';
				$style[]='background-size:100% auto';
				$style[]='background-repeat:no-repeat';
			break;
			case '100h_left':
				$style[]='background-position:left center';
				$style[]='background-size:auto 100%';
				$style[]='background-repeat:no-repeat';
			break;
			case '100h_center':
				$style[]='background-position:center center';
				$style[]='background-size:auto 100%';
				$style[]='background-repeat:no-repeat';
			break;
			case '100h_right':
				$style[]='background-position:right center';
				$style[]='background-size:auto 100%';
				$style[]='background-repeat:no-repeat';
			break;
			case 'repeat':
				$style[]='background-repeat:repeat';
			break;
			case 'repeat_x_top':
				$style[]='background-repeat:repeat-x';
				$style[]='background-position:left top';
			break;			
			case 'repeat_x_center':
				$style[]='background-repeat:repeat-x';
				$style[]='background-position:left center';
			break;			
			case 'repeat_x_bottom':
				$style[]='background-repeat:repeat-x';
				$style[]='background-position:left bottom';
			break;
			case 'repeat_y_left':
				$style[]='background-repeat:repeat-y';
				$style[]='background-position:left top';
			break;			
			case 'repeat_y_center':
				$style[]='background-repeat:repeat-y';
				$style[]='background-position:center top';
			break;			
			case 'repeat_y_right':
				$style[]='background-repeat:repeat-y';
				$style[]='background-position:right top';
			break;
			case 'no_repeat_center':
				$style[]='background-repeat:no-repeat';
				$style[]='background-position:center center';
			break;
			case 'no_repeat_left_top':
				$style[]='background-repeat:no-repeat';
				$style[]='background-position:left top';
			break;
			case 'no_repeat_top':
				$style[]='background-repeat:no-repeat';
				$style[]='background-position:center top';
			break;
			case 'no_repeat_right_top':
				$style[]='background-repeat:no-repeat';
				$style[]='background-position:right top';
			break;
			case 'no_repeat_right':
				$style[]='background-repeat:no-repeat';
				$style[]='background-position:right center';
			break;
			case 'no_repeat_right_bottom':
				$style[]='background-repeat:no-repeat';
				$style[]='background-position:right bottom';
			break;
			case 'no_repeat_bottom':
				$style[]='background-repeat:no-repeat';
				$style[]='background-position:center bottom';
			break;
			case 'no_repeat_left_bottom':
				$style[]='background-repeat:no-repeat';
				$style[]='background-position:left bottom';
			break;			
			case 'no_repeat_left':
				$style[]='background-repeat:no-repeat';
				$style[]='background-position:left center';
			break;
		}
		
		return $style;
			
	}
}

/*************************************************************************************
 * Add helper classes to WP Menu
 *************************************************************************************/

function eventerra_nav_menu_has_children_class ($items) {
	
	foreach($items as $item) {
		if (eventerra_nav_menu_has_sub($item->ID, $items)) {
			$item->classes[] = 'menu-item-has-children';
		}
	}
	return $items;    
}

function eventerra_nav_menu_has_sub ($menu_item_id, &$items) {
  foreach ($items as $item) {
    if ($item->menu_item_parent && $item->menu_item_parent==$menu_item_id) {
      return true;
    }
  }
  return false;
}
if( version_compare($wp_version, '3.7.0', '<') ) {
	add_filter('wp_nav_menu_objects', 'eventerra_nav_menu_has_children_class');	
}

/*************************************************************************************
 * Custom menu walker
 *************************************************************************************/
 
class eventerra_Walker_Nav_Menu extends Walker_Nav_Menu {
  
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<div class=\"sub-menu\"><ul>\n";
	}
	
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul></div>\n";
	}
	
}

/*************************************************************************************
 * HTTP to local address // check if given URL could be converted to local address
 *************************************************************************************/

function eventerra_http2local ($url) {

	$path=rtrim(ABSPATH,'/');
	$home=rtrim(home_url('/'),'/');

	if(stripos($url, 'http') === 0) {
		$url_no_http=preg_replace('/^https?:\/\//i','',$url);
		$home_no_http=preg_replace('/^https?:\/\//i','',$home);

		if(stripos($url_no_http, $home_no_http) === 0) {
			$url_=$path.substr($url_no_http,strlen($home_no_http));
			if(file_exists($url_)) {
				$url=$url_;
			}
		}
	} elseif(substr($url,0,1) == '/') {
		$home_=preg_replace('/^https?:\/\//i','',$home);
		$url_=$url;
		if(strpos($home_, '/') !== false) {
			$home_=substr($home_,strpos($home_, '/'));
			if(stripos($url_, $home_) === 0) {
				$url_=substr($url_, strlen($home_));
			}
		}
		
		$url_=$path.$url_;
		if(file_exists($url_)) {
			$url=$url_;
		}
	}

	return $url;

}

/*************************************************************************************
 * Logo
 *************************************************************************************/

if( !function_exists( 'eventerra_get_logo' ) ) {
	function eventerra_get_logo() {

		$ret=array('logo_type' => 'none');

		$logo_type=get_option('eventerra_site_logo_type');
		
		if($logo_type == 'image') {

			
			$logo_image=esc_url(get_option('eventerra_site_logo_image'));
			$logo_image_2x=esc_url(get_option('eventerra_site_logo_image_2x'));
			
			if(!$logo_image)
				return $ret;
				
			$ret['logo_type']=$logo_type;
			$ret['href']=home_url('/');

			$logo_image_atts=getimagesize(eventerra_http2local($logo_image));
			if($logo_image_atts) {
				$ret['imagesize']=$logo_image_atts;
				$logo_image_atts[3].=' style="max-height:'.$logo_image_atts[1].'px"';
			} else {
				$logo_image_atts[3]='';
			}

			$logo_alt=esc_attr( get_bloginfo( 'name' ) );

			if($logo_image_2x) {
				$ret['image_block'] =
					'<img class="non-retina" src="'.esc_attr($logo_image).'" alt="'.$logo_alt.'"/ '.($logo_image_atts[3]).'>'. 
					'<img class="only-retina" src="'.esc_attr($logo_image_2x).'" alt="'.$logo_alt.'"/ '.($logo_image_atts[3]).'>'; 
			} else {
				$ret['image_block'] = '<img src="'.esc_attr($logo_image).'" alt="'.$logo_alt.'"/ '.($logo_image_atts[3]).'>';
			}
			
		} elseif($logo_type == 'text') {
			
			$text=esc_html(get_option('eventerra_site_logo_text'));
			$text=str_replace("\n",'<br/>',$text);
			$text=preg_replace('/\[color1\]([\s\S]*?)\[\/color1\]/i','<span class="logo-color-1">$1</span>',$text);
			$text=preg_replace('/\[color2\]([\s\S]*?)\[\/color2\]/i','<span class="logo-color-2">$1</span>',$text);
			$text=preg_replace('/\[color3\]([\s\S]*?)\[\/color3\]/i','<span class="logo-color-3">$1</span>',$text);
			
			if($text == '' || $text === false)
				return $ret;
			
			$ret['logo_type']=$logo_type;
			$ret['text_block'] = $text;
			$ret['href']=home_url('/');
			
		}

		return $ret;
	}
}

/*************************************************************************************
 *	Excerpt Length
 *************************************************************************************/

if( !function_exists( 'eventerra_excerpt_length' ) ) {
	function eventerra_excerpt_length($length) {
		return 25; 
	}
	add_filter('excerpt_length', 'eventerra_excerpt_length');
}

if( !function_exists( 'eventerra_more_link_tpl' ) ) {
	function eventerra_more_link_tpl( $atts=array() ) {
		$atts = shortcode_atts( array(
			'href' => '',
			'class' => '',
			'attr' => '',
			'label' => esc_html__('Read more','eventerra'),
		), $atts );
		
		if($atts['href'] == '') {
			$atts['href']=get_permalink();
		}
		
		return '<a href="'. esc_url($atts['href']) . '" class="read-more-link'.($atts['class'] ? ' '.esc_attr($atts['class']) : '').'"'.($atts['attr'] ? ' '.$atts['attr'] : '').'><span class="read-more-icon"></span>'.esc_html($atts['label']).'</a>';
	}
}

if( !function_exists( 'eventerra_blog_excerpt_length' ) ) {
	function eventerra_blog_excerpt_length($length) {
		$n=intval(get_option('eventerra_blog_excerpt_length'));
		if($n) {
			return $n;
		} else {
			return $length;
		}
	}
}

if( !function_exists( 'eventerra_excerpt_more' ) ) {
	function eventerra_excerpt_more( $more ) {
		global $post;
		return '&hellip;<p>'.eventerra_more_link_tpl(array('href' => get_permalink($post->ID))).'</p>';
	}
	add_filter('excerpt_more', 'eventerra_excerpt_more');
}

if( !function_exists( 'eventerra_the_content_more_link' ) ) {
	function eventerra_the_content_more_link( $more ) {
		global $post;
		return '<p>'.eventerra_more_link_tpl(array('href' => get_permalink())).'</p>';
	}
	add_filter('the_content_more_link', 'eventerra_the_content_more_link');
}

if( !function_exists( 'eventerra_blog_excerpt_more' ) ) {
	function eventerra_blog_excerpt_more( $more ) {
		global $post;
		return '&hellip;<p>'.eventerra_more_link_tpl(array('href' => get_permalink($post->ID))).'</p>';
	}
}

if( !function_exists( 'eventerra_blog_excerpt_no_more' ) ) {
	function eventerra_blog_excerpt_no_more( $more ) {
		return '&hellip;';
	}
}

function eventerra_custom_excerpt_more($excerpt, $return=false) {
	global $post;
	
	$more='<p>'.eventerra_more_link_tpl(array('href' => get_permalink($post->ID))).'</p>';
	
	//if( ($pos=strrpos($excerpt_safe, '</p>')) === false)
		$excerpt_safe = $excerpt_safe.$more;
	//else
	//	$excerpt_safe = substr($excerpt_safe,0,$pos).$more.substr($excerpt_safe,$pos);
	
	if($return)
		return $excerpt_safe;
	else
		echo $excerpt_safe;
}

/*************************************************************************************
 * Remove First Video From Content
 *************************************************************************************/
if(!function_exists('eventerra_content_remove_first_video')) {
	function eventerra_content_remove_first_video( $content ) {
		$media = get_media_embedded_in_content( $content );
		if(!empty($media)) {
			$preg_quote=preg_quote($media[0], '/');
			if(strpos($content, '<div class="responsive-embed">' . $media[0]) !== false) {
				$content = preg_replace('/<div class="responsive-embed">'.$preg_quote.'<\/div>/', '', $content, 1);
			} else {
				$content = preg_replace('/'.$preg_quote.'/', '', $content, 1);
			}
		}
		return $content;
	}
}
/*************************************************************************************
 * LayerSlider
 *************************************************************************************/

if(!function_exists('eventerra_layerslider')) {
	function eventerra_layerslider($id = 0, $page = '') {
		
		global $wpdb;
		
		$exists = $wpdb->get_row("
			SELECT EXISTS(
				SELECT * FROM ".$wpdb->prefix."layerslider
				WHERE id = ".(int)$id." AND flag_hidden = '0'	AND flag_deleted = '0'
			)" , ARRAY_N);
		if($exists[0] && function_exists('layerslider')) {
			layerslider($id, $page);
		}
	}
	
}

if(isset($GLOBALS['lsAutoUpdateBox'])) {
	add_action('layerslider_ready', 'eventerra_layerslider_ready');
	function eventerra_layerslider_ready() {
		// Disable auto-updates
		$GLOBALS['lsAutoUpdateBox'] = false;
	}
}

if(defined('LS_PLUGIN_BASE')) {
	remove_action('after_plugin_row_'.LS_PLUGIN_BASE, 'layerslider_plugins_purchase_notice');
}

/*************************************************************************************
 * Revolution Slider
 *************************************************************************************/

if(!function_exists('eventerra_putRevSlider')) {
	function eventerra_putRevSlider($data,$putIn = "") {
		if(function_exists('putRevSlider')) {
			putRevSlider($data,$putIn);
		}
	}
}

function eventerra_rev_slider_remove_notice($theme) {

	update_option('revslider-valid-notice', 'false');
	
}
add_action('after_switch_theme', 'eventerra_rev_slider_remove_notice'); 

if(function_exists( 'set_revslider_as_theme' )){
	add_action( 'init', 'eventerra_set_revslider_as_theme' );
	function eventerra_set_revslider_as_theme() {
		set_revslider_as_theme();
	}
}
