<?php
// Enable the user with no privileges to run ajax_login() in AJAX
add_action( 'wp_ajax_nopriv_zwc_cart_update', 'zenzweb_ajax_zwc_cart_update' );
add_action( 'wp_ajax_zwc_cart_update', 'zenzweb_ajax_zwc_cart_update' );

function zenzweb_ajax_zwc_cart_update(){
  // Nonce is checked security
  // check_ajax_referer( 'zwc_get_attributes', 'nonce_get_data' );

  $cart = WC()->cart;
  $data = $_POST;

  $remove_items = array();
  foreach ($data['item_key'] as $item) {
    $item = explode("|",$item);
    $cart->set_quantity( $item[0], $item[1] ); // Change quantity

    if( $item[1] <= 0 ){
    	$cart->remove_cart_item( $item[0] );
      array_push($remove_items,$item[0]);
    }
  }

  $items = $cart->get_cart();

  $r_items = array();
  foreach($items as $item => $values) {
    $_product =  wc_get_product( $values['data']->get_id() );
    $temp = array(
      $item => wc_price($_product->get_price() * $values['quantity'])
    );
    array_push($r_items,$temp);
  }

  $discount_excl_tax_total = $cart->get_cart_discount_total();
  $discount_tax_total = $cart->get_cart_discount_tax_total();
  $discount_total = $discount_excl_tax_total + $discount_tax_total;
  if( ! empty($discount_total) ){
    $discount = '<span class="cart-discount">'.wc_price(-$discount_total).'</span>';
  }

  $count = $cart->get_cart_contents_count();
  $r_count = $count > 0 ? ( $count == 1 ? $count.' item' : $count.' items' ) : '';
  $r_cart_total = $cart->get_cart_total();
  $r_shipping_total = $cart->get_cart_shipping_total();
  $r_total = $cart->get_cart_total();

  // if (!empty($cart->applied_coupons))
  // {
  //   $applied_coupons = implode($cart->applied_coupons,', ');
  // }

  if (!empty($cart->applied_coupons)){
    $html = array();
    foreach ($cart->applied_coupons as $key => $coupon) {
      array_push($html,'<span><span>'.$coupon.'</span></span>');
    }
    $applied_coupons = '<span>('.implode($html,', ').')</span>';
  }

  $data = array(
    'items' => $r_items,
    'remove_item' => $remove_items,
    'discount' => $discount.$applied_coupons,
    'count' => $r_count,
    'cart_total' => $r_cart_total,
    'shipping_total' => $r_shipping_total,
    'total' => $r_total,
  );

  echo json_encode( array( 'success' => true, 'data' => $data ) );
  die();
}
