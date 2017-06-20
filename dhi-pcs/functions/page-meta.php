<?php

$eventerra_meta_box=array();

$eventerra_meta_box['blog'] = array (
	'id' => 'om-page-meta-box-blog',
	'name' => esc_html__('Blog options', 'eventerra'),
	'fields' => array (
		array ( "name" => esc_html__('Blog Layout','eventerra'),
				"desc" => '',
				"id" => "eventerra_blog_layout",
				"type" => "select",
				"std" => 'small',
				'options' => array(
					'small' => esc_html__('Small thumbnails', 'eventerra'),
					'large' => esc_html__('Large thumbnails', 'eventerra'),
				)
		),
		
		array ( "name" => esc_html__('Cut excerpt within thumbnail height','eventerra'),
				"desc" => '',
				"id" => "eventerra_blog_grid_cut",
				"type" => "select",
				"std" => '',
				'options' => array(
					'0' => esc_html__('Do not cut', 'eventerra'),
					'1' => esc_html__('Yes, please', 'eventerra'),
				),
				'code' => '
					<script>
						jQuery(function($){
							$("#'.'eventerra_blog_layout").change(function(){
								if($("#'.'eventerra_blog_layout").val() == "small") {
									$("#'.'eventerra_blog_grid_cut").parents("tr").show();
								} else {
									$("#'.'eventerra_blog_grid_cut").parents("tr").hide();
								}
							}).change();
						});
					</script>
				', 
		),
			
		array ( "name" => esc_html__('Categories to display','eventerra'),
				"desc" => '',
				"id" => "eventerra_blog_categories",
				"type" => "categories_list_multiple",
				"std" => '',
		),
		
	),
);

if(function_exists('eventerra_add_common_meta_boxes')) {
	eventerra_add_common_meta_boxes($eventerra_meta_box, array('pagetitle', 'slider', 'sidebar'), 'om-page-meta-box-');
}

omfw_Framework::meta_box('page', $eventerra_meta_box, array(
	'enqueue_scripts' => EVENTERRA_TEMPLATE_DIR_URI . '/admin/js/page-meta.js',
));