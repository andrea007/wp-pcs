<?php

function eventerra_widget_contacts_init() {
	register_widget( 'eventerra_widget_contacts' );
}
add_action( 'widgets_init', 'eventerra_widget_contacts_init' );

/* Widget Class */

class eventerra_widget_contacts extends WP_Widget {

	private $instance_defaults;
	
	function __construct() {
	
		parent::__construct(
			'eventerra_widget_contacts',
			'Eventerra: '.esc_html__('Contacts','eventerra'),
			array(
				'classname' => 'eventerra_widget_contacts',
				'description' => esc_html__('Widget to display contacts: address, phone, email.', 'eventerra')
			)
		);
		
		$this->instance_defaults = array(
			'title' => '',
			'address' => '',
			'phone' => '',
			'email' => '',
		);
		
	}

	/* Front-end display of widget. */
		
	function widget( $args, $instance ) {
		extract( $args );
		
		$instance = wp_parse_args( (array) $instance, $this->instance_defaults );
	
		$title = apply_filters('widget_title', $instance['title'] );
	
		echo wp_kses($before_widget, array(
			'div' => array(
				'id' => array(),
				'class' => array(),
			),
			'span' => array(
				'id' => array(),
				'class' => array(),
			),
		));
	
		if ( $title ) {
			echo wp_kses($before_title . $title . $after_title, array(
				'div' => array(
					'id' => array(),
					'class' => array(),
				),
				'span' => array(
					'id' => array(),
					'class' => array(),
				),
			));
		}
			
		if($instance['address'] != '') {
			echo '<div class="w-contacts-line w-contacts-address">'.wp_kses_post($instance['address']).'</div>';
		}
		if($instance['phone'] != '') {
			echo '<div class="w-contacts-line w-contacts-phone">'.esc_html($instance['phone']).'</div>';
		}
		if($instance['email'] != '') {
			echo '<div class="w-contacts-line w-contacts-email"><a href="'.esc_url('mailto:'.$instance['email']).'">'.esc_html($instance['email']).'</a></div>';
		}

		echo wp_kses($after_widget, array(
			'div' => array(
				'id' => array(),
				'class' => array(),
			),
			'span' => array(
				'id' => array(),
				'class' => array(),
			),
		));
	
	}


	/* Sanitize widget form values as they are saved. */
		
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
	
		$instance['address'] = $new_instance['address'] ;
		$instance['phone'] = $new_instance['phone'];
		$instance['email'] = $new_instance['email'];
	
		return $instance;
	}


	/* Back-end widget form. */
		 
	function form( $instance ) {
	
		$instance = wp_parse_args( (array) $instance, $this->instance_defaults );
		
		?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'eventerra') ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>	
			
		<!-- Widget Address: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>"><?php esc_html_e('Address:', 'eventerra') ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>" value="<?php echo esc_attr( $instance['address'] ); ?>" />
		</p>

		<!-- Widget Phone: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>"><?php esc_html_e('Phone:', 'eventerra') ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ); ?>" value="<?php echo esc_attr( $instance['phone'] ); ?>" />
		</p>

		<!-- Widget Phone: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php esc_html_e('Email:', 'eventerra') ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" value="<?php echo esc_attr( $instance['email'] ); ?>" />
		</p>		
		
		<?php
	}
}
?>