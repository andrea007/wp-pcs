<?php

$eventerra_meta_box=array(

);

if(function_exists('eventerra_add_common_meta_boxes')) {
	eventerra_add_common_meta_boxes($eventerra_meta_box, array('pagetitle', 'slider', 'sidebar'), 'om-post-meta-box-');
}

omfw_Framework::meta_box('post', $eventerra_meta_box, array(
	//'enqueue_scripts' => EVENTERRA_TEMPLATE_DIR_URI . '/admin/js/post-meta.js',
));
