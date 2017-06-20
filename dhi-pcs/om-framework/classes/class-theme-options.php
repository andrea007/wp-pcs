<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

class omfw_Theme_Options {

	protected $options_callback=null;
	
	/**
	 * Constructor
	 */
	public function __construct( $options = null ) {
		
		if(!empty($options)) {
			$this->set_options($options);
			$this->init();
		}
		
	}
	
	/**
	 * Initiazlization
	 */
	public function init() {

		add_action('after_switch_theme', array($this, 'setup_default'));
		add_action('admin_menu', array($this, 'add_theme_options_page'), 1);	
		add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_action('wp_ajax_omfw_theme_options_ajax', array($this, 'ajax_callback'));
		add_action('admin_init', array($this, 'options_rie'));

	}

	/**
	 * Set Options
	 */
	public function set_options($options) {
		$this->options_callback=$options;
	}

	/**
	 * Get Options
	 */
	public function get_options() {
		$options=array();
		if(!empty($this->options_callback) && is_callable($this->options_callback)) {
			$options=call_user_func($this->options_callback);
		}
		return $options;
	}
			
	/**
	 *	Add default options after activation
	 */
	public function setup_default() {
		
		$options=$this->get_options();
		foreach($options as $option) {
			if(isset($option['id']) && isset($option['std'])) {
				$db_option = get_option($option['id']);
				if($db_option === false){
					update_option($option['id'], $option['std']);
				}
			}
		}
		
		add_action('admin_init',array($this, 'setup_default_options_updated'));

	}
	
	public function setup_default_options_updated() {
		do_action('omfw_options_updated');
	}


	/**
	 * Add Options Page
	 */
	public function add_theme_options_page() {
	
	  add_theme_page(esc_html__('Theme Options', 'om-theme-framework'), esc_html__('Theme Options', 'om-theme-framework'), 'edit_theme_options', omfw_Framework::$theme_options_slug, array($this, 'options_page'));
		
	}
	
	/**
	 * CSS/JS for Options Page
	 */
	public function enqueue_scripts($hook) {
		if('appearance_page_'.omfw_Framework::$theme_options_slug != $hook)
			return;
			
		wp_enqueue_style('omfw-theme-options', OMFW_URL.'assets/css/theme-options.css', array(), OMFW_VERSION);
		wp_enqueue_style('wp-color-picker');
		
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('wp-color-picker');
		
		wp_enqueue_style('om-wp-color-picker-alpha', OMFW_URL.'assets/css/wp-color-picker-alpha.css', array('wp-color-picker'), OMFW_VERSION);
		wp_enqueue_script('om-wp-color-picker-alpha', OMFW_URL.'assets/js/wp-color-picker-alpha.js', array('wp-color-picker'), OMFW_VERSION);

		wp_enqueue_script('omfw-admin-browse-button', OMFW_URL . 'assets/js/browse-button.js', array('jquery'), OMFW_VERSION);
		if(function_exists( 'wp_enqueue_media' ))
			wp_enqueue_media();

		wp_enqueue_script('omfw-theme-options', OMFW_URL.'assets/js/theme-options.js', array('jquery'), OMFW_VERSION);
	
		add_action('admin_head', array($this, 'options_page_messages'));
	}
	
	/**
	 * Options Page Messages
	 */
	public function options_page_messages(){
		?>
	 	<script type="text/javascript" language="javascript">
			jQuery(function($){
				
				<?php if(isset($_REQUEST['reset'])) { ?>
					var reset_popup = $('#om-popup-reset');
					reset_popup.fadeIn();
					window.setTimeout(function(){
						reset_popup.fadeOut();                        
					}, 2000);
				<?php } ?>
				
				<?php if(isset($_REQUEST['import_ok'])) { ?>
					var import_ok_popup = $('#om-popup-import-ok');
					import_ok_popup.fadeIn();
					window.setTimeout(function(){
						import_ok_popup.fadeOut();                        
					}, 3000);
				<?php } ?>
	
				<?php if(isset($_REQUEST['import_error'])) { ?>
					var import_ok_error = $('#om-popup-import-error');
					import_ok_error.fadeIn();
					window.setTimeout(function(){
						import_ok_error.fadeOut();                        
					}, 4000);
				<?php } ?>
				
			});
			</script>
	<?php
	}
	
	/**
	 * Options Page
	 */
	public function options_page() {

		$options_html_safe = $this->get_options_html();

		?>
			<div class="wrap" id="om-container">
				<div id="om-popup-save" class="om-popup"><div><?php esc_html_e('Options Updated', 'om-theme-framework'); ?></div></div>
				<div id="om-popup-reset" class="om-popup"><div><?php esc_html_e('Options Reset', 'om-theme-framework'); ?></div></div>
				<div id="om-popup-import-ok" class="om-popup"><div><?php esc_html_e('Options Imported', 'om-theme-framework'); ?></div></div>
				<div id="om-popup-import-error" class="om-popup"><div><?php esc_html_e('Sorry, there has been an error while import', 'om-theme-framework'); ?></div></div>
				<form action="" enctype="multipart/form-data" id="om-options-form">
					<div id="om-container-header">
						<h2><?php esc_html_e('Theme Options', 'om-theme-framework'); ?></h2>
				  </div>
					
					<div class="om-save_bar om-top">
						<img style="display:none;margin-right:7px;vertical-align:middle" src="<?php echo OMFW_URL ?>assets/img/loading.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
						<input type="submit" value="<?php esc_html_e('Save All Changes','om-theme-framework');?>" class="button-primary" />
					</div>
					<div id="om-container-pane">
						<div id="om-options-sections">
							<ul>
								<?php echo $options_html_safe['menu']; ?>
							</ul>
						</div>
						<div id="om-options-content">
							<?php echo $options_html_safe['options']; ?>
						</div>
					</div>
					<div class="om-save_bar om-bottom">
						<input type="button" value="<?php esc_html_e('Reset Options','om-theme-framework');?>" class="button submit-button om-reset-button" onclick="if(confirm('Click OK to reset. Any settings will be lost!')){document.getElementById('om-options-form-reset').submit()}">
						<img style="display:none;margin-right:7px;vertical-align:middle" src="<?php echo OMFW_URL ?>assets/img/loading.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
						<input type="submit" value="<?php esc_html_e('Save All Changes','om-theme-framework');?>" class="button-primary" />
					</div>
				</form>
				<form action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" method="post" id="om-options-form-reset">
					<input type="hidden" name="omfw_options_action" value="reset" />
				</form>
			</div>
			
			<div class="om-clear"></div>
			<p><a href="#" onclick="jQuery('#om_options_import_export').slideToggle(200);return false;"><?php esc_html_e('(+) Export / Import Options','om-theme-framework'); ?></a></p>
			
			<div id="om_options_import_export" style="display:none;border-left:1px solid #eee;padding-left:20px">
				<b><?php esc_html_e('Export:','om-theme-framework'); ?></b>
				<form action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" method="post" target="_blank">
					<input type="submit" value="<?php esc_html_e('Download Export File','om-theme-framework');?>" class="button" />
					<input type="hidden" name="omfw_options_action" value="export" />
				</form>
			
				<br />
				<b><?php esc_html_e('Import:','om-theme-framework'); ?></b>
				<form action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" method="post" enctype="multipart/form-data">
					<?php esc_html_e('Choose a file from your computer:','om-theme-framework'); ?>
					<input type="file" name="import_file" size="25" />
					<input type="submit" value="<?php esc_html_e('Upload and Import','om-theme-framework');?>" class="button" />
					<input type="hidden" name="omfw_options_action" value="import" />
				</form>
			</div>
		
			<div class="om-clear"></div>
		<?php
		
	}

	/**
	 * Generate Options
	 */
	 
	protected function get_options_html() {
	
	  $counter = 0;
		$menu = '';
		$output = '';
		$options=$this->get_options();
		
		$dependency=array();
		
		foreach ($options as $option) {

			$counter++;

			//Start Heading
			if ( $option['type'] != "heading" ) {
				$output .= '<div class="om-options-section section-'.$option['type'].'">';
				if(isset($option['mode']) && $option['mode'] == 'toggle') {
					$output .= '<h3 class="heading"><a href="#" onclick="jQuery(\'#'.$option['id'].'-container\').slideToggle(300);return false">'. $option['name'] .' [+]</a></h3>';
					$output .= '<div class="option" id="'.$option['id'].'-container" style="display:none"><div class="om-options-controls">';
				} else {
					$output .= '<h3 class="heading">'. $option['name'] .'</h3>';
					$output .= '<div class="option"><div class="om-options-controls">';
				}
			}
			
			if ( isset($option['dependency']) && isset($option['id'])) {
				$tmp=$option['dependency'];
				unset($tmp['id']);
				$tmp['target']=$option['id'];
				if(isset($tmp['value']) && !is_array($tmp['value'])) {
					$tmp['value']=array($tmp['value']);
				}
				$dependency[$option['dependency']['id']][]=$tmp;
			}
			
			switch ( $option['type'] ) {

				case 'heading':
					if($counter >= 2){
					   $output .= '</div>';
					}
					$jquery_click_hook = preg_replace("/[^A-Za-z0-9]/", "", strtolower($option['name']) );
					$jquery_click_hook = "om-option-section-" . $jquery_click_hook;
					$menu .= '<li><a title="'.  $option['name'] .'" href="#'.  $jquery_click_hook  .'">'.  $option['name'] .'</a></li>';
					$output .= '<div class="om-group" id="'. $jquery_click_hook  .'"><h2>'.$option['name'].'</h2>';
				break;
							
				case 'text':
					$val = get_option($option['id']);
					if($val === false && isset($option['std']))
						$val = $option['std'];

					$output .= '<input name="'. $option['id'] .'" id="'. $option['id'] .'" type="text" value="'. esc_attr($val) .'" class="om-options-input" />';
				break;

				case 'select':
					$val = get_option($option['id']);
					if($val === false && isset($option['std']))
						$val = $option['std'];
						
					$output .= '<select name="'. $option['id'] .'" id="'. $option['id'] .'" class="om-options-input">';
					foreach ($option['options'] as $k => $v) {
						$output .= '<option'. ($val == $k ? ' selected="selected"' : '') .' value="'.$k.'">'.$v.'</option>';
					} 
					$output .= '</select>';
				break;				
				
				case 'select2':
					$val = get_option($option['id']);
					if($val === false && isset($option['std']))
						$val = $option['std'];

					$output .= '<select name="'. $option['id'] .'" id="'. $option['id'] .'" class="om-options-input">';
					foreach ($option['options'] as $v) {
						$output .= '<option'. ($val == $v ? ' selected="selected"' : '') .'>'.$v.'</option>';
					}
					$output .= '</select>';
				break;

				case 'select-cat':
					$val = get_option($option['id']);
					if($val === false && isset($option['std']))
						$val = $option['std'];
					
					$args = array(
						'show_option_all'    => esc_html__('All Categories', 'om-theme-framework'),
						'show_option_none'   => esc_html__('No Categories', 'om-theme-framework'),
						'hide_empty'         => 0, 
						'echo'               => 0,
						'selected'           => $val,
						'hierarchical'       => 0, 
						'name'               => $option['id'],
						'class'              => 'postform',
						'depth'              => 0,
						'tab_index'          => 0,
						'taxonomy'           => 'category',
						'hide_if_empty'      => false 	
					);
					$output .= '<div class="om-options-input">'.wp_dropdown_categories( $args ).'</div>';
				break;
				
				case 'select-page':
					$val = get_option($option['id']);
					if($val === false && isset($option['std']))
						$val = $option['std'];
				
					$args=array(
						'post_type' => 'page',
						'post_status' => 'publish,private,pending,draft',
					);
					$arr=get_pages($args);
					$defaults = array(
						'depth' => 0,
						'child_of' => 0,
						'selected' => $val,
						'echo' => 0,
					);
	        $r = wp_parse_args( $args, $defaults );
					$output .= '<div class="om-options-input"><select name="'.$option['id'].'"><option value="0">'.esc_html__('None (default)','om-theme-framework').'</option>';
					$output .= walk_page_dropdown_tree($arr, 0, $r);
					$output .= '</select></div>';
				break;
	
				case 'select-tax':
					$val = get_option($option['id']);
					if($val === false && isset($option['std']))
						$val = $option['std'];
					
					$args = array(
						'show_option_all'    => esc_html__('All', 'om-theme-framework').' '.$option['taxonomy'],
						'show_option_none'   => esc_html__('No', 'om-theme-framework').' '.$option['taxonomy'],
						'hide_empty'         => 0, 
						'echo'               => 0,
						'selected'           => $val,
						'hierarchical'       => 0, 
						'name'               => $option['id'],
						'class'              => 'postform',
						'depth'              => 0,
						'tab_index'          => 0,
						'taxonomy'           => $option['taxonomy'],
						'hide_if_empty'      => false 	
					);
					$output .= '<div class="om-options-input">'.wp_dropdown_categories( $args ).'</div>';
				break;
				
				case 'textarea':
					$val = get_option($option['id']);
					if($val === false && isset($option['std']))
						$val = $option['std'];
											
					$rows = '8';
					if(isset($option['rows'])){
						$rows = $option['rows'];
					}
					$output .= '<textarea name="'. $option['id'] .'" id="'. $option['id'] .'" rows="'.$rows.'" class="om-options-input">'.esc_textarea($val).'</textarea>';
				break;
	
				case "radio":
					$val = get_option($option['id']);
					if($val === false && isset($option['std']))
						$val = $option['std'];

					$i=0;
					foreach ($option['options'] as $k => $v) {
						$output .= '<label><input type="radio" name="'. $option['id'] .'" value="'. $k .'" '. ($val == $k || ($val === false && $i == 0) ? ' checked="checked"' : '') .' /> ' . $v .'</label><br />';
						$i++;
					}
				break;
	
				case "checkbox": 
					$val = get_option($option['id']);
					if($val === false && isset($option['std']))
						$val = $option['std'];

					$output .= '<input type="checkbox" name="'.  $option['id'] .'" id="'. $option['id'] .'" value="true" '. ($val == 'true' ? ' checked="checked"' : '') .' />';
				break;
				
				case "multicheck":
					$val = get_option($option['id']);
					if($val === false && isset($option['std']))
						$val = $option['std'];
					
					foreach ($option['options'] as $k => $v) {
						$output .= '<input type="checkbox" name="'. $option['id'] .'['.$k.']" id="'. $option['id'] .'_'.$k .'" value="true" '. (isset($val[$k]) && $val[$k] == 'true' ? ' checked="checked"' : '') .' /><label for="'. $option['id'] .'_'.$k .'">'. $v .'</label><br />';
					}
				break;
				
				case "upload":
					$val = get_option($option['id']);
					if($val === false && isset($option['std']))
						$val = $option['std'];
						
					$output .= '
						<input name="'. $option['id'] .'" id="'. $option['id'] .'" type="text" value="'. esc_attr($val) .'" class="om-options-input" />
						<div class="om-upload_button_div">
							<span class="button om-input-browse-button" tabindex="0" id="'.$option['id'].'_browse" rel="'. $option['id'] .'" data-mode="preview" data-base-id="'.$option['id'].'" data-library="image" data-choose="'.esc_html__('Choose a file','om-theme-framework').'" data-select="'.esc_html__('Select','om-theme-framework').'">Browse Image</span>
							<span class="button om-input-browse-button-remove" tabindex="0" id="'. $option['id'] .'_remove" data-base-id="'.$option['id'].'" title="">Remove</span>
						</div>
						<div class="om-clear"></div>
						<div class="om-option-image-preview" id="'.$option['id'].'_image">'.($val? '<a href="'.esc_url($val).'" target="_blank"><img src="'.esc_url($val).'" /></a>':'').'</div>
						<div class="om-clear"></div>
					';
				break;
	
				case "note":
					$output .= '<div class="om-notes"'.(isset($option['id']) ? ' id="'. $option['id'] .'"' : '').'><p>'. $option['message'] .'</p></div>';
				break;
				
				case "intro":
					$output .= '<div class="om-intro"'.(isset($option['id']) ? ' id="'. $option['id'] .'"' : '').'><p>'. $option['message'] .'</p></div>';
				break;
				
				case "subheader":
					$output .= '<div class="om-subheader"><p>'. $option['message'] .'</p></div>';
				break;
				
				case "color":
					$val = get_option($option['id']);
					if($val === false && isset($option['std']))
						$val = $option['std'];
						
					$output .= '<input class="om-wp-color-picker'.( (isset($option['alpha']) && $option['alpha']) ? '-alpha' : '' ).'-field" name="'. $option['id'] .'" id="'. $option['id'] .'" type="text" value="'. esc_attr($val) .'" data-default-color="'. esc_attr($val) .'" />';
				break;   
				
				
				case 'font':
					$stored = get_option($option['id']);
					if($stored === false)
						$stored = $option['std'];
						
					if(!isset($stored['type'])) {
						$stored['type']='standard';
					}
		
					$output .= esc_html__('Source:','om-theme-framework').' <select name="'. $option['id'] .'[type]" id="'. $option['id'] .'" style="width:auto" onchange="jQuery(\'.om-font-'.$option['id'].'-type-box\').hide();jQuery(\'#'. $option['id'] .'_container_\'+this.value).show()">';
				
					$output .= '<option value="standard"'.($stored['type']=='standard' ? ' selected="selected"':'').'>'.esc_html__('Standard fonts','om-theme-framework').'</option>';
					$output .= '<option value="google"'.($stored['type']=='google'?' selected="selected"':'').'>'.esc_html__('Google.Fonts','om-theme-framework').'</option>';
					$output .= '<option value="external"'.($stored['type']=='external'?' selected="selected"':'').'>'.esc_html__('Any external fonts (e.g. Typekit)','om-theme-framework').'</option>';
					$output .=  '</select>';
					
					$output .= '<div id="'. $option['id'] .'_container_standard" class="om-font-'.$option['id'].'-type-box"'.(($stored['type']=='standard' || $stored['type'] == '')?'':' style="display:none"').'>';
					$output .= esc_html__('Font family:','om-theme-framework').' <select name="'. $option['id'] .'[standard][family]" id="'. $option['id'] .'_standard_family" style="width:auto">';
					$val=( isset($stored['standard']['family']) ? $stored['standard']['family'] : '' );
					foreach ($option['options'] as $k => $v) {
						$output .= '<option value="'.$k.'"'.($val==$k?' selected="selected"':'').'>'.$v.'</option>';
					} 
					$output .= '</select>';
					$output .= '</div>';
					
					$output .= '<div id="'. $option['id'] .'_container_google" class="om-font-'.$option['id'].'-type-box"'.(($stored['type']=='google')?'':' style="display:none"').'>';
					$output .= esc_html__('Font name:','om-theme-framework').' <input name="'. $option['id'] .'[google][family]" id="'. $option['id'] .'_google_family" type="text" value="'. esc_attr( isset($stored['google']['family']) ? $stored['google']['family'] : '') .'" style="width:250px" />';
					$output .= '<div class="om-options-note">'.sprintf(esc_html__('Choose the the font from %s and enter the name.', 'om-theme-framework'), '<a href="http://www.google.com/fonts" target="_blank">http://www.google.com/fonts</a>').'</div>';
					if(!isset($option['weights']) || in_array('normal', $option['weights'])) {
						if(!isset($stored['google']['weight_normal']))
							$stored['google']['weight_normal']=400;
						$output .= esc_html__('Font weight for normal text:','om-theme-framework').' <select name="'. $option['id'] .'[google][weight_normal]" id="'. $option['id'] .'_google_weight_normal" style="width:150px">
								<option value="100"'.($stored['google']['weight_normal']==100?' selected="selected"':'').'>100</option>
								<option value="200"'.($stored['google']['weight_normal']==200?' selected="selected"':'').'>200</option>
								<option value="300"'.($stored['google']['weight_normal']==300?' selected="selected"':'').'>300</option>
								<option value="400"'.($stored['google']['weight_normal']==400?' selected="selected"':'').'>400 ('.esc_html__('standard','om-theme-framework').')</option>
								<option value="500"'.($stored['google']['weight_normal']==500?' selected="selected"':'').'>500</option>
								<option value="600"'.($stored['google']['weight_normal']==600?' selected="selected"':'').'>600</option>
								<option value="700"'.($stored['google']['weight_normal']==700?' selected="selected"':'').'>700</option>
								<option value="800"'.($stored['google']['weight_normal']==800?' selected="selected"':'').'>800</option>
								<option value="900"'.($stored['google']['weight_normal']==900?' selected="selected"':'').'>900</option>
							</select>';
					}
					if(isset($option['weights']) && in_array('semibold', $option['weights'])) {
						if(!isset($stored['google']['weight_semibold']))
							$stored['google']['weight_semibold']=400;
						$output .= '<br/>'.esc_html__('Font weight for semibold text:','om-theme-framework').' <select name="'. $option['id'] .'[google][weight_semibold]" id="'. $option['id'] .'_google_weight_semibold" style="width:150px">
								<option value="100"'.($stored['google']['weight_semibold']==100?' selected="selected"':'').'>100</option>
								<option value="200"'.($stored['google']['weight_semibold']==200?' selected="selected"':'').'>200</option>
								<option value="300"'.($stored['google']['weight_semibold']==300?' selected="selected"':'').'>300</option>
								<option value="400"'.($stored['google']['weight_semibold']==400?' selected="selected"':'').'>400</option>
								<option value="500"'.($stored['google']['weight_semibold']==500?' selected="selected"':'').'>500</option>
								<option value="600"'.($stored['google']['weight_semibold']==600?' selected="selected"':'').'>600</option>
								<option value="700"'.($stored['google']['weight_semibold']==700?' selected="selected"':'').'>700</option>
								<option value="800"'.($stored['google']['weight_semibold']==800?' selected="selected"':'').'>800</option>
								<option value="900"'.($stored['google']['weight_semibold']==900?' selected="selected"':'').'>900</option>
							</select>';
					}
					if(!isset($option['weights']) || in_array('bold', $option['weights'])) {
						if(!isset($stored['google']['weight_bold']))
							$stored['google']['weight_bold']=700;
						$output .= '<br/>'.esc_html__('Font weight for bold text:','om-theme-framework').' <select name="'. $option['id'] .'[google][weight_bold]" id="'. $option['id'] .'_google_weight_bold" style="width:150px">
								<option value="100"'.($stored['google']['weight_bold']==100?' selected="selected"':'').'>100</option>
								<option value="200"'.($stored['google']['weight_bold']==200?' selected="selected"':'').'>200</option>
								<option value="300"'.($stored['google']['weight_bold']==300?' selected="selected"':'').'>300</option>
								<option value="400"'.($stored['google']['weight_bold']==400?' selected="selected"':'').'>400</option>
								<option value="500"'.($stored['google']['weight_bold']==500?' selected="selected"':'').'>500</option>
								<option value="600"'.($stored['google']['weight_bold']==600?' selected="selected"':'').'>600</option>
								<option value="700"'.($stored['google']['weight_bold']==700?' selected="selected"':'').'>700 ('.esc_html__('standard','om-theme-framework').')</option>
								<option value="800"'.($stored['google']['weight_bold']==800?' selected="selected"':'').'>800</option>
								<option value="900"'.($stored['google']['weight_bold']==900?' selected="selected"':'').'>900</option>
							</select>';
					}
	
					$output .= '<div class="om-options-note">'.esc_html__('Please, make sure that chosen font supports chosen weight', 'om-theme-framework').'</div>';
					$output .= '<div style="padding-bottom:5px"><i>'.sprintf(esc_html__('Latin charset by default. Include additional character sets for fonts (make sure at %s before that charset is available for chosen font):', 'om-theme-framework'), '<a href="http://www.google.com/fonts/" target="_blank">http://www.google.com/fonts/</a>').'</i></div>';
					foreach(omfw_Framework::$google_charsets as $charset=>$charset_name) {
						$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $option['id'] .'[google]['.$charset.']" value="true" '.(isset($stored['google'][$charset]) && $stored['google'][$charset]?' checked="checked"':'').' /> '.esc_html($charset_name).'</label> &nbsp;&nbsp; ';
					}
					$output .= '</div>';
					
					$output .= '<div id="'. $option['id'] .'_container_external" class="om-font-'.$option['id'].'-type-box"'.((@$stored['type']=='external')?'':' style="display:none"').'>';
					$output .= esc_html__('Embed code for the &lt;head&gt; section:','om-theme-framework').'<br/><textarea name="'. $option['id'] .'[external][embed]" id="'. $option['id'] .'_external_embed" rows="3" style="width:300px">'. esc_textarea(@$stored['external']['embed']) .'</textarea><br/>';
					$output .= esc_html__('Font family:','om-theme-framework').'<br/><input name="'. $option['id'] .'[external][family]" id="'. $option['id'] .'_external_family" type="text" value="'. esc_attr(@$stored['external']['family']) .'" style="width:300px" />';
					$output .= '<div class="om-options-note">'.esc_html__('Enter the value for "font-family" attribute, also you can specify the stack of the fonts', 'om-theme-framework').'</div>';
					$output .= '</div>';
				break;
				
				case "images":
					$val = get_option($option['id']);
					if($val === false && isset($option['std']))
						$val = $option['std'];
						
					$i = 0;
						   
					foreach ($option['options'] as $key => $v) { 
						$checked = '';
						$selected = '';
						if ( $val == $key || $val === false && $i == 0) {
							$checked = ' checked';
							$selected = 'om-radio-img-selected';
						}	
						$output .= '<span>';
						$output .= '<input type="radio" id="om-radio-img-' . $option['id'] . $i . '" class="checkbox om-radio-img-radio" value="'.$key.'" name="'. $option['id'].'" '.$checked.' />';
						$output .= '<div class="om-radio-img-label">'. $key .'</div>';
						$output .= '<img src="'.esc_url($v).'" alt="" class="om-radio-img-img '. $selected .'" onClick="document.getElementById(\'om-radio-img-'. $option['id'] . $i.'\').checked = true;" />';
						$output .= '</span>';
						$i++;
					}
				break; 
				
				case "info":
					$default = $option['std'];
					$output .= $default;
				break;
				
				case "styling_presets":
				
					$saved_std = get_option($option['id']);
					if(!is_array($saved_std))
						$saved_std=array();
	
					if(empty($saved_std))
						$output .= '<i>'.esc_html__('No presets created yet.','om-theme-framework').'</i><br />';
					else {
						$output .= '<table border="0" cellpadding="10" cellspacing="0">';
						foreach($saved_std as $k=>$v) {
							$output .= '<tr>
								<td style="border-bottom:1px dotted #aaa"><b>'.esc_html($k).'</b></td>
								<td style="border-bottom:1px dotted #aaa"><span class="button om-style-apply-button" tabindex="0" id="'.$option['id'].'_apply" data-optionid="'.$option['id'].'" data-optionname="'.esc_attr($k).'" data-redirect-url="'.omfw_Framework::theme_options_url('&rnd='.rand().'#om-option-section-styling').'">'.esc_html__('Apply','om-theme-framework').'</span></td>
								<td style="border-bottom:1px dotted #aaa"><span class="button om-style-remove-button" tabindex="0" id="'.$option['id'].'_apply" data-optionid="'.$option['id'].'" data-optionname="'.esc_attr($k).'">'.esc_html__('Remove','om-theme-framework').'</span></td>
							</tr>';
						}
						$output .= '</table><br />';
					}
					$output .= '<br /><b>'.esc_html__('Save current styling options as new preset:','om-theme-framework').'</b><br/>Name: <input type="text" name="'.$option['id'].'_new" style="width:60%" /> <span class="button" tabindex="0" id="om-styling-button-save">'.esc_html__('Save','om-theme-framework').'</span> <br />';
				break;
				
			} 
			
			if ( $option['type'] != "heading" ) { 
				if ( $option['type'] != "checkbox" ) 
					$output .= '<br/>';
					
				if(!isset($option['desc']))
					$explain_value = '';
				else
					$explain_value = $option['desc']; 
					
				$output .= '</div><div class="om-options-explain">'. $explain_value .'</div>';
				$output .= '<div class="om-clear"></div></div></div>';
			}
			
			if(isset($option['code']))
				$output.=$option['code'];
		  
		}
	
		$output .= '</div>';
		
		if(!empty($dependency)) {
		  $output.='<script>var om_theme_options_dependency='.wp_json_encode($dependency).'</script>';
		}

		return array('options'=>$output,'menu'=>$menu);
	
	}


	/**
	 *	Ajax Callback Action
	 */
	public function ajax_callback() {
	
		$action = $_POST['type'];
		if ( get_magic_quotes_gpc() ) {
			$_POST = stripslashes_deep( $_POST );
		}
		
		// Save All Options
		if ($action == 'options') {
			
			parse_str($_POST['data'],$output);
			$output=array_map( 'stripslashes_deep', $output );
			
			$options=$this->get_options();
			foreach($options as $option_array) {
	
				if(isset($option_array['id'])) { // Non - Headings...
	
					$id = $option_array['id'];
					$new_value = '';
					
					if(isset($output[$id])){
						$new_value = $output[$id];
					}
			
					switch($option_array['type']) {
						
						case 'checkbox':
							if($new_value == 'true')
								update_option($id,'true');
							else
								update_option($id,'false');
						break;
						
						case 'multicheck':
							$option_options = $option_array['options'];
		
							$tmp=array();					
							foreach ($option_options as $options_id => $options_value){
								
							  $tmp[$options_id]=isset($output[$id][$options_id]);
							}
							update_option($id,$tmp);
						break;
						
						case 'styling_presets':
							$tmp=array();
							
							if(is_array($option_array['options'])) {
								foreach($option_array['options'] as $k) {
									$tmp[$k]=@$output[$k];
								}
							}
							$name=$output[$id.'_new'];
							if($name) {
								$output[$id] = get_option($id);
								$output[$id][$name] = $tmp;
								update_option($id,$output[$id]);
							}
						break;
						
						default:
							update_option($id,$new_value);
						break;
						
					}
				}	
			}
			
			do_action('omfw_options_updated');
			
		}
		// Apply Styling
		elseif ($action == 'style_preset_apply') {
			
			$data = $_POST['data'];
			if(isset($data['id']) && $data['id'] != '' && isset($data['name']) && $data['name'] != '') {
				$presets = get_option($data['id']);
				$data['name']=stripslashes($data['name']);
				
				if(isset($presets[$data['name']]) && is_array($presets[$data['name']])) {
					foreach($presets[$data['name']] as $k=>$v) {
						update_option($k,$v);
					}
				}
				do_action('omfw_options_updated');
				
			}
		}
		// Remove Styling
		elseif ($action == 'style_preset_remove') {
			
			$data = $_POST['data'];
			if(isset($data['id']) && $data['id'] != '' && isset($data['name']) && $data['name'] != '') {
				$data['name']=stripslashes($data['name']);
				$presets = get_option($data['id']);
				unset($presets[$data['name']]);
				
				update_option($data['id'],$presets);
				
			}
		}
		
	  wp_die();
	
	}

	/**
	 * Reset/Import/Export Options
	 */
	public function options_rie() {
	
	  // Reset Options
	  if ( isset($_REQUEST['page']) && $_REQUEST['page'] == omfw_Framework::$theme_options_slug && isset($_REQUEST['omfw_options_action']) && $_REQUEST['omfw_options_action'] == 'reset') {
			$this->reset_options();
			header('Location: '.omfw_Framework::theme_options_url('&reset=true'));
			die;
	  }
	
		// Export Options
	  if ( isset($_REQUEST['page']) && $_REQUEST['page'] == omfw_Framework::$theme_options_slug && isset($_REQUEST['omfw_options_action']) && $_REQUEST['omfw_options_action'] == 'export') {
	  	$options_json=$this->options_export_dump();
	  	header("Content-Type: text/plain");
	  	header("Content-Length: ".strlen($options_json)."\n\n");
	  	$filename=( omfw_Framework::$theme_slug ? omfw_Framework::$theme_slug : 'theme') . '.options.dat';
	  	header("Content-Disposition: attachment; filename=".$filename);
			echo $options_json; // output into the file
			die;
	  }
	  
	  // Import Options
	  if ( isset($_REQUEST['page']) && $_REQUEST['page'] == omfw_Framework::$theme_options_slug && isset($_REQUEST['omfw_options_action']) && $_REQUEST['omfw_options_action'] == 'import' ) {
	  	if(@$_FILES['import_file']['tmp_name']) {
	  		if ( $this->options_do_import($_FILES['import_file']['tmp_name']) ) {
					header('Location: '.omfw_Framework::theme_options_url('&import_ok=true'));
					die;
	  		}
	  	}
	  	header('Location: '.omfw_Framework::theme_options_url('&import_error=true'));
			die;
	  }
		
	}
	
	protected function options_do_import($file) {
		$s=trim(omfw_Framework::read_file($file));
		$options=json_decode($s,true);
		
		return self::options_do_import_data($options);
	}
	
	public static function options_do_import_data($options) { // also used in demo import
		if(is_array($options)) {
			if($options['theme_prefix'] == omfw_Framework::$theme_prefix) {
				foreach($options['options'] as $k=>$v) {
					update_option($k, $v);
				}
				do_action('omfw_options_updated');
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Reset Options
	 */
	protected function reset_options() {
	
		$options=$this->get_options();
		foreach($options as $option) {
			if(isset($option['id'])) {
				update_option($option['id'], $option['std']);
			}
		}
		
		do_action('omfw_options_updated');
	}
	
	/**
	 * Export Options
	 */
	protected function options_export_dump() {
	
		$output = array('theme_prefix' => omfw_Framework::$theme_prefix, 'options' => array());
		
		$options=$this->get_options();
		foreach ($options as $option) {
		  if(isset($option['id']) && $option['id']) {
		  	$output['options'][$option['id']] = get_option($option['id']);
		  }
		}
	
		return json_encode($output);
	}

}