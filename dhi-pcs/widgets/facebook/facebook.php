<?php

function eventerra_widget_facebook_init() {
	register_widget( 'eventerra_widget_facebook' );
}
add_action( 'widgets_init', 'eventerra_widget_facebook_init' );

/* Widget Class */

class eventerra_widget_facebook extends WP_Widget {

	private $instance_defaults;
	
	function __construct() {
	
		parent::__construct(
			'eventerra_widget_facebook',
			'Eventerra: '.esc_html__('Facebook Like Box','eventerra'),
			array(
				'classname' => 'eventerra_widget_facebook',
				'description' => esc_html__('Widget that enables Facebook Page owners to attract and gain Likes from your own website.', 'eventerra')
			)
		);
		
		$this->instance_defaults = array(
			'title' => '',
			'url' => 'http://www.facebook.com/platform',
			'small_header' => 'false',
			'hide_cover' => 'false',
			'show_faces' => 'true',
			'show_stream' => 'true',
			'height' => '',
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
			
		$instance['height']=intval($instance['height']);
	
		$lang=get_locale();
		if(!$lang)
			$lang='en_US';

		?>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/<?php echo esc_js($lang)?>/sdk.js#xfbml=1&version=v2.4";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			<div class="fb-page" data-href="<?php echo esc_url($instance['url']) ?>" data-width="500" data-adapt-container-width="true" data-small-header="<?php echo ($instance['small_header']=='true'?'true':'false') ?>" data-hide-cover="<?php echo ($instance['hide_cover']=='true'?'true':'false') ?>" data-show-facepile="<?php echo ($instance['show_faces']=='true'?'true':'false') ?>" data-show-posts="<?php echo ($instance['show_stream']=='true'?'true':'false') ?>"<?php echo ($instance['height']?' data-height="'.esc_attr($instance['height']).'"':'') ?>><div class="fb-xfbml-parse-ignore"></div></div>
		<?php
	
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
	
		$instance['url'] = $new_instance['url'] ;
		$instance['hide_cover'] = $new_instance['hide_cover'];
		$instance['small_header'] = $new_instance['small_header'];
		$instance['show_faces'] = $new_instance['show_faces'];
		$instance['show_stream'] = $new_instance['show_stream'];
		$instance['height'] = $new_instance['height'];		
	
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
			
		<!-- Widget URL: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php esc_html_e('Facebook Page URL:', 'eventerra') ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" value="<?php echo esc_attr( $instance['url'] ); ?>" />
		</p>

		<!-- Use Small Header: Check Box -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'small_header' ) ); ?>"><?php esc_html_e('Use Small Header', 'eventerra') ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'small_header' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'small_header' ) ); ?>" value="true" <?php if( $instance['small_header'] == 'true') echo 'checked="checked"'; ?> />
		</p>
		
		<!-- Hide Cover: Check Box -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_cover' ) ); ?>"><?php esc_html_e('Hide Cover Photo', 'eventerra') ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'hide_cover' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_cover' ) ); ?>" value="true" <?php if( $instance['hide_cover'] == 'true') echo 'checked="checked"'; ?> />
		</p>
		
		<!-- Show Faces: Check Box -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_faces' ) ); ?>"><?php esc_html_e('Show Friend\'s Faces', 'eventerra') ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_faces' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_faces' ) ); ?>" value="true" <?php if( $instance['show_faces'] == 'true') echo 'checked="checked"'; ?> />
		</p>
	
		<!-- Stream: Check Box -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_stream' ) ); ?>"><?php esc_html_e('Show Page Posts', 'eventerra') ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_stream' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_stream' ) ); ?>" value="true" <?php if( $instance['show_stream'] == 'true') echo 'checked="checked"'; ?> />
		</p>

		<!-- Custom height: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php esc_html_e('Custom height (px):', 'eventerra') ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>" value="<?php echo esc_attr( $instance['height'] ); ?>" />
		</p>
		
		<?php
	}
}
?>