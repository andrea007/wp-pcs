<?php

omfw_Framework::demo_import(array(
	array(
		'slug' => 'reg',
		'name' => esc_html__('Demo with Registration Form','eventerra'),
		'demo_content_path' => EVENTERRA_TEMPLATE_DIR . '/demo-content/registration/',
		'wordpress_xml' => 'wordpress.xml',
		'theme_options_dat' => 'theme_options.dat',
		'widgets_dat' => 'widgets.wie',
		'layer_slider_dat' => false, //'LayerSlider.json',
		'layer_slider_uploads_replace' => array(),
		'rev_slider_dat' => array(
			'primary-slider.zip',
		),
		'uploads_replace_dir' => 'http://demo.olevmedia.net/eventerra/wp-content/uploads',
		'widgets_var_to_replace' => array(
			array(
				'sidebar' => 'footer-column-1',
				'widget_key' => 'text-2',
				'widget_field' => 'text',
			),
		),
		'menus' => array( // pair "Menu Name" => "Location"
			'Primary menu' => 'primary-menu',
			'Downloads' => 'secondary-menu',
		),
		'reading' => array(
			'front_page_title' => 'Home',
			'posts_page_title' => '',
		),
		'menu_add_meta' => array(
			'_menu_item_megamenu',
			'_menu_item_megamenu_hide_titles',
			'_menu_item_om_icon',
		),
	),
	
	array(
		'slug' => 'ticket',
		'name' => esc_html__('Demo with Tickets Plugin','eventerra'),
		'demo_content_path' => EVENTERRA_TEMPLATE_DIR . '/demo-content/tickets/',
		'wordpress_xml' => 'wordpress.xml',
		'theme_options_dat' => 'theme_options.dat',
		'widgets_dat' => 'widgets.wie',
		'layer_slider_dat' => false, //'LayerSlider.json',
		'layer_slider_uploads_replace' => array(),
		'rev_slider_dat' => array(
			'primary-slider.zip',
		),
		'uploads_replace_dir' => 'http://demo.olevmedia.net/eventerra/wp-content/uploads',
		'widgets_var_to_replace' => array(
			array(
				'sidebar' => 'footer-column-1',
				'widget_key' => 'text-2',
				'widget_field' => 'text',
			),
		),
		'menus' => array( // pair "Menu Name" => "Location"
			'Primary menu' => 'primary-menu',
			'Downloads' => 'secondary-menu',
		),
		'reading' => array(
			'front_page_title' => 'Home',
			'posts_page_title' => '',
		),
		'menu_add_meta' => array(
			'_menu_item_megamenu',
			'_menu_item_megamenu_hide_titles',
			'_menu_item_om_icon',
		),
	),
));

add_action('omfw_demo_import_reg_completed', 'eventerra_demo_import_reg_completed');

function eventerra_demo_import_reg_completed() {
	
	$reg_form_post=get_page_by_title('Registration form', 'OBJECT', 'wpcf7_contact_form');
	$contact_form_post=get_page_by_title('Contact us', 'OBJECT', 'wpcf7_contact_form');
	
	$reg_post=get_page_by_title('Registration');
	if($reg_post) {
		$reg_post_link=get_permalink($reg_post->ID);
		
		$post=get_page_by_title('Home');
		if($post) {
			$post->post_content=str_replace('http%3A%2F%2Fdemo.olevmedia.net%2Feventerra%2Fregistration%2F',urlencode($reg_post_link),$post->post_content);

			$post_update = array(
				'ID' => $post->ID,
				'post_content' => $post->post_content,
		  );
		  wp_update_post($post_update);
		}
	  
	  ////

		$post=get_page_by_title('Speakers');
		if($post) {
			$post->post_content=str_replace('http%3A%2F%2Fdemo.olevmedia.net%2Feventerra%2Fregistration%2F',urlencode($reg_post_link),$post->post_content);

			$post_update = array(
				'ID' => $post->ID,
				'post_content' => $post->post_content,
		  );
		  wp_update_post($post_update);
		}
	  
	  ////
	  
	  $s=get_option('eventerra_menu_extra_button_link');
	  if($s) {
		  $s=str_replace('/eventerra/registration/',$reg_post_link,$s);
		  update_option('eventerra_menu_extra_button_link', $s);
		}
	  
	  ////
	  
		if($reg_form_post) {
			$reg_post->post_content=str_replace('[contact-form-7 id="7"]','[contact-form-7 id="'.$reg_form_post->ID.'"]',$reg_post->post_content);

			$post_update = array(
				'ID' => $reg_post->ID,
				'post_content' => $reg_post->post_content,
		  );
		  wp_update_post($post_update);
		}
	  
		
	}

	////

	$contacts_post=get_page_by_title('Contacts');
	if($contacts_post && $contact_form_post) {
		$contacts_post->post_content=str_replace('[contact-form-7 id="321"]','[contact-form-7 id="'.$contact_form_post->ID.'"]',$contacts_post->post_content);
			
		$post_update = array(
			'ID' => $contacts_post->ID,
			'post_content' => $contacts_post->post_content,
	  );
	  wp_update_post($post_update);
	}
	
	///

	$from_email=strtolower($_SERVER['SERVER_NAME']);
	if(substr($from_email,0,4)=='www.') {
		$from_email=substr($from_email,4);
	}
  $from_email='wordpress@'.$from_email;
  $admin_email=get_option('admin_email');
	
	if($reg_form_post) {
		$mail=get_post_meta($reg_form_post->ID,'_mail',true);
		if(is_array($mail)) {
			if(isset($mail['sender'])) {
				$mail['sender']=str_replace('wordpress@demo.olevmedia.net',$from_email,$mail['sender']);
			}
			if(isset($mail['recipient'])) {
				$mail['recipient']=$admin_email;
			}
			update_post_meta($reg_form_post->ID,'_mail',$mail);
		}
	}
	if($contact_form_post) {
		$mail=get_post_meta($contact_form_post->ID,'_mail',true);
		if(is_array($mail)) {
			if(isset($mail['sender'])) {
				$mail['sender']=str_replace('wordpress@demo.olevmedia.net',$from_email,$mail['sender']);
			}
			if(isset($mail['recipient'])) {
				$mail['recipient']=$admin_email;
			}
			update_post_meta($contact_form_post->ID,'_mail',$mail);
		}
	}
	
}

add_action('omfw_demo_import_ticket_completed', 'eventerra_demo_import_ticket_completed');

function eventerra_demo_import_ticket_completed() {
	
	$post=get_page_by_title('Tickets');
	if($post) {
		$post_link=get_permalink($post->ID);
	  $s=get_option('eventerra_menu_extra_button_link');
	  if($s) {
		  $s=str_replace('/eventerra/tickets/tickets/',$post_link,$s);
		  update_option('eventerra_menu_extra_button_link', $s);
		}
	}
	
	////

	$contacts_post=get_page_by_title('Contacts');
	$contact_form_post=get_page_by_title('Contact us', 'OBJECT', 'wpcf7_contact_form');
	if($contacts_post && $contact_form_post) {
		$contacts_post->post_content=str_replace('[contact-form-7 id="321"]','[contact-form-7 id="'.$contact_form_post->ID.'"]',$contacts_post->post_content);
			
		$post_update = array(
			'ID' => $contacts_post->ID,
			'post_content' => $contacts_post->post_content,
	  );
	  wp_update_post($post_update);
	}
	
	///

	$from_email=strtolower($_SERVER['SERVER_NAME']);
	if(substr($from_email,0,4)=='www.') {
		$from_email=substr($from_email,4);
	}
  $from_email='wordpress@'.$from_email;
  $admin_email=get_option('admin_email');

	if($contact_form_post) {
		$mail=get_post_meta($contact_form_post->ID,'_mail',true);
		if(is_array($mail)) {
			if(isset($mail['sender'])) {
				$mail['sender']=str_replace('wordpress@demo.olevmedia.net',$from_email,$mail['sender']);
			}
			if(isset($mail['recipient'])) {
				$mail['recipient']=$admin_email;
			}
			update_post_meta($contact_form_post->ID,'_mail',$mail);
		}
	}
		
	////
	
	if(class_exists( 'TC' )) {
		update_option('tc_general_setting', unserialize('a:30:{s:10:"currencies";s:3:"USD";s:15:"currency_symbol";s:1:"$";s:17:"currency_position";s:11:"pre_nospace";s:12:"price_format";s:2:"us";s:13:"show_tax_rate";s:3:"yes";s:8:"tax_rate";s:1:"0";s:13:"tax_inclusive";s:2:"no";s:9:"tax_label";s:3:"Tax";s:15:"use_global_fees";s:2:"no";s:15:"global_fee_type";s:10:"percentage";s:16:"global_fee_scope";s:6:"ticket";s:16:"global_fee_value";s:1:"0";s:9:"show_fees";s:3:"yes";s:10:"fees_label";s:4:"Fees";s:11:"force_login";s:2:"no";s:17:"show_owner_fields";s:3:"yes";s:22:"show_owner_email_field";s:2:"no";s:19:"show_discount_field";s:3:"yes";s:30:"tc_process_payment_use_virtual";s:3:"yes";s:23:"tc_ipn_page_use_virtual";s:3:"yes";s:19:"show_cart_menu_item";s:2:"no";s:21:"global_admin_per_page";s:2:"10";s:30:"use_order_details_pretty_links";s:3:"yes";s:25:"show_events_as_front_page";s:2:"no";s:30:"ticket_template_auto_pagebreak";s:2:"no";s:21:"delete_pending_orders";s:2:"no";s:13:"tc_event_slug";s:9:"tc-events";s:22:"tc_event_category_slug";s:17:"tc-event-category";s:29:"tc_attach_event_date_to_title";s:3:"yes";s:33:"tc_attach_event_location_to_title";s:3:"yes";}'));
		$post=get_page_by_title('Cart');
		if($post) {
			update_option('tc_cart_page_id', $post->ID);
		}
		$post=get_page_by_title('Payment Confirmation');
		if($post) {
			update_option('tc_confirmation_page_id', $post->ID);
		}
		$post=get_page_by_title('IPN');
		if($post) {
			update_option('tc_ipn_page_id', $post->ID);
		}
		update_option('tc_needs_pages', 0);
		$post=get_page_by_title('Order Details');
		if($post) {
			update_option('tc_order_page_id', $post->ID);
		}
		$post=get_page_by_title('Payment');
		if($post) {
			update_option('tc_payment_page_id', $post->ID);
		}
		$post=get_page_by_title('Process Payment');
		if($post) {
			update_option('tc_process_payment_page_id', $post->ID);
		}
	}
	
}