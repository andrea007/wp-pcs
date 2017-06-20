<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

define('OMFW_VERSION', '1.0.0');
define('OMFW_PATH', get_template_directory() . '/om-framework');
define('OMFW_URL', get_template_directory_uri() . '/om-framework/' );

load_theme_textdomain('om-theme-framework', OMFW_PATH . '/languages');

require_once (OMFW_PATH . '/classes/class-framework.php');
require_once (OMFW_PATH . '/classes/class-styling.php');
require_once (OMFW_PATH . '/classes/class-live-customizer.php');
require_once (OMFW_PATH . '/classes/class-color.php');

if(is_admin()) {
	require_once (OMFW_PATH . '/classes/class-theme-options.php');
	require_once (OMFW_PATH . '/classes/class-plugins.php');
	require_once (OMFW_PATH . '/classes/class-theme-update.php');
	require_once (OMFW_PATH . '/classes/class-demo-import.php');
	require_once (OMFW_PATH . '/classes/class-meta-box.php');
}