<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

class omfw_Framework {
	
	public static $theme_prefix='omfw_';
	
	public static $theme_slug=null;
	
	public static $theme_version='';	
	
	public static $google_charsets=array();
	
	public static $body_classes=array();
	
	public static $page_css='';
	
	public static $theme_options_slug='omfw_options';
	
	public static $demo_import_slug='omfw_demo_import';
	
	public static $primary_style_handler=null;

  public static function init($args=array()) {
  	
		$args=wp_parse_args($args,array(
			'fix_footer_css_validation' => true,
		));

		$theme=wp_get_theme();
		$slug=preg_replace('/[^a-z0-9_-]/','',str_replace(' ','-',strtolower($theme->get('Name'))));
		if($slug != '') {
			self::$theme_slug=str_replace('_','-',$slug);
			self::$theme_prefix=str_replace('-','_',$slug).'_';
		}

		self::$google_charsets=array(
			'latin_ext' => esc_html__('Latin Extended', 'om-theme-framework'),
			'arabic' => esc_html__('Arabic', 'om-theme-framework'),
			'cyrillic' => esc_html__('Cyrillic', 'om-theme-framework'),
			'cyrillic_ext' => esc_html__('Cyrillic Extended', 'om-theme-framework'),
			'devanagari' => esc_html__('Devanagari', 'om-theme-framework'),
			'greek' => esc_html__('Greek', 'om-theme-framework'),
			'greek_ext' => esc_html__('Greek Extended', 'om-theme-framework'),
			'hebrew' => esc_html__('Hebrew', 'om-theme-framework'),
			'khmer' => esc_html__('Khmer', 'om-theme-framework'),
			'telugu' => esc_html__('Telugu', 'om-theme-framework'),
			'vietnamese' => esc_html__('Vietnamese', 'om-theme-framework'),
		);
		
		add_filter('body_class',array('omfw_Framework','body_classes'));
		add_action('wp_enqueue_scripts',array('omfw_Framework','page_css'));
		
		if($args['fix_footer_css_validation']) {
			add_filter('style_loader_tag', array('omfw_Framework','add_property_stylesheet'), 10, 2);
		}
  }

	/**
	 * Theme Options Wrapper
	 */
	public static function theme_options($options = null) {
		if(class_exists('omfw_Theme_Options')) {
			return new omfw_Theme_Options($options);
		} else {
			return false;
		}
	}

	/**
	 * Styling Wrapper
	 */
	public static function styling($styling, $args=array()) {
		if(class_exists('omfw_Styling')) {
			return new omfw_Styling($styling, $args);
		} else {
			return false;
		}
	}
	
	/**
	 * Live Customizer Wrapper
	 */
	public static function live_customizer($customize) {
		if(class_exists('omfw_Live_Customizer')) {
			return new omfw_Live_Customizer($customize);
		} else {
			return false;
		}
	}
	
	/**
	 * Plugins Wrapper
	 */
	public static function plugins($plugins) {
		if(class_exists('omfw_Plugins')) {
			return new omfw_Plugins($plugins);
		} else {
			return false;
		}
	}
	
	/**
	 * Theme Update Wrapper
	 */
	public static function theme_update($user, $key) {
		if(class_exists('omfw_Theme_Update')) {
			return new omfw_Theme_Update($user, $key);
		} else {
			return false;
		}
	}
	
	/**
	 * Demo Import Wrapper
	 */
	public static function demo_import($args) {
		if(class_exists('omfw_Demo_Import')) {
			return new omfw_Demo_Import($args);
		} else {
			return false;
		}
	}
	
	/**
	 * Meta Box Wrapper
	 */
	public static function meta_box($post_type, $metaboxes, $args=array()) {
		if(class_exists('omfw_Meta_Box')) {
			return new omfw_Meta_Box($post_type, $metaboxes, $args);
		} else {
			return false;
		}
	}

	/**
	 * Theme Options Page URL
	 */
	public static function theme_options_url($postfix='', $short_link=false) {
		$link='themes.php?page=' . self::$theme_options_slug . $postfix;
		if($short_link) {
			return $link;	
		} else {
			return admin_url($link);	
		}
	}
	
	/**
	 * Demo Import Page URL
	 */
	public static function demo_import_url($postfix='') {
		return admin_url('themes.php?page=' . self::$demo_import_slug . $postfix);
	}
	
	/**
	 * Get value from array by key
	 */ 
	public static function arr_get($array, $key, $default=null) {
		return ( isset($array[$key]) ? $array[$key] : $default );
	}
	
	/**
	 * Escape CSS
	 */ 
	public static function esc_css($string) {
		$string=wp_strip_all_tags($string);
		return $string;
	}

	/**
	 * Escape External Font Include Code
	 */ 	
	public static function esc_ext_fonts($string) {
		$string=wp_kses(
			$string,
			array(
				'link' => array(
					'href' => true,
					'rel' => true,
					'type' => true,
				),
				'style' => array(
					'type' => true,
				),
			)
		);
		
		return $string;
	}

	/**
	 * Escape Embed Codes
	 */ 		
	public static function esc_embed($string) {
		$string=wp_kses(
			$string,
			array_merge(
				wp_kses_allowed_html( 'post' ),
				array(
					'iframe' => array(
						'width' => true,
						'height' => true,
						'src' => true,
						'scrolling' => true,
						'frameborder' => true,
						'style' => true,
						'allowfullscreen' => true,
					),
				)
			)
		);
		
		return $string;
	}

	/**
	 * Body Classes Managment
	 */
	public static function body_classes($classes) {
		$classes_new=array();
	
		foreach($classes as $v) {
			if( ! ( isset(self::$body_classes[$v]) && self::$body_classes[$v]===false ) )
				$classes_new[]=$v; //add class
				
			if(isset(self::$body_classes[$v]) && self::$body_classes[$v])
				unset(self::$body_classes[$v]); //remove from additional list
		}
		
		foreach(self::$body_classes as $k => $v) {
			if($v)
				$classes_new[]=$k;
		}
	
		return $classes_new;
	}

	public static function body_add_class($class) {
		self::$body_classes[$class]=true;
	}

	public static function body_remove_class($class) {
		self::$body_classes[$class]=false;
	}

	/**
	 * Page Custom CSS
	 */
	public static function page_css() {

		if(self::$page_css != '' && self::$primary_style_handler) {
			wp_add_inline_style(self::$primary_style_handler, self::esc_css(self::$page_css));
		}
	}
	
	public static function page_add_css($css) {
		$css=trim($css);
		if(substr($css, -1) != ';') {
			$css.=';';
		}
		self::$page_css.=$css;
	}
	
	/**
	 * Slider Plugins Detection
	 *
	 * check if slider plugins active
	 * empty $sliders variable to check if any slider active
	 * specify slider slug in $sliders to check specific slider
	 */
	public static function is_slider_active($sliders='') {
		
		if(empty($sliders)) {
			$sliders=array(
				'revslider',
				'lslider',
			);
		} else {
			if(!is_array($sliders))
				$sliders=array($sliders);
		}
		
		foreach($sliders as $slider) {
			
			switch($slider) {
				
				case 'revslider':
					if( class_exists('RevSlider') )
						return true;
				break;
						
				case 'lslider':
					if( isset($GLOBALS['lsPluginVersion']) || defined('LS_PLUGIN_VERSION') )
						return true;
				break;
						
			}		
		}
		
		return false;
	}
	
	/**
	 * Encode function
	 */
	public static function str_encode($str, $type='base64') {
		$func=false;
		switch($type) {
			case 'base64':
			case 'json':
			case 'utf8':
				$func=$type.'_encode';
				break;
				
			case 'url':
			case 'rawurl':
				$func=$type.'encode';
				break;
		}
		if($func) {
			$str=call_user_func($func, $str);
			return $str;
		} else {
			return false;
		}
	}
	
	/**
	 * Decode function
	 */
	public static function str_decode($str, $type='base64') {
		$func=false;
		switch($type) {
			case 'base64':
			case 'json':
			case 'utf8':
				$func=$type.'_decode';
				break;
				
			case 'url':
			case 'rawurl':
				$func=$type.'decode';
				break;
		}
		if($func) {
			$str=call_user_func($func, $str);
			return $str;
		} else {
			return false;
		}
	}
	
	/**
	 *	Fix CSS loaded in footer validation error
	 */
	
	public static function add_property_stylesheet($tag, $handle) {
		$tag=str_replace("<link rel='stylesheet'", "<link rel='stylesheet' property='stylesheet'", $tag);
		return $tag;
	}
	
	/**
	 *	Gradient CSS Code
	 */
	
	public static function gradient_css($bg_color, $bg_color2, $type='vertical', $def_bg=false) {
		
		if(!$def_bg) {
			$def_bg=$bg_color;
		}
		
		$code='';
		
		if($type == 'horisontal') {
			$code=
				'background:'.$def_bg.';'.
				'background:-moz-linear-gradient(left, '.$bg_color.' 0%, '.$bg_color2.' 100%);'.
				'background:-webkit-linear-gradient(left, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
				'background:linear-gradient(to right, '.$bg_color.' 0%,'.$bg_color2.' 100%)'
			;
			
		}	elseif($type == 'diagonal1') {
			$code=
				'background:'.$def_bg.';'.
				'background:-moz-linear-gradient(45deg, '.$bg_color.' 0%, '.$bg_color2.' 100%);'.
				'background:-webkit-linear-gradient(45deg, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
				'background:linear-gradient(45deg, '.$bg_color.' 0%,'.$bg_color2.' 100%)'
			;
		}	elseif($type == 'diagonal2') {
			$code=
				'background:'.$def_bg.';'.
				'background:-moz-linear-gradient(-45deg, '.$bg_color.' 0%, '.$bg_color2.' 100%);'.
				'background:-webkit-linear-gradient(-45deg, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
				'background:linear-gradient(135deg, '.$bg_color.' 0%,'.$bg_color2.' 100%)'
			;
		}	elseif($type == 'radial') {
			$code=
				'background:'.$def_bg.';'.
				'background:-moz-radial-gradient(center, ellipse cover, '.$bg_color.' 20%, '.$bg_color2.' 100%);'.
				'background:-webkit-radial-gradient(center, ellipse cover, '.$bg_color.' 20%,'.$bg_color2.' 100%);'.
				'background:radial-gradient(ellipse at center, '.$bg_color.' 20%,'.$bg_color2.' 100%)'
			;
		}	else {
			$code=
				'background:'.$def_bg.';'.
				'background:-moz-linear-gradient(top, '.$bg_color.' 0%, '.$bg_color2.' 100%);'.
				'background:-webkit-linear-gradient(top, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
				'background:linear-gradient(to bottom, '.$bg_color.' 0%,'.$bg_color2.' 100%)'
			;
		}
		
		return $code;

	}
	
	/**
	 *	Array with number values in a row
	 */
	
	public static function array_number_values($args) {
		$out=array();
		
		if(!isset($args['from']) || !isset($args['to']) || !isset($args['step'])) {
			return $out;
		}
		
		for($i=$args['from']; $i<=$args['to']; $i+=$args['step']) {
			if(isset($args['sprintf'])) {
				$value=sprintf($args['sprintf'], $i);
			} else {
				$value=$i;
			}
			if(isset($args['associative']) && $args['associative']) {
				$out[$i]=$value;
			} else {
				$out[]=$value;
			}
		}
		
		return $out;
	}
	
	/**
	 *	Encode SVG images
	 */
	
	public static function svg_url_data($svg) {
		return 'data:image/svg+xml;base64,' . self::str_encode($svg);
	}
	
	/**
	 *	Read file
	 */
	 
	public static function _return_direct() {
		return 'direct';
	}
	 
	public static function read_file($file) {
		
		if(function_exists('WP_Filesystem')) { // in case this function called before WP_Filesystem initialized
			add_filter('filesystem_method', array('omfw_Framework','_return_direct'));
			$r=WP_Filesystem();
			remove_filter('filesystem_method', array('omfw_Framework','_return_direct'));
			if($r) {
				global $wp_filesystem;
				return $wp_filesystem->get_contents( $file );
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
}