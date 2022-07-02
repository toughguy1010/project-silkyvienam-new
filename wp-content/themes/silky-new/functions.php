<?php
/**
 * UnderStrap functions and definitions
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// UnderStrap's includes directory.
$understrap_inc_dir = 'inc';

// Array of files to include.
$understrap_includes = array(
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/customizer.php',                      // Customizer additions.
	'/custom-comments.php',                 // Custom Comments file.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker. Trying to get deeper navigation? Check out: https://github.com/understrap/understrap/issues/567.
	'/editor.php',                          // Load Editor functions.
	'/block-editor.php',                    // Load Block Editor functions.
	'/deprecated.php',                      // Load deprecated functions.
);

// Load WooCommerce functions if WooCommerce is activated.
if ( class_exists( 'WooCommerce' ) ) {
	$understrap_includes[] = '/woocommerce.php';
}

// Load Jetpack compatibility file if Jetpack is activiated.
if ( class_exists( 'Jetpack' ) ) {
	$understrap_includes[] = '/jetpack.php';
}

// Include files.
foreach ( $understrap_includes as $file ) {
	require_once get_theme_file_path( $understrap_inc_dir . $file );
}


// DEFINE
define('THEME_URI',get_theme_file_uri() );
// HOOK
function get_homepage_sytle(){
    // register
  
    wp_register_style('homepage_style',THEME_URI.'/css/homepage.css');
    // enqueue
    wp_enqueue_style('homepage_style');
}
function get_about_style(){
    // register
  
    wp_register_style('about_style',THEME_URI.'/css/about.css');
    // enqueue
    wp_enqueue_style('about_style');
}
function get_blog_style(){
     // register
  
     wp_register_style('blog_style',THEME_URI.'/css/blog.css');
     // enqueue
     wp_enqueue_style('blog_style');
}
function get_header_script(){
    wp_register_script('header_script',THEME_URI.'/js/header.js' );
    wp_enqueue_script('header_script');
}


function get_blog_script(){
    wp_register_script('blog_script', THEME_URI. '/js/blog.js' );
    wp_enqueue_script('blog_script');
}
function get_product_style(){
    wp_register_style('product_style', THEME_URI.'/css/product.css');
    wp_enqueue_style('product_style');
}
function get_product_script(){
    wp_register_script('product_script', THEME_URI. '/js/product.js' );
    wp_enqueue_script('product_script');
}
function get_detail_product_style(){
    wp_register_style('detail_product_style', THEME_URI.'/css/detail-product.css');
    wp_enqueue_style('detail_product_style');
}
// hook style
add_action('homepage_style','get_homepage_sytle');
add_action('about_style','get_about_style');
add_action('blog-style','get_blog_style');
add_action('product_style','get_product_style');
add_action('detail_product_style','get_detail_product_style');
// hook script
add_action('product_style','get_product_script');
add_action('wp_head','get_header_script');
add_action('blog-style','get_blog_script');
require get_template_directory() . '/inc/ajax/zenzweb-ajax.php';
// add_action('woocommerce_after_checkout_form', function() {
add_action('woocommerce_checkout_before_order_review', function() {
    get_template_part('global-templates/part','order-product-sumary');
    }, 99);


  