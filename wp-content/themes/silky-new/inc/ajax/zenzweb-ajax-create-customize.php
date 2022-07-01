<?php
// Enable the user with no privileges to run ajax_login() in AJAX
add_action( 'wp_ajax_nopriv_zwc_create_customize', 'zenzweb_ajax_zwc_create_customize' );
add_action( 'wp_ajax_zwc_create_customize', 'zenzweb_ajax_zwc_create_customize' );

function zenzweb_ajax_zwc_create_customize(){
  // Nonce is checked security
  // check_ajax_referer( 'zwc_get_attributes', 'nonce_get_data' );

  $order    = new WC_Order();
  $cart     = WC()->cart;
  $checkout = WC()->checkout;
  $data     = [];

  if( ! $cart->is_empty() ){
    $cart->empty_cart();
  }

  $cus_p = wc_get_product($_POST['productid']);

  $cart->add_to_cart($cus_p->get_id(),1);

  //set new price in order
  foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
    $cart_item['data']->set_price( $cart_item['data']->get_price() + ( $cart_item['data']->get_price() * 10 / 100 ) );
  }

  $data['billing_first_name'] = $_POST['billing_first_name'];
  $data['billing_phone'] = $_POST['billing_phone'];
  $data['billing_email'] = $_POST['billing_email'];

  foreach ($_POST['measure'] as $key => $value) {
    $new_key = str_replace(" ","_",strtolower(zenzweb_remove_unicode_char($_POST['typename'][$key])));
    $data[$new_key] = $value;
  }

  $cart->calculate_totals();

  if( !isset($data['billing_first_name']) || $data['billing_first_name'] == '' ){
    echo json_encode( array( 'success' => false, 'errorID' => 'billing_first_name-error' ) );
    die();
  }

  if( !isset($data['billing_phone']) || $data['billing_phone'] == '' ){
    echo json_encode( array( 'success' => false, 'errorID' => 'billing_phone-error' ) );
    die();
  }

  if( !isset($data['billing_email']) || $data['billing_email'] == '' ){
    echo json_encode( array( 'success' => false, 'errorID' => 'billing_email-error' ) );
    die();
  }

  $cart_hash          = md5( json_encode( wc_clean( $cart->get_cart_for_session() ) ) . $cart->total );
  $available_gateways = WC()->payment_gateways->get_available_payment_gateways();

  $measures = array();
  // Loop through the data array
  foreach ( $data as $key => $value ) {
    // Use WC_Order setter methods if they exist
    if ( is_callable( array( $order, "set_{$key}" ) ) ) {
      $order->{"set_{$key}"}( $value );

    // Store custom fields prefixed with wither shipping_ or billing_
    } else {
      $measures[$key] = $value;
    }
  }
  //update chung meta data để dễ parse khi hiển thị
  $order->update_meta_data( '_measure_unit', $measures );

  $order->set_created_via( 'checkout' );
  $order->set_cart_hash( $cart_hash );
  $order->set_customer_id( apply_filters( 'woocommerce_checkout_customer_id', isset($_POST['user_id']) ? $_POST['user_id'] : '' ) );
  $order->set_currency( get_woocommerce_currency() );
  $order->set_prices_include_tax( 'yes' === get_option( 'woocommerce_prices_include_tax' ) );
  $order->set_customer_ip_address( WC_Geolocation::get_ip_address() );
  $order->set_customer_user_agent( wc_get_user_agent() );

  // $order->set_customer_note( isset( $data['order_comments'] ) ? $data['order_comments'] : '' );
  // $order->set_customer_note( 'Customize Product' ); // set sau khi có order id

  $order->set_payment_method( isset( $available_gateways[ $data['payment_method'] ] ) ? $available_gateways[ $data['payment_method'] ]  : $data['payment_method'] );
  $order->set_shipping_total( $cart->get_shipping_total() );
  $order->set_discount_total( $cart->get_discount_total() );
  $order->set_discount_tax( $cart->get_discount_tax() );
  $order->set_cart_tax( $cart->get_cart_contents_tax() + $cart->get_fee_tax() );
  $order->set_shipping_tax( $cart->get_shipping_tax() );

  // echo json_encode( array( 'success' => false, 'data' => $cart->get_subtotal(), $cart->get_total('edit') ) );
  // die();

  $order->set_total( $cart->get_total('edit') );

  $checkout->create_order_line_items( $order, $cart );
  $checkout->create_order_fee_lines( $order, $cart );
  $checkout->create_order_shipping_lines( $order, WC()->session->get( 'chosen_shipping_methods' ), WC()->shipping->get_packages() );
  $checkout->create_order_tax_lines( $order, $cart );
  $checkout->create_order_coupon_lines( $order, $cart );

  /**
   * Action hook to adjust order before save.
   * @since 3.0.0
   */
  do_action( 'woocommerce_checkout_create_order', $order, $data );

  // Save the order.
  $order_id = $order->save();
  wc_create_order_note( $order_id, 'Customize Product', true, true );

  if( $order_id != ''){
    do_action( 'woocommerce_checkout_update_order_meta', $order_id, $data );

    $cart->empty_cart();

    // get email
    $mailers = WC()->mailer()->get_emails();
    $sending = $mailers['WC_Email_New_Order'];
    $sending->trigger($order_id);

    // trigger email sended
    // foreach ($mailers as $key => $mailer) {
    //   // code...
    //   if( $mailer->is_enabled() ){
    //     $mailer->trigger($order_id);
    //   }
    // }

    $homeID = get_option('page_on_front');
    $homeFields = get_field_objects( $homeID );
    $customizeID = $homeFields['zwc_setting_customize_product']['value'];
    $customizeFields = get_field_objects( $customizeID );
    $thank     = $customizeFields['zwc_customize_thank_you']['value'];

    $html = '';
    $html .= '<div class="thankyou">';
      $html .= '<div class="thankyou-wrap">';

      $html .= '<span>';
      $html .= '<img src="'.get_template_directory_uri().'/assets/custom.svg" />';
      $html .= '</span>';

      $html .= '<div class="title">';
      $html .= nl2br($thank['title']);
      $html .= '</div>';

      $html .= '<div class="desc">';
      $html .= nl2br($thank['description']);
      $html .= '</div>';

      $html .= '<div class="mess">';
      $html .= '<a href="'.$thank['mess_us'].'"><span><img src="'.get_template_directory_uri().'/assets/mess.svg" /></span>message us</a>';
      $html .= '</div>';

      $html .= '<div class="finish">';
      $html .= '<a href="'.get_permalink( $cus_p->get_parent_id() ).'"><span><img src="'.get_template_directory_uri().'/assets/apply.svg" /></span>finish</a>';
      $html .= '</div>';

      $html .= '</div>';
    $html .= '</div>';

    echo json_encode( array(
      'success' => true,
      'order_id' => $order_id,
      'html' => $html,
    ) );
    die();

  }else{
    echo json_encode( array( 'success' => false, 'data' => '<div class="noti-popup">Đã có lỗi xảy ra!</div></div>' ) );
    die();
  }

  // echo json_encode( array( 'success' => true, 'data' => 'Added!', 'product' => $variable->get_id() ) );
  die();
}
