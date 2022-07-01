<?php
// Enable the user with no privileges to run ajax_login() in AJAX
add_action( 'wp_ajax_nopriv_zwc_apply_coupon', 'zenzweb_ajax_zwc_apply_coupon' );
add_action( 'wp_ajax_zwc_apply_coupon', 'zenzweb_ajax_zwc_apply_coupon' );

function zenzweb_ajax_zwc_apply_coupon(){
  // Nonce is checked security
  // check_ajax_referer( 'zwc_get_attributes', 'nonce_get_data' );

  $cart = WC()->cart;

  if( isset($_POST['coupon']) && isset($_POST['redeem-coupon']) ){
    if( $coupon = esc_attr($_POST['coupon']) ) {
        $applied = $cart->apply_coupon($coupon);
    } else {
        $coupon = false;
    }

    // Lấy các mã coupon đang được áp dụng
    // if (!empty($cart->applied_coupons))
    // {
    //   $error = implode($cart->applied_coupons,',');
    // }

    $success = 'Coupon '.$coupon.' Applied successfully.';
    $error = "This Coupon can't be applied";

    if( isset($applied) && $applied ){
      echo json_encode( array( 'success' => true, 'mess' => $message ) );
    }else{
      echo json_encode( array( 'success' => false, 'mess' => $error ) );
    }

  }else{
    echo json_encode( array( 'success' => false, 'mess' => 'Unable Applied Coupon!' ) );
  }

  die();
}
