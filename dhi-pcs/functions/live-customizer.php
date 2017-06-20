<?php

omfw_Framework::live_customizer('eventerra_customize_register');

if(!function_exists('eventerra_customize_register')) {
	function eventerra_customize_register( $wp_customize, $omfw_customize ) {
	
		require_once (EVENTERRA_TEMPLATE_DIR . '/functions/theme-options-fields.php'); // eventerra_get_theme_options function inside
	
		$theme_options=eventerra_get_theme_options(array('id_as_key'=>true));
	
		/***********/
		
		$wp_customize->add_section('options_notice', array(
			'title' => esc_html__('More Options','eventerra'),
			'priority'   => 1000,
			'description' => sprintf(esc_html__('For more options see %s section','eventerra'), '<a href="'.esc_url(omfw_Framework::theme_options_url()).'">'.esc_html__('Theme Options', 'eventerra').'</a>'),
		));
		
		$wp_customize->add_setting( 'options_notice', array(
			'sanitize_callback' => 'sanitize_text_field',
		));
		$wp_customize->add_control(new omfw_Customize_Notice_Control( // adds a blank option to make section appear
			$wp_customize,
			'options_notice',
			array(
				'label'          => '',
				'section'        => 'options_notice',
				'settings'       => 'options_notice',
				'type'           => 'notice',
			)
		));
		
		/***********/
		/*
		$wp_customize->add_section('layout', array(
			'title' => esc_html__('Layout','eventerra'),
			'priority'   => 30,
		));
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_overall_layout'), array(
			'section' => 'layout',
		));
		*/
		
		/***********/
	
		$wp_customize->add_section('bg_img', array(
			'title' => esc_html__('Background','eventerra'),
			'priority'   => 31,
		));
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_background_mode'), array(
			'section' => 'bg_img',
		));
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_background_preset'), array(
			'section' => 'bg_img',
		));
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_background_color'), array(
			'section' => 'bg_img',
		));
			
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_background_img'), array(
			'section' => 'bg_img',
		));
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_background_pos'), array(
			'section' => 'bg_img',
		));
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_background_attach'), array(
			'section' => 'bg_img',
		));
			
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_background_overlay'), array(
			'section' => 'bg_img',
		));
					
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_background_overlay_color'), array(
			'section' => 'bg_img',
		));					

		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_background_overlay_color2'), array(
			'section' => 'bg_img',
		));					
					
		/***********/
	
		$wp_customize->add_section('header', array(
			'title' => esc_html__('Header','eventerra'),
			'priority'   => 35,
			'description' => sprintf(esc_html__('Logo can be setup only from %s section','eventerra'), '<a href="'.esc_url(omfw_Framework::theme_options_url()).'">'.esc_html__('Theme Options', 'eventerra').'</a>'),
		));
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_header_location'), array(
			'section' => 'header',
		));
	
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_countdown_date'), array(
			'section' => 'header',
		));
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_countdown_hide_seconds'), array(
			'section' => 'header',
		));
		
	
		/***********/
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_accent_color1'), array(
			'section' => 'colors',
		));
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_accent_color2'), array(
			'section' => 'colors',
		));
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_accent_color3'), array(
			'section' => 'colors',
		));
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_header_text_color'), array(
			'section' => 'colors',
		));
	
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_menu_items_color'), array(
			'section' => 'colors',
		));
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_menu_items_color_hover'), array(
			'section' => 'colors',
		));	
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_menu_sub_items_color'), array(
			'section' => 'colors',
		));	
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_menu_sub_items_color_hover'), array(
			'section' => 'colors',
		));	
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_menu_sub_items_bg_color'), array(
			'section' => 'colors',
		));	
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_background_main_content_color'), array(
			'section' => 'colors',
		));	
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_main_text_color'), array(
			'section' => 'colors',
		));	
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_side_text_color'), array(
			'section' => 'colors',
		));	
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_background_footer_color'), array(
			'section' => 'colors',
		));	
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_footer_titles_color'), array(
			'section' => 'colors',
		));	
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_footer_main_text_color'), array(
			'section' => 'colors',
		));	
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_footer_side_text_color'), array(
			'section' => 'colors',
		));	
		
		$omfw_customize->add_as_theme_option(omfw_Framework::arr_get($theme_options,'eventerra_sub_footer_text_color'), array(
			'section' => 'colors',
		));
	
		/***********/
		
		$omfw_customize->append_dependencies();
	}
}




