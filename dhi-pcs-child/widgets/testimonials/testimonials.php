<?php

function eventerra_widget_testimonials_init() {
	register_widget( 'eventerra_widget_testimonials' );
}
add_action( 'widgets_init', 'eventerra_widget_testimonials_init' );

/* Widget Class */

class eventerra_widget_testimonials extends WP_Widget {

	private $instance_defaults;
	
	function __construct() {
	
		parent::__construct(
			'eventerra_widget_testimonials',
			'Eventerra: '.esc_html__('Testimonials','eventerra'),
			array(
				'classname' => 'eventerra_widget_testimonials',
				'description' => esc_html__('Use this widget to display testimonials', 'eventerra')
			)
		);
		
		$this->instance_defaults = array(
			'title' => esc_html__('Testimonials','eventerra'),
			'category' => 0,
			'autorotate' => 0,
			'ids' => '',
		);
	}

	/* Front-end display of widget. */
		
	function widget( $args, $instance ) {
		extract( $args );
		
		$instance = wp_parse_args( (array) $instance, $this->instance_defaults );
		
		$title = apply_filters('widget_title', $instance['title'] );
		$instance['autorotate'] = intval($instance['autorotate']);
	
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
		
		echo do_shortcode('[om_testimonials mode="list" timeout="'.esc_attr($instance['autorotate']).'"'.($instance['category']?' category="'.esc_attr($instance['category']).'"':'').($instance['ids']?' ids="'.esc_attr($instance['ids']).'"':'').']');
		
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
		
		$instance['category'] = $new_instance['category'];
		
		$instance['autorotate'] = $new_instance['autorotate'];
		
		$instance['ids'] = $new_instance['ids'];
			
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
		
		<!-- Category: Select Box -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e('Testimonials category:', 'eventerra') ?></label>
			<?php
				$args = array(
					'show_option_all'    => esc_html__('All Categories', 'eventerra'),
					'hide_empty'         => 0, 
					'echo'               => 1,
					'selected'           => $instance['category'],
					'hierarchical'       => 0, 
					'name'               => $this->get_field_name( 'category' ),
					'id'         		     => $this->get_field_id( 'category' ),
					'class'              => '',
					'depth'              => 0,
					'tab_index'          => 0,
					'taxonomy'           => 'testimonials-type',
					'hide_if_empty'      => false 	
				);
		
				wp_dropdown_categories( $args );

			?>
		</p>
		
		<!-- IDs: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>"><?php esc_html_e('A list of testimonials ID separated with a comma to display certain testimonials.', 'eventerra') ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ids' ) ); ?>" value="<?php echo esc_attr( $instance['ids'] ); ?>" />
		</p>
		
		<!-- Autorotate: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'autorotate' ) ); ?>"><?php esc_html_e('Autorotate (interval in milliseconds. Leave empty to disable):', 'eventerra') ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'autorotate' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'autorotate' ) ); ?>" value="<?php echo esc_attr( $instance['autorotate'] ); ?>" />
		</p>
		
		<?php
	}
}
?>
