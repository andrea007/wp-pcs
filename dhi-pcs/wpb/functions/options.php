<?php

add_action( 'init', 'eventerra_wpb_init' );

function eventerra_wpb_init() {

	vc_remove_element('vc_tabs');
	vc_remove_element('vc_tour');
	vc_remove_element('vc_accordion');
	vc_remove_element('vc_button');
	vc_remove_element('vc_button2');
	vc_remove_element('vc_cta_button');
	vc_remove_element('vc_cta_button2');
	vc_remove_element('vc_widget_sidebar');
	vc_remove_element('vc_posts_slider');
	vc_remove_element('vc_basic_grid');
	vc_remove_element('vc_media_grid');
	vc_remove_element('vc_masonry_grid');
	vc_remove_element('vc_masonry_media_grid');

	/**
	 *  Section
	 */

	vc_remove_param("vc_section", "full_width");
	vc_remove_param("vc_section", "css");
	vc_remove_param("vc_section", "parallax");
	vc_remove_param("vc_section", "parallax_image");
	vc_remove_param("vc_section", "full_height");
	vc_remove_param("vc_section", "columns_placement");
	vc_remove_param("vc_section", "video_bg");
	vc_remove_param("vc_section", "video_bg_url");
	vc_remove_param("vc_section", "video_bg_parallax");
	vc_remove_param("vc_section", "parallax_speed_video");
	vc_remove_param("vc_section", "parallax_speed_bg");
	vc_remove_param("vc_section", "content_placement");
	vc_remove_param("vc_section", "css_animation");

	/**
	 * Row
	 */

	//vc_remove_param("vc_row", "full_width");
	vc_remove_param("vc_row", "css");
	vc_remove_param("vc_row", "parallax");
	vc_remove_param("vc_row", "parallax_image");
	vc_remove_param("vc_row", "full_height");
	vc_remove_param("vc_row", "columns_placement");
	vc_remove_param("vc_row", "video_bg");
	vc_remove_param("vc_row", "video_bg_url");
	vc_remove_param("vc_row", "video_bg_parallax");
	vc_remove_param("vc_row", "parallax_speed_video");
	vc_remove_param("vc_row", "parallax_speed_bg");

	vc_add_param('vc_row', array(
		'type' => 'colorpicker',
		'heading' => esc_html__('Font color', 'eventerra'),
		'param_name' => 'font_color',
		'description' => esc_html__( 'Select custom font color or leave empty to use default.', 'eventerra' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'dropdown',
		'heading' => esc_html__('Row Background', 'eventerra'),
		'param_name' => 'bg_type',
		'value' => array(
			esc_html__('Solid Color', 'eventerra') => 'color',
			esc_html__('Gradient Color', 'eventerra') => 'gradient',
			esc_html__('Image', 'eventerra') => 'image',
			esc_html__('Video', 'eventerra') => 'video',
		),
		'group' => esc_html__( 'Background', 'eventerra' ),
	));

	vc_add_param('vc_row', array(
		'type' => 'colorpicker',
		'heading' => esc_html__('Background color', 'eventerra'),
		'param_name' => 'bg_color',
		//'description' => esc_html__( 'Select background color for the row. Notice: if you set background image, background color will be invisible (covered by image).', 'eventerra' ),
		'group' => esc_html__( 'Background', 'eventerra' ),
		'dependency' => array(
			'element' => 'bg_type',
			'value' => array('color','gradient'),
		),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'colorpicker',
		'heading' => esc_html__('Background color 2', 'eventerra'),
		'param_name' => 'bg_color2',
		'description' => esc_html__( 'Second color of the gradient.', 'eventerra' ),
		'group' => esc_html__( 'Background', 'eventerra' ),
		'dependency' => array(
			'element' => 'bg_type',
			'value' => array('gradient'),
		),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'dropdown',
		'heading' => esc_html__('Gradient type', 'eventerra'),
		'param_name' => 'gradient_type',
		'value' => array(
			esc_html__('Vertical', 'eventerra').' ↓' => 'vertical',
			esc_html__('Horisontal', 'eventerra').' →' => 'horisontal',
			esc_html__('Diagonal', 'eventerra').' ↗' => 'diagonal1',
			esc_html__('Diagonal', 'eventerra').' ↘' => 'diagonal2',
			esc_html__('Radial', 'eventerra').' o' => 'radial',
		),
		'group' => esc_html__( 'Background', 'eventerra' ),
		'dependency' => array(
			'element' => 'bg_type',
			'value' => array('gradient'),
		),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'attach_image',
		'heading' => esc_html__('Background image', 'eventerra'),
		'param_name' => 'bg_image',
		'description' => esc_html__( 'Select background image for the row.', 'eventerra' ),
		'group' => esc_html__( 'Background', 'eventerra' ),
		'dependency' => array(
			'element' => 'bg_type',
			'value' => array('image'),
		),
	));

	vc_add_param('vc_row', array(
		'type' => 'dropdown',
		'heading' => esc_html__('Background image position', 'eventerra'),
		'param_name' => 'bg_image_pos',
		'value' => array_flip(eventerra_get_bg_img_pos_options()),
		'dependency' => array(
			'element' => 'bg_image',
			'not_empty' => true,
		),
		'group' => esc_html__( 'Background', 'eventerra' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'dropdown',
		'heading' => esc_html__('Background image attachment', 'eventerra'),
		'param_name' => 'bg_image_att',
		'value' => array(
			esc_html__('Scroll', 'eventerra') => 'scroll',
			esc_html__('Fixed', 'eventerra') => 'fixed',
			esc_html__('Parallax, up direction', 'eventerra') => 'parallax',
			esc_html__('Parallax, down direction', 'eventerra') => 'parallax_down',
		),
		'dependency' => array(
			'element' => 'bg_image',
			'not_empty' => true,
		),
		'group' => esc_html__( 'Background', 'eventerra' ),
	));

	vc_add_param('vc_row', array(
		'type' => 'colorpicker',
		'heading' => esc_html__('Background image dimming', 'eventerra'),
		'param_name' => 'bg_image_dimming',
		'description' => esc_html__( 'Choose a color and set alpha slider to the desired value to dim an image.', 'eventerra' ),
		'group' => esc_html__( 'Background', 'eventerra' ),
		'std' => '',
		'dependency' => array(
			'element' => 'bg_image',
			'not_empty' => true,
		),
	));
		
	vc_add_param('vc_row', array(
		'type' => 'attach_video',
		'heading' => esc_html__('Background Video File', 'eventerra'),
		'param_name' => 'bg_video_src',
		'description' => esc_html__( 'Select background video for the row.', 'eventerra' ),
		'group' => esc_html__( 'Background', 'eventerra' ),
		'dependency' => array(
			'element' => 'bg_type',
			'value' => array('video'),
		),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'attach_video',
		'heading' => esc_html__('MP4 Video File URL (Optional)', 'eventerra'),
		'param_name' => 'bg_video_mp4',
		'description' => esc_html__( 'Use as a fallback format in addition to the main video file.', 'eventerra' ),
		'dependency' => array(
			'element' => 'bg_video_src',
			'not_empty' => true,
		),
		'group' => esc_html__( 'Background', 'eventerra' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'attach_video',
		'heading' => esc_html__('M4V Video File URL (Optional)', 'eventerra'),
		'param_name' => 'bg_video_m4v',
		'description' => esc_html__( 'Use as a fallback format in addition to the main video file.', 'eventerra' ),
		'dependency' => array(
			'element' => 'bg_video_src',
			'not_empty' => true,
		),
		'group' => esc_html__( 'Background', 'eventerra' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'attach_video',
		'heading' => esc_html__('WebM Video File URL (Optional)', 'eventerra'),
		'param_name' => 'bg_video_webm',
		'description' => esc_html__( 'Use as a fallback format in addition to the main video file.', 'eventerra' ),
		'dependency' => array(
			'element' => 'bg_video_src',
			'not_empty' => true,
		),
		'group' => esc_html__( 'Background', 'eventerra' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'attach_video',
		'heading' => esc_html__('OGV Video File URL (Optional)', 'eventerra'),
		'param_name' => 'bg_video_ogv',
		'description' => esc_html__( 'Use as a fallback format in addition to the main video file.', 'eventerra' ),
		'dependency' => array(
			'element' => 'bg_video_src',
			'not_empty' => true,
		),
		'group' => esc_html__( 'Background', 'eventerra' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'attach_video',
		'heading' => esc_html__('WMV Video File URL (Optional)', 'eventerra'),
		'param_name' => 'bg_video_wmv',
		'description' => esc_html__( 'Use as a fallback format in addition to the main video file.', 'eventerra' ),
		'dependency' => array(
			'element' => 'bg_video_src',
			'not_empty' => true,
		),
		'group' => esc_html__( 'Background', 'eventerra' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'attach_video',
		'heading' => esc_html__('FLV Video File URL (Optional)', 'eventerra'),
		'param_name' => 'bg_video_flv',
		'description' => esc_html__( 'Use as a fallback format in addition to the main video file.', 'eventerra' ),
		'dependency' => array(
			'element' => 'bg_video_src',
			'not_empty' => true,
		),
		'group' => esc_html__( 'Background', 'eventerra' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'colorpicker',
		'heading' => esc_html__('Fallback background color', 'eventerra'),
		'param_name' => 'bg_color_fallback',
		'group' => esc_html__( 'Background', 'eventerra' ),
		'dependency' => array(
			'element' => 'bg_type',
			'value' => array('video','image'),
		),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'attach_image',
		'heading' => esc_html__('Fallback background image', 'eventerra'),
		'param_name' => 'bg_image_fallback',
		'group' => esc_html__( 'Background', 'eventerra' ),
		'dependency' => array(
			'element' => 'bg_type',
			'value' => array('video'),
		),
	));

	vc_add_param('vc_row', array(
		'type' => 'dropdown',
		'heading' => esc_html__('Fancy bottom edge', 'eventerra'),
		'param_name' => 'fancy_edge',
		'value' => array(
			esc_html__('No', 'eventerra') => '',
			esc_html__('Diagonal', 'eventerra').' /' => 'diagonal_left',
			esc_html__('Diagonal', 'eventerra').' \\' => 'diagonal_right',
			esc_html__('Corner', 'eventerra').' \/' => 'corner_down',
			esc_html__('Corner', 'eventerra').' /\\' => 'corner_up',
		),
		'group' => esc_html__( 'Background', 'eventerra' ),
		'dependency' => array(
			'element' => 'bg_type',
			'value' => array('color'),
		),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'dropdown',
		'heading' => esc_html__('Edge size', 'eventerra'),
		'param_name' => 'fancy_edge_size',
		'value' => array(
			esc_html__('Small', 'eventerra') => 'sm',
			esc_html__('Medium', 'eventerra') => 'md',
			esc_html__('Large', 'eventerra') => 'lg',
			esc_html__('X-Large', 'eventerra') => 'xlg',
		),
		'group' => esc_html__( 'Background', 'eventerra' ),
		'dependency' => array(
			'element' => 'fancy_edge',
			'not_empty' => true,
		),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'colorpicker',
		'heading' => esc_html__('Edge transient color', 'eventerra'),
		'param_name' => 'fancy_edge_t_color',
		'description' => esc_html__( 'Set this color if you want to apply transition to custom color (for instance background color of next section). Leave empty to disable transition.', 'eventerra' ),
		'group' => esc_html__( 'Background', 'eventerra' ),
		'dependency' => array(
			'element' => 'fancy_edge',
			'not_empty' => true,
		),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'textfield',
		'heading' => esc_html__('Top padding', 'eventerra'),
		'param_name' => 'padding_top',
		'description' => esc_html__( 'You can use px, em, %, etc. or enter just number and it will use pixels.', 'eventerra' ),
		'group' => esc_html__( 'Extra', 'eventerra' ),
	));

	vc_add_param('vc_row', array(
		'type' => 'textfield',
		'heading' => esc_html__('Bottom padding', 'eventerra'),
		'param_name' => 'padding_bottom',
		'description' => esc_html__( 'You can use px, em, %, etc. or enter just number and it will use pixels.', 'eventerra' ),
		'group' => esc_html__( 'Extra', 'eventerra' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'textfield',
		'heading' => esc_html__('Top margin', 'eventerra'),
		'param_name' => 'margin_top',
		'description' => esc_html__( 'You can use px, em, %, etc. or enter just number and it will use pixels.', 'eventerra' ),
		'group' => esc_html__( 'Extra', 'eventerra' ),
	));

	vc_add_param('vc_row', array(
		'type' => 'textfield',
		'heading' => esc_html__('Bottom margin', 'eventerra'),
		'param_name' => 'margin_bottom',
		'description' => esc_html__( 'You can use px, em, %, etc. or enter just number and it will use pixels.', 'eventerra' ),
		'group' => esc_html__( 'Extra', 'eventerra' ),
	));

	vc_add_param('vc_row', array(
		'type' => 'textarea',
		'heading' => esc_html__('Custom CSS Style', 'eventerra'),
		'param_name' => 'custom_css',
		'description' => esc_html__( 'You can add custom CSS style for the row.', 'eventerra' ),
		'group' => esc_html__( 'Extra', 'eventerra' ),
	));	

	/**
	 * VC Column
	 */
	 
	$tmp=array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Delimiter', 'eventerra' ),
		'description' => esc_html__( 'Delimiter at right hand side, between columns.', 'eventerra' ),
		'param_name' => 'delimiter',
		'value' => array(
			esc_html__( 'No', 'eventerra' ) => '',
			esc_html__( 'Vertical line', 'eventerra' ) => 'vline',
			esc_html__( 'Horisontal line', 'eventerra' ) => 'hline',
			esc_html__( 'Dot', 'eventerra' ) => 'dot',
			esc_html__( 'Arrow', 'eventerra' ) => 'rarr',
		),
	);
	vc_add_param('vc_column', $tmp);
	vc_add_param('vc_column_inner', $tmp);

	$tmp=array(
		'type' => 'textfield',
		'heading' => esc_html__('Maximum content width', 'eventerra'),
		'param_name' => 'max_content_width',
		'admin_label' => true,
		'description'  => esc_html__('You can restrict maximum width of the content in the column in pixels or any other CSS measurement unit', 'eventerra'),
	);
	vc_add_param('vc_column', $tmp);
	vc_add_param('vc_column_inner', $tmp);
	
  /**
   * Text Separator
   */
   
  $params=new OMWPBScParams('vc_text_separator');
	
	$params->add(array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Title size', 'eventerra' ),
		'value' => array(
	  	esc_html__('Small','eventerra') => 's',
	  	esc_html__('Medium','eventerra') => 'm',
	  	esc_html__('Large','eventerra') => 'l',
	  	esc_html__('X-Large','eventerra') => 'xl',
		),
		'std' => 'm',
		'param_name' => 'title_size',
	), 'title_align');
	
  $param=$params->get('color');
  $param['value']=array_merge(array(esc_html__('Default','eventerra') => 'default'),$param['value']);
  $param['heading']=esc_html__( 'Title Color', 'eventerra' );
  $param['edit_field_class'] = 'vc_col-sm-6 vc_column';
  $params->update($param);
  
  $param=$params->get('accent_color');
  $param['heading']=esc_html__( 'Title Custom Color', 'eventerra' );
  $param['edit_field_class'] = 'vc_col-sm-6 vc_column';
  $params->update($param);	
  
	$params->add(array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Border Color', 'eventerra' ),
		'value' => array(
	  	esc_html__('Same as Title Color','eventerra') => 'default',
	  	esc_html__('Custom','eventerra') => 'custom',
		),
		'param_name' => 'border_color',
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	), 'border_width');
	
	$params->add(array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Border Custom Color', 'eventerra' ),
		'param_name' => 'border_custom_color',
		'dependency' => array(
			'element' => 'border_color',
			'value' => array('custom'),
		),
		'std' => '#eeeeee',
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	), 'border_color');
	
  $param=$params->get('i_color');
  $param['value']=array_merge(array(esc_html__('Default','eventerra') => 'default'),$param['value']);
  $params->update($param);
  
	$params->remove('i_background_color');
	$params->remove('i_custom_background_color');

	$param=$params->get('i_background_style');
  $param['type']='hidden';
  $params->update($param);	
  
	$param=$params->get('i_size');
  $param['type']='hidden';
  $params->update($param);	
			  
	$params->save();

	/**
	 * Message box
	 */

  $params=new OMWPBScParams('vc_message');
  
	$param=$params->get('style');
  $param['std']='square';
  $param['type']='hidden';
  $params->update($param);
  
  $param=$params->get('color');
  $tmp=array();
	foreach($param['options'] as $v) {
		if(!in_array($v['value'], array('alert-info','alert-warning','alert-success','alert-danger'))) {
			$tmp[]=$v;
		}
	}
	$param['options']=$tmp;
  $params->update($param);

	$param=$params->get('message_box_style');
	$param['value']=array_diff($param['value'], array('standard', 'solid-icon', '3d')) ;
	$param['edit_field_class'] = 'vc_col-sm-6 vc_column';
	$params->update($param);
	
	$params->add(array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Add shadow?', 'eventerra' ),
		'param_name' => 'add_shadow',
		'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	), 'message_box_style');
	
	$param=$params->get('icon_type');
	$param['value']=array_diff($param['value'], array('pixelicons')) ;
	$params->update($param);

	$param=$params->get('message_box_color');
	$param['value']= array_diff($param['value'], array('alert-info','alert-warning','alert-success','alert-danger')) ;
	$params->update($param);
	
	$params->remove('css');  
	
  $params->save();	

	/**
	 * Toggle
	 */
	
	$params=new OMWPBScParams('vc_toggle');
	$params->remove('style');
	$params->remove('size');
	
	$param=$params->get('color');
	$param['value']=array();
	$params->update($param);
	
	$params->save();

	/**
	 * Single image
	 */
	 
	$params=new OMWPBScParams('vc_single_image');

	$param=$params->get('style');
	unset($param['value']['3D Shadow']);
	$params->update($param);

	$param=$params->get('img_size');
	$param['value']='full';
	$param['description'] = esc_html__('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.','eventerra');
	$params->update($param);

	$params->add(array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Remove left/right margins?', 'eventerra' ),
		'description' => esc_html__( 'Using this option you can remove the gap between image and content box edge', 'eventerra' ),
		'param_name' => 'remove_margins',
		'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
	), 'style');

	$param=$params->get('onclick');
	$param['value'][ esc_html__('YouTube/Vemeo video popup','eventerra') ]='video_popup';
	$params->update($param);

	$params->add(array(
		'type' => 'textfield',
		'heading' => esc_html__( 'Link to YouTube/Vemeo video', 'eventerra' ),
		'param_name' => 'video_link',
		'dependency' => array(
			'element' => 'onclick',
			'value' => array('video_popup'),
		),
	), 'onclick');
	  	
	$params->save();

	/**
	 * Gallery
	 */
	 
	$param = WPBMap::getParam('vc_gallery', 'type');
	unset($param['value']['Flex slider fade']);
	unset($param['value']['Flex slider slide']);
	$param['value']=array_merge(array(
		esc_html__('OM slider','eventerra') => 'om',
		esc_html__('Sliced','eventerra') => 'sliced',
		esc_html__('Masonry','eventerra') => 'masonry',
	),$param['value']);
	WPBMap::mutateParam('vc_gallery', $param);

	$param = WPBMap::getParam('vc_gallery', 'images');
	unset($param['dependency']);
	WPBMap::mutateParam('vc_gallery', $param);

	$param = WPBMap::getParam('vc_gallery', 'source');
	$param['std']='media_library';
	$param['type']='hidden';
	WPBMap::mutateParam('vc_gallery', $param);

	$param = WPBMap::getParam('vc_gallery', 'onclick');
	$param['value'][ esc_html__('Video popup (Custom Links - links to YouTube/Vemeo videos)','eventerra') ]='video_popup';
	WPBMap::mutateParam('vc_gallery', $param);

	$param = WPBMap::getParam('vc_gallery', 'custom_links');
	$param['dependency']['value'][]='video_popup';
	WPBMap::mutateParam('vc_gallery', $param);

	vc_remove_param("vc_gallery", "img_size");
	vc_remove_param("vc_gallery", "external_img_size");
	vc_remove_param("vc_gallery", "custom_srcs");
	vc_remove_param("vc_gallery", "el_class");

	vc_add_param('vc_gallery', array(
		'type' => 'dropdown',
		'heading' => esc_html__('Columns number', 'eventerra'),
		'param_name' => 'columns',
		'value' => array(
			'1',
			'2',
			'3',
			'4',
			'5',
			'6',
			'7',
			'8',
			'9',
		),
		'dependency' => array(
			'element' => 'type',
			'value' => array('masonry','image_grid'),
		),
	));
	
	vc_add_param('vc_gallery', array(
		'type' => 'dropdown',
		'heading' => esc_html__('Images width/height ratio', 'eventerra'),
		'param_name' => 'ratio',
		'value' => array(
			'2:1' => '2:1',
			'16:9' => '16:9',
			'3:2' => '3:2',
			'4:3' => '4:3',
			'1:1' => '1:1',
			'3:4' => '3:4',
			'2:3' => '2:3',
			'9:16' => '9:16',
			'1:2' => '1:2',
		),
		'dependency' => array(
			'element' => 'type',
			'value' => array('image_grid'),
		),
	));
	
	vc_add_param('vc_gallery', array(
		'type' => 'checkbox',
		'heading' => esc_html__('Display captions', 'eventerra'),
		'param_name' => 'captions',
		'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
		'dependency' => array(
			'element' => 'type',
			'value' => array('om','sliced','masonry','image_grid'),
		),
	));
	
	/*
	vc_add_param('vc_gallery', array(
		'type' => 'checkbox',
		'heading' => esc_html__('Use hi-res images', 'eventerra'),
		'description' => esc_html__( 'Check this option of you use gallery in a row without padding and the dimendions of images is not enough. Source images also must be high resolution in this case.', 'eventerra' ),
		'param_name' => 'hires',
		'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
		'dependency' => array(
			'element' => 'type',
			'value' => array('sliced','masonry','image_grid'),
		),
	));
	*/
	
	vc_add_param('vc_gallery', array(
		'type' => 'textfield',
		'heading' => esc_html__( 'Extra class name', 'eventerra' ),
		'param_name' => 'el_class',
		'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'eventerra' )
	));

	/**
	 * Tabs
	 */
	 
  vc_remove_param("vc_tta_tabs", "style");
  vc_remove_param("vc_tta_tabs", "shape");
  //vc_remove_param("vc_tta_tabs", "color");
  vc_remove_param("vc_tta_tabs", "no_fill_content_area");
  vc_remove_param("vc_tta_tabs", "spacing");
  vc_remove_param("vc_tta_tabs", "gap");
  vc_remove_param("vc_tta_tabs", "tab_position");
  vc_remove_param("vc_tta_tabs", "alignment");
  vc_remove_param("vc_tta_tabs", "pagination_style");
  vc_remove_param("vc_tta_tabs", "pagination_color");
  vc_remove_param("vc_tta_tabs", "css");


  $params=new OMWPBScParams('vc_tta_tabs');

  $param=$params->get('color');
	$param['value']=array();
  $params->update($param);	  
  
	$params->add(array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Remove left/right margins?', 'eventerra' ),
		'description' => esc_html__( 'Using this option you can remove the gap between element and content box edge', 'eventerra' ),
		'param_name' => 'remove_margins',
		'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
	), 'color');
	
  $params->save();    
  
	/**
	 * Tour
	 */
	 
	vc_remove_param("vc_tta_tour", "style");
  vc_remove_param("vc_tta_tour", "shape");
  //vc_remove_param("vc_tta_tour", "color");
  vc_remove_param("vc_tta_tour", "no_fill_content_area");
  vc_remove_param("vc_tta_tour", "spacing");
  vc_remove_param("vc_tta_tour", "gap");
  vc_remove_param("vc_tta_tour", "tab_position");
  vc_remove_param("vc_tta_tour", "alignment");
  vc_remove_param("vc_tta_tour", "pagination_style");
  vc_remove_param("vc_tta_tour", "pagination_color");
  vc_remove_param("vc_tta_tour", "css");

  $params=new OMWPBScParams('vc_tta_tour');

  $param=$params->get('color');
	$param['value']=array();
  $params->update($param);	  
  
	$params->add(array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Remove left/right margins?', 'eventerra' ),
		'description' => esc_html__( 'Using this option you can remove the gap between element and content box edge', 'eventerra' ),
		'param_name' => 'remove_margins',
		'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
	), 'color');
	
  $params->save();   
  
	/**
	 * Accordion
	 */

  vc_remove_param("vc_tta_accordion", "style");
  vc_remove_param("vc_tta_accordion", "shape");
  //vc_remove_param("vc_tta_accordion", "color");
  vc_remove_param("vc_tta_accordion", "no_fill");
  vc_remove_param("vc_tta_accordion", "spacing");
  vc_remove_param("vc_tta_accordion", "gap");
  vc_remove_param("vc_tta_accordion", "c_icon");
  vc_remove_param("vc_tta_accordion", "c_position");
  vc_remove_param("vc_tta_accordion", "c_align");
  vc_remove_param("vc_tta_accordion", "pagination_style");
  vc_remove_param("vc_tta_accordion", "pagination_color");
  vc_remove_param("vc_tta_accordion", "css");

  $params=new OMWPBScParams('vc_tta_accordion');

  $param=$params->get('color');
	$param['value']=array();
  $params->update($param);	  
  
	$params->add(array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Remove left/right margins?', 'eventerra' ),
		'description' => esc_html__( 'Using this option you can remove the gap between element and content box edge', 'eventerra' ),
		'param_name' => 'remove_margins',
		'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
	), 'color');
	
  $params->save(); 
  	
	/**
	 * Pageable
	 */
	  
	vc_remove_param("vc_tta_pageable", "css");
	vc_remove_param("vc_tta_pageable", "pagination_style");
	vc_remove_param("vc_tta_pageable", "pagination_color");
	
  $params=new OMWPBScParams('vc_tta_pageable');

	$params->add(array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Color', 'eventerra' ),
		'param_name' => 'color',
		'value' => array(),
		'param_holder_class' => 'vc_colored-dropdown',
	), 'autoplay');

	$params->add(array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Remove left/right margins?', 'eventerra' ),
		'description' => esc_html__( 'Using this option you can remove the gap between element and content box edge', 'eventerra' ),
		'param_name' => 'remove_margins',
		'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
	), 'color');
	
  $params->save();

  /**
   * Custom Heading
   */
   
  $params=new OMWPBScParams('vc_custom_heading');

	$params->add(array(
		'type' => 'textarea',
		'heading' => esc_html__( 'Additional Text', 'eventerra' ),
		'description'  => esc_html__('Smaller size second line', 'eventerra'),
		'std' => '',
		'param_name' => 'text_additional',
	), 'text');

	$params->add(array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Apply uppercase to the text?', 'eventerra' ),
		'param_name' => 'uppercase',
		'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
	), 'text');	
	
  $param=$params->get('text');
  $param['description'].='<br/>'.sprintf(esc_html__( 'Note: you can use codes %s to colorize certain words.', 'eventerra' ), '<b>(color1)word(/color1), (color2)word(/color2), (color3)word(/color3)</b>');
  $params->update($param);

	$params->add(array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Add shadow text?', 'eventerra' ),
		'param_name' => 'add_shadow_text',
		'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
	), 'text_additional');
	
	$params->add(array(
		'type' => 'textfield',
		'heading' => esc_html__( 'Shadow text', 'eventerra' ),
		'description'  => esc_html__('Text, which will be visible as a shadow on the background', 'eventerra'),
		'param_name' => 'shadow_text',
		'dependency' => array(
			'element' => 'add_shadow_text',
			'not_empty' => true,
		),
	), 'add_shadow_text');
	
	$param=$params->get('use_theme_fonts');
	$param['std']='yes';
	$params->update($param);
	
	$params->save();

  /**
   * Button
   */
  
  $params=new OMWPBScParams('vc_btn');
  
 	$params->remove('custom_background');
  $params->remove('custom_text');
  $params->remove('shape');
  
  
  $param=$params->get('style');
  $param['value']=array(
		esc_html__('Box','eventerra') => 'classic',
		esc_html__('Plain','eventerra') => 'flat',
  );
  $param['edit_field_class'] = 'vc_col-sm-6 vc_column';
  $params->update($param);

	$params->add(array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Apply uppercase?', 'eventerra' ),
		'param_name' => 'uppercase',
		'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	), 'style');
	  
	$param=$params->get('color');
	$param['value']=array_merge(eventerra_wpb_get_std_colors(), array(esc_html__('Custom','eventerra') => 'custom'));
	$param['std']='om-accent-color-1';
	$param['description']=esc_html__( 'Select button color. In case "Plain" style is chosen this color is set to icon background.', 'eventerra' );
	$param['edit_field_class'] = 'vc_col-sm-6 vc_column vc_block_clear';
	$params->update($param);
  
	$params->add(array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Custom color', 'eventerra' ),
		'param_name' => 'custom_color',
		'description' => esc_html__( 'Select button custom color.', 'eventerra' ),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
		'dependency'  => array(
			'element' => 'color',
			'value'   => array( 'custom' )
		),
	), 'color');


	$params->add(array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Text color', 'eventerra' ),
		'param_name' => 'text_color',
		'value' => array(
			esc_html__('Default','eventerra') => 'auto',
			esc_html__('Custom','eventerra') => 'custom',
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column vc_block_clear',
	), 'custom_color');
	
	$params->add(array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Custom text color', 'eventerra' ),
		'param_name' => 'text_custom_color',
		'dependency'  => array(
			'element' => 'text_color',
			'value'   => array( 'custom' )
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	), 'text_color');
	
  $param=$params->get('size');
  $param['value']['XLarge']='xlg';
  $params->update($param);

	$params->add(array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Icon color', 'eventerra' ),
		'param_name' => 'icon_color',
		'value' => array(
			esc_html__('Default','eventerra') => 'auto',
			esc_html__('Custom','eventerra') => 'custom',
		),
		'dependency'  => array(
			'element' => 'add_icon',
			'value' => 'true',
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column vc_block_clear',
	), 'i_align');
	
	$params->add(array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Custom icon color', 'eventerra' ),
		'param_name' => 'icon_custom_color',
		'dependency'  => array(
			'element' => 'icon_color',
			'value'   => array( 'custom' )
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	), 'icon_color');

  $param=$params->get('i_type');
  $param['value']=eventerra_wpb_remove_pixel_icons($param['value']);
  $params->update($param);

	/*
	$params->add(array(
		'type' => 'om_get_code',
		'heading' => esc_html__( 'Get code', 'eventerra' ),
		'param_name' => 'code',
		'description' => esc_html__( 'If you wish to use button shortcode somewhere out of Visual Composer or insert it into text inline, you can generate the code which you can use separately.', 'eventerra' )
	));
	*/
	
  $params->save();

	/**
	 * CTA Button
	 */

  $params=new OMWPBScParams('vc_cta');
  $params->remove('use_custom_fonts_h2');
  $params->removeIntegratedShortcode('vc_custom_heading', 'h2_');
  $params->remove('use_custom_fonts_h4');
  $params->removeIntegratedShortcode('vc_custom_heading', 'h4_');
  $params->remove('shape');
  $params->remove('color');
  $params->remove('style');
  $params->remove('css');
  
  $param=$params->get('custom_background');
  unset($param['dependency']);
  $params->update($param);
  $param=$params->get('custom_text');
	unset($param['dependency']);
  $params->update($param);

	$params->add(array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Add background stripes?', 'eventerra' ),
		'param_name' => 'add_stripes',
		'std'=>'yes',
		'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	), 'custom_background');
	  
  $param=$params->get('add_button');
  foreach($param['value'] as $k=>$v) {
  	if($v == 'top') {
  		unset($param['value'][$k]);
  		break;
  	}
  }
  $param['std']='';
  $params->update($param);
  $params->removeIntegratedShortcode('vc_btn', 'btn_');

	$params->add(array(
		'type' => 'textfield',
		'heading' => esc_html__( 'Text', 'eventerra' ),
		'param_name' => 'btn_title',
		'dependency'  => array(
			'element' => 'add_button',
			'not_empty'   => true
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
		'group' => esc_html__( 'Button', 'eventerra' ),
	));
	
	$params->add(array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Apply uppercase?', 'eventerra' ),
		'param_name' => 'btn_uppercase',
		'std'=>'yes',
		'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
		'dependency'  => array(
			'element' => 'add_button',
			'not_empty'   => true
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
		'group' => esc_html__( 'Button', 'eventerra' ),
	));
	
	$params->add(array(
		'type' => 'vc_link',
		'heading' => esc_html__( 'URL (Link)', 'eventerra' ),
		'description' => esc_html__( 'Add link to button.', 'eventerra' ),
		'param_name' => 'btn_link',
		'dependency'  => array(
			'element' => 'add_button',
			'not_empty'   => true
		),
		'group' => esc_html__( 'Button', 'eventerra' ),
	)); 
	
	$params->add(array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Color', 'eventerra' ),
		'description' => esc_html__( 'Select button color.', 'eventerra' ),
		'param_name' => 'btn_color',
		'value' => array_merge(eventerra_wpb_get_std_colors(), array(esc_html__('Custom','eventerra') => 'custom')),
		'dependency'  => array(
			'element' => 'add_button',
			'not_empty'   => true
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column vc_block_clear',
		'param_holder_class' => 'vc_colored-dropdown',
		'group' => esc_html__( 'Button', 'eventerra' ),
	)); 

	$params->add(array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Custom color', 'eventerra' ),
		'param_name' => 'btn_custom_color',
		'description' => esc_html__( 'Select custom color for button.', 'eventerra' ),
		'dependency'  => array(
			'element' => 'btn_color',
			'value'   => array( 'custom' )
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
		'group' => esc_html__( 'Button', 'eventerra' ),
	));

	$params->add(array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Text color', 'eventerra' ),
		'param_name' => 'btn_text_color',
		'value' => array(
			esc_html__('Default','eventerra') => 'auto',
			esc_html__('Custom','eventerra') => 'custom',
		),
		'dependency'  => array(
			'element' => 'add_button',
			'not_empty'   => true
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column vc_block_clear',
		'group' => esc_html__( 'Button', 'eventerra' ),
	));
	
	$params->add(array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Custom text color', 'eventerra' ),
		'param_name' => 'btn_text_custom_color',
		'dependency'  => array(
			'element' => 'btn_text_color',
			'value'   => array( 'custom' )
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
		'group' => esc_html__( 'Button', 'eventerra' ),
	));	

	$params->add(array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Remove left/right margins?', 'eventerra' ),
		'description' => esc_html__( 'Using this option you can remove the gap between element and content box edge', 'eventerra' ),
		'param_name' => 'remove_margins',
		'std'=>'',
		'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
	), 'custom_text');
	
	$params->remove('content');
	$params->remove('add_icon');
	$params->remove('i_on_border');
	$params->removeIntegratedShortcode('vc_icon', 'i_');

  
  $params->save();
    				 
	/**
	 * Video
	 */

	$params=new OMWPBScParams('vc_video');

	$params->add(array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Remove left/right margins?', 'eventerra' ),
		'description' => esc_html__( 'Using this option you can remove the gap between element and content box edge', 'eventerra' ),
		'param_name' => 'remove_margins',
		'std'=>'',
		'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
		'dependency'  => array(
			'element' => 'el_width',
			'value'   => array( '100' )
		),
	), 'el_width');
	
	$params->save();

	/**
	 * GMaps
	 */
	
	$params=new OMWPBScParams('vc_gmaps');

	$params->add(array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Remove left/right margins?', 'eventerra' ),
		'description' => esc_html__( 'Using this option you can remove the gap between element and content box edge', 'eventerra' ),
		'param_name' => 'remove_margins',
		'std'=>'',
		'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
	), 'size');
	
	$params->save();


	/**
	 * Pie charts
	 */

  $params=new OMWPBScParams('vc_pie');

	$params->add(array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Pie label inside circle', 'eventerra' ),
		'param_name' => 'label_type',
		'value' => array(
			esc_html__('Number','eventerra') => 'number',
			esc_html__('Display widget title','eventerra') => 'title',
			esc_html__('Icon','eventerra') => 'icon',
		),
	), 'value');
	
  $param=$params->get('label_value');
  $param['dependency'] = array(
		'element' => 'label_type',
		'value'   => array( 'number' )
	);
  $params->update($param);

  $param=$params->get('units');
  $param['dependency'] = array(
		'element' => 'label_type',
		'value'   => array( 'number' )
	);
  $params->update($param);
  		 
	
	$tmp=eventerra_wpb_icon_params(false, array(
			'element' => 'label_type',
			'value'   => array( 'icon' )
	));
	$after='label_type';
	foreach($tmp as $v) {
		$params->add($v, $after);
		$after=$v['param_name'];
	}

  $param=$params->get('color');
  $param['edit_field_class'] = 'vc_col-sm-6 vc_column vc_block_clear';
  $params->update($param);	
  
  $param=$params->get('custom_color');
  $param['edit_field_class'] = 'vc_col-sm-6 vc_column';
  $params->update($param);	

	$params->add(array(
		'type' => 'textfield',
		'heading' => esc_html__( 'Font size', 'eventerra' ),
		'param_name' => 'font_size',
		'description'  => esc_html__('Specify custom label font size or leave empty for default size', 'eventerra'),
	), 'custom_color');
	
	$params->add(array(
		'type' => 'textfield',
		'heading' => esc_html__( 'Width', 'eventerra' ),
		'param_name' => 'width',
		'description'  => esc_html__('Leave this field blank for auto width or specify maximum width', 'eventerra'),
	), 'font_size');
		  
	$params->save();

  /**
   * Round Chart
   */
   
  $params=new OMWPBScParams('vc_round_chart');
	
  $param=$params->get('style');
  $param['value']=array(
  	esc_html__('Preset colors','eventerra') => 'flat',
  	esc_html__('Custom colors','eventerra') => 'custom',
  );
  $params->update($param);

	$params->add(array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Maximum width', 'eventerra' ),
		'value' => array(
	  	esc_html__('100%','eventerra') => '100',
	  	esc_html__('90%','eventerra') => '90',
	  	esc_html__('80%','eventerra') => '80',
	  	esc_html__('70%','eventerra') => '70',
	  	esc_html__('60%','eventerra') => '60',
	  	esc_html__('50%','eventerra') => '50',
	  	esc_html__('40%','eventerra') => '40',
	  	esc_html__('30%','eventerra') => '30',
		),
		'std' => '100',
		'param_name' => 'max_width',
		'description'  => esc_html__('Specify maximum width of the chart', 'eventerra'),
	), 'animation');
	  
	$params->save();

  /**
   * Line Chart
   */
   
  $params=new OMWPBScParams('vc_line_chart');
	
  $param=$params->get('style');
  $param['value']=array(
  	esc_html__('Preset colors','eventerra') => 'flat',
  	esc_html__('Custom colors','eventerra') => 'custom',
  );
  $params->update($param);

	$params->add(array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'Width', 'eventerra' ),
		'value' => array(
	  	esc_html__('100%','eventerra') => '100',
	  	esc_html__('90%','eventerra') => '90',
	  	esc_html__('80%','eventerra') => '80',
	  	esc_html__('70%','eventerra') => '70',
	  	esc_html__('60%','eventerra') => '60',
	  	esc_html__('50%','eventerra') => '50',
	  	esc_html__('40%','eventerra') => '40',
	  	esc_html__('30%','eventerra') => '30',
		),
		'std' => '100',
		'param_name' => 'max_width',
		'description'  => esc_html__('Specify maximum width of the chart', 'eventerra'),
	), 'animation');
			  
	$params->save();

	/**
	 * Empty Space
	 */
	 
	$params=new OMWPBScParams('vc_empty_space');
	
	$params->add(array(
		'type' => 'checkbox',
		'heading' => esc_html__( 'Hide on mobile devices', 'eventerra' ),
		'value' => array( esc_html__( 'Yes, please', 'eventerra' ) => 'yes' ),
		'param_name' => 'mobile_hide',
	), 'height');
			  
	$params->save();
	 				
	/**
	 * Animation
	 */

	$css_animation_delay = array(
		'type' => 'textfield',
		'heading' => esc_html__( 'Delay before CSS Animation starts (milliseconds)', 'eventerra' ),
		'param_name' => 'css_animation_delay',
	);

	$css_animation_delay_elements = array(
		'vc_row',
		'vc_column',
		'vc_column_inner',
	);

	foreach($css_animation_delay_elements as $element) {
		$params=new OMWPBScParams($element);
		$params->add($css_animation_delay, 'css_animation');
		$params->save();
	}

	$param = WPBMap::getParam('vc_custom_heading', 'css_animation');
	$param['settings']['custom'][]=array(
		'label' => esc_html__('Custom', 'eventerra'),
		'values' => array(
			esc_html__( 'Custom animation for this element', 'eventerra' )  => 'custom',
		)
	);
	WPBMap::mutateParam('vc_custom_heading', $param);

	/**
	 * Adding "Theme Color" option to some shortcodes.
	 */
	
	$theme_color=array(
		esc_html__('Theme Accent Color 1', 'eventerra') => 'om-accent-color-1',
		esc_html__('Theme Accent Color 2', 'eventerra') => 'om-accent-color-2',
		esc_html__('Theme Accent Color 3', 'eventerra') => 'om-accent-color-3',
	);

  $param = WPBMap::getParam('vc_icon', 'color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_icon', $param); 
  
  $param = WPBMap::getParam('vc_icon', 'background_color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_icon', $param); 

  $param = WPBMap::getParam('vc_separator', 'color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_separator', $param);
  
  $param = WPBMap::getParam('vc_text_separator', 'color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_text_separator', $param);
  
  $param = WPBMap::getParam('vc_message', 'message_box_color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_message', $param); 
  
  $param = WPBMap::getParam('vc_toggle', 'color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_toggle', $param); 

  $param = WPBMap::getParam('vc_tta_tabs', 'color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_tta_tabs', $param); 
  
  $param = WPBMap::getParam('vc_tta_tour', 'color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_tta_tour', $param); 

  $param = WPBMap::getParam('vc_tta_accordion', 'color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_tta_accordion', $param); 

  $param = WPBMap::getParam('vc_tta_pageable', 'color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_tta_pageable', $param); 
  
	///////
  
  $param = WPBMap::getParam('vc_single_image', 'border_color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_single_image', $param);
  
  $param = WPBMap::getParam('vc_btn', 'color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_btn', $param); 
  
  $param = WPBMap::getParam('vc_progress_bar', 'bgcolor');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_progress_bar', $param);
  
  $param = WPBMap::getParam('vc_pie', 'color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_pie', $param); 

  
  $param = WPBMap::getParam('vc_cta', 'btn_color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_cta', $param); 
   
  
}
