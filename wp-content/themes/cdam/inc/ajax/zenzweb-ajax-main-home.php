<?php
// Enable the user with no privileges to run ajax_login() in AJAX
add_action( 'wp_ajax_nopriv_zwc_main_home', 'zenzweb_ajax_zwc_main_home' );
add_action( 'wp_ajax_zwc_main_home', 'zenzweb_ajax_zwc_main_home' );

function zenzweb_ajax_zwc_main_home(){
  // Nonce is checked security
  // check_ajax_referer( 'zwc_get_attributes', 'nonce_get_data' );

  get_template_part( 'template-parts/home', 'main' );

  die();
}
