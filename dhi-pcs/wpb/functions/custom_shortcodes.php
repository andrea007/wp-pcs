<?php

add_action( 'vc_before_init', 'eventerra_wpb_map_shortcodes' );

function eventerra_wpb_map_shortcodes() {

	
	/**
	 * Table
	 */
	
	vc_map( array(
		'name' => esc_html__( 'Data HTML Table', 'eventerra' ),
		'base' => 'om_html_table',
		'icon' => 'om-wpb-icon-html-table',
		'category' => esc_html__( 'Content', 'eventerra' ),
		'wrapper_class' => 'clearfix',
		'description' => esc_html__( 'Apply styling to data table', 'eventerra' ),
		'params' => array(
			array(
				'type' => 'textarea_raw_html',
				'holder' => 'div',
				'heading' => esc_html__( 'Table HTML', 'eventerra' ),
				'param_name' => 'content',
				'value' => omfw_Framework::str_encode( '<table>
  <tr>
    <th>Column 1 name</th>
    <th>Column 2 name</th>
    <th>Column 3 name</th>
  </tr>
  <tr>
    <td>Row 1, column 1 value</td>
    <td>Row 1, column 2 value</td>
    <td>Row 1, column 3 value</td>
  </tr>
  <tr>
    <td>Row 2, column 1 value</td>
    <td>Row 2, column 2 value</td>
    <td>Row 2, column 3 value</td>
  </tr>
</table>' ),
				'description' => sprintf(esc_html__( 'Enter your table HTML markup. More information about table HTML markup %s', 'eventerra' ), '<a href="http://www.w3schools.com/html/html_tables.asp" target="_blank">'.esc_html__('here','eventerra').'</a>'),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Style','eventerra'),
				'param_name' => 'style',
				'value' => array(
					esc_html__('Standard','eventerra') => 'standard',
					esc_html__('Bordered','eventerra') => 'bordered',
					esc_html__('Striped','eventerra') => 'striped',
					esc_html__('Stripe on hover','eventerra') => 'hover',
				),
			),
			
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Align','eventerra'),
				'param_name' => 'align',
				'value' => array(
					esc_html__('Left','eventerra') => 'left',
					esc_html__('Center','eventerra') => 'center',
					esc_html__('Right','eventerra') => 'right',
				),
			),
						
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Extra class name', 'eventerra'),
				'param_name' => 'el_class',
				'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'eventerra')
			),
		)
	));
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_om_html_table extends WPBakeryShortCode {
		}
	}
	
	/**
	 * Testimonials
	 */

	vc_map( array(
		'name' => esc_html__( 'Testimonials', 'eventerra' ),
		'base' => 'om_testimonials',
		'icon' => 'om-wpb-icon-testimonials',
		'category' => array(esc_html__( 'Content', 'eventerra' )),
		'description' => esc_html__( 'Testimonials block', 'eventerra' ),
		'params' => array(
			array(
				'type' => 'om_info',
				'heading' => '',
				'param_name' => 'info',
				'description' => sprintf( esc_html__('Testimonials are managed under "%s" section. This block just displays testimonials.','eventerra'), '<a href="'.esc_url(admin_url('edit.php?post_type=testimonials')).'" target="_blank">'.esc_html__('Testimonials','eventerra').'</a>'),
			),
			/*
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Widget title', 'eventerra' ),
				'param_name' => 'title',
				'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'eventerra' )
			),
			*/
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Filter testimonials','eventerra'),
				'param_name' => 'filter',
				'value' => array(
					esc_html__('Do not filter, display all','eventerra') => '',
					esc_html__('Choose certain testimonials','eventerra') => 'id',
					esc_html__('Filter by category','eventerra') => 'category',
				),
			),
			array(
				'type' => 'autocomplete',
				'heading' => esc_html__( 'Certain testimonials to display', 'eventerra' ),
				'param_name' => 'ids',
				'description' => esc_html__( 'Enter testimonial title to include it.', 'eventerra' ),
				'settings' => array(
					'multiple' => true,
					'sortable' => true,
					'unique_values' => true,
					'min_length' => 1,
				),
				'dependency' => array(
					'element' => 'filter',
					'value' => array('id'),
				),
			),
			array(
				'type' => 'autocomplete',
				'heading' => esc_html__( 'Filter testimonials by category', 'eventerra' ),
				'description' => esc_html__( 'Enter testimonial categories', 'eventerra' ),
				'param_name' => 'categories',
				'settings' => array(
					'multiple' => true,
					'min_length' => 1,
					'unique_values' => true,
					'display_inline' => true,
				),
				'dependency' => array(
					'element' => 'filter',
					'value' => array('category'),
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Layout mode','eventerra'),
				'param_name' => 'mode',
				'admin_label' => true,
				'value' => array(
					esc_html__('In one box with sliding','eventerra') => 'box',
					esc_html__('Full list','eventerra') => 'list',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Autorotate','eventerra'),
				'param_name' => 'timeout',
				'value' => '',
				'description' => esc_html__('Interval in milliseconds. Leave empty to disable autorotate','eventerra'),
				'dependency' => array(
					'element' => 'mode',
					'value' => array('box'),
				),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Pause autorotate on hover', 'eventerra' ),
				'param_name' => 'pause',
				'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
				'dependency' => array(
					'element' => 'timeout',
					'not_empty' => true,
				),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Randomize testimonials', 'eventerra' ),
				'param_name' => 'randomize',
				'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Display only one random item', 'eventerra' ),
				'param_name' => 'randomize_one',
				'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
				'dependency' => array(
					'element' => 'randomize',
					'not_empty' => true,
				),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Extra class name', 'eventerra'),
				'param_name' => 'el_class',
				'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'eventerra')
			),			
		),
	));
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_om_testimonials extends WPBakeryShortCode {

		}
	}
	
	// autocomplete
	add_filter( 'vc_autocomplete_om_testimonials_ids_callback', 'eventerra_wpb_search_testimonials', 10, 1 );
	add_filter( 'vc_autocomplete_om_testimonials_ids_render', 'vc_include_field_render', 10, 1 );
	function eventerra_wpb_search_testimonials( $search_string ) {
		$query = $search_string;
		$data = array();
		$args = array(
			's' => $query,
			'post_type' => 'testimonials',
		);
		$args['vc_search_by_title_only'] = true;
		$args['numberposts'] = - 1;
		if ( 0 === strlen( $args['s'] ) ) {
			unset( $args['s'] );
		}
		add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
		$posts = get_posts( $args );
		if ( is_array( $posts ) && ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$data[] = array(
					'value' => $post->ID,
					'label' => $post->post_title,
					'group' => $post->post_type,
				);
			}
		}
	
		return $data;
	}

	add_filter( 'vc_autocomplete_om_testimonials_categories_callback', 'eventerra_wpb_search_testimonials_categories', 10, 1 );
	add_filter( 'vc_autocomplete_om_testimonials_categories_render', 'eventerra_wpb_vc_testimonials_field_render', 10, 1 );
	function eventerra_wpb_search_testimonials_categories( $search_string ) {
		$data = array();
		$vc_taxonomies = get_terms( 'testimonials-type', array(
			'hide_empty' => false,
			'search' => $search_string,
		) );
		if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
			foreach ( $vc_taxonomies as $t ) {
				if ( is_object( $t ) ) {
					$data[] = vc_get_term_object( $t );
				}
			}
		}
	
		return $data;
	}
	function eventerra_wpb_vc_testimonials_field_render( $term ) {
		$args=array(
			'hide_empty' => false,
		);
		if(is_numeric($term['value'])) {
			$args['include']=array($term['value']);
		} else {
			$args['slug']=array($term['value']);
		}
		$terms = get_terms( 'testimonials-type', $args );
		$data = false;
		if ( is_array( $terms ) && 1 === count( $terms ) ) {
			$term = $terms[0];
			$data = vc_get_term_object( $term );
		}
			
		return $data;
	}
	
	/**
	 * Logos
	 */

	vc_map( array(
		'name' => esc_html__( 'Logos', 'eventerra' ),
		'base' => 'om_logos',
		'icon' => 'om-wpb-icon-logos',
		'category' => array(esc_html__( 'Content', 'eventerra' )),
		'description' => esc_html__( 'Align set of logotypes', 'eventerra' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Widget title', 'eventerra' ),
				'param_name' => 'title',
				'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'eventerra' )
			),
			array(
				'type' => 'attach_images',
				'heading' => esc_html__('Images','eventerra'),
				'description' => esc_html__( 'Choose image to display.', 'eventerra' ),
				'param_name' => 'images',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Image size', 'eventerra' ),
				'param_name' => 'img_size',
				'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'eventerra' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Layout','eventerra'),
				'param_name' => 'layout',
				'value' => array(
					esc_html__('Display all', 'eventerra') => 'full',
					esc_html__('Carousel', 'eventerra') => 'carousel',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('On click','eventerra'),
				'param_name' => 'onclick',
				'value' => array(
					esc_html__('Do nothing', 'eventerra') => 'no',
					esc_html__('Open custom link', 'eventerra') => 'custom_link',
					esc_html__('Open link, defined in the "Description" field of an image', 'eventerra') => 'description',
				),
			),
			array(
				'type' => 'exploded_textarea',
				'heading' => esc_html__( 'Custom links', 'eventerra' ),
				'param_name' => 'custom_links',
				'description' => esc_html__( 'Enter links for each image. Divide links with linebreaks (Enter) . ', 'eventerra' ),
				'dependency' => array(
					'element' => 'onclick',
					'value' => array( 'custom_link' )
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Link target', 'eventerra' ),
				'param_name' => 'links_target',
				'description' => esc_html__( 'Select where to open custom links.', 'eventerra' ),
				'dependency' => array(
					'element' => 'onclick',
					'value' => array( 'custom_link', 'description' ),
				),
				'value' => array(
					esc_html__( 'Same window', 'eventerra' ) => '_self',
					esc_html__( 'New window', 'eventerra' ) => '_blank',
				),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Apply grayscale filter?', 'eventerra' ),
				'param_name' => 'grayscale',
				'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Extra class name', 'eventerra'),
				'param_name' => 'el_class',
				'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'eventerra')
			),
		),
	));
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_om_logos extends WPBakeryShortCode {

		}
	}
	
	/**
	 * Speakers
	 */

	vc_map( array(
		'name' => esc_html__( 'Speakers', 'eventerra' ),
		'base' => 'om_speakers',
		'icon' => 'om-wpb-icon-person',
		'category' => array(esc_html__( 'Content', 'eventerra' )),
		'description' => esc_html__( 'Event speakers', 'eventerra' ),
		'params' => array(
			array(
				'type' => 'om_info',
				'heading' => '',
				'param_name' => 'info',
				'description' => sprintf( esc_html__('Speakers are managed under "%s" section. This block just displays them.','eventerra'), '<a href="'.esc_url(admin_url('edit.php?post_type=om-speakers')).'" target="_blank">'.esc_html__('Speakers','eventerra').'</a>' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Filter speakers','eventerra'),
				'param_name' => 'filter',
				'value' => array(
					esc_html__('Do not filter, display all','eventerra') => '',
					esc_html__('Choose certain speakers','eventerra') => 'id',
					esc_html__('Filter by category','eventerra') => 'category',
				),
			),
			array(
				'type' => 'autocomplete',
				'heading' => esc_html__( 'Certain speakers to display', 'eventerra' ),
				'param_name' => 'ids',
				'description' => esc_html__( 'Enter speaker name to include it.', 'eventerra' ),
				'settings' => array(
					'multiple' => true,
					'sortable' => true,
					'unique_values' => true,
					'min_length' => 1,
				),
				'dependency' => array(
					'element' => 'filter',
					'value' => array('id'),
				),
			),
			array(
				'type' => 'autocomplete',
				'heading' => esc_html__( 'Filter speakers by category', 'eventerra' ),
				'description' => esc_html__( 'Enter speaker categories', 'eventerra' ),
				'param_name' => 'categories',
				'settings' => array(
					'multiple' => true,
					'min_length' => 1,
					'unique_values' => true,
					'display_inline' => true,
				),
				'dependency' => array(
					'element' => 'filter',
					'value' => array('category'),
				),
			),
			/*
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Layout','eventerra'),
				'param_name' => 'layout',
				'admin_label' => true,
				'value' => array(
					esc_html__('Grid','eventerra') => 'grid',
					esc_html__('Tiled','eventerra') => 'tiled',
				),
			),
			*/
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Speaker short description','eventerra'),
				'param_name' => 'description',
				'value' => array(
					esc_html__('Display below the photo','eventerra') => 'below',
					esc_html__('Display next to the photo','eventerra') => 'next',
					esc_html__('Do not display','eventerra') => 'no',
				),
				/*
				'dependency' => array(
					'element' => 'layout',
					'value' => array('grid'),
				),
				*/
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Columns in grid','eventerra'),
				'param_name' => 'columns',
				'value' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
				'dependency' => array(
					'element' => 'description',
					'value' => array('below','no'),
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Sorting order','eventerra'),
				'param_name' => 'order',
				'std' => 'custom',
				'value' => array(
					esc_html__( 'Custom (can be set in Speakers - Sort Speakers)', 'eventerra' ) => 'custom',
					esc_html__( 'Alphabetical order', 'eventerra' ) => 'alphabetical',
				),
				'dependency' => array(
					'element' => 'filter',
					'value' => array('', 'category'),
				),
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Display link to speaker`s page', 'eventerra' ),
				'param_name' => 'link_to_speaker',
				'std' => 'yes',
				'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Extra class name', 'eventerra'),
				'param_name' => 'el_class',
				'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'eventerra')
			),
			
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Top margin', 'eventerra'),
				'description' => esc_html__('Custom top margin. You can use px, em, %, etc. or enter just number and it will use pixels.', 'eventerra'),
				'param_name' => 'margin_top',
				'group' => esc_html__( 'Margins', 'eventerra' ),
			),
			
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Bottom margin', 'eventerra'),
				'description' => esc_html__('Custom bottom margin. You can use px, em, %, etc. or enter just number and it will use pixels.', 'eventerra'),
				'param_name' => 'margin_bottom',
				'group' => esc_html__( 'Margins', 'eventerra' ),
			),
	
		),
	));
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_om_speakers extends WPBakeryShortCode {

		}
	}
	
	// autocomplete
	add_filter( 'vc_autocomplete_om_speakers_ids_callback', 'eventerra_wpb_search_speakers', 10, 1 );
	add_filter( 'vc_autocomplete_om_speakers_ids_render', 'vc_include_field_render', 10, 1 );
	function eventerra_wpb_search_speakers( $search_string ) {
		$query = $search_string;
		$data = array();
		$args = array(
			's' => $query,
			'post_type' => 'om-persons',
		);
		$args['vc_search_by_title_only'] = true;
		$args['numberposts'] = - 1;
		if ( 0 === strlen( $args['s'] ) ) {
			unset( $args['s'] );
		}
		add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
		$posts = get_posts( $args );
		if ( is_array( $posts ) && ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$data[] = array(
					'value' => $post->ID,
					'label' => $post->post_title,
					'group' => $post->post_type,
				);
			}
		}
	
		return $data;
	}

	add_filter( 'vc_autocomplete_om_speakers_categories_callback', 'eventerra_wpb_search_speakers_categories', 10, 1 );
	add_filter( 'vc_autocomplete_om_speakers_categories_render', 'eventerra_wpb_vc_speakers_field_render', 10, 1 );
	function eventerra_wpb_search_speakers_categories( $search_string ) {
		$data = array();
		$vc_taxonomies = get_terms( 'om-persons-type', array(
			'hide_empty' => false,
			'search' => $search_string,
		) );
		if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
			foreach ( $vc_taxonomies as $t ) {
				if ( is_object( $t ) ) {
					$data[] = vc_get_term_object( $t );
				}
			}
		}
	
		return $data;
	}
	function eventerra_wpb_vc_speakers_field_render( $term ) {
		$args=array(
			'hide_empty' => false,
		);
		if(is_numeric($term['value'])) {
			$args['include']=array($term['value']);
		} else {
			$args['slug']=array($term['value']);
		}
		$terms = get_terms( 'om-persons-type', $args );
		$data = false;
		if ( is_array( $terms ) && 1 === count( $terms ) ) {
			$term = $terms[0];
			$data = vc_get_term_object( $term );
		}
			
		return $data;
	}
	
	/**
	 * Wide Box
	 */

	vc_map(array(
		'name' => esc_html__('Clickable Wide Box', 'eventerra'),
		'base' => 'om_click_box',
		'icon' => 'om-wpb-icon-click-box',
		'description' => esc_html__('Call to action box', 'eventerra'),
		'category' => esc_html__('Content', 'eventerra'),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'eventerra' ),
				'param_name' => 'title',
				'admin_label' => true,
				'value' => '',
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Apply uppercase to the title?', 'eventerra' ),
				'param_name' => 'apply_uppercase',
				'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Subtitle', 'eventerra' ),
				'param_name' => 'subtitle',
				'admin_label' => true,
				'value' => '',
			),
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'URL (Link)', 'eventerra' ),
				'param_name' => 'link',
				'description' => esc_html__( 'Button link.', 'eventerra' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Size', 'eventerra' ),
				'param_name' => 'size',
				'value' => array(
					esc_html__('Small','eventerra') => 'sm',
					esc_html__('Medium','eventerra') => 'md',
					esc_html__('Large','eventerra') => 'lg',
					esc_html__('X-Large','eventerra') => 'xlg',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Color', 'eventerra' ),
				'param_name' => 'color',
				'value' => array_merge(array(esc_html__('Theme Accent Color 1', 'eventerra') => 'om-accent-color-1'), array(esc_html__('Theme Accent Color 2', 'eventerra') => 'om-accent-color-2'), array(esc_html__('Theme Accent Color 3', 'eventerra') => 'om-accent-color-3'), eventerra_wpb_get_std_colors(), array(esc_html__('Custom','eventerra') => 'custom')),
				'param_holder_class' => 'vc_colored-dropdown',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Custom Color', 'eventerra' ),
				'param_name' => 'custom_color',
				'value' => '',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency' => array(
					'element' => 'color',
					'value' => array('custom'),
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Text Color', 'eventerra' ),
				'param_name' => 'text_color',
				'value' => '#ffffff',
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Remove left/right margins?', 'eventerra' ),
				'description' => esc_html__( 'Using this option you can remove the gap between element and content box edge', 'eventerra' ),
				'param_name' => 'remove_margins',
				'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Extra class name', 'eventerra' ),
				'param_name' => 'el_class',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'eventerra' )
			),
		)
	));
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_om_click_box extends WPBakeryShortCode {
		}
	}				
	
	/**
	 * Clickable Icon box
	 */
	
	vc_map( array(
		'name' => esc_html__('Clickable Icon Box', 'eventerra'),
		'description' => esc_html__('Icon, Title, Text','eventerra'),
		'base' => 'om_click_icon_box',
		'icon' => 'om-wpb-icon-cib',
		'category' => array(esc_html__( 'Content', 'eventerra' )),
		'params' => array_merge(
			array(
				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'URL (Link)', 'eventerra' ),
					'param_name' => 'link',
					'description' => esc_html__( 'Button link.', 'eventerra' )
				),
			),
			eventerra_wpb_icon_params(),
			array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'eventerra' ),
					'param_name' => 'title',
					'admin_label' => true,
				),
	
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Text', 'eventerra' ),
					'param_name' => 'content',
				),
				
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Icon Size', 'eventerra' ),
					'param_name' => 'size',
					'std'=>'m',
					'value' => array(
						esc_html__('Small', 'eventerra') => 's',
						esc_html__('Medium', 'eventerra') => 'm',
						esc_html__('Large', 'eventerra') => 'l',
						esc_html__('X-Large', 'eventerra') => 'xl',
					),
				),
				
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Icon Background Color', 'eventerra' ),
					'param_name' => 'color',
					'value' => array_merge(array(esc_html__('Theme Accent Color 1', 'eventerra') => 'om-accent-color-1'), array(esc_html__('Theme Accent Color 2', 'eventerra') => 'om-accent-color-2'), array(esc_html__('Theme Accent Color 3', 'eventerra') => 'om-accent-color-3'), eventerra_wpb_get_std_colors(), array(esc_html__('Custom','eventerra') => 'custom')),
					'param_holder_class' => 'vc_colored-dropdown',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Icon Custom Background Color', 'eventerra' ),
					'param_name' => 'custom_color',
					'value' => '#3c3c3c',
					'dependency' => array(
						'element' => 'color',
						'value' => array('custom'),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Icon Color', 'eventerra' ),
					'param_name' => 'icon_color',
					'value' => '#ffffff',
				),
				
				array(
					'type' => 'textfield',
					'heading' => esc_html__('Extra class name', 'eventerra'),
					'param_name' => 'el_class',
					'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'eventerra')
				),
			)
		),
	));
	
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_om_click_icon_box extends WPBakeryShortCode {
		}
	}
	
	/**
	 * Teaser
	 */
/*	
	vc_map( array(
		'name' => esc_html__('Teaser', 'eventerra'),
		'description' => esc_html__('Background Image, Title, Text, Link','eventerra'),
		'base' => 'om_teaser',
		'icon' => 'om-wpb-icon-teaser',
		'category' => array(esc_html__( 'Content', 'eventerra' )),
		'params' => array(
			array(
				'type' => 'vc_link',
				'heading' => esc_html__( 'URL (Link)', 'eventerra' ),
				'param_name' => 'link',
				'description' => esc_html__( 'Button link.', 'eventerra' ),
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Background Image', 'eventerra' ),
				'param_name' => 'bg_image',
				'value' => '',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Background Image size', 'eventerra' ),
				'param_name' => 'img_size',
				'value' => 'full',
				'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'eventerra' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'eventerra' ),
				'param_name' => 'title',
				'holder' => 'h4',
			),

			array(
				'type' => 'textarea',
				'heading' => esc_html__( 'Text', 'eventerra' ),
				'param_name' => 'content',
				'holder' => 'div',
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Text color', 'eventerra' ),
				'param_name' => 'text_color',
				'value' => '',
			),		
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Text align', 'eventerra' ),
				'param_name' => 'align',
				'value' => array(
					esc_html__('Center','eventerra') => 'center',
					esc_html__('Left','eventerra') => 'left',
					esc_html__('Right','eventerra') => 'right',
				),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Add shadow?', 'eventerra' ),
				'param_name' => 'add_shadow',
				'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Certain teaser height', 'eventerra' ),
				'param_name' => 'height',
				'description' => esc_html__('Specify teaser height in pixels if you need certain height, otherwise the height will be set automatically', 'eventerra'),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Extra class name', 'eventerra'),
				'param_name' => 'el_class',
				'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'eventerra')
			),
		),
	));
	
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_om_teaser extends WPBakeryShortCode {
		}
	}
*/

	/**
	 * Posts
	 */
	 
	vc_map( array(
		'name' => esc_html__( 'Posts', 'eventerra' ),
		'base' => 'om_posts',
		'icon' => 'om-wpb-icon-posts',
		'category' => array(esc_html__( 'Content', 'eventerra' )),
		'description' => esc_html__( 'Posts block', 'eventerra' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Widget title', 'eventerra' ),
				'param_name' => 'title',
				'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'eventerra' )
			),
			/*array(
				'type' => 'dropdown',
				'heading' => esc_html__('Layout mode','eventerra'),
				'param_name' => 'mode',
				'admin_label' => true,
				'value' => array(
					esc_html__('Table view (fixed cells)','eventerra') => 'fixed',
					esc_html__('Masonry','eventerra') => 'masonry',
				),
			),*/
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Columns','eventerra'),
				'param_name' => 'columns',
				'admin_label' => true,
				'std' => 3,
				'value' => array(
					'3' => '3',
					'2' => '2',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Total number', 'eventerra' ),
				'param_name' => 'count',
				'value' => '',
				'admin_label' => true,
				'description' => esc_html__( 'Leave empty to display all posts', 'eventerra' )
			),
			array(
				'type' => 'om_categories_multiple',
				'heading' => esc_html__( 'Posts category', 'eventerra' ),
				'param_name' => 'category',
				'value' => '0',
				'description' => esc_html__( 'Choose a category (or multiple caterogires), to display posts from certain category.', 'eventerra' )
			),
			array(
				'type' => 'autocomplete',
				'heading' => esc_html__( 'Display only these posts', 'eventerra' ),
				'param_name' => 'ids',
				'settings' => array(
					'multiple' => true,
					'sortable' => true,
					'groups' => true,
				),
				'description' => esc_html__( 'If you want to display only certain posts, choose them here.', 'eventerra' )
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Randomize posts', 'eventerra' ),
				'param_name' => 'randomize',
				'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Hide thumbnail', 'eventerra' ),
				'param_name' => 'hide_thumbnail',
				'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Hide meta (date, categories, tags)', 'eventerra' ),
				'param_name' => 'hide_meta',
				'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Hide excerpt', 'eventerra' ),
				'param_name' => 'hide_excerpt',
				'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Extra class name', 'eventerra'),
				'param_name' => 'el_class',
				'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'eventerra')
			),
		),
	));

	// autocomplete	
	add_filter( 'vc_autocomplete_om_posts_ids_callback', 'eventerra_wpb_posts_field_search', 10, 1 );
	add_filter( 'vc_autocomplete_om_posts_ids_render', 'vc_include_field_render', 10, 1 );
	function eventerra_wpb_posts_field_search( $search_string ) {
		$query = $search_string;
		$data = array();
		$args = array( 's' => $query, 'post_type' => 'post' );
		$args['vc_search_by_title_only'] = true;
		$args['numberposts'] = - 1;
		if ( strlen( $args['s'] ) == 0 ) {
			unset( $args['s'] );
		}
		add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
		$posts = get_posts( $args );
		foreach ( $posts as $post ) {
			$data[] = array(
				'value' => $post->ID,
				'label' => $post->post_title,
				'group' => $post->post_type,
			);
		}
	
		return $data;
	}
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_om_posts extends WPBakeryShortCode {

		}
	}
	
	/**
	 * List
	 */
	 
	vc_map(array(
		'name' => esc_html__('List', 'eventerra'),
		'base' => 'om_list',
		'description' => esc_html__('Icon Bulleted List', 'eventerra'),
		'icon' => 'om-wpb-icon-list',
		'category' => esc_html__('Content', 'eventerra'),
		'params' => array_merge(
		array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'eventerra' ),
				'param_name' => 'title',
				'holder' => 'h3',
				'value' => '',
			),
			array(
				'type' => 'textarea',
				'holder' => 'pre',
				'heading' => esc_html__( 'List', 'eventerra' ),
				'param_name' => 'content',
				'description' => esc_html__( 'Enter list items. Divide items with linebreaks (Enter).', 'eventerra' ),
				'value' => esc_html__( 'List item 1', 'eventerra' )."\n".esc_html__( 'List item 2', 'eventerra' )."\n".esc_html__( 'List item 3', 'eventerra' )."\n",
			),
		),
		eventerra_wpb_icon_params(),
		array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon Color', 'eventerra' ),
				'param_name' => 'icon_color',
				'value' => array_merge(array(esc_html__('Default', 'eventerra') => '', esc_html__('Theme Accent Color 1', 'eventerra') => 'om-accent-color-1'), array(esc_html__('Theme Accent Color 2', 'eventerra') => 'om-accent-color-2'), array(esc_html__('Theme Accent Color 3', 'eventerra') => 'om-accent-color-3'), eventerra_wpb_get_std_colors(), array(esc_html__('Custom','eventerra') => 'custom')),
				'param_holder_class' => 'vc_colored-dropdown',
				'edit_field_class' => 'vc_col-sm-6 vc_column vc_block_clear',
			),
			array(
				'type' => 'colorpicker',
				'heading' => esc_html__( 'Icon Custom Color', 'eventerra' ),
				'param_name' => 'icon_custom_color',
				'value' => '',
				'dependency' => array(
					'element' => 'icon_color',
					'value' => array('custom'),
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Extra class name', 'eventerra' ),
				'param_name' => 'el_class',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'eventerra' )
			)
		)
		)
	));
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_om_list extends WPBakeryShortCode {
		}
	}
	
	/**
	 * Max Width Block
	 */
	
	vc_map( array(
		'name' => esc_html__('Max Width Container', 'eventerra'),
		'description'  => esc_html__('Limit maximum width of the container', 'eventerra'),
		'base' => 'om_max_width',
		'icon' => 'om-wpb-icon-max-width',
		'as_parent' => array('except' => 'vc_tta_section'),
		'category' => array(esc_html__( 'Content', 'eventerra' )),
		'content_element' => true,
		'is_container' => true,
		'show_settings_on_create' => true,
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Maximum container width', 'eventerra'),
				'param_name' => 'max_width',
				'description'  => esc_html__('Specify maximum width of the container in pixels or any other CSS measurement unit', 'eventerra'),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Align', 'eventerra' ),
				'param_name' => 'align',
				'value' => array(
					esc_html__('Center', 'eventerra')=>'center',
					esc_html__('Left', 'eventerra')=>'left',
					esc_html__('Right', 'eventerra')=>'right',
				),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Do not apply on mobile devices', 'eventerra' ),
				'param_name' => 'no_mobile',
				'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Extra class name', 'eventerra'),
				'param_name' => 'el_class',
				'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'eventerra')
			),
		),
		'js_view' => 'VcColumnView'
	));
	
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_Om_Max_Width extends WPBakeryShortCodesContainer {
		}
	}
	
	/**
	 * Remove Space
	 */
	
	vc_map( array(
		'name' => esc_html__('Reduce Empty Space', 'eventerra'),
		'description'  => esc_html__('Use it between elements to reduce empty space', 'eventerra'),
		'base' => 'om_reduce_space',
		'icon' => 'om-wpb-icon-reduce-space',
		'category' => array(esc_html__( 'Content', 'eventerra' )),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Height of the space to reduce', 'eventerra'),
				'param_name' => 'height',
				'value' => '32px',
				'admin_label' => true,
				'description'  => esc_html__('Specify height of the space to reduce in pixels or any other CSS measurement unit', 'eventerra'),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Hide on mobile devices', 'eventerra' ),
				'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
				'param_name' => 'mobile_hide',
			),
		),
	));
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Om_Reduce_Space extends WPBakeryShortCode {
		}
	}

	/**
	 * Agenda
	 */
	
	vc_map( array(
		'name' => esc_html__('Agenda / Schedule', 'eventerra'),
		'base' => 'om_agenda',
		'icon' => 'om-wpb-icon-agenda',
		'as_parent' => array('only' => 'om_agenda_day'),
		'category' => array(esc_html__( 'Content', 'eventerra' )),
		'content_element' => true,
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Layout', 'eventerra' ),
				'param_name' => 'layout',
				'value' => array(
					esc_html__('List', 'eventerra')=>'list',
					esc_html__('Grid', 'eventerra')=>'grid',
				),
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Display Room/Place field', 'eventerra' ),
				'param_name' => 'display_room',
				'std' => 'yes',
				'value' => array( esc_html__( 'Yes', 'eventerra' ) => 'yes' )
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Display Speakers field', 'eventerra' ),
				'param_name' => 'display_speakers',
				'std' => 'yes',
				'value' => array( esc_html__( 'Yes', 'eventerra' ) => 'yes' )
			),
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Expand item description by click', 'eventerra' ),
				'param_name' => 'description_expand',
				'std' => '',
				'value' => array( esc_html__( 'Yes', 'eventerra' ) => 'yes' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Columns', 'eventerra' ),
				'param_name' => 'columns',
				'std'=>'3',
				'value' => array(
					'3'=>'3',
					'2'=>'2',
				),
				'dependency' => array( 'element' => 'layout', 'value' => array('grid') ),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Extra class name', 'eventerra'),
				'param_name' => 'el_class',
				'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'eventerra')
			),
		),
		'js_view' => 'VcColumnView'
	));
	
	vc_map( array(
		'name' => esc_html__('Agenda Day', 'eventerra'),
		'base' => 'om_agenda_day',
		'icon' => 'om-wpb-icon-agenda-day',
		'as_child' => array('only' => 'om_agenda'),
		'as_parent' => array('only' => 'om_agenda_item'),
		'category' => array(esc_html__( 'Content', 'eventerra' )),
		'content_element' => true,
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'eventerra' ),
				'param_name' => 'title',
				'admin_label' => true,
				'description' => esc_html__( 'Enter day title.', 'eventerra' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Date', 'eventerra' ),
				'param_name' => 'date',
				'description' => esc_html__( 'Enter the date.', 'eventerra' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Color of the day block', 'eventerra' ),
				'param_name' => 'color',
				'value' => array(
					esc_html__('Theme Accent Color 1', 'eventerra') => 'om-accent-color-1',
					esc_html__('Theme Accent Color 2', 'eventerra') => 'om-accent-color-2',
					esc_html__('Theme Accent Color 3', 'eventerra') => 'om-accent-color-3',
				),
				'param_holder_class' => 'vc_colored-dropdown',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Extra class name', 'eventerra'),
				'param_name' => 'el_class',
				'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'eventerra')
			),
		),
		'js_view' => 'VcColumnView'
	));
	
	vc_map( array(
		'name' => esc_html__('Agenda Item', 'eventerra'),
		'base' => 'om_agenda_item',
		'icon' => 'om-wpb-icon-agenda-item',
		'content_element' => true,
		'as_child' => array('only' => 'om_agenda_day'),
		'params' => array_merge(
			array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Time', 'eventerra' ),
					'param_name' => 'time',
					'admin_label' => true,
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title of the event', 'eventerra' ),
					'param_name' => 'title',
					'admin_label' => true,
				),
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Description of the event', 'eventerra' ),
					'param_name' => 'content',
				),
			),
			eventerra_wpb_icon_params(false,false,array('icon_fontawesome'=>'fa fa-clock-o')),
			array(
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Featured', 'eventerra' ),
					'param_name' => 'featured',
					'description' => esc_html__( 'If selected, item will stand out.', 'eventerra' ),
					'value' => array( esc_html__( 'Yes', 'eventerra' ) => 'yes' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Room/Place', 'eventerra' ),
					'param_name' => 'room',
				),
				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Link', 'eventerra' ),
					'param_name' => 'link',
					'description' => esc_html__( 'Link to some page from this item if needed.', 'eventerra' )
				),
			),
			array(
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Event speakers', 'eventerra' ),
					'param_name' => 'speaker_ids',
					'description' => esc_html__( 'Enter speaker name to include it. You need to activate Olevmedia Persons plugin and create Speakers to use this option.', 'eventerra' ),
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
						'unique_values' => true,
						'min_length' => 1,
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Display link to speaker page', 'eventerra' ),
					'param_name' => 'speaker_links',
					'std' => 'yes',
					'value' => array( esc_html__( 'Yes', 'eventerra' ) => 'yes' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__('Extra class name', 'eventerra'),
					'param_name' => 'el_class',
					'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'eventerra')
				),
			)
		),
	));
	
	// autocomplete
	add_filter( 'vc_autocomplete_om_agenda_item_speaker_ids_callback', 'eventerra_wpb_search_speakers', 10, 1 );
	add_filter( 'vc_autocomplete_om_agenda_item_speaker_ids_render', 'vc_include_field_render', 10, 1 );

	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_Om_Agenda extends WPBakeryShortCodesContainer {
		}
		class WPBakeryShortCode_Om_Agenda_Day extends WPBakeryShortCodesContainer {
		}
	}
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Om_Agenda_Item extends WPBakeryShortCode {
		}
	}
	
	/***************************************************************
	 ***************************************************************
	 * Tickera
	 ***************************************************************
	 ***************************************************************/
	
	if(class_exists( 'TC' )) {

		/**
		 * Tickera: ticket
		 */
		 
		vc_map( array(
			'name' => esc_html__('Tickera: Ticket', 'eventerra'),
			'description' => esc_html__('Add to cart/buy ticket button','eventerra'),
			'base' => 'om_tc_ticket',
			'icon' => 'om-wpb-icon-tickera',
			'category' => array(esc_html__( 'Content', 'eventerra' ), esc_html__( 'Tickera', 'eventerra' )),
			'params' => array(
				array(
					'type' => 'om_tc_tickets',
					'heading' => esc_html__( 'Ticket Type', 'eventerra' ),
					'param_name' => 'id',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Link Title', 'eventerra' ),
					'param_name' => 'title',
					'value' => esc_html__( 'Add to Cart', 'eventerra' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Soldout Message', 'eventerra' ),
					'param_name' => 'soldout_message',
					'value' => esc_html__( 'Tickets are sold out.', 'eventerra' ),
					'description' => esc_html__( 'The message which will be shown when all tickets are sold.', 'eventerra' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Show Price', 'eventerra' ),
					'param_name' => 'show_price',
					'std' => 'false',
					'value' => array(
						esc_html__('No','eventerra') => 'false',
						esc_html__('Yes','eventerra') => 'true',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Price Position', 'eventerra' ),
					'param_name' => 'price_position',
					'std' => 'after',
					'value' => array(
						esc_html__('After','eventerra') => 'after',
						esc_html__('Before','eventerra') => 'before',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__('Button size', 'eventerra'),
					'param_name' => 'size',
					'std'=>'md',
					'value' => array(
						esc_html__('Mini', 'eventerra') => 'xs',
						esc_html__('Small', 'eventerra') => 'sm',
						esc_html__('Normal', 'eventerra') => 'md',
						esc_html__('Large', 'eventerra') => 'lg',
						esc_html__('X-Large', 'eventerra') => 'xlg',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__('Alignment', 'eventerra'),
					'param_name' => 'alignment',
					'std'=>'inline',
					'value' => array(
						esc_html__('Inline', 'eventerra') => 'inline',
						esc_html__('Left', 'eventerra') => 'left',
						esc_html__('Right', 'eventerra') => 'right',
						esc_html__('Center', 'eventerra') => 'center',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Link Type', 'eventerra' ),
					'description' => esc_html__( 'If Buy Now is selected, after clicking on the link, user will be redirected automatically to the cart page.', 'eventerra' ),
					'param_name' => 'type',
					'std' => 'cart',
					'value' => array(
						esc_html__('Cart','eventerra') => 'cart',
						esc_html__('Buy Now','eventerra') => 'buynow',
					),
				),				

			),
		));
		
		if ( class_exists( 'WPBakeryShortCode' ) ) {
			class WPBakeryShortCode_Om_Tc_Ticket extends WPBakeryShortCode {
			}
		}

		/**
		 * Tickera: tickets
		 */
		 
		vc_map( array(
			'name' => esc_html__('Tickera: all Tickets', 'eventerra'),
			'description' => esc_html__('Displays all types of event tickets','eventerra'),
			'base' => 'tc_event',
			'icon' => 'om-wpb-icon-tickera',
			'category' => array(esc_html__( 'Content', 'eventerra' ), esc_html__( 'Tickera', 'eventerra' )),
			'params' => array(
				array(
					'type' => 'om_tc_events',
					'heading' => esc_html__( 'Event', 'eventerra' ),
					'param_name' => 'id',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Link Title', 'eventerra' ),
					'param_name' => 'title',
					'value' => esc_html__( 'Add to Cart', 'eventerra' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Ticket Type Column Title', 'eventerra' ),
					'param_name' => 'ticket_type_title',
					'value' => esc_html__( 'Ticket Type', 'eventerra' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Price Column Title', 'eventerra' ),
					'param_name' => 'price_title',
					'value' => esc_html__( 'Price', 'eventerra' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Cart Column Title', 'eventerra' ),
					'param_name' => 'cart_title',
					'value' => esc_html__( 'Cart', 'eventerra' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Quantity Column Title', 'eventerra' ),
					'param_name' => 'quantity_title',
					'value' => esc_html__( 'Qty.', 'eventerra' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Soldout Message', 'eventerra' ),
					'param_name' => 'soldout_message',
					'value' => esc_html__( 'Tickets are sold out.', 'eventerra' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Show Quantity Selector', 'eventerra' ),
					'param_name' => 'quantity',
					'std' => '',
					'value' => array(
						esc_html__('No','eventerra') => '',
						esc_html__('Yes','eventerra') => 'true',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Link Type', 'eventerra' ),
					'description' => esc_html__( 'If Buy Now is selected, after clicking on the link, user will be redirected automatically to the cart page.', 'eventerra' ),
					'param_name' => 'type',
					'std' => 'cart',
					'value' => array(
						esc_html__('Cart','eventerra') => 'cart',
						esc_html__('Buy Now','eventerra') => 'buynow',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),				

			),
		));		

		/**
		 * Tickera: CTA Buy Tciket
		 */
		 
		vc_map( array(
			'name' => esc_html__('Tickera: CTA Buy Ticket', 'eventerra'),
			'description' => esc_html__('CTA box with Buy Ticket button','eventerra'),
			'base' => 'om_tc_cta_ticket',
			'icon' => 'om-wpb-icon-tickera',
			'category' => array(esc_html__( 'Content', 'eventerra' ), esc_html__( 'Tickera', 'eventerra' )),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Heading', 'eventerra' ),
					'description' => esc_html__('Enter text for heading line.', 'eventerra' ),
					'param_name' => 'h2',
					'value' => esc_html__( 'Hey! I am first heading line feel free to change me', 'eventerra' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Subheading', 'eventerra' ),
					'description' => esc_html__('Enter text for subheading line.', 'eventerra' ),
					'param_name' => 'h4',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__('Text alignment', 'eventerra'),
					'param_name' => 'txt_align',
					'std'=>'left',
					'value' => array(
						esc_html__('Left', 'eventerra') => 'left',
						esc_html__('Right', 'eventerra') => 'right',
						esc_html__('Center', 'eventerra') => 'center',
						esc_html__('Justify', 'eventerra') => 'justify',
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Background color', 'eventerra' ),
					'param_name' => 'custom_background',
					'description' => esc_html__( 'Select custom background color.', 'eventerra' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Add background stripes?', 'eventerra' ),
					'param_name' => 'add_stripes',
					'std'=>'yes',
					'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Text color', 'eventerra' ),
					'param_name' => 'custom_text',
					'description' => esc_html__( 'Select custom text color.', 'eventerra' ),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Remove left/right margins?', 'eventerra' ),
					'description' => esc_html__( 'Using this option you can remove the gap between element and content box edge', 'eventerra' ),
					'param_name' => 'remove_margins',
					'std'=>'',
					'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
				),
				
				array(
					'type' => 'om_tc_tickets',
					'heading' => esc_html__( 'Ticket Type', 'eventerra' ),
					'param_name' => 'id',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Link Title', 'eventerra' ),
					'param_name' => 'btn_title',
					'value' => esc_html__( 'Buy Ticket', 'eventerra' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Apply uppercase?', 'eventerra' ),
					'param_name' => 'btn_uppercase',
					'std'=>'yes',
					'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Soldout Message', 'eventerra' ),
					'param_name' => 'soldout_message',
					'value' => esc_html__( 'Sold out', 'eventerra' ),
					'description' => esc_html__( 'The message which will be shown when all tickets are sold.', 'eventerra' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Button Color', 'eventerra' ),
					'param_name' => 'btn_color',
					'value' => array(
						esc_html__('Theme Accent Color 1', 'eventerra') => 'om-accent-color-1',
						esc_html__('Theme Accent Color 2', 'eventerra') => 'om-accent-color-2',
						esc_html__('Theme Accent Color 3', 'eventerra') => 'om-accent-color-3',
					),
					'param_holder_class' => 'vc_colored-dropdown',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__('Button alignment', 'eventerra'),
					'param_name' => 'button_alignment',
					'std'=>'right',
					'value' => array(
						esc_html__('Right', 'eventerra') => 'right',
						esc_html__('Left', 'eventerra') => 'left',
						esc_html__('Bottom', 'eventerra') => 'bottom',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'type' => 'textfield',
					'heading' => esc_html__('Extra class name', 'eventerra'),
					'param_name' => 'el_class',
					'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'eventerra')
				),
				
			),
		));
		
		if ( class_exists( 'WPBakeryShortCode' ) ) {
			class WPBakeryShortCode_Om_Tc_Cta_Ticket extends WPBakeryShortCode {
			}
		}
				
	}
	
}
