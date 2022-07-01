<?php
// Enable the user with no privileges to run ajax_login() in AJAX
add_action( 'wp_ajax_nopriv_zwc_remove_coupon', 'zenzweb_ajax_zwc_remove_coupon' );
add_action( 'wp_ajax_zwc_remove_coupon', 'zenzweb_ajax_zwc_remove_coupon' );

function zenzweb_ajax_zwc_remove_coupon(){
  // Nonce is checked security
  // check_ajax_referer( 'zwc_get_attributes', 'nonce_get_data' );

  $cart = WC()->cart;
  $cart->remove_coupon( $_POST['coupon'] );

  die();
}
