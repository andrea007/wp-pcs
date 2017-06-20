<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

class omfw_Styling {

	protected $styling_callback;
		
	protected $font_options=array();
	
	protected $use_inline_callback=null;
	
	protected $primary_style_handler=null;

	
	/**
	 * Constructor
	 */
	public function __construct($styling, $args = array()) {
		
		$this->styling_callback=$styling;

		if(!empty($args)) {
			if(isset($args['font_options'])) {
				$this->font_options=$args['font_options'];
			}
			if(isset($args['use_inline_callback'])) {
				$this->use_inline_callback=$args['use_inline_callback'];
			}
			if(isset($args['primary_style_handler'])) {
				$this->primary_style_handler=$args['primary_style_handler'];
			}
		}
		
		add_action('init', array($this, 'apply_styling'));
		add_action('admin_init', array($this, 'check_css_file'));
		add_action('omfw_options_updated', array($this, 'update_css_file'));
		
	}

	/**
	 * Include Fonts
	 */
	public function include_google_fonts() {

    /*
    Translators: If there are characters in your language that are not supported
    by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */
		if ( 'off' === _x( 'on', 'Google font: on or off', 'eventerra' ) ) {
			return false;
		}

		$charsets=array_keys(omfw_Framework::$google_charsets);
		
		$fonts=array();
		
		foreach($this->font_options as $v) {
			$option=get_option($v);
			if(isset($option['type']) && $option['type'] == 'google' && isset($option['google']))
				$fonts[]=$option['google'];
		}
		
		foreach($fonts as $arr) {
			
			$charsets_include=array();
			foreach($charsets as $charset) {
				if( isset($arr[$charset]) && $arr[$charset] ) {
					$charsets_include[]=$charset;
				}
			}

			$subset='';			
			if(!empty($charsets_include)) {
				$subset='&subset=latin,'.implode(',',$charsets_include);
			}

			$weights=array();
			if(isset($arr['weight_normal'])) {
				$weights[]=$arr['weight_normal'];
			}
			if(isset($arr['weight_semibold'])) {
				$weights[]=$arr['weight_semibold'];
			}
			if(isset($arr['weight_bold'])) {
				$weights[]=$arr['weight_bold'];
			}
			if(empty($weights)) {
				$weights=array(400,700);
			} else {
				$weights=array_unique($weights);
			}
			
			$family=urlencode($arr['family']).':'.implode(',',$weights).$subset;
			wp_enqueue_style(sanitize_title($family), '//fonts.googleapis.com/css?family='.$family);

		}
	}
	
	public function include_external_fonts() {

		foreach($this->font_options as $v) {
			$option=get_option($v);
			if(isset($option['type']) && $option['type'] == 'external' && isset($option['external']['embed']))
				echo omfw_Framework::esc_ext_fonts($base_font['external']['embed']);
		}
		
	}
	
	/**
	 * Inline styles mode check
	 */
	public function is_css_inline() {
		$use_inline=false;
		if(!empty($this->use_inline_callback) && is_callable($this->use_inline_callback)) {
			$use_inline=call_user_func($this->use_inline_callback);
		}
		$use_inline=apply_filters('omfw_use_inline_styling', $use_inline);
		
		return $use_inline;
	}

	/**
	 * Get Styling Code
	 */
	public function get_styling() {
		$code = '';
		
		if(is_callable($this->styling_callback)) {
			$code=call_user_func($this->styling_callback);
			
			$code=preg_replace('/\s*([\{\},;])\s*/','$1',$code);
			$code=str_replace(',{','{',$code);
			$code=trim($code);
		}
		
		return $code;
	}
	
	public function custom_style_file_path() {
		if ( is_multisite() ) {
			return '/style-custom-' . get_current_blog_id() . '.css';
		} else {
			return '/style-custom.css';
		}
	}

	public function apply_styling() {

		add_action('wp_enqueue_scripts', array($this, 'include_google_fonts'));
		add_action('wp_head', array($this, 'include_external_fonts'));
		
		// echo custom styling
		$use_inline=$this->is_css_inline();
		
		// check if file exists when file styling used
		if( !$use_inline && !file_exists( get_template_directory() . $this->custom_style_file_path() ) ) {
			$use_inline=true;
			/*
			if( get_option( omfw_Framework::$theme_prefix . 'style-custom-write-error' ) ) {
				$use_inline=true;
			} else {
				$this->update_css_file();
				if( !file_exists( get_template_directory() . $this->custom_style_file_path() ) ) {
					$use_inline=true;
				}
			}
			*/
		}
		
		if( $use_inline ) {
			add_action('wp_enqueue_scripts', array($this, 'apply_inline_css'));
		} else {
			add_action('wp_enqueue_scripts', array($this, 'apply_css_file'));
		}

	}

	public function apply_inline_css() {
		if($this->primary_style_handler) {
			$css=$this->get_styling();
			wp_add_inline_style($this->primary_style_handler, omfw_Framework::esc_css($css));
		}
	}
		
	function apply_css_file() {
		$file_version=get_option( omfw_Framework::$theme_prefix . 'style-custom-file-version' );
		if($file_version != omfw_Framework::$theme_version) {
			$this->update_css_file();
		}
		
		$salt=get_option( omfw_Framework::$theme_prefix . 'style-custom-salt' );
		if($salt != '')
			$salt='?rev='.$salt;
		wp_enqueue_style('omfw-style-custom', get_template_directory_uri() . $this->custom_style_file_path() . $salt);
	}
	
	/**
	 * Check if CSS file exists and has proper version
	 * On theme update CSS file should be updated or created if it doesn't exist
	 */
	
	public function check_css_file() {
		if( get_option( omfw_Framework::$theme_prefix . 'style-custom-file-version' ) != omfw_Framework::$theme_version ) {
			$use_inline=$this->is_css_inline();
			if( !$use_inline && ! get_option( omfw_Framework::$theme_prefix . 'style-custom-write-error' ) ) {
				$this->update_css_file();
			}
		}
	}
	
	/**
	 * Generate CSS file
	 */
	
	public function update_css_file() {

		if(function_exists('WP_Filesystem')) { // in case this function called before WP_Filesystem initialized
			add_filter('filesystem_method', array('omfw_Framework','_return_direct'));
			if(WP_Filesystem()) {
				global $wp_filesystem;
				if ( $wp_filesystem->put_contents( get_template_directory() . $this->custom_style_file_path(), $this->get_styling(), FS_CHMOD_FILE) ) {
					delete_option( omfw_Framework::$theme_prefix . 'style-custom-write-error' ); 
					update_option( omfw_Framework::$theme_prefix . 'style-custom-salt', rand(10000, 99999) ); 
					update_option( omfw_Framework::$theme_prefix . 'style-custom-file-version', omfw_Framework::$theme_version ); 
				} else {
					update_option( omfw_Framework::$theme_prefix . 'style-custom-write-error', true );
				}
			}
			remove_filter('filesystem_method', array('omfw_Framework','_return_direct'));
		}
		
	}

}