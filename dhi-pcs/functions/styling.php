<?php

$font_options=array(
	'eventerra_base_font',
	'eventerra_sec_font',
	'eventerra_menu_font',
	'eventerra_buttons_font',
	'eventerra_testimonials_font',
);
if(get_option( 'eventerra_site_logo_type' ) == 'text') {
	$font_options[]='eventerra_logo_font';
}

omfw_Framework::styling('eventerra_get_theme_styling', array(
	'font_options' => $font_options,
	'use_inline_callback' => 'eventerra_if_custom_styling_inline',
	'primary_style_handler' => 'eventerra-style',
));

if( !function_exists( 'eventerra_if_custom_styling_inline' ) ) {
	function eventerra_if_custom_styling_inline() {
		return (get_option('eventerra_use_inline_css') == 'true');
	}
}

if( !function_exists( 'eventerra_get_theme_styling' ) ) {
	function eventerra_get_theme_styling() {
		
		/**
		 * Fonts
		 */
		 
		ob_start();
		
		// Base font

		$base_font=get_option('eventerra_base_font');

		if(isset($base_font['type'])) {
			$base_font_f=$base_font[$base_font['type']]['family'];
			
			$base_weight_normal=400;
			$base_weight_bold=700;
			if($base_font['type'] == 'google') {
				if(isset($base_font['google']['weight_normal']))
					$base_weight_normal=$base_font['google']['weight_normal'];
				if(isset($base_font['google']['weight_bold']))
					$base_weight_bold=$base_font['google']['weight_bold'];
			}

			if($base_font_f) {
				echo '
					body,
					input,
					textarea,
					.om-wpb .vc_custom_heading-additional,
					.om-wpb .vc_call_to_action h4.wpb_heading
					{font-family:'.$base_font_f.'}';
					
				if($base_weight_normal != 400) {
					echo '
						body,
						input,
						textarea,
						select,
						.om-wpb .vc_custom_heading-additional,
						.om-wpb .vc_call_to_action h4.wpb_heading
						{font-weight:'.$base_weight_normal.'}';
				}
				if($base_weight_bold != 700) {
					echo '
						b, strong, dt,
						.comment-meta .author,
						th,
						.cart_form .price,
						.om-agenda-item-description-title,
						{font-weight:'.$base_weight_bold.'}';
				}
			}
		}
		
		// Highlight font
		
		$sec_font=get_option('eventerra_sec_font');

		if(isset($sec_font['type'])) {
			$sec_font_f=@$sec_font[@$sec_font['type']]['family'];

			$sec_weight_normal=400;
			$sec_weight_bold=700;
			if(@$sec_font['type'] == 'google') {
				if(isset($sec_font['google']['weight_normal']))
					$sec_weight_normal=$sec_font['google']['weight_normal'];
				if(isset($sec_font['google']['weight_bold']))
					$sec_weight_bold=$sec_font['google']['weight_bold'];
			}
			
	
			
			if($sec_font_f) {
				
				echo '
					h1,h2,h3,h4,h5,h6,
					.page-title-shadow,
					.om-wpb .vc_tta.vc_tta-tabs .vc_tta-tab > a,
					.om-wpb .vc_custom_heading-shadow,
					.om-cib-title,
					.footer-widget-title,
					.blog-posts .post-date,
					.sidebar-widget-title,
					.om-speakers-post,
					.om-agenda-day-header,
					.om-agenda-item-time,
					.event_tickets.tickera th,
					.om_theme .tickera_table th,
					.om-speaker-single-sidebar .om-item-title,
					{font-family:'.$sec_font_f.'}';
				
				
				if($sec_weight_normal != 400) {
					echo '
						.om-wpb .vc_call_to_action h2.wpb_heading,
						.blog-posts .post-date-year,
						{font-weight:'.$base_weight_normal.'}';
				}	
						

				if($sec_weight_bold != 700) {
					echo '
						h1,h2,h3,h4,h5,h6,
						.page-title-shadow,
						.om-wpb .vc_tta.vc_tta-tabs .vc_tta-tab > a,
						.om-wpb .vc_custom_heading-shadow,
						.om-cib-title,
						.footer-widget-title,
						.blog-posts .post-date,
						.sidebar-widget-title,
						.om-agenda-day-header,
						.om-agenda-item-time,
						.event_tickets.tickera th,
						.om_theme .tickera_table th,
						{font-weight:'.$sec_weight_bold.'}';
				}
				
			}
		}
		
		// Logo font
		
		if(get_option( 'eventerra_site_logo_type' ) == 'text') {
			
			$font=get_option('eventerra_logo_font');
	
			if(isset($font['type'])) {
				$font_f=$font[$font['type']]['family'];				
			
				$weight_bold=700;
				if($font['type'] == 'google') {
					if(isset($font['google']['weight_bold']))
						$weight_bold=$font['google']['weight_bold'];
				}
				
				if($font_f) {
					echo '
						.header-logo
						{font-family:'.$font_f;
					if($weight_bold != 700) {
						echo ';font-weight:'.$weight_bold;
					}
					echo '}';
	
				}
			}
			
		}

		// Menu font
		
		$font=get_option('eventerra_menu_font');

		if(isset($font['type'])) {
			$font_f=$font[$font['type']]['family'];				
		
			$weight_normal=400;
			$weight_bold=700;
			if($font['type'] == 'google') {
				if(isset($font['google']['weight_normal']))
					$weight_normal=$font['google']['weight_normal'];
				if(isset($font['google']['weight_bold']))
					$weight_bold=$font['google']['weight_bold'];
			}
			
			if($font_f) {
				echo '
					.header-menu
					{font-family:'.$font_f;
				if($weight_normal != 400) {
					echo ';font-weight:'.$weight_normal;
				}
				echo '}';
				
				if($weight_bold != 700) {
					echo '
						.header-menu.root-items-bold .primary-menu > li > a,
						.primary-menu > li.megamenu-enable > .sub-menu > ul > li > a,
						.header-menu.root-items-bold .header-extra-button,
						.header-menu.root-items-bold .header-extra-dropdown-button
						{font-weight:'.$weight_bold.'}';
				}				

			}
		}
		
		// Buttons font
		
		$font=get_option('eventerra_buttons_font');

		if(isset($font['type'])) {
			$font_f=$font[$font['type']]['family'];				
		
			$weight_normal=400;
			$weight_bold=700;
			if($font['type'] == 'google') {
				if(isset($font['google']['weight_normal']))
					$weight_normal=$font['google']['weight_normal'];
				if(isset($font['google']['weight_bold']))
					$weight_bold=$font['google']['weight_bold'];
			}
			
			if($font_f) {
				echo '
					.om-wpb .vc_general.vc_btn3,
					.om-wpb .vc_cta-button,
					.vc_om-click-box .om-cb-title,
					.read-more-link,
					.navigation-prev-next,
					.navigation-pages,
					input[type=button],
					input[type=submit],
					input[type=reset],
					.cart_form .add_to_cart,
					.tc_in_cart a,
					.rev_slider .rev-btn,
					{font-family:'.$font_f;
				if($weight_normal != 400) {
					echo ';font-weight:'.$weight_normal;
				}
				echo '}';
				
				if($weight_bold != 700) {
					echo '
						.om-wpb .vc_general.vc_btn3.vc_btn3-style-classic,
						.om-wpb .vc_cta-button,
						.vc_om-click-box .om-cb-title,
						input[type=button],
						input[type=submit],
						input[type=reset],
						.cart_form .add_to_cart,
						.tc_in_cart a,
						{font-weight:'.$weight_bold.'}';
				}				

			}
		}

		// Testimonials font
		
		$font=get_option('eventerra_testimonials_font');

		if(isset($font['type'])) {
			$font_f=$font[$font['type']]['family'];				
		
			$weight_normal=400;
			if($font['type'] == 'google') {
				if(isset($font['google']['weight_normal']))
					$weight_normal=$font['google']['weight_normal'];
			}
			
			if($font_f) {
				echo '
					.vc_om-testimonials .om-item-text,
					blockquote
					{font-family:'.$font_f;
				if($weight_normal != 400) {
					echo ';font-weight:'.$weight_normal;
				}
				echo '}';
				
			}
		}		
		
		/* Font scale */
		
		$font_scale=intval(get_option('eventerra_font_scale'));
		if(!$font_scale)
			$font_scale=100;
		if($font_scale != 100) {
			$font_scale/=100;
			
			echo 'body{font-size:'.round(14*$font_scale).'px}';
		}
		
		$line_height=floatval(get_option('eventerra_line_height'));
		if($line_height) {
			echo '
				body,
				.om-wpb .vc_custom_heading-additional,
				.om-wpb .vc_call_to_action h4.wpb_heading
				{line-height:'.$line_height.'}
			';

			echo '
				h1,h2,h3,h4,h5,h6,
				.wpb_heading,
				.ompf-portfolio-thumb .ompf-title,
				.blog-posts .post-date,
				.eventerra_widget_contacts .w-contacts-line,
				.sidebar-widget-title,
				{line-height:'.($line_height*0.85).'}
			';

			echo '
				.om-wpb .vc_toggle_icon {top:'.(($line_height-1.6)/2).'em}
				.om-wpb .wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header a:before {top:'.($line_height*0.5).'em}
				.om-wpb .wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header a:after {top:'.($line_height*0.5 - 0.5).'em}
			';
						
			
		}
			
		/**
		 * Overall Background
		 */
		
		$bg_mode=get_option('eventerra_background_mode');
		if($bg_mode == 'custom') {
		
			$bg_color=get_option('eventerra_background_color');
			$bg_img=get_option('eventerra_background_img');
			$bg_pos=get_option('eventerra_background_pos');
			$attach=get_option('eventerra_background_attach');
		
			$style=array();
		
			if($bg_color) {
				$style[]='background-color:'.$bg_color;
			}
		
			if($bg_img) {
				$style[]='background-image:url('.$bg_img.')';
	
				$style=array_merge($style,eventerra_bg_img_pos_style($bg_pos));
				
				if($attach == 'fixed') {
					$style[]='background-attachment:fixed';
				} elseif($attach == 'scroll') {
					$style[]='background-attachment:scroll';
				}
			}
				
			if(!empty($style))
				$style=implode(';',$style);
			else
				$style='';
			
			echo 'body{'.$style.'}';
			
	
			$overlay=get_option('eventerra_background_overlay');
			$overlay_color=get_option('eventerra_background_overlay_color');
			$overlay_color2=get_option('eventerra_background_overlay_color2');
			
			$style=array();
	
			if($overlay == 'color') {
				$style[]='background-color:'.$overlay_color;
			} elseif($overlay == 'gradient') {
				$style[]=omfw_Framework::gradient_css($overlay_color, $overlay_color2, 'horisontal');
			}
	
			if(!empty($style))
				$style=implode(';',$style);
			else
				$style='';
				
			echo '.body-inner{'.$style.'}';
			
		}

		/**
		 * Header
		 */
		 
		$color1=get_option('eventerra_logo_color_1');
		$color2=get_option('eventerra_logo_color_2');
		$color3=get_option('eventerra_logo_color_3');

		echo '.logo-color-1{color:'.$color1.'}';
		echo '.logo-color-2{color:'.$color2.'}';
		echo '.logo-color-3{color:'.$color3.'}';
		
		$color=get_option('eventerra_header_text_color');
		echo '.header{color:'.$color.'}';

		$rgb=omfw_Color::hex2rgb($color);
		
		echo '
		.header-wpml-selector #lang_sel a.lang_sel_sel,
		.header-wpml-selector #lang_sel_click a.lang_sel_sel
		{border-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.3)}';
		
		echo '
		.countdown-box,
		.countdown-box .box-bg
		{border-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.35)}';

		echo '
		.header-wpml-selector #lang_sel li ul a,
		.header-wpml-selector #lang_sel_click li ul a
		{background:'.$color.' !important;color:rgb('.(255-$rgb[0]).','.(255-$rgb[1]).','.(255-$rgb[2]).') !important}';
		
		/**
		 * Menu
		 */

		$menu_color=get_option('eventerra_menu_items_color');
		$menu_color_hover=get_option('eventerra_menu_items_color_hover');
		$submenu_color=get_option('eventerra_menu_sub_items_color');
		$submenu_color_hover=get_option('eventerra_menu_sub_items_color_hover');
		$submenu_bg_color=get_option('eventerra_menu_sub_items_bg_color');

		echo '
		.primary-menu a,
		.header-menu-mobile-control,
		.primary-mobile-menu-container a
		{color:'.$menu_color.'}';

		$rgb=omfw_Color::hex2rgb($menu_color);

		echo '
		.header-menu-mobile-control,
		.primary-mobile-menu-container
		{background-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',.2)}';
		
		echo '
		.header-menu-mobile-control:hover
		{background-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',.3)}';			
		
		echo '
		.primary-menu > li > a:hover,
		.primary-menu-highlight-active .primary-menu > li.current-menu-item > a
		{color:'.$menu_color_hover.'}';

		echo '
		.primary-menu > li > a:before
		{background:'.$menu_color_hover.'}';

		echo '
		.primary-menu ul a,
		.secondary-menu a
		{color:'.$submenu_color.'}';

		echo '
		.primary-menu ul a[href]:hover,
		.primary-menu ul li.omHover > a,
		.primary-menu-highlight-active .primary-menu ul li.current-menu-item > a,
		.secondary-menu a:hover
		{color:'.$submenu_color_hover.'}';
		
		echo '
		.primary-menu ul,
		.secondary-menu
		{background-color:'.$submenu_bg_color.'}';
		
		$rgb=omfw_Color::hex2rgb($submenu_color);
		echo '
		.primary-menu .sub-menu li:after,
		.primary-menu > li.megamenu-enable > .sub-menu > ul > li,
		.secondary-menu li:after
		{border-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',.07)}';
		
		/**
		 * Common
		 */
		  
		$accent_color1=get_option('eventerra_accent_color1');
		$accent_color2=get_option('eventerra_accent_color2');
		$accent_color3=get_option('eventerra_accent_color3');

		$rgb1=omfw_Color::hex2rgb($accent_color1);
		$rgb2=omfw_Color::hex2rgb($accent_color2);
		$rgb3=omfw_Color::hex2rgb($accent_color3);

		echo '
			.background-color-accent-1,
			.om-bg-om-accent-color-1,
			.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-om-accent-color-1.vc_icon_element-background,
			.vc_message_box.vc_message_box-solid.vc_color-om-accent-color-1,
			.om-wpb .vc_toggle.vc_toggle_color_om-accent-color-1 .vc_toggle_icon,
			.hover-image-extra .link-zoom,
			.hover-image-extra .link-url,
			.custom-gallery .control-prev .prev:before,
			.custom-gallery .control-next .next:before,
			.om-wpb .vc_images_carousel .vc_carousel-control .icon-prev,
			.om-wpb .vc_images_carousel .vc_carousel-control .icon-next,
			.om-wpb .vc_carousel .vc_carousel-control .icon-prev,
			.om-wpb .vc_carousel .vc_carousel-control .icon-next,
			.om-wpb .vc_images_carousel .vc_carousel-indicators li.vc_active,
			.om-wpb .vc_carousel .vc_carousel-indicators li.vc_active,
			.om-wpb .vc_tta-tabs .vc_tta-tabs-container,
			.om-wpb .vc_tta.vc_tta-tabs .vc_tta-panels .vc_tta-panel-heading,
			.om-wpb .vc_tta.vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading,
			.om-wpb .vc_tta.vc_tta-accordion.vc_general .vc_tta-panel .vc_tta-panel-heading,
			.om-wpb .vc_tta .vc_general.vc_pagination .vc_pagination-trigger,
			.om-wpb .vc_btn3.vc_btn3-style-classic.vc_btn3-color-om-accent-color-1,
			.om-wpb .vc_btn3.vc_btn3-style-flat.vc_btn3-color-om-accent-color-1 .vc_btn3-icon,
			.om-wpb .vc_cta-button.vc_cta_button-color-om-accent-color-1,
			.vc_progress_bar.vc_progress-bar-color-om-accent-color-1 .vc_single_bar .vc_bar,
			.vc_om-testimonials-controls .om-prev,
			.vc_om-testimonials-controls .om-next,
			.vc_om-logos-controls .om-prev,
			.vc_om-logos-controls .om-next,
			.vc_om-click-icon-box.om-cib-color-om-accent-color-1 .om-cib-icon,
			.read-more-icon,
			.custom-gallery .control-progress .progress,
			.navigation-prev a:before,
			.navigation-next a:after,
			.navigation-pages-inner > a,
			input[type=button],
			input[type=submit],
			input[type=reset],
			.om-speakers-contact-icon.om-envelope,
			.om-agenda-day.om-color-om-accent-color-1 .om-agenda-day-header,
			.om-agenda-day.om-color-om-accent-color-1 .om-agenda-item-speaker-photo-popup,
			.cart_form .add_to_cart,
			.om_theme .tc_in_cart a,
			.om-speaker-single-sidebar .om-item a:before,
			{background-color:'.$accent_color1.'}';
			
		echo '
			.background-color-accent-2,
			.om-bg-om-accent-color-2,
			.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-om-accent-color-2.vc_icon_element-background,
			.vc_message_box.vc_message_box-solid.vc_color-om-accent-color-2,
			.om-wpb .vc_toggle.vc_toggle_color_om-accent-color-2 .vc_toggle_icon,
			.om-wpb .vc_tta-tabs.vc_tta-color-om-accent-color-2 .vc_tta-tabs-container,
			.om-wpb .vc_tta.vc_tta-tabs.vc_tta-color-om-accent-color-2 .vc_tta-panels .vc_tta-panel-heading,
			.om-wpb .vc_tta.vc_tta-accordion.vc_tta-color-om-accent-color-2 .vc_tta-panel .vc_tta-panel-heading,
			.om-wpb .vc_tta.vc_tta-color-om-accent-color-2 .vc_general.vc_pagination .vc_pagination-trigger,
			.om-wpb .vc_btn3.vc_btn3-style-classic.vc_btn3-color-om-accent-color-2,
			.om-wpb .vc_btn3.vc_btn3-style-flat.vc_btn3-color-om-accent-color-2 .vc_btn3-icon,
			.om-wpb .vc_cta-button.vc_cta_button-color-om-accent-color-2,
			.vc_progress_bar.vc_progress-bar-color-om-accent-color-2 .vc_single_bar .vc_bar,
			.vc_om-click-icon-box.om-cib-color-om-accent-color-2 .om-cib-icon,
			.om-agenda-day.om-color-om-accent-color-2 .om-agenda-day-header,
			.om-agenda-day.om-color-om-accent-color-2 .om-agenda-item-speaker-photo-popup,
			.event_tickets.tickera th,
			.vc_cta-button-wrapper.om-btn-color-om-accent-color-2 .cart_form .add_to_cart,
			.om_theme .vc_cta-button-wrapper.om-btn-color-om-accent-color-2 .tc_in_cart a,
			.om_theme .tickera_table th,
			{background-color:'.$accent_color2.'}';

		echo '
			.background-color-accent-3,
			.om-bg-om-accent-color-3,
			.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-om-accent-color-3.vc_icon_element-background,
			.vc_message_box.vc_message_box-solid.vc_color-om-accent-color-3,
			.om-wpb .vc_toggle.vc_toggle_color_om-accent-color-3 .vc_toggle_icon,
			.om-wpb .vc_tta-tabs.vc_tta-color-om-accent-color-3 .vc_tta-tabs-container,
			.om-wpb .vc_tta.vc_tta-tabs.vc_tta-color-om-accent-color-3 .vc_tta-panels .vc_tta-panel-heading,
			.om-wpb .vc_tta.vc_tta-accordion.vc_tta-color-om-accent-color-3 .vc_tta-panel .vc_tta-panel-heading,
			.om-wpb .vc_tta.vc_tta-color-om-accent-color-3 .vc_general.vc_pagination .vc_pagination-trigger,
			.om-wpb .vc_btn3.vc_btn3-style-classic.vc_btn3-color-om-accent-color-3,
			.om-wpb .vc_btn3.vc_btn3-style-flat.vc_btn3-color-om-accent-color-3 .vc_btn3-icon,
			.om-wpb .vc_cta-button.vc_cta_button-color-om-accent-color-3,
			.vc_progress_bar.vc_progress-bar-color-om-accent-color-3 .vc_single_bar .vc_bar,
			.vc_om-click-icon-box.om-cib-color-om-accent-color-3 .om-cib-icon,
			.om-agenda-day.om-color-om-accent-color-3 .om-agenda-day-header,
			.om-agenda-day.om-color-om-accent-color-3 .om-agenda-item-speaker-photo-popup,
			.vc_cta-button-wrapper.om-btn-color-om-accent-color-3 .cart_form .add_to_cart,
			.om_theme .vc_cta-button-wrapper.om-btn-color-om-accent-color-3 .tc_in_cart a,
			{background-color:'.$accent_color3.'}';

		echo '
			.om-wpb .vc_toggle.vc_toggle_color_om-accent-color-1 .vc_toggle_content,
			.hover-image-extra .over,
			.om-wpb .vc_tta.vc_tta-tabs .vc_tta-panels,
			.om-wpb .vc_tta.vc_tta-tabs.vc_general .vc_tta-panels,
			.om-wpb .vc_tta.vc_tta-accordion .vc_tta-panel .vc_tta-panel-body,
			{background-color:rgba('.$rgb1[0].','.$rgb1[1].','.$rgb1[2].',.1)}';
			
		echo '
			.om-wpb .vc_toggle.vc_toggle_color_om-accent-color-2 .vc_toggle_content,
			.om-wpb .vc_tta.vc_tta-tabs.vc_tta-color-om-accent-color-2 .vc_tta-panels,
			.om-wpb .vc_tta.vc_tta-accordion.vc_tta-color-om-accent-color-2 .vc_tta-panel .vc_tta-panel-body,
			{background-color:rgba('.$rgb2[0].','.$rgb2[1].','.$rgb2[2].',.1)}';

		echo '
			.om-wpb .vc_toggle.vc_toggle_color_om-accent-color-3 .vc_toggle_content,
			.om-wpb .vc_tta.vc_tta-tabs.vc_tta-color-om-accent-color-3 .vc_tta-panels,
			.om-wpb .vc_tta.vc_tta-accordion.vc_tta-color-om-accent-color-3 .vc_tta-panel .vc_tta-panel-body,
			{background-color:rgba('.$rgb3[0].','.$rgb3[1].','.$rgb3[2].',.1)}';

		echo '
			.om-agenda-day.om-color-om-accent-color-1 .om-agenda-item:nth-child(odd),
			{background-color:rgba('.$rgb1[0].','.$rgb1[1].','.$rgb1[2].',.08)}';
			
		echo '
			.om-agenda-day.om-color-om-accent-color-2 .om-agenda-item:nth-child(odd),
			.event_tickets.tickera tr:nth-child(odd) td,
			.om_theme .tickera-checkout tbody tr:nth-child(odd) td,
			{background-color:rgba('.$rgb2[0].','.$rgb2[1].','.$rgb2[2].',.08)}';

		echo '
			.om-agenda-day.om-color-om-accent-color-3 .om-agenda-item:nth-child(odd),
			{background-color:rgba('.$rgb3[0].','.$rgb3[1].','.$rgb3[2].',.08)}';
			
		echo '
			.om-agenda-day.om-color-om-accent-color-1 .om-agenda-item:nth-child(even),
			{background-color:rgba('.$rgb1[0].','.$rgb1[1].','.$rgb1[2].',.12)}';
			
		echo '
			.om-agenda-day.om-color-om-accent-color-2 .om-agenda-item:nth-child(even),
			.event_tickets.tickera tr:nth-child(even) td,
			.om_theme .tickera-checkout tbody tr:nth-child(even) td,
			{background-color:rgba('.$rgb2[0].','.$rgb2[1].','.$rgb2[2].',.12)}';

		echo '
			.om-agenda-day.om-color-om-accent-color-3 .om-agenda-item:nth-child(even),
			{background-color:rgba('.$rgb3[0].','.$rgb3[1].','.$rgb3[2].',.12)}';
			
		echo '
			.om-agenda-day.om-color-om-accent-color-1 .om-agenda-item:nth-child(odd):hover,
			{background-color:rgba('.$rgb1[0].','.$rgb1[1].','.$rgb1[2].',.06)}';
			
		echo '
			.om-agenda-day.om-color-om-accent-color-2 .om-agenda-item:nth-child(odd):hover,
			{background-color:rgba('.$rgb2[0].','.$rgb2[1].','.$rgb2[2].',.06)}';

		echo '
			.om-agenda-day.om-color-om-accent-color-3 .om-agenda-item:nth-child(odd):hover,
			{background-color:rgba('.$rgb3[0].','.$rgb3[1].','.$rgb3[2].',.06)}';
			
		echo '
			.om-agenda-day.om-color-om-accent-color-1 .om-agenda-item:nth-child(even):hover,
			{background-color:rgba('.$rgb1[0].','.$rgb1[1].','.$rgb1[2].',.1)}';
			
		echo '
			.om-agenda-day.om-color-om-accent-color-2 .om-agenda-item:nth-child(even):hover,
			{background-color:rgba('.$rgb2[0].','.$rgb2[1].','.$rgb2[2].',.1)}';

		echo '
			.om-agenda-day.om-color-om-accent-color-3 .om-agenda-item:nth-child(even):hover,
			{background-color:rgba('.$rgb3[0].','.$rgb3[1].','.$rgb3[2].',.1)}';

		echo '
			a,
			.text-color-accent-1,
			.vc_separator.vc_sep_color_om-accent-color-1 .vc_icon_element-inner,
			.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-om-accent-color-1 .vc_icon_element-icon,
			.vc_separator.vc_sep_color_om-accent-color-1 h4,
			.vc_separator.vc_sep_color_om-accent-color-1.vc_sep_shadow .vc_sep_holder,
			.vc_message_box.vc_message_box-outline.vc_color-om-accent-color-1 .vc_message_box-icon,
			.post-title a:hover,
			.navigation-pages-inner > span.current,
			.blog-posts .blog-post.sticky .post-title h2:before,
			.vc_om-list.vc_om-color-om-accent-color-1 .om-list-icon,
			.om-agenda-day.om-color-om-accent-color-1 .om-agenda-item-icon,
			.om-agenda-day.om-color-om-accent-color-1 .om-agenda-item-room-inner:before,
			.om-agenda-day.om-color-om-accent-color-1 .om-agenda-item-speakers-inner:before,
			.om-agenda-day.om-color-om-accent-color-1 .om-agenda-item-speakers a,
			.om_theme .tc_event_date_title_front i,
			.om_theme .tc_event_location_title_front i,
			.om_theme .coupon-code-message,
			.om_theme .ticket-quantity .tickera_button:hover,
			.sidebar-widget.widget_nav_menu .menu li a:hover,
			.footer-menu a:hover,
			.footer-widgets a:hover,
			{color:'.$accent_color1.'}';
			
		echo '
			.text-color-accent-2,
			.vc_separator.vc_sep_color_om-accent-color-2 .vc_icon_element-inner,
			.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-om-accent-color-2 .vc_icon_element-icon,
			.vc_separator.vc_sep_color_om-accent-color-2 h4,
			.vc_separator.vc_sep_color_om-accent-color-2.vc_sep_shadow .vc_sep_holder,
			.vc_message_box.vc_message_box-outline.vc_color-om-accent-color-2 .vc_message_box-icon,
			.vc_om-list.vc_om-color-om-accent-color-2 .om-list-icon,
			.om-agenda-day.om-color-om-accent-color-2 .om-agenda-item-icon,
			.om-agenda-day.om-color-om-accent-color-2 .om-agenda-item-room-inner:before,
			.om-agenda-day.om-color-om-accent-color-2 .om-agenda-item-speakers-inner:before,
			.om-agenda-day.om-color-om-accent-color-2 .om-agenda-item-speakers a,
			{color:'.$accent_color2.'}';

		echo '
			.text-color-accent-3,
			.vc_separator.vc_sep_color_om-accent-color-3 .vc_icon_element-inner,
			.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-om-accent-color-3 .vc_icon_element-icon,
			.vc_separator.vc_sep_color_om-accent-color-3 h4,
			.vc_separator.vc_sep_color_om-accent-color-3.vc_sep_shadow .vc_sep_holder,
			.vc_message_box.vc_message_box-outline.vc_color-om-accent-color-3 .vc_message_box-icon,
			.vc_om-list.vc_om-color-om-accent-color-3 .om-list-icon,
			.om-agenda-day.om-color-om-accent-color-3 .om-agenda-item-icon,
			.om-agenda-day.om-color-om-accent-color-3 .om-agenda-item-room-inner:before,
			.om-agenda-day.om-color-om-accent-color-3 .om-agenda-item-speakers-inner:before,
			.om-agenda-day.om-color-om-accent-color-3 .om-agenda-item-speakers a,
			{color:'.$accent_color3.'}';

		echo '
			.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-om-accent-color-1.vc_icon_element-outline,
			.vc_separator.vc_sep_color_om-accent-color-1 .vc_sep_holder .vc_sep_line,
			.vc_message_box.vc_message_box-outline.vc_color-om-accent-color-1,
			.om-wpb .vc_tta-tabs.vc_tta-has-pagination .vc_tta-panels-container,
			.om-wpb .vc_btn3.vc_btn3-style-flat.vc_btn3-color-om-accent-color-1 .vc_btn3-icon-effect,
			.vc_om-testimonials-controls .om-prev:after,
			.vc_om-testimonials-controls .om-next:after,
			.vc_om-logos-controls .om-prev:after,
			.vc_om-logos-controls .om-next:after,
			.read-more-icon:after,
			.navigation-prev a:after,
			.navigation-next a:before,
			.navigation-pages-inner > a:after,
			input[type=text]:focus,
			input[type=email]:focus,
			input[type=tel]:focus,
			input[type=password]:focus,
			input[type=file]:focus,
			textarea:focus,
			input[type=number]:focus,
			.om-agenda-day.om-color-om-accent-color-1 .om-agenda-item.om-featured,
			.om_theme .ticket-quantity .quantity:focus,
			{border-color:'.$accent_color1.'}';

		echo '
			.om-back-to-top:before
			{border-right-color:'.$accent_color1.';border-bottom-color:'.$accent_color1.'}';
		echo '
			body.rtl .om-back-to-top:before
			{border-left-color:'.$accent_color1.';border-bottom-color:'.$accent_color1.'}';

		echo '
			.widget_tag_cloud .tagcloud a
			{border-color:rgba('.$rgb1[0].','.$rgb1[1].','.$rgb1[2].',.5)}';
						
		echo '
			.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-om-accent-color-2.vc_icon_element-outline,
			.vc_separator.vc_sep_color_om-accent-color-2 .vc_sep_holder .vc_sep_line,
			.vc_message_box.vc_message_box-outline.vc_color-om-accent-color-2,
			.om-wpb .vc_tta-tabs.vc_tta-has-pagination.vc_tta-color-om-accent-color-2 .vc_tta-panels-container,
			.om-wpb .vc_btn3.vc_btn3-style-flat.vc_btn3-color-om-accent-color-2 .vc_btn3-icon-effect,
			.om-agenda-day.om-color-om-accent-color-2 .om-agenda-item.om-featured,
			.om_theme .tickera_additional_info,
			{border-color:'.$accent_color2.'}';

		echo '
			.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-om-accent-color-3.vc_icon_element-outline,
			.vc_separator.vc_sep_color_om-accent-color-3 .vc_sep_holder .vc_sep_line,
			.vc_message_box.vc_message_box-outline.vc_color-om-accent-color-3,
			.om-wpb .vc_tta-tabs.vc_tta-has-pagination.vc_tta-color-om-accent-color-3 .vc_tta-panels-container,
			.om-wpb .vc_btn3.vc_btn3-style-flat.vc_btn3-color-om-accent-color-3 .vc_btn3-icon-effect,
			.om-agenda-day.om-color-om-accent-color-3 .om-agenda-item.om-featured,
			{border-color:'.$accent_color3.'}';


		echo '
			.om-agenda-day.om-color-om-accent-color-1 .om-agenda-item-speaker-photo-popup:after
			{border-top-color:'.$accent_color1.'}';
			
		echo '
			.om-agenda-day.om-color-om-accent-color-2 .om-agenda-item-speaker-photo-popup:after
			{border-top-color:'.$accent_color2.'}';
			
		echo '
			.om-agenda-day.om-color-om-accent-color-3 .om-agenda-item-speaker-photo-popup:after
			{border-top-color:'.$accent_color3.'}';

		echo '
			input[type=button]:hover,
			input[type=submit]:hover,
			input[type=reset]:hover,
			.om_theme .tc_in_cart a:hover,
			{background-color:'.omfw_Color::brightness(omfw_Color::lightness($accent_color1, .04), .03).'}';
			
		echo '
			.button-a-bg.color-accent-1:before,
			.om-wpb .vc_btn3.vc_btn3-style-classic.vc_btn3-color-om-accent-color-1:before,
			.vc_om-click-box.om-bg-om-accent-color-1:before,
			.vc_om-click-icon-box.om-cib-color-om-accent-color-1 .om-cib-icon:before,
			.cart_form .add_to_cart:before,
			{background-image: url(\''.omfw_Framework::svg_url_data('<svg xmlns="http://www.w3.org/2000/svg" width="1000" height="1000"><polygon fill="'.omfw_Color::brightness(omfw_Color::lightness($accent_color1, .04), .02).'" points="0,1000 1000,0, 1000,1000"/></svg>').'\');}';

		echo '
			.button-a-bg.color-accent-2:before,
			.om-wpb .vc_btn3.vc_btn3-style-classic.vc_btn3-color-om-accent-color-2:before,
			.vc_om-click-box.om-bg-om-accent-color-2:before,
			.vc_om-click-icon-box.om-cib-color-om-accent-color-2 .om-cib-icon:before,
			.vc_cta-button-wrapper.om-btn-color-om-accent-color-2 .cart_form .add_to_cart:before,
			{background-image: url(\''.omfw_Framework::svg_url_data('<svg xmlns="http://www.w3.org/2000/svg" width="1000" height="1000"><polygon fill="'.omfw_Color::brightness(omfw_Color::lightness($accent_color2, .04), .02).'" points="0,1000 1000,0, 1000,1000"/></svg>').'\');}';

		echo '
			.button-a-bg.color-accent-3:before,
			.om-wpb .vc_btn3.vc_btn3-style-classic.vc_btn3-color-om-accent-color-3:before,
			.vc_om-click-box.om-bg-om-accent-color-3:before,
			.vc_om-click-icon-box.om-cib-color-om-accent-color-3 .om-cib-icon:before,
			.vc_cta-button-wrapper.om-btn-color-om-accent-color-3 .cart_form .add_to_cart:before,
			{background-image: url(\''.omfw_Framework::svg_url_data('<svg xmlns="http://www.w3.org/2000/svg" width="1000" height="1000"><polygon fill="'.omfw_Color::brightness(omfw_Color::lightness($accent_color3, .04), .02).'" points="0,1000 1000,0, 1000,1000"/></svg>').'\');}';

		echo '
			.om-loading-circle
			{background-image: url(\''.omfw_Framework::svg_url_data('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48" height="48">
<circle class="path" cx="24" cy="24" r="21" fill="none" stroke="'.$accent_color1.'" stroke-width="2">
	<animate attributeName="stroke-dasharray" attributeType="XML" from="1,200" to="89,200" values="1,200; 89,200; 89,200" keyTimes="0; 0.5; 1" dur="1.5s" repeatCount="indefinite" /> 
  <animate attributeName="stroke-dashoffset" attributeType="XML" from="0" to="-124" values="0; -35; -124" keyTimes="0; 0.5; 1" dur="1.5s" repeatCount="indefinite" />
  <animateTransform attributeName="transform" attributeType="XML" type="rotate" from="0 24 24" to="360 24 24" dur="3s" repeatCount="indefinite"/>
</circle>
</svg>').'\');}';

		/**
		 * Content
		 */

		$bg_color=get_option('eventerra_background_main_content_color');
		echo '
		.content,
		.om-closing,
		.om-loading-circle,
		{background-color:'.$bg_color.'}';

		echo '
		.event_tickets.tickera td,
		.om_theme .tickera-checkout tbody tr td,
		{border-color:'.$bg_color.'}';		

		$rgb=omfw_Color::hex2rgb($bg_color);
		
		echo '
		.blog-posts.layout-small.sublayout-cut .blog-post.has-thumbnail .post-body-wrapper .post-body:after,
		.vc_om-speakers.vc_om-layout-grid.vc_om-description-next .om-speakers-body-npe:after,
		{background: -moz-linear-gradient(top,  rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0) 0%, rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',1) 100%);
			background: -webkit-linear-gradient(top,  rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0) 0%,rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',1) 100%);
			background: linear-gradient(to bottom,  rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0) 0%,rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',1) 100%);
		}';

		$text_color=get_option('eventerra_main_text_color');
		echo '
		.content,
		.comment-meta .author,
		.sidebar-widget.widget_categories li:before,
		.sidebar-widget.widget_archive li:before,
		.sidebar-widget.widget_recent_comments li:before,
		.sidebar-widget.widget_recent_comments li .comment-author-link,
		{color:'.$text_color.'}';

		$side_text=get_option('eventerra_side_text_color');
		echo '
		.breadcrumbs,
		.breadcrumbs a,
		.breadcrumbs a:hover,
		.page-title-subtitle,
		.om-wpb .wpb_single_image .vc_figure-caption,
		.om-wpb .vc_custom_heading-additional,
		.vc_om-testimonials .om-item-author,
		.blog-posts .post-date,
		.post-meta,
		.comment-meta,
		.om-speakers-post,
		.om-agenda-item-time-room .om-agenda-item-room,
		.om_theme .tc_event_date_title_front,
		.om_theme .tc_event_location_title_front,
		.om_theme .ticket-quantity .tickera_button,
		.om_theme .tickera_additional_info .fields-wrap span,
		.sidebar-widget.widget_recent_entries .post-date,
		.sidebar-widget.widget_categories li,
		.sidebar-widget.widget_archive li,
		.sidebar-widget.widget_recent_comments li,
		.eventerra_widget_contacts .w-contacts-line:before,
		.eventerra_widget_tweets .tweet-time,
		.wpcf7 p.label,
		.search-results-note,
		.wpcf7 .note
		{color:'.$side_text.'}';

		echo '
		select
		{background-image: url(\''.omfw_Framework::svg_url_data('<svg xmlns="http://www.w3.org/2000/svg" width="17" height="5"><polygon fill="'.$side_text.'" points="0,0 9,0 5,5"/></svg>').'\');}';

		echo '
		.om-speakers-post:before
		{background-image: url(\''.omfw_Framework::svg_url_data('<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"><line x1="0" y1="10" x2="10" y2="0" style="stroke:'.$side_text.';stroke-width:1"/></svg>').'\');}';

		$rgb=omfw_Color::hex2rgb($text_color);
			
		echo '
		.page-title-wrapper,
		.blog-post,
		.comments-title,
		.comment-inner,
		.blog-posts.layout-shortcode .blog-post,
		.vc_om-speakers.vc_om-layout-grid .om-speakers-item,
		.vc_om-speakers.vc_om-layout-grid .om-speakers-items,
		.om_theme .tickera-payment-gateways,
		.sidebar-display .content-columns-wrapper:before,
		.sidebar-widget.widget_nav_menu .menu li a,
		.om-speaker-single-card,
		.search-results-list li,
		{border-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',.1)}';

		echo '
		.wpb_column.vc_column_delimiter-vline:after,
		{background-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',.1)}';
				
		echo '
		.blog-posts.layout-shortcode .blog-post,
		{box-shadow:inset 1px 1px 0 0 rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',.1)}';

		echo '
		.vc_om-speakers.vc_om-layout-grid.vc_om-description-next .om-speakers-items
		{box-shadow:inset 0 1px 0 0 rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',.1)}';
		
		echo '
		.vc_om-speakers.vc_om-layout-grid.vc_om-description-next .om-speakers-item,
		{box-shadow:inset 0 -1px 0 0 rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',.1)}';

		echo '
		.vc_om-table table td,
		.vc_om-table table th,
		.vc_om-testimonials.vc_om-mode-list .om-item,
		input[type=text],
		input[type=email],
		input[type=tel],
		input[type=password],
		input[type=file],
		textarea,
		input[type=number],
		select,
		.om_theme .tickera select,
		.om_theme .ticket-quantity .quantity,
		{border-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',.12)}';
		
		echo '
		.vc_om-table.vc_om-table-style-striped table tr:nth-child(even) td,
		.vc_om-table.vc_om-table-style-hover table tr:hover td,
		.comments-section .logged-in-as,
		.comments-section .must-log-in,
		.comments-section .nocomments,
		.cart_empty_message,
		.cart_form .price,
		.tc_in_cart,
		#wp-calendar thead th,
		#wp-calendar tbody td,
		{background-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',.07)}';

		echo '
		.comments-section .logged-in-as:after,
		.comments-section .must-log-in:after,
		.comments-section .nocomments:after,
		.cart_empty_message:after,
		{border-top-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',.07)}';

		/**
		 * Footer
		 */
	
		$bg_color=get_option('eventerra_background_footer_color');
		
		echo '
		.footer-widgets
		{background-color:'.$bg_color.'}';
		
		$color=get_option('eventerra_footer_main_text_color');
		
		echo '
		.footer-widgets,
		.footer-widgets a
		{color:'.$color.'}';

		$color=get_option('eventerra_footer_titles_color');

		echo '
		.footer-widget-title,
		{color:'.$color.'}';		

		$color=get_option('eventerra_footer_side_text_color');

		echo '
		.footer-widget.widget_recent_entries .post-date,
		.footer-widget.eventerra_widget_tweets .tweet-time a,
		{color:'.$color.'}';

		echo '
		.footer-widget.widget_recent_entries .post-date:before,
		.footer-widget.eventerra_widget_tweets .tweet-time:before,
		{background-image: url(\''.omfw_Framework::svg_url_data('<svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"><line x1="0" y1="9" x2="9" y2="0" style="stroke:'.$color.';stroke-width:1"/></svg>').'\');}';


		$color=get_option('eventerra_sub_footer_text_color');
		echo '
		.sub-footer
		{color:'.$color.'}';

		/*********/
		
		$out = ob_get_contents();
    ob_end_clean();

    return $out;
	}
	
}




if( !function_exists( 'eventerra_body_styling_classes' ) ) {
	
	function eventerra_body_styling_classes($classes) {
	
		omfw_Framework::body_add_class('om_theme');
		omfw_Framework::body_add_class('eventerra_theme');
		
		/*
		if( ( $layout = get_option('eventerra_overall_layout') ) ) {
			omfw_Framework::body_add_class('layout-'.$layout);
		} else {
			omfw_Framework::body_add_class('layout-wide');
		}
		*/
		
		if(get_option('eventerra_sidebar_position')=='left') {
			omfw_Framework::body_add_class('flip-sidebar');
		}
		
		omfw_Framework::body_add_class('om-animation-enabled');
		
		if(get_option('eventerra_no_animation_on_touch')=='true') {
			omfw_Framework::body_add_class('om-no-animation-on-touch');
		}

		if(get_option('eventerra_menu_highlight_active') == 'true') {
			omfw_Framework::body_add_class('primary-menu-highlight-active');
		}	
		
		if(get_option('eventerra_background_mode') == 'preset') {
			omfw_Framework::body_add_class('bg-'.get_option('eventerra_background_preset'));
			omfw_Framework::body_add_class('bg-overlay-enabled');
		} elseif(get_option('eventerra_background_overlay') == 'color' || get_option('eventerra_background_overlay') == 'gradient') {
			omfw_Framework::body_add_class('bg-overlay-enabled');
		}	

		if(get_option('eventerra_page_title_uppercase') == 'true') {
			omfw_Framework::body_add_class('page-titles-apply-uppercase');
		}		
			
	}
	add_action('get_header','eventerra_body_styling_classes');
	
}

if( !function_exists( 'eventerra_mobile_nav_bar_color' ) ) {

	function eventerra_mobile_nav_bar_color() {
		$color=false;
	
		if(get_option('eventerra_background_mode') == 'preset') {
			$preset=get_option('eventerra_background_preset');
			switch($preset) {
				case 'preset-1':
					$color='#094567';
				break;
			}
		} else {
			$color=get_option('eventerra_background_color');
		}

		if($color) {
			echo '<meta name="theme-color" content="'.esc_attr($color).'"><meta name="msapplication-navbutton-color" content="'.esc_attr($color).'"><meta name="apple-mobile-web-app-status-bar-style" content="'.esc_attr($color).'">';
		}
	}
	add_action('wp_head','eventerra_mobile_nav_bar_color');
	
}
