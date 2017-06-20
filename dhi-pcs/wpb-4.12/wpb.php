<?php

define('EVENTERRA_TEMPLATE_WPB_DIR', EVENTERRA_TEMPLATE_DIR . '/wpb-4.12'); // without the trailing slash
define('EVENTERRA_TEMPLATE_WPB_DIR_URI', EVENTERRA_TEMPLATE_DIR_URI . '/wpb-4.12' ); // without trailing slash

function eventerra_wpb_activated() {
	return defined( 'WPB_VC_VERSION' );
}

function eventerra_vc_set_as_theme() {
	vc_set_as_theme(true);
}
add_action( 'vc_before_init', 'eventerra_vc_set_as_theme' );

function eventerra_vc_after_init() {
	if( ! vc_is_updater_disabled() ) {
		remove_filter( 'upgrader_pre_download', array( vc_updater(), 'preUpgradeFilter' ) );
		remove_action( 'wp_ajax_nopriv_vc_check_license_key', array( vc_updater(), 'checkLicenseKeyFromRemote' ) );
		
		remove_filter( 'pre_set_site_transient_update_plugins', array( vc_updater()->updateManager(), 'check_update' ) );
		remove_filter( 'plugins_api', array( vc_updater()->updateManager(), 'check_info' ) );
		remove_action( 'in_plugin_update_message-' . vc_plugin_name(), array( vc_updater()->updateManager(), 'addUpgradeMessageLink' ) );
	}
	
	if ( vc_user_access()
			->wpAny( 'manage_options' )
			->part( 'settings' )
			->can( 'vc-updater-tab' )
			->get()
	) {
		remove_action( 'admin_notices', array( vc_license(), 'adminNoticeLicenseActivation' ) );
	}
}
add_action( 'vc_after_init', 'eventerra_vc_after_init' );

/******************************************/

if( eventerra_wpb_activated() && get_option('eventerra_disable_wpb_addons') != 'true' ) {

	function eventerra_wpb_remove_grid() {
		if(defined('VC_PAGE_MAIN_SLUG') && class_exists('Vc_Grid_Item_Editor')) {
			remove_submenu_page(VC_PAGE_MAIN_SLUG, 'edit.php?post_type=' . rawurlencode( Vc_Grid_Item_Editor::postType() ));
			
			global $wp_post_types;
			if(isset($wp_post_types['vc_grid_item'])) {
				unset($wp_post_types['vc_grid_item']);
			}
		}
	}
	add_action('vc_menu_page_build', 'eventerra_wpb_remove_grid', 20);
	
	vc_set_shortcodes_templates_dir(EVENTERRA_TEMPLATE_WPB_DIR . '/vc_templates/');
		
	require_once (EVENTERRA_TEMPLATE_WPB_DIR . '/functions/attribute-types.php');
	require_once (EVENTERRA_TEMPLATE_WPB_DIR . '/functions/options.php');
	require_once (EVENTERRA_TEMPLATE_WPB_DIR . '/functions/misc.php');
	require_once (EVENTERRA_TEMPLATE_WPB_DIR . '/functions/custom_shortcodes.php');
	require_once (EVENTERRA_TEMPLATE_WPB_DIR . '/functions/modifications.php');

	// Testimonials
	if(isset($GLOBALS['omTestimonialsPlugin'])) {
		include_once (EVENTERRA_TEMPLATE_DIR . '/widgets/testimonials/testimonials.php');
	}
	
	/**
	 * Styles & Scripts
	 */
	
	omfw_Framework::body_add_class('om-wpb');
	
	function eventerra_wpb_admin_scripts() {
		if ( in_array( get_post_type(), vc_editor_post_types() )) {
			wp_enqueue_style( 'eventerra_wpb_admin_styles', EVENTERRA_TEMPLATE_WPB_DIR_URI . '/assets/css/wpb-admin.css', array(), EVENTERRA_THEME_VERSION );
			//wp_enqueue_script( 'eventerra_wpb_custom_views', EVENTERRA_TEMPLATE_WPB_DIR_URI . '/assets/js/custom-views.js', array('jquery'), EVENTERRA_THEME_VERSION, true);
		}
	}
	add_action( 'admin_enqueue_scripts', 'eventerra_wpb_admin_scripts' );
	
	function eventerra_wpb_front_scripts() {
		wp_register_script( 'om_vc_pie', EVENTERRA_TEMPLATE_WPB_DIR_URI . '/assets/js/jquery.vc_chart.js', array( 'jquery', 'waypoints', 'progressCircle' ), EVENTERRA_THEME_VERSION, true );

		wp_register_script( 'eventerra_js_composer_front', EVENTERRA_TEMPLATE_WPB_DIR_URI . '/assets/js/addon_js_composer_front.js', array('jquery', 'omLibraries', 'waypoints'), EVENTERRA_THEME_VERSION, true );
		
		// add dependency to make sure that eventerra_js_composer_front will be loaded always before wpb_composer_front_js
		if(isset($GLOBALS['wp_scripts']->registered['wpb_composer_front_js']))
			$GLOBALS['wp_scripts']->registered['wpb_composer_front_js']->deps[]='eventerra_js_composer_front';
	}
	add_action( 'wp_enqueue_scripts', 'eventerra_wpb_front_scripts' );
	
	
	
	function eventerra_wpb_head_styles() {
		if ( in_array( get_post_type(), vc_editor_post_types() )) {
			$css = '
				.vc_colored-dropdown .om-accent-color-1,
				.vc_message_box.vc_message_box-solid.vc_color-om-accent-color-1,
				.vc_btn3.vc_btn3-color-om-accent-color-1
				{background-color:'.get_option('eventerra_accent_color1').' !important;color:#fff !important}

				.vc_colored-dropdown .om-accent-color-2,
				.vc_message_box.vc_message_box-solid.vc_color-om-accent-color-2,
				.vc_btn3.vc_btn3-color-om-accent-color-2
				{background-color:'.get_option('eventerra_accent_color2').' !important;color:#fff !important}
				
				.vc_colored-dropdown .om-accent-color-3,
				.vc_message_box.vc_message_box-solid.vc_color-om-accent-color-3,
				.vc_btn3.vc_btn3-color-om-accent-color-3
				{background-color:'.get_option('eventerra_accent_color3').' !important;color:#fff !important}
				
				.vc_message_box.vc_message_box-outline.vc_color-om-accent-color-1
				{border-color:'.get_option('eventerra_accent_color1').' !important}

				.vc_message_box.vc_message_box-outline.vc_color-om-accent-color-2
				{border-color:'.get_option('eventerra_accent_color2').' !important}
				
				.vc_message_box.vc_message_box-outline.vc_color-om-accent-color-3
				{border-color:'.get_option('eventerra_accent_color3').' !important}
			';
			
			$css=preg_replace('/\s*([\{\},;])\s*/','$1',$css);
			$css=trim(str_replace(',{','{',$css));

			wp_add_inline_style('js_composer', $css);
			
		}
	}
	add_action('admin_enqueue_scripts', 'eventerra_wpb_head_styles');


	if(isset($_GET['vc_editable']) && $_GET['vc_editable'] == 'true') { //frontend editor activated
		add_filter('pre_option_' . 'eventerra_lazyload', '__return_empty_string');
	} 
	
	// remove welcome screen of VC
	remove_action( 'vc_activation_hook', 'vc_page_welcome_set_redirect' );
	remove_action( 'admin_init', 'vc_page_welcome_redirect' );

} else {
	
	function eventerra_wpb_detect($post) {
		return false;
	}
	
}