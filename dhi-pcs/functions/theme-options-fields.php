<?php

if(!function_exists('eventerra_get_theme_options')) {
	function eventerra_get_theme_options($args=array()) {

		$options = array(
		
			array(
				"name" => esc_html__('General settings','eventerra'),
				"type" => "heading",
			),
		
			array(
				"name" => "",
				"message" => esc_html__('You can import demo content in a one click:','eventerra').' <a href="'.esc_url(omfw_Framework::demo_import_url()).'" class="button button-primary" style="text-shadow:none">'.esc_html__('Demo Content Import Tool &rarr;','eventerra').'</a>',
				"type" => "intro",
			),
		
			array(
				"name" => esc_html__('Sub-footer text line','eventerra'),
				"desc" => '',
				"id" => "eventerra_subfooter_text",
				"std" => "",
				"type" => "textarea",
				"rows" => 5,
			),
		
			array(
				'name' => esc_html__('Use lazy load for images', 'eventerra'),
				'desc' => esc_html__('Check if you want to load images on scroll to the view area', 'eventerra'),
				'id' =>  'eventerra_lazyload',
				'std' => 'true',
				'type' => 'checkbox',
			),
		
			/*
			array(
				'name' => esc_html__('Display search box in the header', 'eventerra'),
				'desc' => esc_html__('Check if you want to display search button in the header', 'eventerra'),
				'id' =>  'eventerra_show_header_search',
				'std' => '',
				'type' => 'checkbox',
			),
			*/
		                    
			array(
				'name' => esc_html__('Disable animation on touch devices', 'eventerra'),
				'desc' => esc_html__('Check if you want to disable some animation effects to improve perfomance on mobile devices', 'eventerra'),
				'id' =>  'eventerra_no_animation_on_touch',
				'std' => 'true',
				'type' => 'checkbox',
			),
		                    
			array(
				'name' => esc_html__('Enable animation on page transitions', 'eventerra'),
				'desc' => esc_html__('Check if you want to enable animation on click, when user is moving to another page. NOTE: doesn\'t work in Safari browser.', 'eventerra'),
				'id' =>  'eventerra_enable_page_out_animation',
				'std' => '',
				'type' => 'checkbox',
			),
		
			array(
				'name' => esc_html__('Display "Back to Top" button', 'eventerra'),
				'desc' => esc_html__('Button in the bottom right corner of the screen', 'eventerra'),
				'id' =>  'eventerra_display_back_to_top',
				'std' => '',
				'type' => 'checkbox',
			),		                    
		
			array(
				'name' => esc_html__('Enable local links scroll animation', 'eventerra'),
				'desc' => esc_html__('Animation for links like #something', 'eventerra'),
				'id' =>  'eventerra_enable_local_scroll',
				'std' => 'true',
				'type' => 'checkbox',
			),
		                    
			array(
				'name' => esc_html__('Do not replace default WordPress Gallery with the Theme&#39;s custom gallery', 'eventerra'),
				'desc' => esc_html__('May be useful if you use some plugin for styling default WordPress gallery', 'eventerra'),
				'id' =>  'eventerra_do_not_replace_gallery',
				'std' => '',
				'type' => 'checkbox',
			),
		                    
		/////////////////////////////////////////////////////////////
		                    
			array(
				"name" => esc_html__('Logo','eventerra'),
				"type" => "heading",
			),
		
			array(
				'name' => esc_html__('Site logo type', 'eventerra'),
				'desc' => esc_html__('Choose what do you want to use as site logo: image or plain text.', 'eventerra'),
				'id' =>  'eventerra_site_logo_type',
				'std' => 'text',
				'options'=>array(
					'text'=>esc_html__('Plain text', 'eventerra'),
					'image'=>esc_html__('Image', 'eventerra'),
					'none'=>esc_html__('No logo', 'eventerra'),
				),
				'type' => 'radio',
			),
		                    
			array(
				"name" => esc_html__('Site logo text','eventerra'),
				"desc" => sprintf(esc_html__('Logo text. Note, that you can use codes %s to apply different colors to words','eventerra'), '<br/><br/><b>[color1]word here[/color1],<br/>[color2]word here[/color2],<br/>[color3]word here[/color3]</b><br/><br/>'),
				"id" => "eventerra_site_logo_text",
				"std" => "[color1]Annual'7[/color1]
[color2]Eventerra[/color2]
[color3]Conference[/color3]",
				"type" => "textarea",
				'dependency' => array(
					'id' => 'eventerra_site_logo_type',
					'mode' => 'value',
					'value' => 'text',
				),
			),

			array(
				"name" => esc_html__('Logo color palette: Color 1', 'eventerra'),
				"desc" => sprintf(esc_html__('Use code %s in the logo text to apply this color','eventerra'), '<b>[color1]word[/color1]</b>'),
				"id" => "eventerra_logo_color_1",
				"std" => "#eff1f2",
				"type" => "color",
				'dependency' => array(
					'id' => 'eventerra_site_logo_type',
					'mode' => 'value',
					'value' => 'text',
				),
			),
			
			array(
				"name" => esc_html__('Logo color palette: Color 2', 'eventerra'),
				"desc" => sprintf(esc_html__('Use code %s in the logo text to apply this color','eventerra'), '<b>[color2]word[/color2]</b>'),
				"id" => "eventerra_logo_color_2",
				"std" => "#2aabc8",
				"type" => "color",
				'dependency' => array(
					'id' => 'eventerra_site_logo_type',
					'mode' => 'value',
					'value' => 'text',
				),
			),
			
			array(
				"name" => esc_html__('Logo color palette: Color 3', 'eventerra'),
				"desc" => sprintf(esc_html__('Use code %s in the logo text to apply this color','eventerra'), '<b>[color3]word[/color3]</b>'),
				"id" => "eventerra_logo_color_3",
				"std" => "#0ebfe7",
				"type" => "color",
				'dependency' => array(
					'id' => 'eventerra_site_logo_type',
					'mode' => 'value',
					'value' => 'text',
				),
			),
			
			array(
				'name' => esc_html__('Logo font', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_logo_font',
				'std' => array(
		    	'type'=>'google',
		    	'google'=>array('family'=>'Montserrat', 'weight_bold' => 700),
		    ),
				'options'=>array(
		    	'Arial' => 'Arial',
		    	'Times New Roman' => 'Times New Roman',
		    	'Verdana' => 'Verdana',
		    	'Tahoma' => 'Tahoma',
		    	'Courier' => 'Courier',
		    	'Courier New' => 'Courier New',
		    	'Georgia' => 'Georgia',
		    	'Impact' => 'Impact',
		    	'Lucida Console' => 'Lucida Console',
		    	'Trebuchet MS' => 'Trebuchet MS',
		    ),
				'type' => 'font',
				'weights' => array('bold'),
				'dependency' => array(
					'id' => 'eventerra_site_logo_type',
					'mode' => 'value',
					'value' => 'text',
				),
			),

			array(
				'name' => esc_html__('Uppercase logo text?', 'eventerra'),
				'desc' => esc_html__('Yes, please', 'eventerra'),
				'id' =>  'eventerra_logo_text_uppercase',
				'std' => 'true',
				'type' => 'checkbox',
				'dependency' => array(
					'id' => 'eventerra_site_logo_type',
					'mode' => 'value',
					'value' => 'text',
				),
			),

			array(
				'name' => esc_html__('Logo text font size', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_logo_text_size',
				'std' => '70px',
				'options'=>omfw_Framework::array_number_values(array(
					'from' => 10,
					'to' => 150,
					'step' => 5,
					'sprintf' => '%dpx',
				)),
				'type' => 'select2',
				'dependency' => array(
					'id' => 'eventerra_site_logo_type',
					'mode' => 'value',
					'value' => 'text',
				),
			),
			
			array(
				'name' => esc_html__('Logo text line height', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_logo_text_line_height',
				'std' => '0.95',
				'options'=>omfw_Framework::array_number_values(array(
					'from' => .7,
					'to' => 1.55,
					'step' => .05,
					'sprintf' => '%01.2f',
				)),
				'type' => 'select2',
				'dependency' => array(
					'id' => 'eventerra_site_logo_type',
					'mode' => 'value',
					'value' => 'text',
				),
			),	
			
			array(
				"name" => esc_html__('Site logo image','eventerra'),
				"desc" => esc_html__('Choose a logo for your theme, or specify the image address of your online logo (http://example.com/logo.png).','eventerra'),
				"id" => "eventerra_site_logo_image",
				"std" => "",
				"type" => "upload",
				'dependency' => array(
					'id' => 'eventerra_site_logo_type',
					'mode' => 'value',
					'value' => 'image',
				),
			),
		
			array(
				"name" => esc_html__('Site logo image for retina displays (optional)','eventerra'),
				"desc" => esc_html__('Choose double sized image for retina displays for better quality','eventerra'),
				"id" => "eventerra_site_logo_image_2x",
				"std" => "",
				"type" => "upload",
				'dependency' => array(
					'id' => 'eventerra_site_logo_type',
					'mode' => 'value',
					'value' => 'image',
				),
			),

		/////////////////////////////////////////////////////////////
		
			array(
				"name" => esc_html__('Event','eventerra'),
				"type" => "heading",
			),

			array(
				'name' => esc_html__('Time zone of the area the event is going to take place', 'eventerra'),
				'desc' => esc_html__('UTC time offset','eventerra'),
				'id' =>  'eventerra_event_utc',
				'std' => '0',
				'options'=>array(
		    	'-1200' => esc_html__('UTC-12:00', 'eventerra'),
		    	'-1100' => esc_html__('UTC-11:00', 'eventerra'),
		    	'-1000' => esc_html__('UTC-10:00', 'eventerra'),
		    	'-0930' => esc_html__('UTC-09:30', 'eventerra'),
		    	'-0900' => esc_html__('UTC-09:00', 'eventerra'),
		    	'-0800' => esc_html__('UTC-08:00', 'eventerra'),
		    	'-0700' => esc_html__('UTC-07:00', 'eventerra'),
		    	'-0600' => esc_html__('UTC-06:00', 'eventerra'),
		    	'-0500' => esc_html__('UTC-05:00', 'eventerra'),
		    	'-0430' => esc_html__('UTC-04:30', 'eventerra'),
		    	'-0400' => esc_html__('UTC-04:00', 'eventerra'),
		    	'-0330' => esc_html__('UTC-03:30', 'eventerra'),
		    	'-0300' => esc_html__('UTC-03:00', 'eventerra'),
		    	'-0200' => esc_html__('UTC-02:00', 'eventerra'),
		    	'-0100' => esc_html__('UTC-01:00', 'eventerra'),
		    	'0' => esc_html__('UTC', 'eventerra'),
		    	'+0100' => esc_html__('UTC+01:00', 'eventerra'),
		    	'+0200' => esc_html__('UTC+02:00', 'eventerra'),
		    	'+0300' => esc_html__('UTC+03:00', 'eventerra'),
		    	'+0330' => esc_html__('UTC+03:30', 'eventerra'),
		    	'+0400' => esc_html__('UTC+04:00', 'eventerra'),
		    	'+0430' => esc_html__('UTC+04:30', 'eventerra'),
		    	'+0500' => esc_html__('UTC+05:00', 'eventerra'),
		    	'+0530' => esc_html__('UTC+05:30', 'eventerra'),
		    	'+0545' => esc_html__('UTC+05:45', 'eventerra'),
		    	'+0600' => esc_html__('UTC+06:00', 'eventerra'),
		    	'+0630' => esc_html__('UTC+06:30', 'eventerra'),
		    	'+0700' => esc_html__('UTC+07:00', 'eventerra'),
		    	'+0800' => esc_html__('UTC+08:00', 'eventerra'),
		    	'+0830' => esc_html__('UTC+08:30', 'eventerra'),
		    	'+0845' => esc_html__('UTC+08:45', 'eventerra'),
		    	'+0900' => esc_html__('UTC+09:00', 'eventerra'),
		    	'+0930' => esc_html__('UTC+09:30', 'eventerra'),
		    	'+1000' => esc_html__('UTC+10:00', 'eventerra'),
		    	'+1030' => esc_html__('UTC+10:30', 'eventerra'),
		    	'+1100' => esc_html__('UTC+11:00', 'eventerra'),
		    	'+1200' => esc_html__('UTC+12:00', 'eventerra'),
		    	'+1245' => esc_html__('UTC+12:45', 'eventerra'),
		    	'+1300' => esc_html__('UTC+13:00', 'eventerra'),
		    	'+1400' => esc_html__('UTC+14:00', 'eventerra'),
		    ),
				'type' => 'select',
			),	
			
			array(
				"name" => esc_html__('Event location and date in the header','eventerra'),
				"desc" => esc_html__('E.g. New Orleans, Louisiana. 25-30 April, 2018','eventerra'),
				"id" => "eventerra_header_location",
				"std" => "",
				"type" => "text",
			),

			array(
				"name" => esc_html__('Countdown: event start date','eventerra'),
				"desc" => sprintf(esc_html__('Format must be %s, for example %s','eventerra'), '<b>YYYY-MM-DD HH:MM:SS</b>', '2018-04-25 10:00:00'),
				"id" => "eventerra_countdown_date",
				"std" => "",
				"type" => "text",
			),
			
			array(
				"name" => esc_html__('Hide seconds in countdown timer','eventerra'),
				'desc' => esc_html__('Yes, please', 'eventerra'),
				"id" => "eventerra_countdown_hide_seconds",
				"std" => "",
				"type" => "checkbox",
			),

		/////////////////////////////////////////////////////////////
		
			array(
				"name" => esc_html__('Layout','eventerra'),
				"type" => "heading",
			),
		
		                    
			array(
				'name' => esc_html__('Activate responsive mode for mobile devices', 'eventerra'),
				'desc' => esc_html__('Check if you want your site to be fitted by width on mobile devices', 'eventerra'),
				'id' =>  'eventerra_responsive',
				'std' => 'true',
				'type' => 'checkbox',
			),
		/*
			array(
				'name' => esc_html__('Overall layout', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_overall_layout',
				'std' => 'wide',
				'options'=>array(
		    	'wide' => esc_html__('Wide','eventerra'),
		    	'boxed' => esc_html__('Boxed','eventerra'),
		    ),
				'type' => 'select',
			),
		
			array(
				"name" => esc_html__('Header layout','eventerra'),
				"desc" => esc_html__('Select header layout.','eventerra'),
				"id" => "eventerra_header_layout",
				"std" => "1",
				"type" => "images",
				"options" => array(
					'1' => EVENTERRA_TEMPLATE_DIR_URI . '/admin/images/header-1.png',
					'3' => EVENTERRA_TEMPLATE_DIR_URI . '/admin/images/header-3.png',
					'2' => EVENTERRA_TEMPLATE_DIR_URI . '/admin/images/header-2.png',
				),
			),
		*/						
		
		/*
			array(
				'name' => esc_html__('Maximum content container width', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_content_max_width',
				'std' => '1440',
				'options'=>array(
		    	'1440' => esc_html__('1440 pixels', 'eventerra'),
		    	'1200' => esc_html__('1200 pixels', 'eventerra'),
		    	'960' => esc_html__('960 pixels', 'eventerra'),
		    ),
				'type' => 'select',
			),
		*/
		                    
			array(
				'name' => esc_html__('Footer layout', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_footer_layout',
				'std' => '1v3-1v3-1v3',
				'options'=>array(
		    	'1v4-1v4-1v4-1v4' => esc_html__('4 Columns 1/4 + 1/4 + 1/4 + 1/4', 'eventerra'),
		    	'2v4-1v4-1v4' => esc_html__('3 Columns 2/4 + 1/4 + 1/4', 'eventerra'),
		    	'1v4-1v4-2v4' => esc_html__('3 Columns 1/4 + 1/4 + 2/4', 'eventerra'),
		    	'1v3-1v3-1v3' => esc_html__('3 Columns 1/3 + 1/3 + 1/3', 'eventerra'),
		    	'2v3-1v3' => esc_html__('2 Columns 2/3 + 1/3', 'eventerra'),
		    	'1v3-2v3' => esc_html__('2 Columns 1/3 + 2/3', 'eventerra'),
		    	'1v2-1v2' => esc_html__('2 Columns 1/2 + 1/2', 'eventerra'),
		    	'1v1' => esc_html__('1 Column', 'eventerra'),
		    ),
				'type' => 'select',
			),
		                    
		/////////////////////////////////////////////////////////////
		
			array(
				"name" => esc_html__('Menu','eventerra'),
				"type" => "heading",
			),
		
			array(
				'name' => esc_html__('Display drop down symbol for menu items with sublevels', 'eventerra'),
				'desc' => esc_html__('Check if you want to display drop down symbol in primary menu for items which has sublevels', 'eventerra'),
				'id' =>  'eventerra_show_dropdown_symbol',
				'std' => 'true',
				'type' => 'checkbox',
			),
		                    
			array(
				'name' => esc_html__('Highlight active menu item', 'eventerra'),
				'desc' => esc_html__('Check if you want to highlight active menu item of primary menu', 'eventerra'),
				'id' =>  'eventerra_menu_highlight_active',
				'std' => '',
				'type' => 'checkbox',
			),
			
			array(
				'name' => esc_html__('Apply bold font weight for root menu items', 'eventerra'),
				'desc' => esc_html__('Yes, please', 'eventerra'),
				'id' =>  'eventerra_menu_root_bold',
				'std' => 'true',
				'type' => 'checkbox',
			),
		                    
			array(
				'name' => esc_html__('Uppercase', 'eventerra'),
				'desc' => esc_html__('Check to apply uppercase for menu items', 'eventerra'),
				'id' =>  'eventerra_menu_uppercase',
				'std' => 'true',
				'type' => 'checkbox',
			),
		                    
			array(
				'name' => esc_html__('Enable MegaMenu addon', 'eventerra'),
				'desc' => esc_html__('Check if you want to enable MegaMenu feature or uncheck if you don\'t need it or you want to use some other plugin for this purpose', 'eventerra'),
				'id' =>  'eventerra_menu_megamenu_active',
				'std' => 'true',
				'type' => 'checkbox',
			),

			array(
				"name" => "",
				"message" => esc_html__('Highlighted menu button','eventerra'),
				"type" => "subheader",
			),
			
			array(
				'name' => esc_html__('Display highlighted menu button', 'eventerra'),
				'desc' => esc_html__('Yes, please', 'eventerra'),
				'id' =>  'eventerra_menu_extra_button',
				'std' => '',
				'type' => 'checkbox',
			),

			array(
				"name" => esc_html__('Highlighted menu button title','eventerra'),
				"desc" => '',
				"id" => "eventerra_menu_extra_button_title",
				"std" => "",
				"type" => "text",
				'dependency' => array(
					'id' => 'eventerra_menu_extra_button',
					'mode' => 'not_empty',
				),
			),
			
			array(
				"name" => esc_html__('Highlighted menu button link','eventerra'),
				"desc" => esc_html__('You can insert any URL here','eventerra'),
				"id" => "eventerra_menu_extra_button_link",
				"std" => "",
				"type" => "text",
				'dependency' => array(
					'id' => 'eventerra_menu_extra_button',
					'mode' => 'not_empty',
				),
			),
			
			array(
				'name' => esc_html__('Highlighted menu button target', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_menu_extra_button_target',
				'std' => '_self',
				'options'=>array(
		    	'_self' => esc_html__('Default', 'eventerra'),
		    	'_blank' => esc_html__('New window', 'eventerra'),
		    ),
				'type' => 'select',
				'dependency' => array(
					'id' => 'eventerra_menu_extra_button',
					'mode' => 'not_empty',
				),
			),
			
			array(
				'name' => esc_html__('Highlighted menu button color', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_menu_extra_button_color',
				'std' => 'accent-1',
				'options'=>array(
		    	'accent-1' => esc_html__('Accent color 1', 'eventerra'),
		    	'accent-2' => esc_html__('Accent color 2', 'eventerra'),
		    	'accent-3' => esc_html__('Accent color 3', 'eventerra'),
		    ),
				'type' => 'select',
				'dependency' => array(
					'id' => 'eventerra_menu_extra_button',
					'mode' => 'not_empty',
				),
			),
			
			array(
				"name" => "",
				"message" => esc_html__('Dropdown secondary menu button','eventerra'),
				"type" => "subheader",
			),
			
			array(
				'name' => esc_html__('Display dropdown secondary menu button', 'eventerra'),
				'desc' => esc_html__('Yes, please', 'eventerra'),
				'id' =>  'eventerra_menu_extra_dropdown_button',
				'std' => '',
				'type' => 'checkbox',
			),

			array(
				"name" => esc_html__('Dropdown secondary menu button title','eventerra'),
				"desc" => '',
				"id" => "eventerra_menu_extra_dropdown_button_title",
				"std" => "",
				"type" => "text",
				'dependency' => array(
					'id' => 'eventerra_menu_extra_dropdown_button',
					'mode' => 'not_empty',
				),
			),

			array(
				'name' => esc_html__('Dropdown secondary menu button color', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_menu_extra_dropdown_button_color',
				'std' => 'accent-2',
				'options'=>array(
		    	'accent-1' => esc_html__('Accent color 1', 'eventerra'),
		    	'accent-2' => esc_html__('Accent color 2', 'eventerra'),
		    	'accent-3' => esc_html__('Accent color 3', 'eventerra'),
		    ),
				'type' => 'select',
				'dependency' => array(
					'id' => 'eventerra_menu_extra_dropdown_button',
					'mode' => 'not_empty',
				),
			),			
			
			array(
				"name" => "",
				"message" => sprintf(esc_html__('To display dropdown menu, create and attach the menu to the "Secondary menu" location in the "%s" section.','eventerra'), '<a href="'.esc_url(admin_url('nav-menus.php')).'">'.esc_html__('Menu','eventerra').'</a>'),
				'id' => 'eventerra_menu_extra_dropdown_none',
				"type" => "note",
				'dependency' => array(
					'id' => 'eventerra_menu_extra_dropdown_button',
					'mode' => 'not_empty',
				),
			),
			
		////////////////////////////////////////////////////////////
		
			array(
				"name" => esc_html__('Styling','eventerra'),
				"type" => "heading",
			),

			array(
				'name' => '',
				'desc' => esc_html__('Apply custom styling by inline code (check this option if you have problems with styling because of styling file rewrite permissions)', 'eventerra'),
				'id' =>  'eventerra_use_inline_css',
				'std' => '',
				'type' => 'checkbox',
			),
		
			array(
				"name" => "",
				"message" => esc_html__('Style Presets:','eventerra'),
				"type" => "subheader",
			),
		
		                    
			array(
				'name' => '',
				'desc' => esc_html__('Choose one of the preseted styles or create your own one', 'eventerra'),
				'id' =>  'eventerra_styling_presets',
				'std' => json_decode('{"Prussian Blue Theme":{"eventerra_logo_color_1":"#eff1f2","eventerra_logo_color_2":"#2aabc8","eventerra_logo_color_3":"#0ebfe7","eventerra_background_mode":"preset","eventerra_background_preset":"preset-1","eventerra_background_color":"#1e73be","eventerra_background_img":"http:\/\/demo.olevmedia.com\/eventerra.beta\/wp-content\/uploads\/2016\/01\/person-17.jpg","eventerra_background_pos":"no_repeat_left_top","eventerra_background_attach":"fixed","eventerra_background_overlay":"gradient","eventerra_background_overlay_color":"rgba(238,238,34,0.5)","eventerra_background_overlay_color2":"rgba(130,36,227,0.5)","eventerra_accent_color1":"#e94f49","eventerra_accent_color2":"#17a571","eventerra_accent_color3":"#188fbb","eventerra_header_text_color":"#dbdbdb","eventerra_menu_items_color":"#dee4e8","eventerra_menu_items_color_hover":"#ffffff","eventerra_menu_sub_items_color":"#0c3b61","eventerra_menu_sub_items_color_hover":"#518fbc","eventerra_menu_sub_items_bg_color":"#ffffff","eventerra_background_main_content_color":"#ffffff","eventerra_main_text_color":"#494949","eventerra_side_text_color":"#c6c6c6","eventerra_background_footer_color":"#f3f3f3","eventerra_footer_titles_color":"#b5b5b5","eventerra_footer_main_text_color":"#898989","eventerra_footer_side_text_color":"#c1c1c1","eventerra_sub_footer_text_color":"rgba(255,255,255,0.7)"},"Crusoe Theme":{"eventerra_logo_color_1":"#f9fdfa","eventerra_logo_color_2":"#86d9a4","eventerra_logo_color_3":"#b7f3cc","eventerra_background_mode":"preset","eventerra_background_preset":"preset-2","eventerra_background_color":"#1e73be","eventerra_background_img":"http:\/\/demo.olevmedia.com\/eventerra.beta\/wp-content\/uploads\/2016\/01\/person-17.jpg","eventerra_background_pos":"no_repeat_left_top","eventerra_background_attach":"fixed","eventerra_background_overlay":"gradient","eventerra_background_overlay_color":"rgba(238,238,34,0.5)","eventerra_background_overlay_color2":"rgba(130,36,227,0.5)","eventerra_accent_color1":"#e59534","eventerra_accent_color2":"#2f9961","eventerra_accent_color3":"#82777a","eventerra_header_text_color":"#dbdbdb","eventerra_menu_items_color":"#e5f0ea","eventerra_menu_items_color_hover":"#ffffff","eventerra_menu_sub_items_color":"#184830","eventerra_menu_sub_items_color_hover":"#269960","eventerra_menu_sub_items_bg_color":"#ffffff","eventerra_background_main_content_color":"#ffffff","eventerra_main_text_color":"#494949","eventerra_side_text_color":"#c6c6c6","eventerra_background_footer_color":"#f3f3f3","eventerra_footer_titles_color":"#b5b5b5","eventerra_footer_main_text_color":"#898989","eventerra_footer_side_text_color":"#c1c1c1","eventerra_sub_footer_text_color":"rgba(255,255,255,0.7)"},"Windsor Theme":{"eventerra_logo_color_1":"#fcfaff","eventerra_logo_color_2":"#bfaae5","eventerra_logo_color_3":"#e2d8f3","eventerra_background_mode":"preset","eventerra_background_preset":"preset-3","eventerra_background_color":"#1e73be","eventerra_background_img":"http:\/\/demo.olevmedia.com\/eventerra.beta\/wp-content\/uploads\/2016\/01\/person-17.jpg","eventerra_background_pos":"no_repeat_left_top","eventerra_background_attach":"fixed","eventerra_background_overlay":"gradient","eventerra_background_overlay_color":"rgba(238,238,34,0.5)","eventerra_background_overlay_color2":"rgba(130,36,227,0.5)","eventerra_accent_color1":"#e52a6f","eventerra_accent_color2":"#801468","eventerra_accent_color3":"#675682","eventerra_header_text_color":"#dbdbdb","eventerra_menu_items_color":"#e2dbee","eventerra_menu_items_color_hover":"#ffffff","eventerra_menu_sub_items_color":"#32185f","eventerra_menu_sub_items_color_hover":"#9368de","eventerra_menu_sub_items_bg_color":"#ffffff","eventerra_background_main_content_color":"#ffffff","eventerra_main_text_color":"#494949","eventerra_side_text_color":"#c6c6c6","eventerra_background_footer_color":"#f3f3f3","eventerra_footer_titles_color":"#b5b5b5","eventerra_footer_main_text_color":"#898989","eventerra_footer_side_text_color":"#c1c1c1","eventerra_sub_footer_text_color":"rgba(255,255,255,0.7)"},"Jacko Bean Theme":{"eventerra_logo_color_1":"#f8f5ef","eventerra_logo_color_2":"#e7cea5","eventerra_logo_color_3":"#ebe2d3","eventerra_background_mode":"preset","eventerra_background_preset":"preset-4","eventerra_background_color":"#1e73be","eventerra_background_img":"http:\/\/demo.olevmedia.com\/eventerra.beta\/wp-content\/uploads\/2016\/01\/person-17.jpg","eventerra_background_pos":"no_repeat_left_top","eventerra_background_attach":"fixed","eventerra_background_overlay":"gradient","eventerra_background_overlay_color":"rgba(238,238,34,0.5)","eventerra_background_overlay_color2":"rgba(130,36,227,0.5)","eventerra_accent_color1":"#ec9700","eventerra_accent_color2":"#945d60","eventerra_accent_color3":"#9e8c8a","eventerra_header_text_color":"#dbdbdb","eventerra_menu_items_color":"#f4eee5","eventerra_menu_items_color_hover":"#ffffff","eventerra_menu_sub_items_color":"#4a4132","eventerra_menu_sub_items_color_hover":"#a6906b","eventerra_menu_sub_items_bg_color":"#ffffff","eventerra_background_main_content_color":"#ffffff","eventerra_main_text_color":"#494949","eventerra_side_text_color":"#c6c6c6","eventerra_background_footer_color":"#f3f3f3","eventerra_footer_titles_color":"#b5b5b5","eventerra_footer_main_text_color":"#898989","eventerra_footer_side_text_color":"#c1c1c1","eventerra_sub_footer_text_color":"rgba(255,255,255,0.7)"},"Dark Gray Theme":{"eventerra_logo_color_1":"#f4f4f4","eventerra_logo_color_2":"#cccccc","eventerra_logo_color_3":"#e8e8e8","eventerra_background_mode":"preset","eventerra_background_preset":"preset-5","eventerra_background_color":"#1e73be","eventerra_background_img":"http:\/\/demo.olevmedia.com\/eventerra.beta\/wp-content\/uploads\/2016\/01\/person-17.jpg","eventerra_background_pos":"no_repeat_left_top","eventerra_background_attach":"fixed","eventerra_background_overlay":"gradient","eventerra_background_overlay_color":"rgba(238,238,34,0.5)","eventerra_background_overlay_color2":"rgba(130,36,227,0.5)","eventerra_accent_color1":"#f2504c","eventerra_accent_color2":"#0aa66d","eventerra_accent_color3":"#f0bb0f","eventerra_header_text_color":"#dbdbdb","eventerra_menu_items_color":"#e7e7e7","eventerra_menu_items_color_hover":"#ffffff","eventerra_menu_sub_items_color":"#434343","eventerra_menu_sub_items_color_hover":"#9a9a9a","eventerra_menu_sub_items_bg_color":"#ffffff","eventerra_background_main_content_color":"#ffffff","eventerra_main_text_color":"#494949","eventerra_side_text_color":"#c6c6c6","eventerra_background_footer_color":"#f3f3f3","eventerra_footer_titles_color":"#b5b5b5","eventerra_footer_main_text_color":"#898989","eventerra_footer_side_text_color":"#c1c1c1","eventerra_sub_footer_text_color":"rgba(255,255,255,0.7)"},"Maroon Theme":{"eventerra_logo_color_1":"#fcf7f6","eventerra_logo_color_2":"#eed0c0","eventerra_logo_color_3":"#f3e7e1","eventerra_background_mode":"preset","eventerra_background_preset":"preset-6","eventerra_background_color":"#1e73be","eventerra_background_img":"http:\/\/demo.olevmedia.com\/eventerra.beta\/wp-content\/uploads\/2016\/01\/person-17.jpg","eventerra_background_pos":"no_repeat_left_top","eventerra_background_attach":"fixed","eventerra_background_overlay":"gradient","eventerra_background_overlay_color":"rgba(238,238,34,0.5)","eventerra_background_overlay_color2":"rgba(130,36,227,0.5)","eventerra_accent_color1":"#ee6a00","eventerra_accent_color2":"#8a6541","eventerra_accent_color3":"#6d2523","eventerra_header_text_color":"#dbdbdb","eventerra_menu_items_color":"#f5eae4","eventerra_menu_items_color_hover":"#ffffff","eventerra_menu_sub_items_color":"#290200","eventerra_menu_sub_items_color_hover":"#8a3527","eventerra_menu_sub_items_bg_color":"#ffffff","eventerra_background_main_content_color":"#ffffff","eventerra_main_text_color":"#494949","eventerra_side_text_color":"#c6c6c6","eventerra_background_footer_color":"#f3f3f3","eventerra_footer_titles_color":"#b5b5b5","eventerra_footer_main_text_color":"#898989","eventerra_footer_side_text_color":"#c1c1c1","eventerra_sub_footer_text_color":"rgba(255,255,255,0.7)"}}', true),
				'options' => array(
					'eventerra_logo_color_1',
					'eventerra_logo_color_2',
					'eventerra_logo_color_3',
		    	'eventerra_background_mode',
		    	'eventerra_background_preset',
		    	'eventerra_background_color',
		    	'eventerra_background_img',
		    	'eventerra_background_pos',
		    	'eventerra_background_attach',
		    	'eventerra_background_overlay',
		    	'eventerra_background_overlay_color',
		    	'eventerra_background_overlay_color2',
		    	'eventerra_accent_color1',
		    	'eventerra_accent_color2',
		    	'eventerra_accent_color3',
		    	'eventerra_header_text_color',
		    	'eventerra_menu_items_color',
		    	'eventerra_menu_items_color_hover',
		    	'eventerra_menu_sub_items_color',
		    	'eventerra_menu_sub_items_color_hover',
		    	'eventerra_menu_sub_items_bg_color',
		    	'eventerra_background_main_content_color',
		    	'eventerra_main_text_color',
		    	'eventerra_side_text_color',
		    	'eventerra_background_footer_color',
		    	'eventerra_footer_titles_color',
		    	'eventerra_footer_main_text_color',
		    	'eventerra_footer_side_text_color',
		    	'eventerra_sub_footer_text_color',
		    ),
				'type' => 'styling_presets',
			),		
		                    
			array(
				"name" => "",
				"message" => esc_html__('Overall Background:','eventerra'),
				"type" => "subheader",
			),

			array(
				"name" => esc_html__('Background', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_background_mode",
				'std' => 'preset',
				'options'=>array(
		    	'preset' => esc_html__('Theme`s preset', 'eventerra'),
		    	'custom' => esc_html__('Custom background', 'eventerra'),
		    ),
				'type' => 'select',
			),

			array(
				"name" => esc_html__('Background Preset', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_background_preset",
				'std' => 'preset-1',
				'options'=>array(
		    	'preset-1' => esc_html__('Blue Squares', 'eventerra'),
		    	'preset-2' => esc_html__('Crusoe Hexagons', 'eventerra'),
		    	'preset-3' => esc_html__('Windsor Lines', 'eventerra'),
		    	'preset-4' => esc_html__('Jacko Bean Cubes', 'eventerra'),
		    	'preset-5' => esc_html__('Dark Gray Triangles', 'eventerra'),
		    	'preset-6' => esc_html__('Maroon Dotted Lights', 'eventerra'),
		    ),
				'type' => 'select',
				'dependency' => array(
					'id' => 'eventerra_background_mode',
					'mode' => 'value',
					'value' => 'preset',
				),
			),
			
			array(
				"name" => esc_html__('Background color', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_background_color",
				"std" => "#1a98c7",
				"type" => "color",
				'dependency' => array(
					'id' => 'eventerra_background_mode',
					'mode' => 'value',
					'value' => 'custom',
				),
			),
		                    
			array(
				'name' => esc_html__('Background image', 'eventerra'),
				'id' =>  'eventerra_background_img',
				'std' => '',
				'type' => 'upload',
				'dependency' => array(
					'id' => 'eventerra_background_mode',
					'mode' => 'value',
					'value' => 'custom',
				),
			),
		                    
			array(
				'name' => esc_html__('Background image position', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_background_pos',
				'std' => 'repeat',
				'options'=>eventerra_get_bg_img_pos_options(),
				'type' => 'select',
				'dependency' => array(
					'id' => 'eventerra_background_img',
					'mode' => 'not_empty',
				),
			),
		                    
			array(
				'name' => esc_html__('Background image attachment', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_background_attach',
				'std' => 'scroll',
				'options'=>array(
		    	'scroll' => 'Scroll',
		    	'fixed' => 'Fixed',
		    ),
				'type' => 'select',
				'dependency' => array(
					'id' => 'eventerra_background_img',
					'mode' => 'not_empty',
				),
			),
			
			array(
				'name' => esc_html__('Background overlay layer', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_background_overlay',
				'std' => 'none',
				'options'=>array(
		    	'none' => esc_html__('None', 'eventerra'),
		    	'color' => esc_html__('Solid color', 'eventerra'),
		    	'gradient' => esc_html__('Gradient', 'eventerra'),
		    ),
				'type' => 'select',
				'dependency' => array(
					'id' => 'eventerra_background_mode',
					'mode' => 'value',
					'value' => 'custom',
				),
			),

			array(
				"name" => esc_html__('Background overlay color', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_background_overlay_color",
				"std" => "rgba(0,0,0,0.5)",
				"type" => "color",
				'alpha' => true,
				'dependency' => array(
					'id' => 'eventerra_background_overlay',
					'mode' => 'value',
					'value' => array('color','gradient'),
				),
			),
			
			array(
				"name" => esc_html__('Background overlay color, gradient second color', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_background_overlay_color2",
				"std" => "rgba(0,0,0,0.5)",
				"type" => "color",
				'alpha' => true,
				'dependency' => array(
					'id' => 'eventerra_background_overlay',
					'mode' => 'value',
					'value' => 'gradient',
				),
			),
						
			/***/
		                    
			array(
				"name" => "",
				"message" => esc_html__('Common:','eventerra'),
				"type" => "subheader",
			),

			array(
				"name" => "",
				"message" => esc_html__('Accent colors are used to highlight some key information, buttons, blocks and etc. Choose three colors. In some content blocks properties you are able to choose one of these three colors manually.','eventerra'),
				"type" => "intro",
			),
			
			array(
				"name" => esc_html__('Accent color 1', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_accent_color1",
				"std" => "#e94f49",
				"type" => "color",
			),
			
			array(
				"name" => esc_html__('Accent color 2', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_accent_color2",
				"std" => "#17a571",
				"type" => "color",
			),

			array(
				"name" => esc_html__('Accent color 3', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_accent_color3",
				"std" => "#188fbb",
				"type" => "color",
			),
						
			array(
				"name" => "",
				"message" => esc_html__('Header:','eventerra'),
				"type" => "subheader",
			),
		
			array(
				"name" => esc_html__('Header text color', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_header_text_color",
				"std" => "#dbdbdb",
				"type" => "color",
			),

			array(
				"name" => "",
				"message" => esc_html__('Header menu:','eventerra'),
				"type" => "subheader",
			),
		

			array(
				"name" => esc_html__('Menu items color', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_menu_items_color",
				"std" => "#dee4e8",
				"type" => "color",
			),
		
			array(
				"name" => esc_html__('Menu items color by hover', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_menu_items_color_hover",
				"std" => "#ffffff",
				"type" => "color",
			),
		                    
			array(
				"name" => esc_html__('Sub-Menu items color', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_menu_sub_items_color",
				"std" => "#0c3b61",
				"type" => "color",
			),
		
			array(
				"name" => esc_html__('Sub-Menu items color by hover', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_menu_sub_items_color_hover",
				"std" => "#518fbc",
				"type" => "color",
			),
		                  
			array(
				"name" => esc_html__('Sub-Menu items background color', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_menu_sub_items_bg_color",
				"std" => "#ffffff",
				"type" => "color",
			),
		                    
			array(
				"name" => "",
				"message" => esc_html__('Main Content:','eventerra'),
				"type" => "subheader",
			),
		
			array(
				"name" => esc_html__('Main content background color', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_background_main_content_color",
				"std" => "#ffffff",
				"type" => "color",
			),
		
			array(
				"name" => esc_html__('Main text color', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_main_text_color",
				"std" => "#494949",
				"type" => "color",
			),
		                    
			array(
				"name" => esc_html__('Side text color', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_side_text_color",
				"std" => "#c6c6c6",
				"type" => "color",
			),
		
		/*		                    
			array(
				"name" => esc_html__('Side text color (less inportant information)', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_side_text_color2",
				"std" => "#dedede",
				"type" => "color",
			),
		*/
		
		/*
			array(
				'name' => esc_html__('Main content panes background transparency', 'eventerra'),
				'desc' => esc_html__('Value between 0 and 100. 0 - opaque, 100 - transparent', 'eventerra'),
				'id' =>  'eventerra_background_main_content_opacity',
				'std' => '0',
				'type' => 'text',
			),
		*/
		
		/*		                    
			array(
				"name" => '',
				"desc" => esc_html__('Check this option if you chose dark background for content panes (needed for adjusting few blocks)', 'eventerra'),
				"id" => "eventerra_content_panes_dark_bg",
				"std" => "",
				"type" => "checkbox",
			),
		*/
		/*
			array(
				"name" => esc_html__('Sidebar panes background color', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_background_sidebar_color",
				"std" => "#ffffff",
				"type" => "color",
			),
		
		*/
		
			array(
				"name" => "",
				"message" => esc_html__('Footer:','eventerra'),
				"type" => "subheader",
			),
		
			array(
				"name" => esc_html__('Footer background color', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_background_footer_color",
				"std" => "#f3f3f3",
				"type" => "color",
			),
		                    
			array(
				"name" => esc_html__('Footer titles color', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_footer_titles_color",
				"std" => "#b5b5b5",
				"type" => "color",
			),
		
			array(
				"name" => esc_html__('Footer text color', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_footer_main_text_color",
				"std" => "#898989",
				"type" => "color",
			),
		
		                    
			array(
				"name" => esc_html__('Footer side text color', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_footer_side_text_color",
				"std" => "#c1c1c1",
				"type" => "color",
			),
			
			array(
				"name" => esc_html__('Sub-footer text color', 'eventerra'),
				"desc" => '',
				"id" => "eventerra_sub_footer_text_color",
				"std" => "#b9c6cb",
				"type" => "color",
			),
		
		////////////////////////////////////////////////////////////
		
		
			array(
				"name" => esc_html__('Fonts','eventerra'),
				"type" => "heading",
			),


			array(
				'name' => esc_html__('Base font', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_base_font',
				'std' => array(
		    	'type'=>'google',
		    	'google'=>array('family'=>'Open Sans', 'weight_normal' => 400, 'weight_bold' => 700),
		    ),
				'options'=>array(
		    	'Arial' => 'Arial',
		    	'Times New Roman' => 'Times New Roman',
		    	'Verdana' => 'Verdana',
		    	'Tahoma' => 'Tahoma',
		    	'Courier' => 'Courier',
		    	'Courier New' => 'Courier New',
		    	'Georgia' => 'Georgia',
		    	'Impact' => 'Impact',
		    	'Lucida Console' => 'Lucida Console',
		    	'Trebuchet MS' => 'Trebuchet MS',
		    ),
				'type' => 'font',
			),
		                    
			array(
				'name' => esc_html__('Highlight font', 'eventerra'),
				'desc' => esc_html__('Headers, titles', 'eventerra'),
				'id' =>  'eventerra_sec_font',
				'std' => array(
		    	'type'=>'google',
		    	'google'=>array('family'=>'Montserrat', 'weight_normal' => 400, 'weight_bold' => 700),
		    ),
				'options'=>array(
		    	'Arial' => 'Arial',
		    	'Times New Roman' => 'Times New Roman',
		    	'Verdana' => 'Verdana',
		    	'Tahoma' => 'Tahoma',
		    	'Courier' => 'Courier',
		    	'Courier New' => 'Courier New',
		    	'Georgia' => 'Georgia',
		    	'Impact' => 'Impact',
		    	'Lucida Console' => 'Lucida Console',
		    	'Trebuchet MS' => 'Trebuchet MS',
		    ),
				'type' => 'font',
			),
			
			array(
				'name' => esc_html__('Primary menu font', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_menu_font',
				'std' => array(
		    	'type'=>'google',
		    	'google'=>array('family'=>'Raleway', 'weight_normal' => 500, 'weight_bold' => 700),
		    ),
				'options'=>array(
		    	'Arial' => 'Arial',
		    	'Times New Roman' => 'Times New Roman',
		    	'Verdana' => 'Verdana',
		    	'Tahoma' => 'Tahoma',
		    	'Courier' => 'Courier',
		    	'Courier New' => 'Courier New',
		    	'Georgia' => 'Georgia',
		    	'Impact' => 'Impact',
		    	'Lucida Console' => 'Lucida Console',
		    	'Trebuchet MS' => 'Trebuchet MS',
		    ),
				'type' => 'font',
			),

			array(
				'name' => esc_html__('Buttons font', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_buttons_font',
				'std' => array(
		    	'type'=>'google',
		    	'google'=>array('family'=>'Raleway', 'weight_normal' => 400, 'weight_bold' => 700),
		    ),
				'options'=>array(
		    	'Arial' => 'Arial',
		    	'Times New Roman' => 'Times New Roman',
		    	'Verdana' => 'Verdana',
		    	'Tahoma' => 'Tahoma',
		    	'Courier' => 'Courier',
		    	'Courier New' => 'Courier New',
		    	'Georgia' => 'Georgia',
		    	'Impact' => 'Impact',
		    	'Lucida Console' => 'Lucida Console',
		    	'Trebuchet MS' => 'Trebuchet MS',
		    ),
				'type' => 'font',
			),
			
			array(
				'name' => esc_html__('Testimonials font', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_testimonials_font',
				'std' => array(
		    	'type'=>'google',
		    	'google'=>array('family'=>'Roboto Slab', 'weight_normal' => 300),
		    ),
				'options'=>array(
		    	'Arial' => 'Arial',
		    	'Times New Roman' => 'Times New Roman',
		    	'Verdana' => 'Verdana',
		    	'Tahoma' => 'Tahoma',
		    	'Courier' => 'Courier',
		    	'Courier New' => 'Courier New',
		    	'Georgia' => 'Georgia',
		    	'Impact' => 'Impact',
		    	'Lucida Console' => 'Lucida Console',
		    	'Trebuchet MS' => 'Trebuchet MS',
		    ),
				'type' => 'font',
				'weights' => array('normal'),
			),			
		);
		
		$tmp=array();
		for($i=80;$i<=160;$i++) {
			$tmp[$i]=$i.'%';
		}
		
		$options=array_merge($options, array(
			array(
				'name' => esc_html__('Font scaling', 'eventerra'),
				'desc' => esc_html__('You can scale all font sizes in the theme by this selector', 'eventerra'),
				'id' =>  'eventerra_font_scale',
				'std' => '100',
				'options' => $tmp,
				'type' => 'select',
			)
		));
		
		$tmp=array();
		for($i=1;$i<3.01;$i+=0.05) {
			$tmp[]=sprintf('%01.2f',$i);
		}
		$options=array_merge($options, array(
			array(
				'name' => esc_html__('Text Line Height', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_line_height',
				'std' => '1.60',
				'options' => $tmp,
				'type' => 'select2',
			),
		));
		
														                    
		////////////////////////////////////////////////////////////
		
		$options=array_merge($options, array(
		
			array(
				"name" => esc_html__('Comments','eventerra'),
				"type" => "heading",
			),
		
			array(
				'name' => esc_html__('Hide comments block on pages', 'eventerra'),
				'desc' => esc_html__('Check if you want to hide comments block on single pages. To hide comments on post pages and portfolio - see sections "Post options" and "Portfolio options"', 'eventerra'),
				'id' =>  'eventerra_hide_comments_page',
				'std' => '',
				'type' => 'checkbox',
			),
		
			array(
				'name' => esc_html__('Hide comments block on the post pages', 'eventerra'),
				'desc' => esc_html__('Check if you want to hide comments block on the post pages.', 'eventerra'),
				'id' =>  'eventerra_hide_comments_post',
				'std' => '',
				'type' => 'checkbox',
			),
			
		));
		if(isset($GLOBALS['omPortfolioPlugin'])) {
			$options=array_merge($options, array(		
				array(
					'name' => esc_html__('Hide comments block on the portfolio pages', 'eventerra'),
					'desc' => esc_html__('Check if you want to hide comments block on the portfolio pages.', 'eventerra'),
					'id' =>  'eventerra_hide_comments_portfolio',
					'std' => '',
					'type' => 'checkbox',
				),
			));
		}
		
		$options=array_merge($options, array(
			array(
				"name" => "",
				"message" => esc_html__('Facebook comments','eventerra'),
				"type" => "subheader",
			),
									                    
			array(
				'name' => esc_html__('Moderator Facebook user ID', 'eventerra'),
				'desc' => esc_html__('The easiest way to moderate comments - insert Facebook user ID who can moderate comments. To add multiple moderators, separate the uids by comma without spaces.', 'eventerra'),
				'id' =>  'eventerra_fb_comments_admin_id',
				'std' => '',
				'type' => 'text',
			),
		
			array(
				'name' => esc_html__('Your Facebook application ID', 'eventerra'),
				'desc' => sprintf(esc_html__('Second way to moderate comments - insert Facebook application ID. You will be able to moderate comments with %s', 'eventerra'), '<a href="http://developers.facebook.com/tools/comments" target="_blank">'.esc_html__('Facebook Comment Moderation Tool','eventerra').'</a>' ),
				'id' =>  'eventerra_fb_comments_app_id',
				'std' => '',
				'type' => 'text',
			),
		                    
			array(
				'name' => esc_html__('Number of posts to display by default', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_fb_comments_count',
				'std' => '2',
				'type' => 'text',
			),
		                    
			array(
				'name' => esc_html__('Facebook comments color scheme', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_fb_comments_color',
				'std' => '',
				'options'=>array(
		    	'' => 'Light',
		    	'dark' => 'Dark',
		    ),
				'type' => 'select',
			),
		
			array(
				'name' => esc_html__('Show Facebook comments on pages', 'eventerra'),
				'desc' => esc_html__('Check to show Facebook comments block on single pages', 'eventerra'),
				'id' =>  'eventerra_fb_comments_page',
				'std' => '',
				'type' => 'checkbox',
			),
		
			array(
				'name' => esc_html__('Show Facebook comments on post pages', 'eventerra'),
				'desc' => esc_html__('Check to show Facebook comments block on single post pages', 'eventerra'),
				'id' =>  'eventerra_fb_comments_post',
				'std' => '',
				'type' => 'checkbox',
			),
			             
			array(
				'name' => esc_html__('Position of Facebook comments', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_fb_comments_position',
				'std' => '',
				'options'=>array(
		    	'' => 'Before WordPress Comments',
		    	'after' => 'After WordPress Comments',
		    ),
				'type' => 'select',
			),
		
		////////////////////////////////////////////////////////////
		
			array(
				"name" => esc_html__('Page titles','eventerra'),
				"type" => "heading",
			),
		                    
			array(
				"name" => "",
				"message" => esc_html__('You can set default page titles layout here. Also it\'s possible to set custom page title layout for a specific page when edit it.','eventerra'),
				"type" => "intro",
			),

			array(
				'name' => esc_html__('Uppercase page titles?', 'eventerra'),
				'desc' => esc_html__('Yes, please', 'eventerra'),
				'id' =>  'eventerra_page_title_uppercase',
				'std' => 'true',
				'type' => 'checkbox',
			),
					
			array(
				"name" => esc_html__('Page title layout','eventerra'),
				"desc" => '',
				"id" => "eventerra_default_page_title",
				"type" => 'select',
				"std" => 'standard',
					'options' => array(
						'standard' => esc_html__('Standard', 'eventerra'),
						'shadow' => esc_html__('With a shadow', 'eventerra'),
						'hide' => esc_html__('Hide', 'eventerra'),
					),
					'code' => '<script>
						jQuery(function($){
							$("#'.'eventerra_default_page_title").change(function(){
								$("#'.'eventerra_default_title_align").parents(".om-options-section").hide();
								
								if($(this).val() == "standard") {
									$("#'.'eventerra_default_title_align").parents(".om-options-section").show();
								}
							}).change();
						});
					</script>',
			),
			
			array(
				"name" => esc_html__('Title align','eventerra'),
				"desc" => '',
				"id" => "eventerra_default_title_align",
				"type" => 'select',
				"std" => '',
				'options' => array(
					'' => esc_html__('Left', 'eventerra'),
					'center' => esc_html__('Center', 'eventerra'),
					'right' => esc_html__('Right', 'eventerra'),
				),
			),
			

		////////////////////////////////////////////////////////////
		
		
			array(
				"name" => esc_html__('Blog options','eventerra'),
				"type" => "heading",
			),

			array(
				'name' => esc_html__('Date format', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_blog_date_format',
				'std' => 'm/d|Y',
				'options'=>array(
					'M j|Y'=>esc_html__('Month DD, YYYY', 'eventerra'),
					'm/d|Y'=>esc_html__('MM/DD/YYYY', 'eventerra'),
					'd/m|Y'=>esc_html__('DD/MM/YYYY', 'eventerra'),
					'default'=>esc_html__('Default, see Settings - General Settings - Date Format', 'eventerra'),
				),
				'type' => 'radio',
			),
					                    
			array(
				'name' => esc_html__('Excerpt mode', 'eventerra'),
				'desc' => esc_html__('&lt;!--more--&gt; tag can be inserted with "Insert More Tag" button at the toolbar pane. Custom excerpt field can be enabled under "Screen options - Excerpt" when you edit the post','eventerra'),
				'id' =>  'eventerra_blog_excerpt_mode',
				'std' => 'more',
				'options'=>array(
		    	'more' => esc_html__('Excerpt separated by &lt;!--more--&gt; tag or set by custom excerpt field','eventerra'),
		    	'auto' => esc_html__('Excerpt generated automatically if not set by custom excerpt field','eventerra'),
		    ),
				'type' => 'select',
			),
		                    
			array(
				'name' => esc_html__('Auto excerpt length', 'eventerra'),
				'desc' => esc_html__('Specify the length of excerpt in number of words, if the automatically generated excerpt chosen above', 'eventerra'),
				'id' =>  'eventerra_blog_excerpt_length',
				'std' => '30',
				'type' => 'text',
			),
		
			array(
				'name' => esc_html__('Hide post author', 'eventerra'),
				'desc' => esc_html__('Check, if you want to hide post author name', 'eventerra'),
				'id' =>  'eventerra_post_hide_author',
				'std' => '',
				'type' => 'checkbox',
			),
		
			array(
				'name' => esc_html__('Hide post categories', 'eventerra'),
				'desc' => esc_html__('Check, if you want to hide post categories', 'eventerra'),
				'id' =>  'eventerra_post_hide_categories',
				'std' => '',
				'type' => 'checkbox',
			),
		                    
			array(
				'name' => esc_html__('Hide post tags', 'eventerra'),
				'desc' => esc_html__('Check, if you want to hide post tags', 'eventerra'),
				'id' =>  'eventerra_post_hide_tags',
				'std' => '',
				'type' => 'checkbox',
			),
		                    
			array(
				'name' => esc_html__('Hide post date', 'eventerra'),
				'desc' => esc_html__('Check, if you want to hide post date', 'eventerra'),
				'id' =>  'eventerra_post_hide_date',
				'std' => '',
				'type' => 'checkbox',
			),
		                    
			array(
				'name' => esc_html__('Hide comments counter', 'eventerra'),
				'desc' => esc_html__('Check, if you want to hide post comments counter', 'eventerra'),
				'id' =>  'eventerra_post_hide_comments',
				'std' => '',
				'type' => 'checkbox',
			),
		
			array(
				'name' => esc_html__('Show featured image on the post page', 'eventerra'),
				'desc' => esc_html__('Check to show the featured image at the beginning of the post on the single post page', 'eventerra'),
				'id' =>  'eventerra_post_single_show_thumb',
				'std' => 'true',
				'type' => 'checkbox',
			),
		                    
			array(
				'name' => esc_html__('Previous/next navigation links', 'eventerra'),
				'desc' => esc_html__('Show previous/next links on post pages', 'eventerra'),
				'id' =>  'eventerra_show_prev_next_post',
				'std' => '',
				'type' => 'checkbox',
			),
		                    
			array(
				'name' => esc_html__('Pagination mode', 'eventerra'),
				'desc' => esc_html__('Choose the pagination mode for blog (number of posts per page can be set under "Settings - Reading")', 'eventerra'),
				'id' =>  'eventerra_blog_pagination',
				'std' => '',
				'options'=>array(
		    	'' => esc_html__('Older/Newer links','eventerra'),
		    	'pages' => esc_html__('Links to pages (1, 2, 3, ...)','eventerra'),
		    ),
				'type' => 'select',
			),
		
			array(
				"name" => "",
				"message" => esc_html__('Archive/Category Options','eventerra'),
				"type" => "subheader",
			),
		
			array(
				'name' => esc_html__('Pull sidebar/slider settings for Archive/Category pages from page:', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_archive_category_page_settings',
				'std' => '',
				'type' => 'select-page',
			),
		                    
			array(
				"name" => "",
				"message" => esc_html__('Frontpage displays latest posts','eventerra'),
				"type" => "subheader",
			),
		
			array(
				'name' => esc_html__('Pull sidebar/slider settings for Frontpage from page:', 'eventerra'),
				'desc' => esc_html__('Use this option if Frontpage displays latest posts','eventerra'),
				'id' =>  'eventerra_front_page_settings',
				'std' => '',
				'type' => 'select-page',
			),

		));
		
		////////////////////////////////////////////////////////////
		
		if(isset($GLOBALS['omPersonsPlugin'])) {
			$options=array_merge($options, array(
				array(
					"name" => esc_html__('Speakers','eventerra'),
					"type" => "heading",
				),
	
				array(
					'name' => '',
					'desc' => esc_html__('Hide Other Speakers block on speaker single page', 'eventerra'),
					'id' =>  'eventerra_other_speakers_hide',
					'std' => '',
					'type' => 'checkbox',
				),
	
				array(
					'name' => esc_html__('Other Speakers block title', 'eventerra'),
					'desc' => esc_html__('Other Speakers block title on speaker single page', 'eventerra'),
					'id' =>  'eventerra_other_speakers_title',
					'std' => esc_html__('Other Speakers', 'eventerra'),
					'type' => 'text',
					'dependency' => array(
						'id' => 'eventerra_other_speakers_hide',
						'mode' => 'value',
						'value' => '',
					),
				),
						
			));
		}
							
		////////////////////////////////////////////////////////////
		
		$options=array_merge($options, array(
		
			array(
				"name" => esc_html__('Lightbox','eventerra'),
				"type" => "heading",
			),
		                    
			array(
				'name' => esc_html__('PrettyPhoto Lightbox', 'eventerra'),
				'desc' => esc_html__('Check to show navigation chain', 'eventerra'),
				'id' =>  'eventerra_prettyphoto_lightbox',
				'std' => 'enabled',
				'options'=>array(
					'enabled' => esc_html__('Use Lightbox for images and galleries', 'eventerra'),
					'disabled' => esc_html__('Disable Lightbox', 'eventerra'),
					'disabled_no_action' => esc_html__('Disable Lightbox and disable click on image in galleries', 'eventerra'),
		    ),
				'type' => 'select',
			),
		
			array(
				'name' => '',
				'desc' => esc_html__('Show title', 'eventerra'),
				'id' =>  'eventerra_prettyphoto_show_title',
				'std' => 'true',
				'type' => 'checkbox',
			),
		                    
			array(
				'name' => '',
				'desc' => esc_html__('Show social buttons', 'eventerra'),
				'id' =>  'eventerra_prettyphoto_social_tools',
				'std' => 'false',
				'type' => 'checkbox',
			),
		
			array(
				'name' => '',
				'desc' => esc_html__('Overlay gallery on the fullscreen image on mouse over', 'eventerra'),
				'id' =>  'eventerra_prettyphoto_overlay_gallery',
				'std' => 'false',
				'type' => 'checkbox',
			),
		                    		                    
		                    
		                    
		////////////////////////////////////////////////////////////
		
			array(
				"name" => esc_html__('Breadcrumbs','eventerra'),
				"type" => "heading",
			),
		                    
			array(
				'name' => esc_html__('Show breadcrumbs', 'eventerra'),
				'desc' => esc_html__('Check to show navigation chain', 'eventerra'),
				'id' =>  'eventerra_show_breadcrumbs',
				'std' => '',
				'type' => 'checkbox',
			),
		
			array(
				'name' => esc_html__('Breadcrumbs caption', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_breadcrumbs_caption',
				'std' => '',
				'type' => 'text',
			),
		
			array(
				'name' => esc_html__('Current page title', 'eventerra'),
				'desc' => esc_html__('Check to include current page title to breadcrumbs', 'eventerra'),
				'id' =>  'eventerra_breadcrumbs_show_current',
				'std' => '',
				'type' => 'checkbox',
			),
		                    
		
		////////////////////////////////////////////////////////////
		
		
			array(
				"name" => esc_html__('Sidebars','eventerra'),
				"type" => "heading",
			),
		
			array(
				"name" => esc_html__('Sidebar position','eventerra'),
				"desc" => esc_html__('Select sidebar alignment.','eventerra'),
				"id" => "eventerra_sidebar_position",
				"std" => "right",
				"type" => "images",
				"options" => array(
					'right' => EVENTERRA_TEMPLATE_DIR_URI . '/admin/images/2cr.png',
					'left' => EVENTERRA_TEMPLATE_DIR_URI . '/admin/images/2cl.png'
				),
			),
		
		/*						
			array(
				"name" => "",
				"message" => esc_html__('You can set the number of available alternative sidebars, set them up at the "Appearance > Widgets" section and choose for every page one of them at the page settings.','eventerra'),
				"type" => "intro",
			),
							
			array(
				"name" => esc_html__('Number of alternative sidebars','eventerra'),
				"desc" => '',
				"id" => "eventerra_sidebars_num",
				"std" => "3",
				"type" => "text",
			),
		*/
		
			array(
				"name" => esc_html__('Sticky sidebar','eventerra'),
				"desc" => esc_html__('Check to enable sidebar sliding up and down while scrolling the page.','eventerra'),
				"id" => "eventerra_sidebar_sliding",
				"std" => "true",
				"type" => "checkbox",
			),
						
					
		////////////////////////////////////////////////////////////
		
			array(
				"name" => esc_html__('Social icons','eventerra'),
				"type" => "heading",
			),
		
			array(
				"name" => esc_html__('Social icons in the header','eventerra'),
				"desc" => esc_html__('Check to display social icons in the header.','eventerra'),
				"id" => 'eventerra_social_icons_header',
				"std" => "true",
				"type" => "checkbox",
			),
		
			array(
				"name" => esc_html__('Social icons in the footer','eventerra'),
				"desc" => esc_html__('Check to display social icons in the footer.','eventerra'),
				"id" => 'eventerra_social_icons_footer',
				"std" => "true",
				"type" => "checkbox",
			),
								                    
			array(
				"name" => '',
				"message" => esc_html__('Specify necessary links and icons will be shown in the header. Note, that link should begins with http://','eventerra'),
				"type" => "intro",
			),
		
			array(
				"name" => '',
				"message" => '<b>'.sprintf(esc_html__('You can set order of icons for the front page %s','eventerra'), '<a href="'.esc_url(admin_url('themes.php?page=social_icons_sort')).'">'.esc_html__('here','eventerra').'</a>').'</b>',
				"type" => "note",
			),
		
		));
		
		$icons=eventerra_social_icons_list();
		foreach($icons as $k=>$v) {
			$options[]=array(
				'name' => $v.' '.esc_html__('link','eventerra'),
				'id' =>  'eventerra_social_'.$k,
				'std' => '',
				'type' => 'text',
			);
		}                    
		
		////////////////////////////////////////////////////////////
		
		$options=array_merge($options, array(
			array(
				"name" => esc_html__('Sliders','eventerra'),
				"type" => "heading",
			),
		
			array(
				"name" => "",
				"message" => esc_html__('LayerSlider','eventerra'),
				"type" => "subheader",
			),
		));
							
		if(isset($GLOBALS['lsPluginVersion']) || defined('LS_PLUGIN_VERSION')){
			$options[]=array(
				"name" => "",
				"message" => sprintf(esc_html__('LayerSlider can be deactivated via %s.','eventerra'), '<a href="'.esc_url(admin_url('plugins.php')).'">'.esc_html__('plugins manager tool','eventerra').'</a>'),
				"type" => "note",
			);
		} else {
			$options[]=array(
				"name" => "",
				"message" => sprintf(esc_html__('LayerSlider can be installed and activated via %s.','eventerra'), '<a href="'.esc_url(admin_url('themes.php?page=tgmpa-install-plugins')).'">'.esc_html__('theme plugins manager tool','eventerra').'</a>'),
				"type" => "note",
			);
		}
		
		$options=array_merge($options, array(
			array(
				"name" => "",
				"message" => esc_html__('Revolution slider','eventerra'),
				"type" => "subheader",
			),
		));
		
		if(class_exists('RevSlider')){
			$options[]=array(
				"name" => "",
				"message" => sprintf(esc_html__('Revolution slider can be deactivated via %s.','eventerra'), '<a href="'.esc_url(admin_url('plugins.php')).'">'.esc_html__('plugins manager tool','eventerra').'</a>'),
				"type" => "note",
			);
		} else {
			$options[]=array(
				"name" => "",
				"message" => sprintf(esc_html__('Revolution slider can be installed and activated via %s.','eventerra'), '<a href="'.esc_url(admin_url('themes.php?page=tgmpa-install-plugins')).'">'.esc_html__('theme plugins manager tool','eventerra').'</a>'),
				"type" => "note",
			);
		}		
		
		////////////////////////////////////////////////////////////
		
		$options=array_merge($options, array(
			array(
				"name" => esc_html__('Visual Composer','eventerra'),
				"type" => "heading",
			),
		));
		                    
		if(eventerra_wpb_activated()){
			$options=array_merge($options, array(
				array(
					"name" => "",
					"message" => sprintf(esc_html__('Visual Composer can be deactivated via %s.','eventerra'), '<a href="'.esc_url(admin_url('plugins.php')).'">'.esc_html__('plugins manager tool','eventerra').'</a>'),
					"type" => "note",
				),
									
				array(
					'name' => 'Deactivate Visual Composer Theme`s Addons',
					'desc' => esc_html__('Check this option if you want to deactivate all addons and modifications, provided by the Theme. It can be handy, if you want to use some other addon for Visual Composer, but it cause a conflict.', 'eventerra'),
					'id' =>  'eventerra_disable_wpb_addons',
					'std' => '',
					'type' => 'checkbox',
				),
			));	                    
		} else {
			$options[]=array(
				"name" => "",
				"message" => sprintf(esc_html__('Visual Composer can be installed and activated via %s.','eventerra'), '<a href="'.esc_url(admin_url('themes.php?page=tgmpa-install-plugins')).'">'.esc_html__('theme plugins manager tool','eventerra').'</a>'),
				"type" => "note",
			);
		}
		
		////////////////////////////////////////////////////////////
		
		$options=array_merge($options, array(
		
			array(
				"name" => esc_html__('Theme updates','eventerra'),
				"type" => "heading",
			),
		
			array(
				"name" => "",
				"message" => esc_html__('If you want to receive notifications about new Theme versions in WordPress Dashboard, please, specify your ThemeForest(Envato) username and API key below.','eventerra'),
				"type" => "note",
			),		                    
								
			array(
				'name' => esc_html__('Your ThemeForest(Envato) username', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_envato_username',
				'std' => '',
				'type' => 'text',
			),
		                    
			array(
				'name' => esc_html__('Your ThemeForest(Envato) API key', 'eventerra'),
				'desc' => '',
				'id' =>  'eventerra_envato_api',
				'std' => '',
				'type' => 'text',
			),
					
		////////////////////////////////////////////////////////////
		
			array(
				"name" => esc_html__('Custom CSS','eventerra'),
				"type" => "heading",
			),
		                    
			array(
				'name' => '',
				'desc' => esc_html__('Here you can add custom CSS code', 'eventerra'),
				'id' =>  'eventerra_code_custom_css',
				'std' => '',
				'rows' => '20',
				'type' => 'textarea',
			),
		
		));
		
		if(defined('ICL_SITEPRESS_VERSION')) {
			$options=array_merge($options, array(
				array(
					"name" => esc_html__('WPML','eventerra'),
					"type" => "heading",
				),
				              
				array(
					'name' => '',
					'desc' => esc_html__('Display WPML language selector in the header', 'eventerra'),
					'id' =>  'eventerra_show_wpml_language_selector',
					'std' => '',
					'type' => 'checkbox',
				),
			));
		}

		if(isset($args['id_as_key']) && $args['id_as_key']) {
			$options_=array();
			foreach($options as $v) {
				if(isset($v['id'])) {
					$options_[$v['id']]=$v;
				}
			}
			$options=$options_;
		}
				
		return $options;
	}
}




	
