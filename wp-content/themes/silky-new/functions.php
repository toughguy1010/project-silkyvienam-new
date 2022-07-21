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

function yourprefix_get_menu_items($location_id){
    $menu_items = get_registered_nav_menus();
    $menus = wp_get_nav_menus();
   
    $menu_locations = get_nav_menu_locations();

    if (isset($menu_locations[ $location_id ]) && $menu_locations[ $location_id ]!=0) {
        foreach ($menus as $menu) {
            if ($menu->term_id == $menu_locations[ $location_id ]) {
                $menu_items = wp_get_nav_menu_items($menu);
                break;
            }
        }
        return $menu_items;
    }
}
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


    add_shortcode( 'coupon_field', function() {

        $output  = '<div id="redeem-coupon">
        <div><img src="'.get_template_directory_uri().'/assets/coupon-icon.svg'.'"/> If you have a coupon code, please apply it below.</div>
        <input type="text" name="coupon" id="coupon" class = "input-coupon"/>
        <button class="redeem-coupon" name="redeem-coupon">'.__('Nhập Voucher').'</button>';
    
        return $output . '</div>';
    } );

    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 ); 
    add_action( 'woocommerce_after_checkout_billing_form', function() {
        echo do_shortcode('[coupon_field]');
      } );
    // add_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form',99 );
   
    // add_action( 'woocommerce_checkout_before_customer_details', 'woocommerce_checkout_coupon_form', 50 ); 
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




remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
add_action('woocommerce_cart_is_empty','custom_empty_cart_message',10);
function custom_empty_cart_message(){
    echo '<div class = "custom_cart-empty_wrapper"> ';
	echo '<p class="custom_cart-empty_mess woocommerce-info">' . wp_kses_post( apply_filters( 'custom_empty_cart_message', __( 'Your cart is currently empty.', 'woocommerce' ) ) ) . '</p>';

}
function pagination_nav() {
    global $wp_query;
 
    if ( $wp_query->max_num_pages > 1 ) { ?>
        <nav class="pagination" role="navigation">
            <div class="nav-previous"><?php next_posts_link( '&larr; Older posts' ); ?></div>
            <div class="nav-next"><?php previous_posts_link( 'Newer posts &rarr;' ); ?></div>
        </nav>
<?php }
}




if( ! function_exists( 'zwc_parse_page_id' ) ){
	function zwc_parse_page_id(){
		if( is_page() ){
			global $post;
			return $post->ID;
		}

		if( is_tax() ){
			$cat = get_queried_object();

			$cateFields = get_field_objects( $cat->taxonomy.'_'.$cat->term_id );
			$cat_type = $cateFields['zwc_product_cat_type']['value'];

			$type = $cat_type['value'];

			if( $type == 'collection' || $type == 'shop' ){
	      return $type;
	    }

			return $cat->term_id;
		}

		if( 'product' == get_post_type() ){
			global $post;
			$cat = get_the_terms($post->ID,'product_cat');
			$cat = $cat[0];

			$cateFields = get_field_objects( $cat->taxonomy.'_'.$cat->term_id );
			$cat_type = $cateFields['zwc_product_cat_type']['value'];

			$type = $cat_type['value'];

			if( $type == 'collection' || $type == 'shop' ){
				return $type;
			}
		}

		return false;
	}
}



if( !function_exists('zwc_parse_text_to_color') ){{
    function zwc_parse_text_to_color($ternid){
      $homeID = get_option('page_on_front');
        $homeFields = get_field_objects( $homeID );
  
      $colors = $homeFields['zwc_product_parse_color']['value'];
  
      foreach ($colors as $key => $color) {
        if( $color['color'] == $ternid ){
          return $color['color_code'];
        }
      }
    }
  }}
  

  /** 
 * Posts per page for CPT archive
 * prevent 404 if posts per page on main query
 * is greater than the posts per page for product cpt archive
 *
 * thanks to https://sridharkatakam.com/ for improved solution!
 */

function prefix_change_cat_product_per_page( $query ) {
        
    // var_dump($query->is_tax, $query->queried_object->parent == 34);
    //* for cpt or any post type main archive
    if ( $query->is_main_query() && $query->is_tax && $query->queried_object && $query->queried_object->parent == 34 ) {
        $query->set( 'posts_per_page', '2' );
        // var_dump("bbbbbb");
    }

}
add_action( 'pre_get_posts', 'prefix_change_cat_product_per_page' );




add_filter('woocommerce_catalog_orderby', 'wc_customize_product_sorting');

function wc_customize_product_sorting($sorting_options){
    $sorting_options = array(
        'menu_order' => __( 'Mặc định', 'woocommerce' ),
        'popularity' => __( 'Phổ biến', 'woocommerce' ),
        'rating'     => __( 'Đánh giá', 'woocommerce' ),
        'date'       => __( 'Mới nhất', 'woocommerce' ),
        'price'      => __( 'Giá từ thấp đến cao', 'woocommerce' ),
        'price-desc' => __( 'Giá từ cao đến thấp', 'woocommerce' ),
    );

    return $sorting_options;
}
