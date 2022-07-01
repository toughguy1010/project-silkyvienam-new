<?php
function ajax_loginout_init(){

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'zenzweb_ajax_login' );
    add_action( 'wp_ajax_ajaxlogin', 'zenzweb_ajax_login' );
    add_action( 'wp_ajax_nopriv_ajaxregis', 'zenzweb_ajax_register' );
    add_action( 'wp_ajax_ajaxregis', 'zenzweb_ajax_register' );
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
  add_action('init', 'ajax_loginout_init');
}

function zenzweb_ajax_login(){

    // First check the nonce, if it fails the function will break wp_nonce_field( 'custom_checkout_z', 'nonce_checkout_key' );
    check_ajax_referer( 'custom_checkout_z', 'nonce_checkout_key' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    if ( function_exists( 'pll_get_post' ) ){
      $redirect = pll_get_post( get_option( 'woocommerce_myaccount_page_id' ) );
    } else {
      $redirect = get_option( 'woocommerce_myaccount_page_id' );
    }

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
        die();
    } else {
        echo json_encode(array(
          'loggedin'=>true,
          'message'=>__('Login successful, redirecting...'),
          'url' => esc_url( get_permalink( $redirect )),
        ));
        die();
    }

    die();
}

function zenzweb_ajax_register(){

    // Nonce is checked security
    check_ajax_referer( 'custom_checkout_z', 'nonce_checkout_key' );

    $user_login = trim($_POST['email']);
    $username_exists = username_exists($user_login);
    if($user_login == '' && strlen($user_login) < 5){
      echo json_encode(array('loggedin'=>false, 'message'=>  'The Username must be at least 4 characters!', 'name' => 'user' ));
      die();
    }
    if($username_exists){
      echo json_encode(array('loggedin'=>false, 'message'=>  'User name <b> ' . $user_login . ' </b> has been used!', 'name' => 'user' ));
      die();
    }

    $user_email = trim($_POST['email']);
    $email_exists = email_exists($user_email);
    if(!is_email($user_email)){
      echo json_encode(array('loggedin'=>false, 'message'=> 'Wrong email!', 'name' => 'email' ));
      die();
    }elseif($email_exists){
      echo json_encode(array('loggedin'=>false, 'message'=> 'Email <b> ' . $user_email . ' </b> has been used!', 'name' => 'email' ));
      die();
    }else{

    }

    // $user_password = wp_generate_password( 12, false );
    $user_password = trim($_POST['password']);

    $uppercase = preg_match('@[A-Z]@', $user_password);
    $lowercase = preg_match('@[a-z]@', $user_password);
    $number    = preg_match('@[0-9]@', $user_password);
    $spec    = preg_match('@[\W]@', $user_password);

    if(!$uppercase || !$lowercase || !$number || !$spec || strlen($user_password) < 8){
      echo json_encode(array(
        'loggedin'=>false,
        'message'=> 'The password Wrong characters!',
        'name' => 'password',
        'uppercase' => $uppercase,
        'lowercase' => $lowercase,
        'number' => $number,
        'spec' => $spec,
        'check_pass' => $check_pass,
      ));
      die();
    }

    $user_password2 = trim($_POST['password2']);
    if($user_password2 == '' || strlen($user_password2) < 8){
      echo json_encode(array('loggedin'=>false, 'message'=> 'The password must be at least 8 characters!', 'name' => 'password2' ));
      die();
    }
    if($user_password != $user_password2){
      echo json_encode(array('loggedin'=>false, 'message'=> 'Password not correct!', 'name' => 'password2' ));
      die();
    }

    // $recaptcha = $_POST['g-recaptcha-response'];
    // if($recaptcha == null){
    //   echo json_encode(array('loggedin'=>false, 'message'=>  'Please check the the captcha form!' ));
    //   die();
    // }
    // $secretKey = "6LdISyIUAAAAACBgkBuASOATtq5yoxqkchl-ZNh-";
    // $ip = $_SERVER['REMOTE_ADDR'];
    // $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$recaptcha."&remoteip=".$ip);
    // $responseKeys = json_decode($response,true);
    // if(intval($responseKeys["success"]) !== 1) {
    //   echo json_encode(array('loggedin'=>false, 'message'=>  '<b>NOOO Spam!</b>' ));
    //   die();
    // } else {
    //
    // }

    $first_name = trim($_POST['firstname']);
    if($first_name == ''){
      echo json_encode(array('loggedin'=>false, 'message'=>  'This fields required!', 'name' => 'firstname' ));
      die();
    }

    $last_name = trim($_POST['lastname']);
    if($first_name == ''){
      echo json_encode(array('loggedin'=>false, 'message'=>  'This fields required!', 'name' => 'lastname' ));
      die();
    }

    $phone = trim($_POST['phone']);
    if($phone == '' || strlen($phone) < 10){
      echo json_encode(array('loggedin'=>false, 'message'=>  'This fields required!', 'name' => 'phone' ));
      die();
    }

    $user_day = trim($_POST['day']);
    if($user_day == ''){
      echo json_encode(array('loggedin'=>false, 'message'=>  'This fields required!', 'name' => 'day' ));
      die();
    }

    $user_month = trim($_POST['month']);
    if($user_month == ''){
      echo json_encode(array('loggedin'=>false, 'message'=>  'This fields required!', 'name' => 'day' ));
      die();
    }

    $user_year = trim($_POST['year']);
    if($user_year == ''){
      echo json_encode(array('loggedin'=>false, 'message'=>  'This fields required!', 'name' => 'day' ));
      die();
    }

    $check_subscribe = trim($_POST['check_subscribe']);
    $check_policy = trim($_POST['check_policy']);
    if( $check_policy != 1 ){
      echo json_encode(array('loggedin'=>false, 'message'=>  'You need accept Policy!', 'name' => 'check_policy' ));
      die();
    }

    $userdata = array(
        'user_login' => $user_login,
        'user_pass'  => $user_password,
        'user_email' => $user_email,
        'user_phone' => $user_phone,
        'user_day_of_birthday' => $user_day,
        'user_month_of_birthday' => $user_month,
        'user_year_of_birthday' => $user_year,
        'first_name' => $user_first_name,
        'last_name' => $user_last_name,
        'user_check_subscribe' => $user_check_subscribe,
        'role' => 'customer',
    );
    $user_id = wp_insert_user( $userdata ) ;
    wp_new_user_notification( $user_id, $user_password );

    // Return
    if( !is_wp_error($user_id) ) {
      update_user_meta( $user_id, 'billing_first_name', $user_first_name );
      update_user_meta( $user_id, 'billing_last_name', $user_last_name );
      update_user_meta( $user_id, 'billing_phone', $user_phone );
      update_user_meta( $user_id, 'billing_email', $user_email );
      update_user_meta( $user_id, 'user_day_of_birthday', $user_day_of_birthday );
      update_user_meta( $user_id, 'user_month_of_birthday', $user_month_of_birthday );
      update_user_meta( $user_id, 'user_year_of_birthday', $user_year_of_birthday );
      update_user_meta( $user_id, 'user_check_subscribe', $user_check_subscribe );

      $info['user_login'] = $user_login;
      $info['user_password'] = $user_password;
      $info['remember'] = true;

      wp_signon( $info, false );

      echo json_encode(array(
        'loggedin' => true,
        'message' => 'Account created!',
        'url' => esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
      ));
      die();
    } else {
        echo json_encode(array('loggedin'=>false, 'message'=> 'Something Wrong!' ));
        die();
    }
    die();
}
