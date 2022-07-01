<?php
// Enable the user with no privileges to run ajax_login() in AJAX
add_action( 'wp_ajax_nopriv_zwc_change_price', 'zenzweb_ajax_zwc_change_price' );
add_action( 'wp_ajax_zwc_change_price', 'zenzweb_ajax_zwc_change_price' );

function zenzweb_ajax_zwc_change_price(){
  // Nonce is checked security
  // check_ajax_referer( 'zwc_get_attributes', 'nonce_get_data' );

  $data = $_POST;

  $p_children = wc_get_product($data['pid']);

  if( $p_children->get_type() == 'simple' ){
    $price = $p_children->get_price_html();

    echo json_encode( array( 'success' => true, 'price' => $price, 'variation_id' => $p_children->get_id() ) );
    die();
  }

  if( $p_children->get_type() == 'variable' ){
    $attribute = wp_list_pluck($p_children->get_available_variations(),'attributes','variation_id');

    $result = '';
    foreach ($attribute as $key => $value) {
      if( strtolower(str_replace("-en","",$value['attribute_pa_size'])) == strtolower(str_replace("/","-",str_replace(" ","-",zenzweb_remove_unicode_char($data['size'])))) && strtolower(str_replace("-en","",$value['attribute_pa_colour'])) == strtolower(str_replace(" ","-",zenzweb_remove_unicode_char($data['color']))) ){
        $result = $key;
      }
    }

    $variable = wc_get_product($result);
    $price = $variable->get_price_html();

    $thumb = '<img class="zoom-img" src="'.wp_get_attachment_image_src( $variable->get_image_id(), 'full' )[0].'" alt="">';

    $gallery_images = get_post_meta( $variable->get_id(), 'woo_variation_gallery_images', true );

    if ( !empty($gallery_images) ) {
      foreach ( $gallery_images as $gallery_image ) {
        $thumb .= '<img class="zoom-img" src="'.wp_get_attachment_image_src( $gallery_image, 'full' )[0].'" alt="">';
      }
    }

    echo json_encode( array( 'success' => true, 'price' => $price, 'variation_id' => $result, 'image' => $thumb ) );
    die();
  }
  die();
}
