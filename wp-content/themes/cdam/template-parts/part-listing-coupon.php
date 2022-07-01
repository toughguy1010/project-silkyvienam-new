<?php
$cart = WC()->cart;

if (!empty($cart->applied_coupons)){
  $html = array();
  foreach ($cart->applied_coupons as $key => $coupon) {
    array_push($html,'<span><span>'.$coupon.'</span></span>');
  }
  echo '<span>('.implode($html,', ').')</span>';
}
