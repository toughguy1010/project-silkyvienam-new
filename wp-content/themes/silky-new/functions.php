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
add_action('homepage_style','get_homepage_sytle',0);
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
        <div><img src="'.get_template_directory_uri().'/assets/coupon-icon.svg'.'"/> Nếu bạn có mã giảm giá, hãy nhập vào đây</div>
        <input type="text" name="coupon" id="coupon" class = "input-coupon"/>
        <button class="redeem-coupon" name="redeem-coupon">'.__('Nhập Voucher').'</button>';
    
        return $output . '</div>';
    },999);



    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 ); 
    add_action( 'coupon', function() {
        echo do_shortcode('[coupon_field]');
      } ,999);
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




// if( ! function_exists( 'zwc_parse_page_id' ) ){
// 	function zwc_parse_page_id(){
// 		if( is_page() ){
// 			global $post;
// 			return $post->ID;
// 		}

// 		if( is_tax() ){
// 			$cat = get_queried_object();

// 			$cateFields = get_field_objects( $cat->taxonomy.'_'.$cat->term_id );
// 			$cat_type = $cateFields['zwc_product_cat_type']['value'];

// 			$type = $cat_type['value'];

// 			if( $type == 'collection' || $type == 'shop' ){
// 	      return $type;
// 	    }

// 			return $cat->term_id;
// 		}

// 		if( 'product' == get_post_type() ){
// 			global $post;
// 			$cat = get_the_terms($post->ID,'product_cat');
// 			$cat = $cat[0];

// 			$cateFields = get_field_objects( $cat->taxonomy.'_'.$cat->term_id );
// 			$cat_type = $cateFields['zwc_product_cat_type']['value'];

// 			$type = $cat_type['value'];

// 			if( $type == 'collection' || $type == 'shop' ){
// 				return $type;
// 			}
// 		}

// 		return false;
// 	}
// }



// if( !function_exists('zwc_parse_text_to_color') ){{
//     function zwc_parse_text_to_color($ternid){
//       $homeID = get_option('page_on_front');
//         $homeFields = get_field_objects( $homeID );
  
//       $colors = $homeFields['zwc_product_parse_color']['value'];
  
//       foreach ($colors as $key => $color) {
//         if( $color['color'] == $ternid ){
//           return $color['color_code'];
//         }
//       }
//     }
//   }}
  

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
  
    }

}
add_action( 'pre_get_posts', 'prefix_change_cat_product_per_page' );




add_filter('woocommerce_catalog_orderby', 'wc_customize_product_sorting');

function wc_customize_product_sorting($sorting_options){
    $sorting_options = array(
        'menu_order' => __( 'Mặc định', 'woocommerce' ),
        // 'popularity' => __( 'Phổ biến', 'woocommerce' ),
        // 'rating'     => __( 'Đánh giá', 'woocommerce' ),
        // 'date'       => __( 'Mới nhất', 'woocommerce' ),
        'price'      => __( 'Giá từ thấp đến cao', 'woocommerce' ),
        'price-desc' => __( 'Giá từ cao đến thấp', 'woocommerce' ),
    );

    return $sorting_options;
}




// );






add_filter( 'woocommerce_should_load_paypal_standard', '__return_true' );   

// add_filter( 'woocommerce_currencies', 'add_my_currency' );
 
// function add_my_currency( $currencies ) {
//      $currencies['vnd'] = __( 'VNĐ', 'woocommerce' );
//      return $currencies;
// }


add_filter('wp_head', function() {
    $lang = get_locale();
    global $WOOCS;
    switch ($lang)
    {
        case 'vi':
            $WOOCS->set_currency('VND');
            break;
        case 'en_US':
            $WOOCS->set_currency('USD');
            break;
        default:
            $WOOCS->set_currency('VND');
            break;
    }
});
add_filter('woocommerce_cart_item_subtotal', 'checkout_review_order_remove_link', 1000, 3);
function checkout_review_order_remove_link($quantity_html, $cart_item, $cart_item_key) {
    return $quantity_html . apply_filters('woocommerce_cart_item_remove_link', sprintf(
        '<a href="%s" rel="nofollow" class="remove">
        <svg id="Group_1514" data-name="Group 1514" xmlns="http://www.w3.org/2000/svg" width="12.347" height="13.892" viewBox="0 0 12.347 13.892">
  <g id="Group_1513" data-name="Group 1513">
    <path id="Path_3573" data-name="Path 3573" d="M204.156,394.22c-.371,0-.724,0-1.077,0-.295,0-.471-.151-.467-.391s.188-.386.478-.386q5.7,0,11.4,0c.3,0,.468.145.466.391s-.165.385-.468.386h-1.035a.466.466,0,0,0-.034.279q0,4.984,0,9.968c0,.447-.112.554-.562.554q-4.059,0-8.119,0c-.485,0-.584-.1-.584-.579V394.22Zm8.467,10.014v-10h-7.668v10Z" transform="translate(-202.612 -391.129)" fill="#fff"/>
    <path id="Path_3574" data-name="Path 3574" d="M208.792,391.906q-.936,0-1.872,0c-.276,0-.448-.149-.453-.382a.4.4,0,0,1,.444-.394q1.874,0,3.745,0a.4.4,0,0,1,.455.386c0,.239-.177.388-.47.388q-.924,0-1.849,0Z" transform="translate(-202.612 -391.129)" fill="#fff"/>
    <path id="Path_3575" data-name="Path 3575" d="M208.017,399.263q0,1.109,0,2.217c0,.28-.142.45-.375.458s-.4-.176-.4-.46q0-2.252,0-4.5a.387.387,0,0,1,.392-.441c.244,0,.384.161.385.444Q208.019,398.12,208.017,399.263Z" transform="translate(-202.612 -391.129)" fill="#fff"/>
    <path id="Path_3576" data-name="Path 3576" d="M210.329,399.264c0,.739,0,1.478,0,2.217,0,.284-.141.451-.375.457a.411.411,0,0,1-.4-.463q0-2.252,0-4.5c0-.279.151-.44.393-.439s.383.161.383.444q0,1.145,0,2.287Z" transform="translate(-202.612 -391.129)" fill="#fff"/>
  </g>
</svg>

        </a>',
        esc_url(wc_get_cart_remove_url($cart_item_key)),
        __('Remove this item', 'woocommerce'),
        esc_attr($cart_item['product_id']),
        esc_attr($cart_item['data']->get_sku())
    ), $cart_item_key);
}

// add_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );







// add_filter( 'nav_menu_link_attributes', 'add_class_to_items_link', 10, 3 );

// function add_class_to_items_link( $atts, $item, $args ) {
//   // check if the item has children
//   $hasChildren = (in_array('menu-item-has-children', $item->classes));
//   if ($hasChildren) {
//     // add the desired attributes:
//     $atts['class'] = 'your-custom-class'; //This is the main concern according to the question
//     $atts['id'] = 'your-custom-id'; //Optional
//     $atts['data-toggle'] = 'dropdown'; //Optional
//     $atts['data-target'] = '#'; //Optional
//   }
//   return $atts;
// }


// add_action( 'wp', 'wpshout_get_queried_object' );
// function wpshout_get_queried_object() {
// 	var_dump( get_queried_object() );
// }