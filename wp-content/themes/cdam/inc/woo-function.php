<?php


// @hooked woocommerce_template_single_title - 5
// * @hooked woocommerce_template_single_rating - 10
// * @hooked woocommerce_template_single_price - 10
// * @hooked woocommerce_template_single_excerpt - 20
// * @hooked woocommerce_template_single_add_to_cart - 30
// * @hooked woocommerce_template_single_meta - 40
// * @hooked woocommerce_template_single_sharing - 50
// * @hooked WC_Structured_Data::generate_product_data() - 60

remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

add_action( 'woocommerce_after_single_product_summary', function(){
  get_template_part('template-parts/content','recommend');
}, 20 );

add_action( 'woocommerce_before_single_product_summary', function(){
  get_template_part('template-parts/content','product-thumbnail');
}, 10 );

add_action( 'woocommerce_single_product_summary', function(){
  get_template_part('template-parts/content','product-sumary');
}, 10 );

remove_action('woocommerce_after_shop_loop','woocommerce_pagination',10);
remove_action('woocommerce_before_main_content','woocommerce_breadcrumb',20);
// remove_action('woocommerce_before_shop_loop','woocommerce_output_all_notices',10);
remove_action('woocommerce_before_shop_loop','woocommerce_result_count',20);
remove_action('woocommerce_before_shop_loop','woocommerce_catalog_ordering',30);

add_filter('woocommerce_currency_symbol', function( $currency_symbol, $currency ) {
     switch( $currency ) {
          case 'VND': $currency_symbol = 'VNĐ'; break;
     }
     return $currency_symbol;
}, 10, 2);

// add_action('woocommerce_after_checkout_form', function() {
add_action('woocommerce_checkout_before_order_review', function() {
  get_template_part('template-parts/part','order-product-sumary');
}, 99);

add_filter( 'get_the_archive_title', function ($title) {
  if ( is_category() ) {
    $title = single_cat_title( '', false );
  } else if ( is_tag() ) {
    $title = single_tag_title( '', false );
  } else if ( is_post_type_archive() ) {
    $title = post_type_archive_title( '', false );
  } else if ( is_tax() ) {
    $title  = single_term_title( '', false );
  }
  return $title;
});

remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );

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

add_shortcode( 'coupon_field', function() {

    $output  = '<p id="redeem-coupon">
    <span><img src="'.get_template_directory_uri().'/assets/coupon.svg'.'"/> If you have a coupon code, please apply it below.</span>
    <input type="text" name="coupon" id="coupon"/>
    <button class="redeem-coupon" name="redeem-coupon"><img src="'.get_template_directory_uri().'/assets/apply.svg"/>'.__('Apply Coupon').'</button>';

    return $output . '</p>';
} );

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
// add_action( 'woocommerce_after_checkout_billing_form', function() {
//   echo do_shortcode('[coupon_field]');
// } );

add_filter( 'woocommerce_order_button_html', function ($button_html ) {
	$button_html = str_replace( 'Place order', 'Pay Now', $button_html );
	return $button_html;
} );

get_template_part('inc/woo','form-field');
get_template_part('inc/woo','shipping');

add_filter( 'woocommerce_gateway_description', function( $description, $payment_id ){
    //
    if( 'bacs' === $payment_id ){
        ob_start(); // Start buffering

        echo '<div class="bacs-fields">';

        $bacs_accounts_info = get_option( 'woocommerce_bacs_accounts');
        foreach ($bacs_accounts_info as $key => $value) {
          ?>
          <div class="item">
            <div class="content">
              <div class="title">
                <?php echo $value['bank_name'] ? $value['bank_name'] : ''; ?>
              </div>
              <div class="desc">
                <span><?php echo $value['account_number'] ? $value['account_number'] : ''; ?></span>
                <span><?php echo $value['account_name'] ? $value['account_name'] : ''; ?></span>
                <span><?php echo $value['bic'] ? $value['bic'] : ''; ?></span>
                <span><?php echo $value['sort_code'] ? $value['sort_code'] : ''; ?></span>
                <span><?php echo $value['iban'] ? $value['iban'] : ''; ?></span>
              </div>
            </div>
          </div>
          <?php
        }

        echo '<div>';
        $description .= ob_get_clean(); // Append buffered content
    }
    return $description;
}, 20, 2 );

add_filter( 'woocommerce_cart_shipping_method_full_label', function( $label ) {
	$pos = strpos( $label, '' );
	return substr( $label, ++$pos );
} );
add_filter( 'woocommerce_order_shipping_to_display_shipped_via', '__return_false' );

/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', function($order){

  $measures = get_post_meta( $order->get_id(), '_measure_unit', true );
  foreach ($measures as $key => $measure) {
    echo '<p><strong>'.__(ucwords(str_replace("_"," ",$key))).':</strong> ' . (!empty($measure) ? $measure.'cm ' : '') . '</p>';
  }

  echo '<p><strong>'.__('New Notes').':</strong> <br/>' . get_post_meta( $order->get_id(), '_billing_new_order_notes', true ) . '</p>';
  echo '<p><strong>'.__('Height (cm)').':</strong> <br/>' . get_post_meta( $order->get_id(), '_billing_height', true ) . '</p>';
  echo '<p><strong>'.__('Weight (kg)').':</strong> <br/>' . get_post_meta( $order->get_id(), '_billing_weight', true ) . '</p>';
  // echo '<p><strong>'.__('Loyalty points used').':</strong> <br/>' . get_post_meta( $order->get_id(), '_zenzweb_redeem_point', true ) . '</p>';
}, 10, 1 );

add_action('wp_logout',function(){
  $homeID = get_option('page_on_front');
  $homeFields = get_field_objects( $homeID );
  $signinup = $homeFields['zwc_home_signinup']['value'];
  if( wp_redirect( esc_url( get_permalink($signinup['signin']) ) ) ){
    exit();
  }
});

add_action( 'template_redirect', function(){
  $homeID = get_option('page_on_front');
  $homeFields = get_field_objects( $homeID );
  $signinup = $homeFields['zwc_home_signinup']['value'];

  // pll_get_post(get_option( 'woocommerce_myaccount_page_id' ), 'en')
  $lang_slug = pll_default_language();

  if ( ! is_user_logged_in() && is_page(get_option( 'woocommerce_myaccount_page_id' )) ) {
    wp_redirect( esc_url( get_permalink($signinup['signin']) ) );
    exit();
  }

  if ( is_user_logged_in() && is_page($signinup['signin']) && !empty($signinup['signin']) ) {
    wp_redirect( esc_url( get_permalink( pll_get_post(get_option( 'woocommerce_myaccount_page_id' ), $lang_slug) ) ) );
    exit();
  }

  if ( is_user_logged_in() && is_page($signinup['signup']) && !empty($signinup['signup']) ) {
    wp_redirect( esc_url( get_permalink( pll_get_post(get_option( 'woocommerce_myaccount_page_id' ), $lang_slug) ) ) );
    exit();
  }

} );

add_filter( 'woocommerce_should_load_paypal_standard', '__return_true' );