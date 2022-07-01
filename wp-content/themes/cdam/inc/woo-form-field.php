<?php
// Remove default order note
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );

add_filter( 'woocommerce_checkout_fields' , function ( $fields ) {
  // Remove company field (billing & shipping)
  unset($fields['billing']['billing_company']);
  unset($fields['shipping']['shipping_company']);

  // Remove address_2 field (billing & shipping)
  unset($fields['billing']['billing_address_2']);
  unset($fields['shipping']['shipping_address_2']);

  //Remove last nam field (billing & shipping)
  unset($fields['billing']['billing_last_name']);
  unset($fields['shipping']['shipping_last_name']);

  // Modify postcode field
  $fields['billing']['billing_postcode']['label'] = 'Postcode / ZIP*';
  // $fields['billing']['billing_postcode']['required'] = true;
  $fields['shipping']['shipping_postcode']['label'] = 'Postcode / ZIP*';
  // $fields['shipping']['shipping_postcode']['required'] = true;

  // Modify state field
  $fields['billing']['billing_state']['label'] = 'State / County*';
  $fields['billing']['billing_state']['required'] = false;
  $fields['shipping']['shipping_state']['label'] = 'State / County*';
  $fields['shipping']['shipping_state']['required'] = false;

  // Modify phone field
  $fields['shipping']['shipping_phone']['label'] = 'Phone*';
  $fields['shipping']['shipping_phone']['required'] = true;

  // Modify email field
  $fields['shipping']['shipping_email']['label'] = 'Email*';
  $fields['shipping']['shipping_email']['required'] = true;

  // Create new field none data
  $fields['billing']['billing_foo'] = array(
    'type' => 'hidden',
    'label' => 'Please assist us in providing you with perfect personalization by filling your measurements in the spaces below.',
    'class' => array('form-row-wide','foo-measurement'),
    'clear' => true,
    'priority' => 110,
    'required' => false,
  );

  $user = wp_get_current_user();

  // Create new field height and weight
  $fields['billing']['billing_height'] = array(
    'type' => 'text',
    'default' => esc_attr( $user->measurement_height ),
    // 'label' => 'Your height (cm) <span>*</span>',
    'label' => 'Your height (cm)',
    'class' => array('form-row-wide','row-measurement'),
    'clear' => true,
    'priority' => 999999,
    'required' => false,
  );

  $fields['billing']['billing_weight'] = array(
    'type' => 'text',
    'default' => esc_attr( $user->measurement_weight ),
    // 'label' => 'Your weight (kg) <span>*</span>',
    'label' => 'Your weight (kg)',
    'class' => array('form-row-wide','row-measurement'),
    'clear' => true,
    'priority' => 999999,
    'required' => false,
  );

  // Create new order note
  $fields['billing']['billing_new_order_notes'] = array(
    'type' => 'textarea',
    'label' => 'Notes',
    'class' => array('form-row-wide'),
    'clear' => true,
    'priority' => 999999,
  );
  // echo '<pre>';
  // print_r($fields);
  // echo '</pre>';
  return $fields;
} );

add_filter( 'woocommerce_default_address_fields', function ( $fields ) {
    $fields['first_name']['priority'] = 5;
    $fields['phone']['priority'] = 6;
    $fields['foo']['priority'] = 6;
    $fields['email']['priority'] = 7;
    $fields['country']['priority'] = 8;
    $fields['state']['priority'] = 9;
    $fields['city']['priority'] = 10;
    $fields['address_1']['priority'] = 11;
    $fields['postcode']['priority'] = 99;
    return $fields;
} );


add_action( 'woocommerce_checkout_update_order_meta', function( $order_id, $data ) {
   if ( ! is_object( $order_id ) ) {
      $order = wc_get_order( $order_id );
   // }
   // $order->set_customer_note( isset( $data['billing_new_order_notes'] ) ? $data['billing_new_order_notes'] : '' );
   // wc_create_order_note( $order_id, $data['billing_new_order_notes'], true, true );

     if( isset( $_POST['shipping_phone'] ) && $_POST['shipping_phone'] != '' ){
       $order->update_meta_data('_shipping_phone', $_POST['shipping_phone']);
     }
     if( isset( $_POST['shipping_email'] ) && $_POST['shipping_email'] != '' ){
       $order->update_meta_data('_shipping_email', $_POST['shipping_email']);
     }
     if( isset( $_POST['billing_new_order_notes'] ) && $_POST['billing_new_order_notes'] != '' ){
       $order->update_meta_data('_billing_new_order_notes', $_POST['billing_new_order_notes']);
     }
     if( isset( $_POST['billing_height'] ) && $_POST['billing_height'] != '' ){
       $order->update_meta_data('_billing_height', $_POST['billing_height']);
     }
     if( isset( $_POST['billing_weight'] ) && $_POST['billing_weight'] != '' ){
       $order->update_meta_data('_billing_weight', $_POST['billing_weight']);
     }

     $order->save();
   }
}, 10, 2 );

add_filter( 'woocommerce_form_field' , function ( $field, $key, $args, $value ) {
    if( is_checkout() && ! is_wc_endpoint_url() ) {
        $optional = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
        $field = str_replace( $optional, '', $field );
    }
    return $field;
}, 10, 4 );

// Add the custom field edit account detail form
add_action( 'woocommerce_edit_account_form', function() {
    $user = wp_get_current_user();
    ?>
      <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-row-foo form-row-last">
        Please assist us in providing you with perfect personalization by filling your measurements in the spaces below.
      </p>
      <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-row-measurement">
        <label for="measurement_height"><?php _e( 'Your height (cm) <span>*</span>', 'woocommerce' ); ?></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="measurement_height" id="measurement_height" value="<?php echo esc_attr( $user->measurement_height ); ?>" />
      </p>
      <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-row-measurement">
        <label for="measurement_height"><?php _e( 'Your weight (kg) <span>*</span>', 'woocommerce' ); ?></label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="measurement_weight" id="measurement_weight" value="<?php echo esc_attr( $user->measurement_weight ); ?>" />
      </p>
    <?php
} );


// Save the custom field edit account detail form
add_action( 'woocommerce_save_account_details', function( $user_id ) {
    // For height
    if( isset( $_POST['measurement_height'] ) )
        update_user_meta( $user_id, 'measurement_height', sanitize_text_field( $_POST['measurement_height'] ) );

    // For weight
    if( isset( $_POST['measurement_weight'] ) )
        update_user_meta( $user_id, 'measurement_weight', sanitize_text_field( $_POST['measurement_weight'] ) );

}, 12, 1 );
