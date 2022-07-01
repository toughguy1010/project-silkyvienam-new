<?php
// Enable the user with no privileges to run ajax_login() in AJAX
add_action( 'wp_ajax_nopriv_zwc_add_to_cart', 'zenzweb_ajax_zwc_add_to_cart' );
add_action( 'wp_ajax_zwc_add_to_cart', 'zenzweb_ajax_zwc_add_to_cart' );

function zenzweb_ajax_zwc_add_to_cart(){
  // Nonce is checked security
  // check_ajax_referer( 'zwc_get_attributes', 'nonce_get_data' );
  $cart = WC()->cart;
  $data = $_POST;

  $p_children = wc_get_product($data['pid']);

  if( $p_children->get_type() == 'simple' ){
    $cart->add_to_cart($p_children->get_id(),1);

    echo json_encode( array( 'success' => true, 'data' => 'Added!', 'product' => $p_children->get_id(), 'simple' ) );
    die();
  }

  if( $p_children->get_type() == 'variable' ){
    $attribute = wp_list_pluck($p_children->get_available_variations(),'attributes','variation_id');

    $result = '';
    foreach ($attribute as $key => $value) {
      if( strtolower(str_replace("-en","",$value['attribute_pa_size'])) == strtolower(str_replace("/","-",zenzweb_remove_unicode_char($data['size']))) && strtolower(str_replace("-en","",$value['attribute_pa_colour'])) == strtolower(str_replace(" ","-",zenzweb_remove_unicode_char($data['color']))) ){
        $result = $key;
      }
    }

    // if( function_exists( 'pll_default_language' ) ){
    //   echo json_encode( array( 'success' => true, 'data' => 'Added!', 'product' => pll_default_language() ) );
    //   die();
    // }

    $variable = wc_get_product($result);

    if( $variable->get_stock_status() != 'outofstock' ){
      $cart->add_to_cart($p_children->get_id(),1,$variable->get_id());
      echo json_encode( array( 'success' => true, 'data' => 'Added!', 'product' => $variable->get_id(), 'variable', $cart ) );
    }else{
      echo json_encode( array( 'success' => false, 'data' => 'Product Out of Stock. Please chooses another Attribute!', 'product' => $variable->get_id() ) );
      die();
    }

    // echo json_encode( array( 'success' => true, 'data' => 'Added!', 'product' => $variable->get_id() ) );
    die();
  }
  die();
}
