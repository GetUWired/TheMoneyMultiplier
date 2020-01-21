<?php

/* Load parent theme stylesheet */
function my_theme_enqueue_styles() {
    $theme_version = et_get_theme_version();
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css', array(), $theme_version);
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
 
/* Add query string to child theme stylesheet */
function add_stylesheet_querystring() {
    $style = get_stylesheet_directory() . '/style.css';
    $cache_buster = $cache_buster = date("YmdHi", filemtime( $style ) );
    wp_dequeue_style( 'divi-style' );
    wp_deregister_style( 'divi-style' );
    wp_enqueue_style('divi-child', get_stylesheet_directory_uri() . "/style.css", array(), $cache_buster);
}
add_action('wp_enqueue_scripts', 'add_stylesheet_querystring', 15);