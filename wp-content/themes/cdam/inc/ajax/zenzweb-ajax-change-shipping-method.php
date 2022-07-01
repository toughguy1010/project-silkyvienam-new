<?php
// Enable the user with no privileges to run ajax_login() in AJAX
add_action( 'wp_ajax_nopriv_zwc_change_shipping_method', 'zenzweb_ajax_zwc_change_shipping_method' );
add_action( 'wp_ajax_zwc_change_shipping_method', 'zenzweb_ajax_zwc_change_shipping_method' );

function zenzweb_ajax_zwc_change_shipping_method(){
  // Nonce is checked security
  // check_ajax_referer( 'zwc_get_attributes', 'nonce_get_data' );

  $data = $_POST;
  WC()->session->set('chosen_shipping_methods', array( $data['shipping'] ) );

  WC()->session->set( 'refresh_totals', true );

  $cart = WC()->cart;
  $cart->calculate_totals();
  $cart_total = $cart->get_total();

  $current_shipping_method = WC()->session->get('chosen_shipping_methods');
  $html = '';
  // Loop through shipping packages from WC_Session (They can be multiple in some cases)
  foreach ( WC()->cart->get_shipping_packages() as $package_id => $package ) {
    // Check if a shipping for the current package exist
    if ( WC()->session->__isset( 'shipping_for_package_'.$package_id ) ) {
      // Loop through shipping rates for the current package
      foreach ( WC()->session->get( 'shipping_for_package_'.$package_id )['rates'] as $shipping_rate_id => $shipping_rate ) {
        $rate_id     = $shipping_rate->get_id(); // same thing that $shipping_rate_id variable (combination of the shipping method and instance ID)
        $method_id   = $shipping_rate->get_method_id(); // The shipping method slug
        $instance_id = $shipping_rate->get_instance_id(); // The instance ID
        $label_name  = $shipping_rate->get_label(); // The label name of the method
        $cost        = $shipping_rate->get_cost(); // The cost without tax
        $tax_cost    = $shipping_rate->get_shipping_tax(); // The tax cost
        $taxes       = $shipping_rate->get_taxes(); // The taxes details (array)

        $html .= '<li>';
          $html .= '<input type="radio" class="zwc_chosen_method" name="zwc_chosen_method" value="'.$rate_id.'" '.($current_shipping_method[0] == $rate_id ? 'checked' : '').'>';
          $html .= '<label for="">'.$label_name.'</label>: <span class="sh-cost">'.wc_price($cost).'</span>';
        $html .= '</li>';

      }
    }
  }

  echo json_encode( array( 'success' => true, 'mess' => 'update shipping', 'total' => $cart_total, $data, 'html' => $html ) );
  die();
}
