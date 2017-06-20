<?php

define('EVENTERRA_TEMPLATE_DIR', get_template_directory()); // without the trailing slash
define('EVENTERRA_TEMPLATE_DIR_URI', get_template_directory_uri()); // without trailing slash
define('EVENTERRA_THEME_VERSION', '1.1.3');

/*************************************************************************************
 *	WordPress minimum required version check
 *************************************************************************************/

if(version_compare($wp_version, '4.4', '<')) {

	function eventerra_wordpress_version_error() {
		echo '<div class="notice notice-error"><p style="font-size:120%"><strong>'.esc_html__('The theme requires WordPress 4.4 or greater. Please, update to proceed.', 'eventerra').'</strong></p></div>';
	}
	add_action( 'admin_notices', 'eventerra_wordpress_version_error' );
	
	return;
}
 
/*************************************************************************************
 *	Load Olevmedia Framework
 *************************************************************************************/

require_once (EVENTERRA_TEMPLATE_DIR . '/om-framework/om-framework.php');
omfw_Framework::init();
omfw_Framework::$theme_version=EVENTERRA_THEME_VERSION;
omfw_Framework::$primary_style_handler='eventerra-style';

/*************************************************************************************
 *	Translation Text Domain
 *************************************************************************************/

load_theme_textdomain('eventerra', EVENTERRA_TEMPLATE_DIR . '/languages');

/*************************************************************************************
 *	Register Menu
 *************************************************************************************/
 
if( !function_exists( 'eventerra_register_menu' ) ) {
	function eventerra_register_menu() {
	  register_nav_menu('primary-menu', esc_html__('Primary Menu', 'eventerra'));
	  register_nav_menu('secondary-menu', esc_html__('Secondary Menu', 'eventerra'));
	  register_nav_menu('menu-404', esc_html__('Menu for 404 Error page', 'eventerra'));
	}

	add_action('init', 'eventerra_register_menu');
}

if( !function_exists( 'eventerra_primary_menu_fallback' ) ) {
	function eventerra_primary_menu_fallback($args) {
	  $menu_safe=wp_page_menu(array(
	  	'echo' => false,
	 	));
	 	$args['menu_class'].=' primary-menu-fallback';
	 	$menu_safe=str_replace('<div class="menu"><ul>','<div class="menu"><ul class="'.esc_attr($args['menu_class']).'">',$menu_safe);
	 	$menu_safe=str_replace('page_item_has_children','menu-item-has-children',$menu_safe);
	 	$menu_safe=preg_replace('/<ul[^>]*class=[\'"]([^\'"]*)children([^\'"]*)[\'"][^>]*>/','<div class="$1sub-menu$2"><ul>',$menu_safe);
	 	$menu_safe=str_replace('</ul>','</ul></div>',$menu_safe);
	 	$menu_safe=str_replace('</ul></div></div>','</ul></div>',$menu_safe);
	 	if(isset($args['echo']) && $args['echo'] == false) {
	 		return $menu_safe;
	 	} else {
	 		echo $menu_safe;
	 	}
	}
}

if( !function_exists( 'eventerra_primary_mobile_menu_fallback' ) ) {
	function eventerra_primary_mobile_menu_fallback($args) {
	  $menu_safe=wp_page_menu(array(
	  	'echo' => false,
	 	));
	 	$args['menu_class'].=' primary-menu-fallback';
	 	$menu_safe=str_replace('<div class="menu"><ul>','<div class="primary-mobile-menu-container"><ul class="'.esc_attr($args['menu_class']).'">',$menu_safe);
	 	$menu_safe=str_replace('page_item_has_children','menu-item-has-children',$menu_safe);
	 	if(isset($args['echo']) && $args['echo'] == false) {
	 		return $menu_safe;
	 	} else {
	 		echo $menu_safe;
	 	}
	}
}

/*************************************************************************************
 *	Set Max Content Width
 *************************************************************************************/
 
if ( ! isset( $content_width ) ) $content_width = 1168;

/*************************************************************************************
 *	Post Formats
 *************************************************************************************/

if( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-formats', array(
			'aside',
			'gallery', 
			'link', 
			'image', 
			'quote', 
			'status',			
			'video',
			'audio',
			'chat',
	)); 
}

/*************************************************************************************
 *	Post Thumbnails
 *************************************************************************************/

add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 144, 144, true );

/*************************************************************************************
 *	Automatic Feed Links
 *************************************************************************************/

add_theme_support( 'automatic-feed-links' );

/*************************************************************************************
 *	Register Sidebars
 *************************************************************************************/

if( !function_exists('eventerra_widgets_init') ) {
	function eventerra_widgets_init() {
		
		register_sidebar(array(
			'name' => esc_html__('Main Sidebar','eventerra'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Sidebar that appears on the right/left (depends on Theme Options)','eventerra'),
			'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s"><div class="sidebar-widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="sidebar-widget-title">',
			'after_title' => '</div>',
		));
	
		$footer_columns_layout=get_option('eventerra_footer_layout');
		if( $footer_columns_layout == '1v4-1v4-1v4-1v4')
			$footer_columns=array(
				'footer-column-1'=>esc_html__('Footer 1st Column 1/4','eventerra'),
				'footer-column-2'=>esc_html__('Footer 2nd Column 1/4','eventerra'),
				'footer-column-3'=>esc_html__('Footer 3rd Column 1/4','eventerra'),
				'footer-column-4'=>esc_html__('Footer 4th Column 1/4','eventerra'),
			);
		elseif( $footer_columns_layout == '2v4-1v4-1v4')
			$footer_columns=array(
				'footer-column-1'=>esc_html__('Footer 1st Column 2/4','eventerra'),
				'footer-column-2'=>esc_html__('Footer 2nd Column 1/4','eventerra'),
				'footer-column-3'=>esc_html__('Footer 3rd Column 1/4','eventerra'),
			);
		elseif( $footer_columns_layout == '1v4-1v4-2v4')
			$footer_columns=array(
				'footer-column-1'=>esc_html__('Footer 1st Column 1/4','eventerra'),
				'footer-column-2'=>esc_html__('Footer 2nd Column 1/4','eventerra'),
				'footer-column-3'=>esc_html__('Footer 3rd Column 2/4','eventerra'),
			);
		elseif( $footer_columns_layout == '1v3-1v3-1v3')
			$footer_columns=array(
				'footer-column-1'=>esc_html__('Footer 1st Column 1/3','eventerra'),
				'footer-column-2'=>esc_html__('Footer 2nd Column 1/3','eventerra'),
				'footer-column-3'=>esc_html__('Footer 3rd Column 1/3','eventerra'),
			);
		elseif( $footer_columns_layout == '2v3-1v3')
			$footer_columns=array(
				'footer-column-1'=>esc_html__('Footer 1st Column 2/3','eventerra'),
				'footer-column-2'=>esc_html__('Footer 2nd Column 1/3','eventerra'),
			);
		elseif( $footer_columns_layout == '1v3-2v3')
			$footer_columns=array(
				'footer-column-1'=>esc_html__('Footer 1st Column 1/3','eventerra'),
				'footer-column-2'=>esc_html__('Footer 2nd Column 2/3','eventerra'),
			);
		elseif( $footer_columns_layout == '1v2-1v2')
			$footer_columns=array(
				'footer-column-1'=>esc_html__('Footer 1st Column 1/2','eventerra'),
				'footer-column-2'=>esc_html__('Footer 2nd Column 1/2','eventerra'),
			);
		else
			$footer_columns=array(
				'footer-column-1'=>esc_html__('Footer','eventerra'),
			);
	
		foreach($footer_columns as $id=>$name) {
			register_sidebar(array(
				'name' => $name,
				'description' => esc_html__('Appears in the footer of the site','eventerra'),
				'id' => $id,
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s"><div class="footer-widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="footer-widget-title">',
				'after_title' => '</div>',
			));	
		}
	
	
		$sidebars=get_option("eventerra_extra_sidebars");
		if(is_array($sidebars)) {
			foreach($sidebars as $k=>$v) {
				register_sidebar(array(
					'name' => esc_html__('Extra:','eventerra').' '.$v,
					'description' => esc_html__('This is an extra sidebar - it can be displayed on specific page instead of "Main sidebar"','eventerra'),
					'id' => 'extra-'.$k,
					'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s"><div class="sidebar-widget-inner">',
					'after_widget' => '</div></div>',
					'before_title' => '<div class="sidebar-widget-title">',
					'after_title' => '</div>',
				));	
			}
		}
	}
}

add_action( 'widgets_init', 'eventerra_widgets_init' );


/*************************************************************************************
 *	Widgets
 *************************************************************************************/

// Facebook
include_once( EVENTERRA_TEMPLATE_DIR . '/widgets/facebook/facebook.php' );

// Latest Tweets
include_once( EVENTERRA_TEMPLATE_DIR . '/widgets/tweets/tweets.php' );

// Contacts
include_once( EVENTERRA_TEMPLATE_DIR . '/widgets/contacts/contacts.php' );

/*************************************************************************************
 *	Front-end JS/CSS
 *************************************************************************************/

if(!function_exists('eventerra_enqueue_scripts')) {
	function eventerra_enqueue_scripts() {

		// styles
		wp_enqueue_style('eventerra-style', get_stylesheet_uri(), array(), EVENTERRA_THEME_VERSION);
		if(get_option('eventerra_responsive') == 'true') {
			wp_enqueue_style('eventerra-responsive-mobile', EVENTERRA_TEMPLATE_DIR_URI.'/css/responsive-mobile.css');
			if(is_rtl()) {
				wp_enqueue_style('eventerra-responsive-mobile-rtl', EVENTERRA_TEMPLATE_DIR_URI.'/css/responsive-mobile-rtl.css');
			}
		}

    /*
    Translators: If there are characters in your language that are not supported
    by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */
		if ( 'off' !== _x( 'on', 'Google font: on or off', 'eventerra' ) ) {
			wp_enqueue_style('montserrat700', '//fonts.googleapis.com/css?family=Montserrat:700'); // font for countdown
		}		
		
		wp_enqueue_style('omFont', EVENTERRA_TEMPLATE_DIR_URI.'/libraries/omFont/omFont.css');
		wp_register_style('font-awesome', EVENTERRA_TEMPLATE_DIR_URI.'/libraries/fontawesome/css/font-awesome.min.css', array(), '4.5.0');
		wp_register_style('linecons-omfi-ext', EVENTERRA_TEMPLATE_DIR_URI.'/libraries/linecons/style.css');
		wp_register_style('typicons', EVENTERRA_TEMPLATE_DIR_URI.'/libraries/typicons/typicons.css');
		
		if( ! in_array(get_option('eventerra_prettyphoto_lightbox'), array('disabled','disabled_no_action')) ) {
			wp_enqueue_style('eventerra-prettyphoto', EVENTERRA_TEMPLATE_DIR_URI.'/libraries/prettyphoto/css/prettyPhoto.custom.css');
			wp_enqueue_script('eventerra-prettyphoto', EVENTERRA_TEMPLATE_DIR_URI.'/libraries/prettyphoto/js/jquery.prettyPhoto.custom.min.js', array('jquery'), false, true);
		}

		// scripts

		//wp_enqueue_script('hoverIntent');
		wp_enqueue_script('omLibraries', EVENTERRA_TEMPLATE_DIR_URI.'/js/libraries.js', array('jquery'), false, true);
		wp_enqueue_script('superfish', EVENTERRA_TEMPLATE_DIR_URI.'/js/jquery.superfish.min.js', array('jquery'), false, true);
		wp_enqueue_script('omSlider', EVENTERRA_TEMPLATE_DIR_URI.'/js/jquery.omslider.min.js', array('jquery'), false, true);
		if(get_option("eventerra_lazyload") == 'true') {
			wp_enqueue_script('lazysizes', EVENTERRA_TEMPLATE_DIR_URI.'/js/lazysizes.min.js', array(), false, true);
		}
		wp_register_script('om-isotope', EVENTERRA_TEMPLATE_DIR_URI.'/js/isotope.pkgd.om.min.js', array('jquery'), false, true);
		wp_enqueue_script('waypoints', EVENTERRA_TEMPLATE_DIR_URI.'/js/jquery.waypoints.min.js', array('jquery'), false, true);
		wp_enqueue_script('kbwood-countdown', EVENTERRA_TEMPLATE_DIR_URI.'/js/jquery.countdown.min.js', array('jquery'), false, true);
		wp_enqueue_script('eventerra-custom', EVENTERRA_TEMPLATE_DIR_URI.'/js/custom.js', array('jquery','omLibraries'), EVENTERRA_THEME_VERSION, true);
		
		if(get_option('eventerra_sidebar_sliding') == 'true') {
			wp_enqueue_script('om-sticky-sidebar', EVENTERRA_TEMPLATE_DIR_URI.'/js/jquery.om.sticky.sidebar.js', array('jquery'), false, true);
		}
		
		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
		
  }

	add_action('wp_enqueue_scripts', 'eventerra_enqueue_scripts');
}

// theme custom css block
if(!function_exists('eventerra_custom_css_block')) {
	function eventerra_custom_css_block() {
		
		$custom_css=get_option('eventerra_code_custom_css');
		if($custom_css != '') {
			wp_add_inline_style('eventerra-style', omfw_Framework::esc_css($custom_css));
		}
	
  }
	add_action('wp_enqueue_scripts', 'eventerra_custom_css_block', 11);
}

/*************************************************************************************
 *	Extensions
 *************************************************************************************/

require_once ( EVENTERRA_TEMPLATE_DIR . '/libraries/aq_resizer/aq_resizer.php');
require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/misc.php' );
require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/styling.php' );
require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/social-icons.php' );
require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/templates.php' );
require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/breadcrumbs.php' );
require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/comments.php' );
require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/facebook-comments.php' );
require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/images.php' );
require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/speakers.php' );
require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/gallery-interface.php' );
require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/live-customizer.php' );
require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/megamenu.php' );
require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/icons.php' );
$wpb_dir = 'wpb';
if ( defined( 'WPB_VC_VERSION' ) && version_compare( WPB_VC_VERSION, '5.0', '<' ) ) {
	$wpb_dir = 'wpb-4.12';
	if ( version_compare( WPB_VC_VERSION, '4.11', '<' ) ) {
		function eventerra_show_js_composer_old_version_notice() {
			echo '<div id="message" class="error"><p><strong>'.esc_html__('Version of Visual Composer plugin installed on your WordPress is outdated and not compatible with current Theme. Please, navigate to "Appearance > Install Plugins" and update Visual Composer plugin.','eventerra').'</strong></p></div>';
		}
		add_action('admin_notices', 'eventerra_show_js_composer_old_version_notice');
		add_filter('option_' . 'eventerra_disable_wpb_addons', '__return_true');
	}
}
require_once ( EVENTERRA_TEMPLATE_DIR . '/' . $wpb_dir . '/wpb.php' );
require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/custom-javascript.php' );

	
if(is_admin()) {
	require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/plugins.php' );
	require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/demo-import.php' );
	require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/common-meta.php' );
	require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/metaboxes-theme.php' );
	require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/page-meta.php' );
	require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/post-meta.php' );
	require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/tc_events-meta.php' );
	require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/sidebars-manager.php' );
	require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/theme-update.php' );
	require_once ( EVENTERRA_TEMPLATE_DIR . '/functions/theme-options.php' );
}

/*************************************************************************************
 *	Embed wrap
 *************************************************************************************/

function eventerra_embed_oembed_html($html) {
	
	if(strpos($html, '<blockquote class="twitter-tweet"') === false)
		return '<div class="responsive-embed">'.$html.'</div>';
	else
		return $html;
	
}
add_filter('embed_oembed_html', 'eventerra_embed_oembed_html');

/*************************************************************************************
 *	Title
 *************************************************************************************/

function eventerra_title_tag() {
   add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'eventerra_title_tag' );

/*************************************************************************************
 *	Back to top button
 *************************************************************************************/
 
if(!function_exists('eventerra_back_to_top')) {
	function eventerra_back_to_top() {
		echo '<div class="om-back-to-top"><span class="om-back-to-top-link"></span><span class="om-back-to-top-icon"></span></div>';
  }
	if(get_option('eventerra_display_back_to_top') == 'true')
		add_action('wp_footer', 'eventerra_back_to_top');
}

/*************************************************************************************
 *	Contact Form 7 Styling
 *************************************************************************************/
 
if(!function_exists('eventerra_contact_form_7_ajax')) {
	function eventerra_contact_form_7_ajax($url) {
		$url=omfw_Framework::svg_url_data('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="28" height="28">
<circle class="path" cx="24" cy="24" r="20" fill="none" stroke="'.get_option('eventerra_side_text_color').'" stroke-width="4">
  <animate attributeName="stroke-dasharray" attributeType="XML" from="1,200" to="89,200" values="1,200; 89,200; 89,200" keyTimes="0; 0.5; 1" dur="1.5s" repeatCount="indefinite" />
  <animate attributeName="stroke-dashoffset" attributeType="XML" from="0" to="-124" values="0; -35; -124" keyTimes="0; 0.5; 1" dur="1.5s" repeatCount="indefinite" />
  <animateTransform attributeName="transform" attributeType="XML" type="rotate" from="0 24 24" to="360 24 24" dur="3s" repeatCount="indefinite"/>
</circle>
</svg>');
		return $url;
  }
	add_filter('wpcf7_ajax_loader', 'eventerra_contact_form_7_ajax');
}

if(!function_exists('eventerra_contact_form_7_def_form')) {
	function eventerra_contact_form_7_def_form($template, $prop) {
		if('form' == $prop) {
		$template =
			'<p class="label">' . esc_html__( 'Your Name', 'eventerra' ). esc_html__( '(required)', 'eventerra' ) .'</p>'. "\n".
			'<p>[text* your-name]</p>' . "\n\n".
			'<p class="label">' . esc_html__( 'Your Email', 'eventerra' ). esc_html__( '(required)', 'eventerra' ) .'</p>'. "\n".
			'<p>[email* your-email]</p>' . "\n\n".
			'<p class="label">' . esc_html__( 'Subject', 'eventerra' ) .'</p>'. "\n".
			'<p>[text your-subject]</p>' . "\n\n".
			'<p class="label">' . esc_html__( 'Your Message', 'eventerra' ) .'</p>'. "\n".
			'<p>[textarea your-message]</p>' . "\n\n".
			'<p>[submit "' . esc_html__( 'Send', 'eventerra' ) . '"]</p>';
		}
		
		return $template;
  }
	add_filter('wpcf7_default_template', 'eventerra_contact_form_7_def_form', 10, 2);
}