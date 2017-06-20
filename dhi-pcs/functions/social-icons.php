<?php

/*************************************************************************************
 * Social Icons list
 *************************************************************************************/

if( !function_exists( 'eventerra_social_icons_list' ) ) { 
	function eventerra_social_icons_list() {
		return array(
			'behance' => esc_html__('Behance','eventerra'),
			'delicious' => esc_html__('Delicious','eventerra'),
			'deviantart' => esc_html__('DeviantArt','eventerra'),
			'digg' => esc_html__('Digg','eventerra'),
			'dribbble' => esc_html__('Dribbble','eventerra'),
			'facebook' => esc_html__('Facebook','eventerra'),
			'flickr' => esc_html__('Flickr','eventerra'),
			'foursquare' => esc_html__('Foursquare','eventerra'),
			'github' => esc_html__('GitHub','eventerra'),
			'google-plus' => esc_html__('Google+','eventerra'),
			'instagram' => esc_html__('Instagram','eventerra'),
			'lastfm' => esc_html__('Last.fm','eventerra'),
			'linkedin' => esc_html__('LinkedIn','eventerra'),
			'openid' => esc_html__('OpenID','eventerra'),
			'pinterest' => esc_html__('Pinterest','eventerra'),
			'skype' => esc_html__('Skype','eventerra'),
			'soundcloud' => esc_html__('SoundCloud','eventerra'),
			'spotify' => esc_html__('Spotify','eventerra'),
			'tumblr' => esc_html__('Tumblr','eventerra'),
			'twitter' => esc_html__('Twitter','eventerra'),
			'vimeo' => esc_html__('Vimeo','eventerra'),
			'vine' => esc_html__('Vine','eventerra'),
			'vk' => esc_html__('VK','eventerra'),
			'wordpress' => esc_html__('WordPress','eventerra'),
			'xing' => esc_html__('XING','eventerra'),
			'yahoo' => esc_html__('Yahoo!','eventerra'),
			'youtube' => esc_html__('YouTube','eventerra'),
		);
	}
}

/*************************************************************************************
 * Social Icons HTML List
 *************************************************************************************/

if( !function_exists( 'eventerra_get_social_icons' ) ) { 
	function eventerra_get_social_icons() {

		$prefix='social-icon-';
		$divider='';
		
		$socials=wp_cache_get( 'social_icons', 'eventerra' );
		if($socials !== false) {
			return $socials;
		}
			
		$icons=eventerra_social_icons_list();
		if(function_exists('eventerra_social_icons_sort')) {
			eventerra_social_icons_sort($icons);
		}
			
		$arr=array();
		foreach($icons as $k=>$v) {
			if($url=get_option('eventerra_social_'.$k)) {
				$arr[]='<a href="'.esc_url($url).'" class="om-social-icon '.esc_attr($prefix.$k).'" title="'.esc_attr($v).'" target="_blank"><i class="omfi omfi-'.esc_attr($k).'"></i></a>';
			}
		}
		$socials=implode($divider, $arr);
		wp_cache_set( 'social_icons', $socials, 'eventerra' );
		
		return $socials;
		
	}
}

if( !function_exists( 'eventerra_the_social_icons' ) ) { 
	function eventerra_the_social_icons() {
		echo eventerra_get_social_icons();
	}
}

if( !function_exists( 'eventerra_are_social_icons_set' ) ) { 
	function eventerra_are_social_icons_set() {
		$icons=eventerra_get_social_icons();
		return ! empty($icons);
	}
}

/*************************************************************************************
 *	Social Icons Sort Page
 *************************************************************************************/

function eventerra_social_icons_sort_page_add() {
	add_theme_page(esc_html__('Sort Social Icons','eventerra'), esc_html__('Sort Social Icons','eventerra'), 'edit_theme_options', 'social_icons_sort', 'eventerra_social_icons_sort_page');
}
add_action('admin_menu', 'eventerra_social_icons_sort_page_add', 20);

function eventerra_enqueue_scripts_social_icons_sort($hook) {
	if('appearance_page_social_icons_sort' != $hook)
		return;
		
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('om-social-icons-sort', EVENTERRA_TEMPLATE_DIR_URI.'/admin/js/items-sort.js', array('jquery','jquery-ui-sortable'));
}
add_action('admin_enqueue_scripts', 'eventerra_enqueue_scripts_social_icons_sort');

if( !function_exists( 'eventerra_social_icons_sort' ) ) { 
	function eventerra_social_icons_sort(&$list) {
		$order=get_option('eventerra_social_icons_order');
	
		if($order) {
			$order=explode(',',$order);
			$new_list=array();
			if(is_array($order)) {
				foreach($order as $k) {
					if(isset($list[$k])) {
						$new_list[$k]=$list[$k];
						unset($list[$k]);
					}
				}
			}
			$list=array_merge($new_list,$list);
		}
	}
}

function eventerra_social_icons_sort_page() {
	$list=eventerra_social_icons_list();
	eventerra_social_icons_sort($list);

	?>
	<div class="wrap">
		<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br /></div>
		<h2><?php esc_html_e('Sort Social Icons', 'eventerra'); ?></h2>
		<p><?php esc_html_e('Sort icons by drag-n-drop. Items at the top will appear first.', 'eventerra'); ?></p>
	
		<ul id="social_icons_items">
			<?php foreach($list as $k=>$v) { ?>
				<li id="<?php echo esc_attr($k); ?>" class="menu-item">
					<dl class="menu-item-bar">
						<dt class="menu-item-handle">
							<span class="menu-item-title"><?php echo esc_html($v) ?></span>
						</dt>
					</dl>
					<ul class="menu-item-transport"></ul>
				</li>
			<?php } ?>
		</ul>
	</div>
	<script>
		jQuery(document).ready(function($) {
			om_items_sort('#social_icons_items','social_icons_apply_sort');
		});
	</script>
	<?php wp_reset_postdata(); ?>
	<?php
}

function eventerra_social_icons_apply_sort() {
	global $wpdb;
	
	update_option('eventerra_social_icons_order', $_POST['order']);

	exit();
	
}
add_action('wp_ajax_social_icons_apply_sort', 'eventerra_social_icons_apply_sort');