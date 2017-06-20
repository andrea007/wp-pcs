<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

class omfw_Live_Customizer {

	protected $customize_callback=null;
	
	protected $wp_customize=null;
	
	protected $controls_priority_counter=1;
	
	protected $dependencies=array();

	/**
	 * Constructor
	 */
	public function __construct( $customize ) {
		
		$this->customize_callback=$customize;
		
		add_action( 'customize_register', array($this, 'customize_register') );
		
		add_action('customize_save_after', array($this, 'customize_save_after') );
		
		if(is_customize_preview()) {
			$this->start_preview();
		}
	}
	
	/**
	 * Function to hook
	 */
	public function customize_register($wp_customize) {
		
		$this->wp_customize=$wp_customize;
		
		if(is_callable($this->customize_callback)) {
			call_user_func_array($this->customize_callback, array(
				$wp_customize,
				$this
			));
		}
		
	}

	public function add_as_theme_option($option, $args) {
		
		if(!empty($option) && isset($option['id'])) {
			
			switch($option['type']) {
				default:
					$sanitize_callback='wp_kses_post';
			}
			
			$this->wp_customize->add_setting( $option['id'] , array(
					'capability' => 'edit_theme_options',
					'type' => 'option',
					'sanitize_callback' => $sanitize_callback,
			) );
		
			switch($option['type']) {
				case 'text':
					$this->wp_customize->add_control(new WP_Customize_Control(
						$this->wp_customize,
						$option['id'],
						array(
							'label'          => $option['name'],
							'section'        => $args['section'],
							'settings'       => $option['id'],
							'type'           => 'text',
							'priority'       => $this->controls_priority_counter++,
						)
					));
				
					break;
					
				case 'textarea':
					$this->wp_customize->add_control(new omfw_Customize_Textarea_Control(
						$this->wp_customize,
						$option['id'],
						array(
							'label'          => $option['name'],
							'section'        => $args['section'],
							'settings'       => $option['id'],
							'type'           => 'textarea',
							'priority'       => $this->controls_priority_counter++,
						)
					));
				
					break;
	
				case 'checkbox':
					$this->wp_customize->add_control(new WP_Customize_Control(
						$this->wp_customize,
						$option['id'],
						array(
							'label'          => $option['name'],
							'section'        => $args['section'],
							'settings'       => $option['id'],
							'type'           => 'radio',
							'choices'        => array(
								'false' => 'No',
								'true' => 'Yes',
							),
							'priority'       => $this->controls_priority_counter++,
						)
					));
				
					break;		
					
				case 'upload':
					$this->wp_customize->add_control(new WP_Customize_Image_Control(
						$this->wp_customize,
						$option['id'],
						array(
							'label'          => $option['name'],
							'section'        => $args['section'],
							'settings'       => $option['id'],
							'priority'       => $this->controls_priority_counter++,
						)
					));
				
					break;		
	
				case 'images':
					$i=1;
					$choices=array();
					foreach($option['options'] as $k=>$v) {
						$choices[$k]=esc_html__('Variant','om-theme-framework').' '.$i;
						$i++;
					}
				
					$this->wp_customize->add_control(new WP_Customize_Control(
						$this->wp_customize,
						$option['id'],
						array(
							'label'          => $option['name'],
							'section'        => $args['section'],
							'settings'       => $option['id'],
							'type'           => 'radio',
							'choices'        => $choices,
							'priority'       => $this->controls_priority_counter++,
						)
					));	
					
					break;
					
				case 'select':
				
					$this->wp_customize->add_control(new WP_Customize_Control(
						$this->wp_customize,
						$option['id'],
						array(
							'label'          => $option['name'],
							'section'        => $args['section'],
							'settings'       => $option['id'],
							'type'           => 'select',
							'choices'        => $option['options'],
							'priority'       => $this->controls_priority_counter++,
						)
					));	
					
					break;	
					
				case 'color':
				
					$this->wp_customize->add_control(new WP_Customize_Color_Control(
						$this->wp_customize,
						$option['id'],
						array(
							'label'          => $option['name'],
							'section'        => $args['section'],
							'settings'       => $option['id'],
							'priority'       => $this->controls_priority_counter++,
						)
					));	
					
					break;

			}
			
			if ( isset($option['dependency']) && isset($option['id'])) {
				$tmp=$option['dependency'];
				unset($tmp['id']);
				$tmp['target']=$option['id'];
				if(isset($tmp['value']) && !is_array($tmp['value'])) {
					$tmp['value']=array($tmp['value']);
				}
				$this->dependencies[$option['dependency']['id']][]=$tmp;
			}
		
		}
	}
	
	public function start_preview() {
		add_filter( 'omfw_use_inline_styling', '__return_true' );
	}
	
	/**
	 * Hook to update custom css file
	 */
	public function customize_save_after() {
		do_action('omfw_options_updated');
	}
	
	/**
	 * Dependencies
	 */

	public function append_dependencies() {
		add_action('customize_controls_enqueue_scripts', array($this, 'dependencies_enqueue_scripts'));
	}
	
	public function dependencies_enqueue_scripts() {
		echo '<style>.om-lcd-option-hidden{display:none !important}</style>';
		echo '<script>var om_theme_live_customizer_dependency='.wp_json_encode($this->dependencies).'</script>';
		wp_enqueue_script('om-live-customizer-dep-scripts', OMFW_URL.'assets/js/live-customizer-dependencies.js', array(), OMFW_VERSION);
	}
		 
}

if(class_exists('WP_Customize_Control')) {

	if(!class_exists('omfw_Customize_Textarea_Control')) {
		
		class omfw_Customize_Textarea_Control extends WP_Customize_Control {
		    public $type = 'textarea';
		 
		    public function render_content() {
		        ?>
		        <label>
		        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		        <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		        </label>
		        <?php
		    }
		}
		
	}
	
	if(!class_exists('omfw_Customize_Notice_Control')) {
		
		class omfw_Customize_Notice_Control extends WP_Customize_Control {
		    public $type = 'notice';
		 
		    public function render_content() {
		        ?>
		        <span class="customize-control-title"><?php echo wp_kses($this->label, array(
							'a' => array(
								'href' => array(),
								'title' => array(),
								'target' => array(),
							),
							'br' => array(),
							'em' => array(),
							'strong' => array(),
							'i' => array(),
							'b' => array(),
							)
						); ?></span>
		        <input type="hidden" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
		        <?php
		    }
		}
		
	}

}

if(! function_exists('is_customize_preview') ) { // function exists since WP 4.0
	function is_customize_preview() {
		global $wp_customize;
		return is_a( $wp_customize, 'WP_Customize_Manager' ) && $wp_customize->is_preview();
	} 
}