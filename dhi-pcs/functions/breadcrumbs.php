<?php

function eventerra_breadcrumbs($caption='', $before='<div class="breadcrumbs">', $after='</div>', $separator=' / ') {
	global $post, $wp_query;

	$show_last=(get_option('eventerra_breadcrumbs_show_current') == 'true');
		
	if(function_exists('is_bbpress') && is_bbpress()) {
		remove_filter( 'bbp_no_breadcrumb', '__return_true' );
		echo bbp_get_breadcrumb(array(
			'before' => $before,
			'after' => $after,
			'sep' => $separator,
			'pad_sep' => 0,
			'crumb_before' => $caption,
			'include_current' => $show_last,
			'home_text' => esc_html__('Home','eventerra'),
		));
		add_filter( 'bbp_no_breadcrumb', '__return_true' );
		return;
	}
	
	$out=array();
	
	if( is_home() ) {
		
		if(is_front_page()) {
			
			// do nothing
			return;
			
		} else {
			$blog_page_id=get_option('page_for_posts');
			if($blog_page_id) {
				$blog = get_post($blog_page_id);
				if($show_last)
					$out[]=$blog->post_title;
				eventerra_breadcrumbs_add_parents($out,$blog);
			}
		}
		
	}	elseif ( is_attachment() ) {
		
		if($show_last)
			$out[]=$post->post_title;
		eventerra_breadcrumbs_add_parents($out,$post);
		
	} elseif( is_page() ) {

		if($show_last)
			$out[]=$post->post_title;
		eventerra_breadcrumbs_add_parents($out,$post);

	} elseif( is_single() ) {

		if( $post->post_type == 'portfolio' ) {

			if($show_last)
				$out[]=$post->post_title;

			if(function_exists('ompf_get_portfolio_root_page')) {
				$portfolio_page=ompf_get_portfolio_root_page($post->ID);

				if($portfolio_page) {
					$out[]='<a href="'. esc_url( get_permalink($portfolio_page->ID) ) .'">'.$portfolio_page->post_title.'</a>';
					eventerra_breadcrumbs_add_parents($out,$portfolio_page);
				}	
			}
			
		} elseif( $post->post_type == 'testimonials' ) {

			if($show_last)
				$out[]=$post->post_title;

		} elseif( $post->post_type == 'product' && function_exists('woocommerce_breadcrumb') ) {

			ob_start();
			woocommerce_breadcrumb();
			$woo=ob_get_clean();
			$out[]=$woo;
			
			if($show_last)
				$out[]=$post->post_title;

		} else {
			if($show_last)
				$out[]=$post->post_title;
	
			$blog_page_id=get_option('page_for_posts');
			if($blog_page_id) {
				
				$blog = get_post($blog_page_id);
				$out[]='<a href="'. esc_url( get_permalink($blog->ID) ) .'">'.$blog->post_title.'</a>';
				eventerra_breadcrumbs_add_parents($out,$blog);
				
			} else {
				
				$args = array(
					'post_type' => 'page',
					'posts_per_page' => 1,
					'meta_query' => array(
						array(
							'key' => '_wp_page_template',
							'value' => array('template-blog.php'),
							'compare' => 'IN',
						)
					)
				);
				
				$blog_page=false;
				$tmp_q = new WP_Query($args);
				if($tmp_q->post_count) {
					$blog_page=$tmp_q->posts[0];
				}
				wp_reset_postdata();
				
				if($blog_page) {
					$out[]='<a href="'. esc_url( get_permalink($blog_page->ID) ) .'">'.$blog_page->post_title.'</a>';
					eventerra_breadcrumbs_add_parents($out,$blog_page);
				}	
				
			}
		}

	}	elseif( is_category() ||  is_tag() || is_day() || is_month() || is_year()) {

		if($show_last)
			$out[]=eventerra_get_archive_page_title();

		$blog_page_id=get_option('page_for_posts');
		if($blog_page_id) {
			$blog = get_post($blog_page_id);
			$out[]='<a href="'. esc_url( get_permalink($blog->ID) ) .'">'.$blog->post_title.'</a>';
			eventerra_breadcrumbs_add_parents($out,$blog);
		}
		
	}	elseif( is_tax('portfolio-type') ) {
		
		if($show_last)
			$out[]=$wp_query->queried_object->name;

		$portfolio_root_cat=false;
		if($wp_query->queried_object->parent) {
			$tmp=get_term($wp_query->queried_object->parent,'portfolio-type');
			while($tmp->parent)
				$tmp=get_term($tmp->parent,'portfolio-type');
			$portfolio_root_cat=$tmp->term_id;
		}

		$args = array(
			'post_type' => 'page',
			'posts_per_page' => 1,
			'meta_query' => array(
				array(
					'key' => '_wp_page_template',
					'value' => 'template-portfolio.php',
				)
			)
		);
		if($portfolio_root_cat) {
			$args['meta_query'][]=array(
				'key' => 'ompf_portfolio_categories',
				'value' => array('0','',$portfolio_root_cat),
				'compare' => 'IN',
			);
		}
		$tmp_q = new WP_Query($args);
		if($tmp_q->post_count) {
			$portfolio_page=$tmp_q->posts[0];
		} else {
			$portfolio_page=false;
		}
		wp_reset_postdata();
		
		if($portfolio_page) {
			$out[]='<a href="'. esc_url( get_permalink($portfolio_page->ID) ) .'">'.$portfolio_page->post_title.'</a>';
			eventerra_breadcrumbs_add_parents($out,$portfolio_page);
		}		
	}
	
	$out[]='<a href="'. esc_url( home_url('/') ) .'">'.esc_html__('Home','eventerra').'</a>';
	if(is_rtl())
		echo wp_kses_post ( $before. implode( $separator, $out ) . $caption . (!$show_last ? $separator.'' : '') . $after );
	else
		echo wp_kses_post ( $before . $caption . implode( $separator, array_reverse($out) ) . (!$show_last ? $separator.'' : '') . $after );
}


function eventerra_breadcrumbs_add_parents(&$out,$post) {

	if($post->post_parent) {
		$parent=$post->post_parent;
		while($parent) {
			$tmp=get_post($parent);
			if($tmp) {
				$out[]='<a href="'. esc_url( get_permalink($tmp->ID) ) .'">'.$tmp->post_title.'</a>';
				$parent=$tmp->post_parent;
			} else {
				break;
			}
		}
	}

}