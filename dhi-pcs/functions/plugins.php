<?php

if ( defined( 'WPB_VC_VERSION' ) && version_compare(WPB_VC_VERSION, '5.1', '>') ) {
	function eventerra_show_js_composer_version_notice() {
		echo '<div id="message" class="error"><p><strong>'.esc_html__('Version of Visual Composer plugin installed on your WordPress is not yet tested with the current Theme version. Please, remove Visual Composer plugin and install one provided with the Theme (Appearance > Install Plugins).','eventerra').'</strong></p></div>';
	}
	add_action('admin_notices', 'eventerra_show_js_composer_version_notice');
}

omfw_Framework::plugins(array(

		// Visual Composer
		array(
			'name'     				=> 'Visual Composer', // The plugin name
			'slug'     				=> 'js_composer', // The plugin slug (typically the folder name)
			'source'   				=> EVENTERRA_TEMPLATE_DIR . '/plugins/js_composer.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '5.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		
		// Include Olevmedia Testimonials
		array(
			'name'     				=> 'Olevmedia Testimonials', // The plugin name
			'slug'     				=> 'olevmedia-testimonials', // The plugin slug (typically the folder name)
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'source'   				=> EVENTERRA_TEMPLATE_DIR . '/plugins/olevmedia-testimonials.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		
		// Include Olevmedia Persons
		array(
			'name'     				=> 'Olevmedia Persons', // The plugin name
			'slug'     				=> 'olevmedia-persons', // The plugin slug (typically the folder name)
			'version' 				=> '1.0.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'source'   				=> EVENTERRA_TEMPLATE_DIR . '/plugins/olevmedia-persons.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		
		// Include Revolution Slider
		array(
			'name'     				=> 'Slider Revolution', // The plugin name
			'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
			'source'   				=> EVENTERRA_TEMPLATE_DIR . '/plugins/revslider.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '5.4.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		
		// Include LayerSlider WP
		array(
			'name'     				=> 'LayerSlider', // The plugin name
			'slug'     				=> 'LayerSlider', // The plugin slug (typically the folder name)
			'source'   				=> EVENTERRA_TEMPLATE_DIR . '/plugins/LayerSlider.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '6.1.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
	
	
		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required'  => false,
		),
		
		array(
			'name'      => 'Tickera - WordPress Event Ticketing',
			'slug'      => 'tickera-event-ticketing-system',
			'required'  => false,
		),

));