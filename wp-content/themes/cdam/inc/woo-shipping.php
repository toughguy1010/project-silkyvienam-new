<?php
if ( ! defined( 'WPINC' ) ) {
    die;
}

// adding custom class shipping method
add_action( 'woocommerce_shipping_init', function () {
    if ( ! class_exists( 'CDAM_Woo_Shipping_Method' ) ) {
        class CDAM_Woo_Shipping_Method extends WC_Shipping_Method {
            /**
             * Constructor for your shipping class
             *
             * @access public
             * @return void
             */
            public function __construct( $instance_id = 0 ) {
                $this->id                 = 'cdam_shipping_method';
                $this->instance_id        = absint($instance_id);
                $this->method_title       = __( 'CDAM Shipping Methods', 'cdam' );
                $this->method_description = __( 'Custom Shipping Method for CDAM', 'cdam' );

                // Availability & Countries
                // $this->availability = 'including';
                // $this->countries = array(
                //     'US', // Unites States of America
                //     'CA', // Canada
                //     'DE', // Germany
                //     'GB', // United Kingdom
                //     'IT', // Italy
                //     'ES', // Spain
                //     'VN', // Croatia
                //     'BD', // Croatia
                //     );

                $this->supports = array(
                    'shipping-zones',
                    // 'settings',
                    'instance-settings',
                    'instance-settings-modal',
                );

                $this->instance_form_fields = array(
            			'enabled' => array(
            				'title' 		=> __( 'Enable/Disable' ),
            				'type' 			=> 'checkbox',
            				'label' 		=> __( 'Enable this shipping method' ),
            				'default' 	=> 'yes',
            			),
            			'title' => array(
            				'title' 		=> __( 'CDAM Shipping' ),
            				'type' 			=> 'text',
            				'description' 	=> __( 'This controls the title which the user sees during checkout.' ),
            				'default'		=> __( 'CDAM Shipping' ),
            				'desc_tip'	=> true
            			)
            		);
            		$this->enabled              = $this->get_option( 'enabled' );
            		$this->title                = $this->get_option( 'title' );

                $this->init();
            }

            /**
             * Init your settings
             *
             * @access public
             * @return void
             */
            function init() {
                // Load the settings API
                $this->init_form_fields();
                $this->init_settings();

                // Save settings in admin if you have any defined
                add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
            }

            /**
             * Define settings field for this shipping
             * @return void
             */
            function init_form_fields() {

              $arr_fields = array();

              $arr_fields['title'] = array(
                'title'       => __( 'Title', 'cdam' ),
                'type'        => 'text',
                // 'description' => __( 'Title to be display on site', 'cdam' ),
                'default'     => __( 'CDAM Shipping', 'cdam' ),
                'placeholder' => __( 'Title to be display on site', 'cdam' ),
              );

              $arr_fields['cost_default'] = array(
                'title'       => __( 'Cost default', 'cdam' ),
                'type'        => 'number',
                // 'description' => __( 'Cost default', 'cdam' ),
                'placeholder' => __( 'Enter Cost', 'cdam'),
              );

              $arr_fields['cost_default_only'] = array(
                'type'        => 'checkbox',
                'label'       => __( 'Using only cost default', 'cdam' )
              );

              if( $this->get_country_code() == 'VN' ){

                $arr_fields['district'] = array(
                  'title'       => __( 'District', 'cdam' ),
                  'type'        => 'multiselect',
                  'label'       => __('Select a district', 'cdam' ),
                  'class'       => 'woocommerce_cdam_shipping_method_district',
                  'placeholder' => __('Enter something', 'cdam' ),
                  'description' => __('<p><a id="woocommerce_cdam_shipping_method_district_clear" href="#">Clear Selected</a></p><p>Hold ctrl addition district selected</p>', 'cdam' ),
                  'options'     => $this->get_settings_listing_district()
                );

              }

              // Shipping weight config
              $arr_fields['weight_active'] = array(
                'type'        => 'checkbox',
                'label'       => __( 'Active Weight', 'cdam' )
              );

              $arr_fields['weight_default'] = array(
                'title'       => __( 'Weight default', 'cdam' ),
                'type'        => 'number',
                'label'       => __('Weight default', 'cdam' ),
                'description' => __( 'Weight <= kg', 'cdam' ),
                'placeholder' => __('Enter weight', 'cdam' ),
              );

              $arr_fields['weight_default_cost'] = array(
                'title'       => __( 'Shipping cost default', 'cdam' ),
                'type'        => 'number',
                'placeholder' => __('Enter cost', 'cdam' ),
              );

              $arr_fields['weight'] = array(
                'title'       => __( 'Weight per Kg', 'cdam' ),
                'type'        => 'select',
                'label'       => __('Weight per Kg', 'cdam' ),
                'placeholder' => __('Enter cost', 'cdam' ),
                'options'     => array(
                  '001' => 'No chosen',
                  '002' => 'Per 0.5 kg',
                  '003' => 'Per 1.0 kg',
                ),
              );

              $arr_fields['weight_cost'] = array(
                'title'       => __( 'Shipping cost per Kg', 'cdam' ),
                'type'        => 'number',
                'label'       => __('Shipping cost per Kg', 'cdam' ),
                'placeholder' => __('Enter cost', 'cdam' ),
              );

              $arr_fields['shipping_disable'] = array(
                // 'title'       => __( 'Shipping disable', 'cdam' ),
                'type'        => 'checkbox',
                'label'       => __( 'Shipping disable', 'cdam' ),
                'description' => __( 'Follow district field selected', 'cdam' ),
              );

              $this->instance_form_fields = $arr_fields;

            }

            /**
             * This function is used to calculate the shipping cost. Within this function we can check for weights, dimensions and other parameters.
             *
             * @access public
             * @param mixed $package
             * @return void
             */
            public function calculate_shipping( $package = array() ) {

                // parse data form setting field
                $weight               = 0;
                $cost                 = 0;

                // detected address show rate
                $country = $package["destination"]["country"];
                $state = $package["destination"]["state"];
                $city = $package["destination"]["city"];

                // assgin data in class using
                $this->package              = $package;
                $this->destination_country  = $country;
                $this->destination_state    = $state;
                $this->destination_city     = $city;

                switch ($country) {
                  case 'VN':

                    if( $this->get_cost_weight() != '' ){

                      $rate = array(
                        'id'    => $this->id . $this->instance_id,
                        'label' => $this->title,
                        'cost'  => $this->get_cost_weight()
                      );
                      $this->add_rate( $rate );

                    }

                    break;

                  default:

                    $rate = array(
                      'id'    => $this->id . $this->instance_id,
                      'label' => $this->title,
                      'cost'  => $this->get_cost_weight()
                    );
                    $this->add_rate( $rate );

                    break;
                }

            }

            /**
              * $this->get_option('cost_default');
              * $this->get_option('weight_active');
              * $this->get_option('weight_default');
              * $this->get_option('weight_default_cost');
              * $this->get_option('weight');
              * $this->get_option('weight_cost');
              * $this->get_option('shipping_disable');
              * $this->get_option('district');
              */

            public function get_country_code() {
              $zone2                  = WC_Shipping_Zones::get_zone_by( 'instance_id', $this->instance_id );
              $zone_locations         = $zone2->get_zone_locations();
              $zone_locations_code    = isset( $zone_locations[0]->code ) ? $zone_locations[0]->code : '0:0';
              $zone_code_element      = explode(":",$zone_locations_code);

              return $zone_code_element[0];
            }

            public function get_settings_listing_district() {

              $zone2                  = WC_Shipping_Zones::get_zone_by( 'instance_id', $this->instance_id );
              $zone_locations         = $zone2->get_zone_locations();
              $zone_codes = array();
              foreach ($zone_locations as $key => $zone_location) {
                $zone_locations_code    = isset( $zone_location->code ) ? $zone_location->code : '0:0';
                $zone_code_element      = explode(":",$zone_locations_code);
                $zone_codes[]           = $zone_code_element;
              }

              $temp2 = array();
              foreach ($zone_codes as $key => $zone_code) {

                foreach (get_quan_huyen() as $key => $city) {
                  if( $city['matp'] == $zone_code[1] ){
                    $temp2[$zone_code[1]][$city['maqh']] = $city['name'];
                  }
                }

              }

              return $temp2;
            }


            public function get_district_selected() {
              return $this->get_option('district');
            }

            public function get_destination_district() {
              $all_city = get_thanhpho_quanhuyen();

              $select_city = $all_city[$this->destination_state];

              $city_key = array_keys($select_city, $this->destination_city);
              $city_key = $city_key[0];

              return $city_key;
            }

            public function get_cost_default_only() {
              $active = 0;

              $cost_default_only     = $this->get_option('cost_default_only');

              if( $cost_default_only == 'yes' ){
                $active = 1;
              }

              return $active;
            }

            public function get_shipping_disable() {
              $active = 0;

              $setting_shipping_disable     = $this->get_option('shipping_disable');

              if( $setting_shipping_disable == 'yes' ){
                $active = 1;
              }

              return $active;
            }

            public function get_weight_active() {
              $active = 0;

              $setting_weight_active        = $this->get_option('weight_active');

              if( $setting_weight_active == 'yes' ){
                $active = 1;
              }

              return $active;
            }

            public function get_cost_default() {
              $setting_cost_default         = $this->get_option('cost_default');

              return $setting_cost_default;
            }

            public function get_cost_per_weight() {

              $setting_weight_default = $this->get_option('weight_default');
              $setting_weight_default_cost  = $this->get_option('weight_default_cost');
              $setting_weight_cost = $this->get_option('weight_cost');

              $weight = $this->get_weight();

              $setting_weight = $this->get_option('weight');

              if( $setting_weight == '001' ){
                $per_kg = 0;
              }
              if( $setting_weight == '002' ){
                $per_kg = 0.5;
              }
              if( $setting_weight == '003' ){
                $per_kg = 1;
              }

              if( $weight <= $setting_weight_default ){

                $cost = $setting_weight_default_cost;

              }else{

                if( $per_kg != 0 ){
                  $add_count_weight = ceil( ($weight - $setting_weight_default) / $per_kg );
                  $cost = $setting_weight_default_cost + ( $add_count_weight * $setting_weight_cost );
                }

              }

              return $cost;
            }

            public function get_weight() {

              $weight = 0;

              // get weight from order (kg)
              foreach ( $this->package['contents'] as $item_id => $values )
              {
                  $_product = $values['data'];
                  $weight = $weight + $_product->get_weight() * $values['quantity'];
              }
              $weight = wc_get_weight( $weight, 'kg' );

              return $weight;
            }

            public function get_cost_weight() {

              // check destinoin city in config district?
              $district_selected = 0;
              $district_method = $this->get_district_selected();
              $city_key = $this->get_destination_district();
              if( in_array($city_key,$district_method) ){
                $district_selected = 1;
              }

              // check using cost default?
              $cost_default_only = $this->get_cost_default_only();

              // check weight calculate cost active?
              $active_weight = $this->get_weight_active();

              // check shipping disable?
              $shipping_disable = $this->get_shipping_disable();

              if( $shipping_disable ){

                if( $district_selected ){

                  $cost = '';

                }else{

                  if( $cost_default_only ){
                    $cost = $this->get_cost_default();
                  }else{
                    if( $active_weight ){
                      $cost = $this->get_cost_per_weight();
                    }else{
                      $cost = $this->get_cost_default();
                    }
                  }

                }

              }else{

                if( $district_selected ){

                  if( $active_weight ){
                    $cost = $this->get_cost_per_weight();
                  }else{
                    $cost = $this->get_cost_default();
                  }

                }else{

                  if( $cost_default_only ){
                    $cost = $this->get_cost_default();
                  }else{
                    if( $active_weight ){
                      $cost = $this->get_cost_per_weight();
                    }else{
                      $cost = $this->get_cost_default();
                    }
                  }

                }

              }

              return $cost;
            }
        }
    }
} );

// adding shipping method to available method
add_filter( 'woocommerce_shipping_methods', function( $methods ) {
    $methods['cdam_shipping_method'] = 'CDAM_Woo_Shipping_Method';
    return $methods;
} );

function cdam_validate_order( $posted )   {

    $packages = WC()->shipping->get_packages();

    $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );

    if( is_array( $chosen_methods ) && in_array( 'cdam_shipping_method', $chosen_methods ) ) {

        foreach ( $packages as $i => $package ) {

            if ( $chosen_methods[ $i ] != "cdam_shipping_method" ) {

                continue;

            }

            $CDAM_Woo_Shipping_Method = new CDAM_Woo_Shipping_Method();
            $weightLimit = (int) $CDAM_Woo_Shipping_Method->settings['weight'];
            $weight = 0;

            foreach ( $package['contents'] as $item_id => $values )
            {
                $_product = $values['data'];
                $weight = $weight + $_product->get_weight() * $values['quantity'];
            }

            $weight = wc_get_weight( $weight, 'kg' );

            if( $weight > $weightLimit ) {

                    $message = sprintf( __( 'Sorry, %d kg exceeds the maximum weight of %d kg for %s', 'tutsplus' ), $weight, $weightLimit, $CDAM_Woo_Shipping_Method->title );

                    $messageType = "error";

                    if( ! wc_has_notice( $message, $messageType ) ) {

                        wc_add_notice( $message, $messageType );

                    }
            }
        }
    }
}

add_action( 'woocommerce_review_order_before_cart_contents', 'cdam_validate_order' , 10 );
add_action( 'woocommerce_after_checkout_validation', 'cdam_validate_order' , 10 );

/**
 * Add select States VN when chosen Country
 */
add_filter( 'woocommerce_states', function ( $states ) {
  $states['VN'] = get_tinh_thanhpho();
  return $states;
} );

/**
 * Add city to state
 * Replace XX with the country code. Instead of YYY, ZZZ use actual  state codes.
 */
add_filter( 'wc_city_select_cities', function ( $cities ) {
  $temp2 = array();
  foreach (array_unique(wp_list_pluck(get_quan_huyen(),'matp')) as $key => $city_code) {
    foreach (get_quan_huyen() as $key => $city) {
      if( $city['matp'] == $city_code ){
        $temp2[$city_code][$city['maqh']] = $city['name'];
      }
    }
  }
  $cities['VN'] = $temp2;
  return $cities;
} );
