<?php

/**
 * Config
 */

function eventerra_ompn_plugin_config($config) {
	
	$config['post_slug']='speakers';
	
	$config['post_type_labels'] = array(
			'name' => esc_html__( 'Speakers','eventerra'),
			'singular_name' => esc_html__( 'Speaker','eventerra' ),
			'add_new' => esc_html__('Add New','eventerra'),
			'add_new_item' => esc_html__('Add New Speaker','eventerra'),
			'edit_item' => esc_html__('Edit Speaker','eventerra'),
			'new_item' => esc_html__('New Speaker','eventerra'),
			'view_item' => esc_html__('View Speaker','eventerra'),
			'search_items' => esc_html__('Search Speakers','eventerra'),
			'not_found' =>  esc_html__('No speakers found','eventerra'),
			'not_found_in_trash' => esc_html__('No speakers found in Trash','eventerra'), 
			'parent_item_colon' => '',
	);
	$config['post_taxonomies_labels'] = array(
			'name' => esc_html__( 'Speakers Categories', 'eventerra' ),
			'singular_name' => esc_html__( 'Speakers Category', 'eventerra' ),
			'search_items' =>  esc_html__( 'Search Speakers Categories', 'eventerra' ),
			'popular_items' => esc_html__( 'Popular Speakers Categories', 'eventerra' ),
			'all_items' => esc_html__( 'All Speakers Categories', 'eventerra' ),
			'parent_item' => esc_html__( 'Parent Speakers Category', 'eventerra' ),
			'parent_item_colon' => esc_html__( 'Parent Speakers Category:', 'eventerra' ),
			'edit_item' => esc_html__( 'Edit Speakers Category', 'eventerra' ), 
			'update_item' => esc_html__( 'Update Speakers Category', 'eventerra' ),
			'add_new_item' => esc_html__( 'Add New Speakers Category', 'eventerra' ),
			'new_item_name' => esc_html__( 'New Speakers Category Name', 'eventerra' ),
			'separate_items_with_commas' => esc_html__( 'Separate speakers categories with commas', 'eventerra' ),
			'add_or_remove_items' => esc_html__( 'Add or remove speakers categories', 'eventerra' ),
			'choose_from_most_used' => esc_html__( 'Choose from the most used speakers categories', 'eventerra' ),
			'menu_name' => esc_html__( 'Speakers Categories', 'eventerra' ),
	);
	$config['post_extra_labels'] = array(
			'sort' => esc_html__('Sort Speakers','eventerra'),
			'sort_full' => esc_html__('Sort Speakers by drag-n-drop. Items at the top will appear first.','eventerra'),
			'details' => esc_html__('Speaker Details', 'eventerra'),
	);
			
	return $config;
	
}
add_filter('ompn_config','eventerra_ompn_plugin_config');
