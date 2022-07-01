<?php
// Enable the user with no privileges to run ajax_login() in AJAX
add_action( 'wp_ajax_nopriv_zwc_subscibe', 'zenzweb_ajax_zwc_subscibe' );
add_action( 'wp_ajax_zwc_subscibe', 'zenzweb_ajax_zwc_subscibe' );

function zenzweb_ajax_zwc_subscibe(){
  // Nonce is checked security
  check_ajax_referer( 'custom_zwc_subscibe', 'nonce_zwc_subscibe_key' );

  $data = $_POST;

  $email = isset( $data['email'] ) ? $data['email'] : '';

  if( $email == '' || !is_email( $email ) ){
    echo json_encode( array( 'success' => false, 'mess' => 'Email not correctly!',$_POST ) );
    die();
  }

  $args = array(
    'post_title' => $email,
    'post_type'  => 'zwc_subscibe',
    'post_status'   => 'publish',
  );
  $new_post_id = wp_insert_post( $args );

  if( ! is_wp_error($new_post_id) ){

    echo json_encode( array( 'success' => true, 'mess' => 'Thank you for subscribing!' ) );
    die();

  }else{

    wp_delete_post( $new_post_id, true );
    echo json_encode( array( 'success' => false, 'mess' => 'Something Error!' ) );
    die();

  }

  echo json_encode(
    array(
      'success' => $success,
      'data' => $_POST,
    )
  );
  die();
}
