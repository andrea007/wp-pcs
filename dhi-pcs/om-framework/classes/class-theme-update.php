<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

require_once (OMFW_PATH . '/libraries/envato-theme-updater/envato-wp-theme-updater.php');

class omfw_Theme_Update {
	
	/**
	 * Constructor
	 */
	public function __construct($username, $key) {

		if($username && $key) {
			
			$theme_data = wp_get_theme(get_option('template'));
			Envato_WP_Theme_Updater::init( $username, $key, $theme_data->get( 'Author' ) );
		
		}

	}

}