<?php

$eventerra_meta_box=array();

if(function_exists('eventerra_add_common_meta_boxes')) {
	eventerra_add_common_meta_boxes($eventerra_meta_box, array('pagetitle', 'slider', 'sidebar'), 'om-tc_events-meta-box-');
}

omfw_Framework::meta_box('tc_events', $eventerra_meta_box);