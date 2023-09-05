<?php

function add_theme_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
}
function register_my_menus() {
  register_nav_menus(
    array(
		'about' => 'about',
		'posts' => 'posts',
     )
   );
 }

function add_last_nav_item($items) {
  return  $items .= "<li>User: " .$_SESSION["User"]. "</li>";
}
function wpdocs_setup_theme() {
  add_theme_support( 'post-thumbnails' );
  set_post_thumbnail_size( 150, 150 , true);
}
add_action( 'after_setup_theme', 'wpdocs_setup_theme' );
add_filter('wp_nav_menu_items','add_last_nav_item');
function my_function_admin_bar(){ return false; }
add_filter( 'show_admin_bar' , 'my_function_admin_bar');
add_action( 'wp_enqueue_scripts', 'register_my_menus' );
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );