<?php
// Enable the user with no privileges to run ajax_login() in AJAX
add_action( 'wp_ajax_nopriv_zwc_cart_menu_update', 'zenzweb_ajax_zwc_cart_menu_update' );
add_action( 'wp_ajax_zwc_cart_menu_update', 'zenzweb_ajax_zwc_cart_menu_update' );

function zenzweb_ajax_zwc_cart_menu_update(){
  // Nonce is checked security
  // check_ajax_referer( 'zwc_get_attributes', 'nonce_get_data' );

  $cart = WC()->cart;

  $homeID = get_option('page_on_front');
  $homeFields = get_field_objects( $homeID );

  $header_mete = $homeFields['zwc_home_menu_meta']['value'];

  foreach ($header_mete as $key => $value) {
    $class_chk = $value['class'];
    if( $class_chk == 'cart-show' ){
      $anchor = $value['anchor'];
      echo $anchor.' ('.$cart->get_cart_contents_count().')';
    }
  }

  // echo 'Cart ('.$cart->get_cart_contents_count().')';

  die();
}
