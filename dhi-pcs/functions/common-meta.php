<?php

if(!function_exists('eventerra_add_common_meta_boxes')) {
	function eventerra_add_common_meta_boxes(&$arr, $boxes, $prefix) {
	
		$meta_boxes = array (
		
			'pagetitle' => array (
				'id' => 'pagetitle',
				'name' => esc_html__('Page Title', 'eventerra'),
				'fields' => array (
					array ( "name" => esc_html__('Page Title Layout','eventerra'),
							"desc" => '',
							"id" => "eventerra_page_title",
							"type" => "select",
							"std" => '',
							'options' => array(
								'' => esc_html__('Default (as set in Theme Options)', 'eventerra'),
								'standard' => esc_html__('Standard', 'eventerra'),
								'shadow' => esc_html__('With a shadow', 'eventerra'),
								'hide' => esc_html__('Hide', 'eventerra'),
							),
							'code' => '<script>
								jQuery(function($){
									$("#'.'eventerra_page_title").change(function(){
										$("#'.'eventerra_title_align").parents("tr").hide();
										$("#'.'eventerra_title_alternative_text").parents("tr").hide();
										$("#'.'eventerra_title_shadow_text").parents("tr").hide();
										$("#'.'eventerra_title_subtitle").parents("tr").hide();
										
										if($(this).val() == "hide") {
											$("#'.'eventerra_title_subtitle").parents("tr").hide();
										} else {
											$("#'.'eventerra_title_subtitle").parents("tr").show();
										}
										
										if($(this).val() == "standard") {
											$("#'.'eventerra_title_align").parents("tr").show();
											$("#'.'eventerra_title_alternative_text").parents("tr").show();
										} else if($(this).val() == "shadow") {
											$("#'.'eventerra_title_alternative_text").parents("tr").show();
											$("#'.'eventerra_title_shadow_text").parents("tr").show();
										}
									}).change();
								});
							</script>',
					),
					
					array ( "name" => esc_html__('Title align','eventerra'),
							"desc" => '',
							"id" => "eventerra_title_align",
							"type" => "select",
							"std" => '',
							'options' => array(
								'' => esc_html__('Left', 'eventerra'),
								'center' => esc_html__('Center', 'eventerra'),
								'right' => esc_html__('Right', 'eventerra'),
							),
					),
					
					array ( "name" => esc_html__('Title alternative text','eventerra'),
							"desc" => sprintf(esc_html__('You can specify alternative title text here and apply accent colors (see "%s - Styling") to certain words. Use codes %s to colorize words.', 'eventerra'), '<a href="'.esc_url(omfw_Framework::theme_options_url()).'">'.esc_html__('Theme Options', 'eventerra').'</a>', '<b>[color1]word[/color1], [color2]word[/color2], [color3]word[/color3]</b>'),
							"id" => "eventerra_title_alternative_text",
							"type" => "text",
							"std" => '',
					),
					
					array ( "name" => esc_html__('Title shadow alternative text','eventerra'),
							"desc" => esc_html__('You can specify alternative text for shadow, otherwise page title will be used','eventerra'),
							"id" => "eventerra_title_shadow_text",
							"type" => "text",
							"std" => '',
					),

					array ( "name" => esc_html__('Subtitle text','eventerra'),
							"desc" => esc_html__('Additional text string below the page title','eventerra'),
							"id" => "eventerra_title_subtitle",
							"type" => "text",
							"std" => '',
					),
					
				),
			),
			
			'slider' => array (
				'id' => 'slider',
				'name' => esc_html__('Slider', 'eventerra'),
				'fields' => array (
		
					array (
						'name' => esc_html__('Choose the slider','eventerra'),
						'desc' => '',
						'id' => 'eventerra_slider_id',
						'type' => 'slider',
						'std' => ''
					),
		
					array ( "name" => esc_html__('Slider layout','eventerra'),
							"desc" => '',
							"id" => "eventerra_slider_layout",
							"type" => "select",
							"std" => 'above',
							'options' => array(
								'above' => esc_html__('Above page title', 'eventerra'),
								'below' => esc_html__('Below page title', 'eventerra'),
							)
					),
					
				),
				
			),
			
			'sidebar' => array (
				'id' => 'sidebar',
				'name' => esc_html__('Sidebar', 'eventerra'),
				'fields' => array (
					array ( "name" => esc_html__('Sidebar','eventerra'),
							"desc" => '',
							"id" => "eventerra_sidebar_show",
							"type" => "select",
							"std" => 'hide',
							'options' => array(
								'hide' => esc_html__('Hide Sidebar', 'eventerra'),
								'display' => esc_html__('Display Sidebar', 'eventerra'),
							),
							'code' => '<script>
								jQuery(function($){
									$("#'.'eventerra_sidebar_show").change(function(){
										if($(this).val() == "hide") {
											$("#'.'eventerra_sidebar").parents("tr").hide();
											$("#'.'eventerra_sidebar_custom_pos").parents("tr").hide();
										} else {
											$("#'.'eventerra_sidebar").parents("tr").show();
											$("#'.'eventerra_sidebar_custom_pos").parents("tr").show();
										}
									}).change();
								});
							</script>',
					),
		
					array (
						'name' => esc_html__('Choose the sidebar','eventerra'),
						'desc' => esc_html__('You can create any number of sidebars under "Appearance > Sidebars".','eventerra'),
						'id' => 'eventerra_sidebar',
						'type' => 'sidebar',
						'std' => ''
					),
		
					array ( "name" => esc_html__('Sidebar Position','eventerra'),
							"desc" => esc_html__('Sidebar position for current page.','eventerra'),
							"id" => "eventerra_sidebar_custom_pos",
							"type" => "select",
							"std" => '',
							'options' => array(
								'' => esc_html__('Default (As set in "Theme Options")', 'eventerra'),
								'left' => esc_html__('Left Side', 'eventerra'),
								'right' => esc_html__('Right Side', 'eventerra'),
							)
					),
				),
			),
			
		);
		
		foreach($boxes as $id) {
			
			if( isset($meta_boxes[$id]) ) {
				
				if($id == 'slider') {
					if( omfw_Framework::is_slider_active() ) { 
						$arr[$id]=$meta_boxes[$id];
						$arr[$id]['id']=$prefix.$arr[$id]['id'];
					}
				} else {
					$arr[$id]=$meta_boxes[$id];
					$arr[$id]['id']=$prefix.$arr[$id]['id'];
				}
				
			}
			
			
		}
		
	}
}