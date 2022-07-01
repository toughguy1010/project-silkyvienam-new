<?php
// Enable the user with no privileges to run ajax_login() in AJAX
add_action( 'wp_ajax_nopriv_zwc_show_customize', 'zenzweb_ajax_zwc_show_customize' );
add_action( 'wp_ajax_zwc_show_customize', 'zenzweb_ajax_zwc_show_customize' );

function zenzweb_ajax_zwc_show_customize(){
  // Nonce is checked security
  // check_ajax_referer( 'zwc_get_attributes', 'nonce_get_data' );

  $homeID = get_option('page_on_front');
  $homeFields = get_field_objects( $homeID );

  $customizeID = $homeFields['zwc_setting_customize_product']['value'];
  $customizeFields = get_field_objects( $customizeID );

  $content      = $customizeFields['zwc_customize_content']['value'];

  $listing = wp_list_pluck($content['gallery_image'],'image','position');

  $imageid = $_POST['image'];

  echo wp_get_attachment_image( $listing[$imageid],'full' );

  // echo json_encode( array( 'success' => true, 'data' => 'Added!', 'product' => $variable->get_id() ) );
  die();
}
