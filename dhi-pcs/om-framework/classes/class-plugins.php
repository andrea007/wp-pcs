<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

require_once (OMFW_PATH . '/libraries/tgm-plugin-activation/class-tgm-plugin-activation.php');

class omfw_Plugins {
	
	protected $plugins=array();

	/**
	 * Constructor
	 */
	public function __construct($plugins) {

		$this->plugins=$plugins;

		add_action('admin_head', array($this,'tgmpa_style_fix'));
		add_action('tgmpa_register', array($this, 'tgmpa_register'));

	}

	public function tgmpa_style_fix() {
	  echo '<style>#setting-error-tgmpa {display:block;}</style>';
	}

	public function tgmpa_register() {
	
		$config = array(
			'id'           => 'omfw',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => true,                    // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);
		tgmpa( $this->plugins, $config );

	}

}