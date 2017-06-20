<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<?php if(get_option('eventerra_responsive') == 'true') : ?><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" /><?php endif; ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?><link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"><?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class() ?>>
	<div class="body-inner">
		<div class="container">
			<?php $logo_arr=eventerra_get_logo(); ?>
			<div class="header clearfix header-logo-type-<?php echo esc_attr($logo_arr['logo_type']) ?>">
				<div class="header-top clearfix">
					<?php if($logo_arr['logo_type'] != 'none') { ?>
					<div class="header-logo<?php echo ( ( $logo_arr['logo_type'] == 'text' && get_option( 'eventerra_logo_text_uppercase' ) == 'true' ) ? ' header-logo-uppercase' : '') ?>" style="<?php echo ( get_option( 'eventerra_logo_text_size' ) ? 'font-size:'.esc_attr(get_option( 'eventerra_logo_text_size' )).';' : '' ).( get_option( 'eventerra_logo_text_line_height' ) ? 'line-height:'.esc_attr(get_option( 'eventerra_logo_text_line_height' )).';' : '' ) ?>">
						<div class="header-logo-inner">
							<?php
								if($logo_arr['logo_type'] == 'image') {
									echo '<a href="' . esc_url( $logo_arr['href'] ) .'">'. $logo_arr['image_block'] .'</a>';
								} elseif($logo_arr['logo_type'] == 'text') {
									echo '<a href="' . esc_url( $logo_arr['href'] ) .'">'. $logo_arr['text_block'] .'</a>';
								}
							?>
						</div>
					</div>
					<?php } ?>
					<div class="header-info">
						<?php
							$location = get_option('eventerra_header_location');
							$wpml_selector = ( get_option( 'eventerra_show_wpml_language_selector' ) == 'true' && defined('ICL_SITEPRESS_VERSION') );
							$header_social_icons = (get_option('eventerra_social_icons_header') == 'true') ? eventerra_are_social_icons_set() : false;
						?>
						<?php if($location || $wpml_selector || $header_social_icons) { ?> 
						<div class="header-info-top">
							<?php if($location) { ?>
								<div class="header-location"><?php echo esc_html($location); ?></div>
							<?php } ?>
							<?php if($wpml_selector) { ?>
								<div class="header-wpml-selector"><?php do_action('icl_language_selector'); ?></div>
							<?php } ?>
							<?php if($header_social_icons) { ?>
								<div class="header-social-icons"><?php eventerra_the_social_icons(); ?></div>
							<?php } ?>
						</div>
						<?php } ?>
						<?php if(get_option('eventerra_countdown_date') != '') { ?>
						<div class="header-countdown-wrapper">
							<div class="header-countdown">
								<div id="header-countdown"<?php if(get_option('eventerra_countdown_hide_seconds') == 'true') echo ' data-hideseconds="true"' ?> data-days="<?php esc_attr_e('days','eventerra') ?>" data-hrs="<?php esc_attr_e('hrs','eventerra') ?>" data-min="<?php esc_attr_e('min','eventerra') ?>" data-sec="<?php esc_attr_e('sec','eventerra') ?>" data-label="<?php esc_attr_e('time left','eventerra') ?>" data-gmt="<?php echo esc_attr(get_option('eventerra_event_utc')) ?>"><?php echo esc_html(get_option('eventerra_countdown_date')) ?></div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php
					$extra_button = (get_option('eventerra_menu_extra_button') == 'true');
					if($extra_button) {
						$extra_button_title = get_option('eventerra_menu_extra_button_title');
						$extra_button_link = get_option('eventerra_menu_extra_button_link');
						if($extra_button_title == '' || $extra_button_link == '') {
							$extra_button=false;
						}
					}
					$extra_dropdown_button = (get_option('eventerra_menu_extra_dropdown_button') == 'true');
					if($extra_dropdown_button) {
						$extra_dropdown_button_title = get_option('eventerra_menu_extra_dropdown_button_title');
						if($extra_dropdown_button_title == '' || !has_nav_menu( 'secondary-menu' )) {
							$extra_dropdown_button=false;
						}
					}
					if($extra_button && $extra_dropdown_button) {
						$class='extra-buttons-two';
					} elseif($extra_button || $extra_dropdown_button) {
						$class='extra-buttons-one';
					} else {
						$class='extra-buttons-none';
					}
				?>
				<div class="header-menu clearfix <?php echo $class.(get_option('eventerra_menu_uppercase')=='true'?' apply-uppercase':'').(get_option('eventerra_menu_root_bold')=='true'?' root-items-bold':'') ?>">
					<div class="header-menu-mobile-control"></div>
					<?php if($extra_button || $extra_dropdown_button) { ?>
					<div class="header-buttons clearfix">
						<?php
							if($extra_button) {
								$extra_button_target = get_option('eventerra_menu_extra_button_target');
								$extra_button_color = get_option('eventerra_menu_extra_button_color');
								echo '<a href="'.esc_url($extra_button_link).'" class="header-extra-button button-a-bg background-color-'.esc_attr($extra_button_color).' color-'.esc_attr($extra_button_color).'"'.($extra_button_target == '_blank' ? ' target="_blank"' : '').'><span class="button-a-bg-inner">'.esc_html($extra_button_title).'</span></a>';
							}
							if($extra_dropdown_button) {
								$extra_dropdown_button_color = get_option('eventerra_menu_extra_dropdown_button_color');
								echo '<div class="header-extra-dropdown-button-wrapper">';
									echo '<div class="header-extra-dropdown-button button-a-bg background-color-'.esc_attr($extra_dropdown_button_color).' color-'.esc_attr($extra_dropdown_button_color).'"><span class="button-a-bg-inner">'.esc_html($extra_dropdown_button_title).'</span></div>';
									echo '<div class="header-extra-dropdown-menu-wrapper">';
									wp_nav_menu( array(
										'theme_location' => 'secondary-menu',
										'container' => false,
										'menu_class' => 'secondary-menu',
									) );
									echo '</div>';
								echo '</div>';
							}
						?>
					</div>
					<?php } ?>
					<div class="header-menu-primary">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'primary-menu',
								'container' => 'nav',
								'fallback_cb' => 'eventerra_primary_menu_fallback',
								'menu_class' => 'primary-menu sf-menu clearfix'
									.(get_option('eventerra_show_dropdown_symbol')=='true'?' show-dropdown-symbol':''),
								'walker' => new eventerra_Walker_Nav_Menu(),
							) );
						?>
					</div>
					<div class="header-mobile-menu-primary">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'primary-menu',
								'container' => 'nav',
								'container_class' => 'primary-mobile-menu-container',
								'fallback_cb' => 'eventerra_primary_mobile_menu_fallback',
								'menu_class' => 'primary-mobile-menu sf-menu clearfix'
									.(get_option('eventerra_show_dropdown_symbol')=='true'?' show-dropdown-symbol':''),
							) );
						?>
					</div>
				</div>
			</div>
			<div class="content-footer">