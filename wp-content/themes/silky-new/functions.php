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


  // Minimum CSS to remove +/- default buttons on input field type number
add_action( 'wp_head' , 'custom_quantity_fields_css' );
function custom_quantity_fields_css(){
    ?>
    <style>
    .quantity input::-webkit-outer-spin-button,
    .quantity input::-webkit-inner-spin-button {
        display: none;
        margin: 0;
    }
    .quantity input.qty {
        appearance: textfield;
        -webkit-appearance: none;
        -moz-appearance: textfield;
    }
    </style>
    <?php
}


add_action( 'wp_footer' , 'custom_quantity_fields_script' );
function custom_quantity_fields_script(){
    ?>
    <script type='text/javascript'>
    jQuery( function( $ ) {
        if ( ! String.prototype.getDecimals ) {
            String.prototype.getDecimals = function() {
                var num = this,
                    match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                if ( ! match ) {
                    return 0;
                }
                return Math.max( 0, ( match[1] ? match[1].length : 0 ) - ( match[2] ? +match[2] : 0 ) );
            }
        }
        // Quantity "plus" and "minus" buttons
        $( document.body ).on( 'click', '.plus, .minus', function() {
            var $qty        = $( this ).closest( '.quantity' ).find( '.qty'),
                currentVal  = parseFloat( $qty.val() ),
                max         = parseFloat( $qty.attr( 'max' ) ),
                min         = parseFloat( $qty.attr( 'min' ) ),
                step        = $qty.attr( 'step' );

            // Format values
            if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
            if ( max === '' || max === 'NaN' ) max = '';
            if ( min === '' || min === 'NaN' ) min = 0;
            if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

            // Change the value
            if ( $( this ).is( '.plus' ) ) {
                if ( max && ( currentVal >= max ) ) {
                    $qty.val( max );
                } else {
                    $qty.val( ( currentVal + parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            } else {
                if ( min && ( currentVal <= min ) ) {
                    $qty.val( min );
                } else if ( currentVal > 0 ) {
                    $qty.val( ( currentVal - parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            }

            // Trigger change event
            $qty.trigger( 'change' );
        });
    });
    </script>
    <?php
}



// function excerpt_in_cart($cart_item_html, $product_data) {
//     global $_product;
    
//     $excerpt = get_the_excerpt($product_data['product_id']);
//     $excerpt = substr($excerpt, 0, 80);
    
//     echo $cart_item_html . '<br><p class="shortDescription">' . $excerpt . '...' . '</p>';
//     }
    
//     add_filter('woocommerce_cart_item_name', 'excerpt_in_cart', 40, 2);