<?php

function eventerra_template_custom_gallery_settings() {
	?>
	<script type="text/html" id="tmpl-om-gallery-settings">
		<label class="setting">
			<span>Gallery Layout</span>
			<select class="layout" name="layout" data-setting="layout">
				<?php
					$options = array(
						'default' => esc_html__('WordPress Default','eventerra'),
						'slider' => esc_html__('Slider','eventerra'),
						'sliced' => esc_html__('Sliced','eventerra'),
						'masonry' => esc_html__('Masonry','eventerra'),
					);
					
					foreach ( $options as $v => $n ) {
						?><option value="<?php echo esc_attr( $v ); ?>"><?php echo esc_html( $n ); ?></option><?php
					}
				?>
			</select>
		</label>
		<label class="setting">
			<span>Images Ratio</span>
			<select class="ratio" name="ratio" data-setting="ratio">
				<?php
					$options = array(
						'2:1' => '2',
						'16:9' => '1.777778',
						'3:2' => '1.5',
						'4:3' => '1.333333',
						'1:1' => '1',
						'3:4' => '0.75',
						'2:3' => '0.666667',
						'9:16' => '0.5625',
						'1:2' => '0.5',
					);
					
					foreach ( $options as $v => $n ) {
						?><option value="<?php echo esc_attr( $v ); ?>"><?php echo esc_html( $v ); ?></option><?php
					}
				?>
			</select>
		</label>
		<label class="setting">
			<span>Captions</span>
			<select class="captions" name="captions" data-setting="captions">
				<?php
					$options = array(
						'yes' => esc_html__('Display','eventerra'),
						'no' => esc_html__('Hide','eventerra'),
					);
					
					foreach ( $options as $v => $n ) {
						?><option value="<?php echo esc_attr( $v ); ?>"><?php echo esc_html( $n ); ?></option><?php
					}
				?>
			</select>
		</label>
		<style>.collection-settings.gallery-settings label.setting.size {display:none}</style>
	</script>
	
  <?php
}
add_action( 'print_media_templates', 'eventerra_template_custom_gallery_settings' );


function eventerra_gallery_settings_scripts($hook) {
	if( 'post.php' != $hook && 'post-new.php' != $hook )
		return;
	global $post;
	if( !isset($post->post_type) || ( 'page' != $post->post_type && 'post' != $post->post_type ) )
		return;
		
	wp_enqueue_script('om-gallery-settings',EVENTERRA_TEMPLATE_DIR_URI.'/admin/js/om-gallery-settings.js', array( 'media-views' ), EVENTERRA_THEME_VERSION	);
}
add_action('admin_enqueue_scripts', 'eventerra_gallery_settings_scripts');


/**
 * Standard Gallery Shortcode
 */
 
function eventerra_custom_gallery_shortcode($output, $atts, $instance) {

	if((!isset($atts['layout']) || $atts['layout'] == 'default') && get_option('eventerra_do_not_replace_gallery') == 'true') {
		return $output;
	}

	if(!isset($atts['layout']) || $atts['layout'] == 'default') {
		$atts['layout']='grid';
	}
	 		
	if(!isset($atts['captions']))
		$atts['captions']='yes';
		
	if(!isset($atts['link']))
		$atts['link']='post';
	
	$args=array(
		'mode' => $atts['layout'],
		'show_captions' => ($atts['captions'] != 'no'),
		'link_to' => $atts['link'],
	);

	if(isset($atts['columns']))
		$args['columns'] = $atts['columns'];
		
	if(isset($atts['ratio']))
		$args['ratio'] = $atts['ratio'];
	
	$attachments=false;
	if(isset($atts['ids']) && $atts['ids']) {
		$attachments=explode(',',$atts['ids']);
	}
	if(empty($attachments)) {
		global $post;
		if(isset($post) && is_object($post))
			$attachments=$post->ID;
	} else {
		$attachments = get_posts(array(
			'post_type' => 'attachment',
			'orderby' => (isset($atts['orderby']) && $atts['orderby'] == 'rand') ? 'rand' : 'post__in',
			'post__in' => $attachments,
			'post_mime_type' => 'image',
			'post_status' => null,
			'numberposts' => -1
		));	
	}

	return '<div class="om-inline-gallery-wrapper">'.eventerra_get_custom_gallery($attachments, $args).'</div>';
		
}
add_filter( 'post_gallery', 'eventerra_custom_gallery_shortcode', 10, 3);
