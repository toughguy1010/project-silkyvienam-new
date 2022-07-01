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
// product title
add_filter( 'silky_filter-product-title_name', 'product_title' );

function product_title( $title ) {
  return $title;
}
// product img

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);


/**
 * WooCommerce Loop Product Thumbs
 **/

 if ( ! function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) {

	function woocommerce_template_loop_product_thumbnail() {
		echo woocommerce_get_product_thumbnail();
	} 
 }

 function woocommerce_get_product_thumbnail( $size = 'woocommerce_thumbnail', $attr = array(), $placeholder = true ) {
    global $product;

   

    if ( ! is_array( $attr ) ) {
        $attr = array();
    }

    if ( ! is_bool( $placeholder ) ) {
        $placeholder = true;
    }

    $attr['class'] = 'img-product-respon';
    $image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );
    return $product ? $product->get_image( $image_size, $attr, $placeholder ) : '';
}


// function render_product_link(){
//     global $product;

// 		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

// 		echo '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
// }

// add_action( 'woocommerce_before_shop_loop_item', 'render_product_link', 10 );
require get_template_directory() . '/inc/ajax/zenzweb-ajax.php';
// add_action('woocommerce_after_checkout_form', function() {
add_action('woocommerce_checkout_before_order_review', function() {
    get_template_part('global-templates/part','order-product-sumary');
    }, 99);

  
// 
remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30);
add_action('woocommerce_after_single_product_summary','woocommerce_template_single_add_to_cart',1 );
remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 20 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_simple_add_to_cart', 10 );
add_filter( 'woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_home_text' );
function wcc_change_breadcrumb_home_text( $defaults ) {
    // Change the breadcrumb home text from 'Home' to 'Apartment'
	$defaults['home'] = 'Apartment';
	return $defaults;
}
// remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
// add_action('output_btn', 'woocommerce_single_variation_add_to_cart_button',1);
// 	function woocommerce_single_variation_add_to_cart_button() {
// 		wc_get_template( 'single-product/add-to-cart/variation-add-to-cart-button.php' );
// 	}; 


// add_action( 'woocommerce_before_shop_loop_item_title', 'add_on_hover_shop_loop_image' ) ; 
// // end if
// function add_on_hover_shop_loop_image() {

//     $gallery_image_ids = wc_get_product()->get_gallery_image_ids();
//     if ($gallery_image_ids) {
//         $image_id = $gallery_image_ids[0] ; 

//         if ( $image_id ) {

//             echo wp_get_attachment_image( $image_id ) ;

//         } else {  //assuming not all products have galleries set

//             echo wp_get_attachment_image( wc_get_product()->get_image_id() ) ; 

//         }
//     }
    

// }        

//   add_shortcode('woof', array($this, 'woof_shortcode'));
//   if (get_option('woof_try_ajax', 0) AND!isset($_REQUEST['woof_products_doing'])AND!$is_wc_shortcode) {
//     echo '<div class="woocommerce woocommerce-page woof_shortcode_output">';
//     $shortcode_txt = "woof_products is_ajax=1";
//     if ($this->is_really_current_term_exists()) {
//         $o = $this->get_really_current_term();
//         $shortcode_txt = "woof_products taxonomies={$o->taxonomy}:{$o->term_id} is_ajax=1 predict_ids_and_continue=1";
//         $_REQUEST['WOOF_IS_TAX_PAGE'] = $o->taxonomy;
//     }
//     echo '<div id="woof_results_by_ajax" data-shortcode="' . $shortcode_txt . '">';
// }
function wp_shortcode( $atts ) {
    var_dump("1111111111");
    extract( shortcode_atts( array(
        'foo' => 'something',
        'bar' => 'something else',
    ), $atts ) );


    return "foo = {$foo}";
    // return your_function();
}
add_shortcode( 'your-shortcode', 'wp_shortcode' );