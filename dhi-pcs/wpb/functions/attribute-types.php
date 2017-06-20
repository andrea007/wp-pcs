<?php

if(class_exists('WpbakeryShortcodeParams')) {

	function eventerra_wpb_attribute_attach_video($settings, $value) {
		return
	   	'<div class="'.$settings['type'].'_field_block">'.
				'<input name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field" id="wpb_'.$settings['param_name'].'_value" type="text" value="'.$value.'" style="width:75%;"/>'.
				' <a href="#" class="button wpb-vc-button om-wpb-browse-button" rel="wpb_'.$settings['param_name'].'_value" data-library="video" data-choose="Choose a file" data-select="Select">Browse</a>'.
			'</div>'
		;
	}
	//vc_add_ shortcode_param('attach_video', 'eventerra_wpb_attribute_attach_video', EVENTERRA_TEMPLATE_WPB_DIR_URI . '/assets/js/attributes.js');
	WpbakeryShortcodeParams::addField('attach_video', 'eventerra_wpb_attribute_attach_video', EVENTERRA_TEMPLATE_WPB_DIR_URI . '/assets/js/attributes.js');
	
	function eventerra_wpb_attribute_om_get_code($settings, $value) {
		return
	   	'<div class="'.$settings['type'].'_field_block">'.
	   		'<a href="#" class="button om_get_code_button" data-output-id="wpb_'.$settings['param_name'].'_value">'.esc_html__('Get code','eventerra').'</a>'.
				'<textarea id="wpb_'.$settings['param_name'].'_value" style="display:none" rows="3" readonly="readonly"></textarea>'.
			'</div>'
		;
	}
	//vc_add_ shortcode_param('om_get_code', 'eventerra_wpb_attribute_om_get_code', EVENTERRA_TEMPLATE_WPB_DIR_URI . '/assets/js/attributes.js');
	WpbakeryShortcodeParams::addField('om_get_code', 'eventerra_wpb_attribute_om_get_code', EVENTERRA_TEMPLATE_WPB_DIR_URI . '/assets/js/attributes.js');
	
	function eventerra_wpb_attribute_om_info($settings, $value) {
		return
	   	'<div class="'.$settings['type'].'_field_block">'.
			'</div>'
		;
	}
	//vc_add_ shortcode_param('om_info', 'eventerra_wpb_attribute_om_info');
	WpbakeryShortcodeParams::addField('om_info', 'eventerra_wpb_attribute_om_info');
	
	function eventerra_wpb_attribute_om_categories($settings, $value) {
		$args = array(
			'show_option_all'    => esc_html__('All Categories', 'eventerra'),
			'show_option_none'   => '',
			'orderby' => 'name',
			'hide_empty'         => 0, 
			'echo'               => 0,
			'selected'           => $value,
			'hierarchical'       => 1, 
			'name'               => $settings['param_name'],
			'id'         		     => 'wpb_'.$settings['param_name'].'_value',
			'class'              => 'wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'_field',
			'depth'              => 4,
			'tab_index'          => 0,
			'taxonomy'           => 'category',
			'hide_if_empty'      => false 	
		);
		
		if(isset($settings['args'])) {
			$args=array_merge($args, $settings['args']);
		}
	
		$select = wp_dropdown_categories( $args );
	
		return
	   	'<div class="'.$settings['type'].'_field_block">'.
				$select.
			'</div>'
		;
	}
	//vc_add_ shortcode_param('om_categories', 'eventerra_wpb_attribute_om_categories', EVENTERRA_TEMPLATE_WPB_DIR_URI . '/assets/js/attributes.js');
	WpbakeryShortcodeParams::addField('om_categories', 'eventerra_wpb_attribute_om_categories', EVENTERRA_TEMPLATE_WPB_DIR_URI . '/assets/js/attributes.js');
	
	function eventerra_wpb_attribute_om_categories_multiple($settings, $value) {
		$args = array(
			'show_option_all'    => esc_html__('All Categories', 'eventerra'),
			'show_option_none'   => '',
			'orderby' => 'name',
			'hide_empty'         => 0, 
			'echo'               => 0,
			'selected'           => $value,
			'hierarchical'       => 1, 
			'name'               => $settings['param_name'],
			'id'         		     => 'wpb_'.$settings['param_name'].'_value',
			'class'              => 'wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'_field',
			'depth'              => 4,
			'tab_index'          => 0,
			'taxonomy'           => 'category',
			'hide_if_empty'      => false 	
		);
		
		if(isset($settings['args'])) {
			$args=array_merge($args, $settings['args']);
		}
	
		$select = wp_dropdown_categories( $args );
		$select = str_replace('<select', '<select multiple="multiple" size="4"', $select);
	
		return
	   	'<div class="'.$settings['type'].'_field_block">'.
				$select.
			'</div>'
		;
	}
	//vc_add_ shortcode_param('om_categories_multiple', 'eventerra_wpb_attribute_om_categories_multiple', EVENTERRA_TEMPLATE_WPB_DIR_URI . '/assets/js/attributes.js');
	WpbakeryShortcodeParams::addField('om_categories_multiple', 'eventerra_wpb_attribute_om_categories_multiple', EVENTERRA_TEMPLATE_WPB_DIR_URI . '/assets/js/attributes.js');
	
	function eventerra_wpb_attribute_om_tc_tickets($settings, $value) {

		$options='';
		if(class_exists('TC_Tickets_Search') && class_exists('TC_Ticket')) {
			$wp_tickets_search = new TC_Tickets_Search( '', '', -1 );
			foreach ( $wp_tickets_search->get_results() as $ticket_type ) {
				$ticket = new TC_Ticket( $ticket_type->ID );
				$options .= '<option value="'. esc_attr( $ticket->details->ID ) .'"'.($ticket->details->ID == $value ? ' selected="selected"' : '').'>'. $ticket->details->post_title .'</option>';
			}
		}
	
		return
	   	'<div class="'.$settings['type'].'_field_block">'.
	   		'<select name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-input wpb-select dropdown">'.
					$options.
				'</select>'.
			'</div>'
		;
	}
	WpbakeryShortcodeParams::addField('om_tc_tickets', 'eventerra_wpb_attribute_om_tc_tickets', EVENTERRA_TEMPLATE_WPB_DIR_URI . '/assets/js/attributes.js');

	function eventerra_wpb_attribute_om_tc_events($settings, $value) {

		$options='';
		if(class_exists('TC_Events_Search') && class_exists('TC_Event')) {
			$wp_events_search = new TC_Events_Search( '', '', -1 );
			foreach ( $wp_events_search->get_results() as $event ) {
				$event = new TC_Event( $event->ID );
				$options .= '<option value="'. esc_attr( $event->details->ID ) .'"'.($event->details->ID == $value ? ' selected="selected"' : '').'>'. $event->details->post_title .'</option>';
			}
		}
	
		return
	   	'<div class="'.$settings['type'].'_field_block">'.
	   		'<select name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-input wpb-select dropdown">'.
					$options.
				'</select>'.
			'</div>'
		;
	}
	WpbakeryShortcodeParams::addField('om_tc_events', 'eventerra_wpb_attribute_om_tc_events', EVENTERRA_TEMPLATE_WPB_DIR_URI . '/assets/js/attributes.js');

}