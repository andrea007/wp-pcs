<?php

function eventerra_child_textdomain() {
	load_child_theme_textdomain( 'eventerra', get_stylesheet_directory() . '/languages/parent' );
	load_child_theme_textdomain( 'eventerra-child', get_stylesheet_directory() . '/languages/child' );
}
add_action( 'after_setup_theme', 'eventerra_child_textdomain' );

function eventerra_child_enqueue_styles() {
	wp_enqueue_style( 'eventerra-parent-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme( get_template() )->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'eventerra_child_enqueue_styles' );