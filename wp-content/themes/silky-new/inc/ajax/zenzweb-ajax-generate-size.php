<?php
// Enable the user with no privileges to run ajax_login() in AJAX
add_action( 'wp_ajax_nopriv_zwc_generate_size', 'zenzweb_ajax_zwc_generate_size' );
add_action( 'wp_ajax_zwc_generate_size', 'zenzweb_ajax_zwc_generate_size' );

function zenzweb_ajax_zwc_generate_size(){
  // Nonce is checked security
  // check_ajax_referer( 'zwc_generate_size', 'nonce_get_generate_size' );

  $data = $_POST;

  $p_children = wc_get_product($data['pid']);

  $attribute = wp_list_pluck($p_children->get_available_variations(),'attributes','variation_id');

  $attr = $p_children->get_attributes();

  $pa_size = $attr['pa_size'];
  $label_size = wc_attribute_label($pa_size['name']);
  $pa_parse_size = wc_get_product_terms( $p_children->get_id(), $pa_size['name'] );

  $check_active = 0;
  $result = '';
  foreach ($pa_parse_size as $ks => $size) {

    foreach ($attribute as $kv => $value) {

      if ( strtolower(str_replace("-en","",$value['attribute_pa_size'])) == strtolower(str_replace("/","-",str_replace(" ","-",zenzweb_remove_unicode_char($size->name))))
        && strtolower(str_replace("-en","",$value['attribute_pa_colour'])) == strtolower(str_replace(" ","-",zenzweb_remove_unicode_char($data['color']))) ){

        $variable = wc_get_product($kv);
        if( $variable->get_stock_status() != 'outofstock' ){
          $result .= '<li class="p-li-size '.($check_active == 0 ? 'active' : '').'" data-sizeterm="'.$size->term_id.'" data-size="'.$size->name.'" data-sizetext="'.$size->name.'">'.$size->name.'</li>';
          if( $check_active == 0 ){
            $size_chosen = $size->name;
            $variation_id = $variable->get_id();
          }
          $check_active++;
        }else{
          $result .= '<li class="p-li-size disabled" data-sizeterm="'.$size->term_id.'" data-size="'.$size->name.'" data-sizetext="'.$size->name.'">'.$size->name.'</li>';
        }
      }

    }

  }

  if( $check_active == 0 ){
    // $size_chosen = $pa_parse_size[0]->name;
    foreach ($pa_parse_size as $ks => $size) {
      if( $ks == 0 ){
        $size_chosen = $size->name;
      }

      $temp_size_fisrt = array();
      foreach ($attribute as $kv => $value) {
        if ( strtolower($value['attribute_pa_colour']) == strtolower(str_replace(" ","-",zenzweb_remove_unicode_char($data['color']))) ){
          array_push($temp_size_fisrt,$kv);
        }
      }

    }
    $variation_id = $temp_size_fisrt[0];
  }

  $final_p = wc_get_product( $variation_id );

  $thumb = '<img class="zoom-img" src="'.wp_get_attachment_image_src( $final_p->get_image_id(), 'full' )[0].'" alt="">';

  $gallery_images = get_post_meta( $final_p->get_id(), 'woo_variation_gallery_images', true );

  if ( !empty($gallery_images) ) {
    foreach ( $gallery_images as $gallery_image ) {
      $thumb .= '<img class="zoom-img" src="'.wp_get_attachment_image_src( $gallery_image, 'full' )[0].'" alt="">';
    }
  }

  echo json_encode( array( 'success' => true, 'html' => $result, 'check' => $check_active, 'size_chosen' => $size_chosen, 'variation_id' => $variation_id, 'image' => $thumb, 'attr' => $attribute ) );
  die();

}
