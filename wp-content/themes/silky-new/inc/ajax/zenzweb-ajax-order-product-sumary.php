<?php
// Enable the user with no privileges to run ajax_login() in AJAX
add_action( 'wp_ajax_nopriv_zwc_order_product_sumary', 'zenzweb_ajax_zwc_order_product_sumary' );
add_action( 'wp_ajax_zwc_order_product_sumary', 'zenzweb_ajax_zwc_order_product_sumary' );

function zenzweb_ajax_zwc_order_product_sumary(){
  // Nonce is checked security
  // check_ajax_referer( 'zwc_get_attributes', 'nonce_get_data' );

//   $cart = WC()->cart;
//   $items = $cart->get_cart();

//   foreach($items as $item => $values) {
//     $_product =  wc_get_product( $values['data']->get_id() );
//     $_product = pll_get_post($values['data']->get_id(),pll_current_language());
//     if( $_product == '' ){
//       $cart->remove_cart_item($item);
//     }
//   }

  $cart = WC()->cart;
  $items = $cart->get_cart();
  ?>
  <?php if( !empty($items) ) { ?>
  <div class="title">
    Order Summary
  </div>

  <div class="bottom">
    <div class="wrap-bottom">
      <?php
      $discount_excl_tax_total = $cart->get_cart_discount_total();
      $discount_tax_total = $cart->get_cart_discount_tax_total();
      $discount_total = $discount_excl_tax_total + $discount_tax_total;
      ?>
      <?php if( ! empty($discount_total) ): ?>
        <div class="cart-coupon item">
          <div class="coll-left">
            <span>
             Coupon Discount
            </span>
          </div>
          <div class="coll-right">
            <span class="cart-discount">
              <?php 
              echo wc_price(-$discount_total);
          //     $current_language = get_locale();

          // if( $current_language == 'vi' ){
          //   echo - $discount_total   ; echo ' VNĐ' ; ;
          // }
          
          // if( $current_language == 'en_US' ){
          //   $convertPrice = 0.0000427862 ;
          //   echo ceil( - $discount_total  * $convertPrice );echo '$';
          // }
              ?>
            </span>
            <?php get_template_part('template-parts/part','listing-coupon-remove'); ?>
          </div>
        </div>
      <?php endif; ?>
      <div class="cart-items item totals-cart-item">
        <div class="coll-left">
          <span>
           <?php
           $count = $cart->get_cart_contents_count();
           echo $count > 0 ? ( $count == 1 ? $count.' item' : $count.' items' ) : ''; ?>
          </span>
        </div>
        <div class="coll-right">
          <?php

// $amount = WC()->cart->cart_contents_total + WC()->cart->tax_total;
// $current_language = get_locale();

//           if( $current_language == 'vi' ){
//             echo  $amount   ; echo ' VNĐ' ; ;
//           }
          
//           if( $current_language == 'en_US' ){
//             $convertPrice = 0.0000427862 ;
//             echo ceil( $amount  * $convertPrice );echo '$';
//           }

          echo $cart->get_cart_total();
          ?>
        </div>
      </div>
      <div class="cart-shipping item cart-shipping-method">
        <div class="coll-left">
      	<span>
      	 Shipping Cost
      	</span>
        </div>
        <div class="coll-right">
          <ul id="zwc_chosen_method">
        	<?php
        	// echo $cart->get_cart_shipping_total();

          $current_shipping_method = WC()->session->get('chosen_shipping_methods');
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
                ?>
                <li>
                  <input type="radio" class="zwc_chosen_method" name="zwc_chosen_method" value="<?php echo $rate_id; ?>" <?php echo $current_shipping_method[0] == $rate_id ? 'checked' : ''; ?>>
                  <label for=""><?php echo $label_name; ?></label>: <span class="sh-cost"><?php 
                
                  // $current_language = get_locale();
                  
                  //           if( $current_language == 'vi' ){
                  //             echo  $cost   ; echo 'VNĐ' ; ;
                  //           }
                            
                  //           if( $current_language == 'en_US' ){
                  //             $convertPrice = 0.0000427862 ;
                  //             echo ceil( $cost  * $convertPrice) ;echo '$';
                  //           }
                  echo wc_price($cost);
                  
                  
                  ?></span>
                </li>
                <?php
        			}
        		}
        	}
        	?>
          </ul>
        </div>
      </div>
      <div class="cart-total total-cart-price item">
        <div class="coll-left">
          <span>
           Total
          </span>
        </div>
        <div class="coll-right">
          <?php
          WC()->session->set( 'refresh_totals', true );
          $cart->calculate_totals();

          // $amount = WC()->cart->cart_contents_total + WC()->cart->tax_total;
          // $current_language = get_locale();

          // if( $current_language == 'vi' ){
          //   echo  $amount - $cost   ; echo 'VNĐ' ; ;
          // }
          
          // if( $current_language == 'en_US' ){
          //   $convertPrice = 0.0000427862 ;
          //   echo  ceil(($amount  * $convertPrice) - ceil( $cost  * $convertPrice)) ;echo '$';
          // }
          echo $cart->get_total();
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class="checkout-line"></div>
  <div class="top">
    <div class="listing-cart ">
    <?php
    foreach($items as $item => $values) {
      $_product =  wc_get_product( $values['data']->get_id() );
      ?>
      <div class="item checkout_product_item">
        <div class="wrap-item-detail">
          <div class="wrap-title">
            <div class="title checkout_product_title">
              <a href="<?php echo esc_url( get_permalink( $_product->get_parent_id() ) ); ?>"><?php echo "<b>".$_product->get_title() .'</b>'; ?></a>
            </div>
              <!-- <p>Light Cotton Canvas</p> -->
          </div>
          <div class="wrap-attr">
            <div class="left">
              <div class="attr checkout_attr">
                <?php
                foreach ($_product->get_attributes() as $slug => $attr_val) {
                  $term = get_term_by('slug', $attr_val, $slug);
                  $temp = wc_attribute_label($slug).': '.$term->name;
                  ?>
                  <div class="attr-item ">
                    <?php
                     echo $temp; 
                    
                     ?>
                  </div>
                  <?php
                }
                ?>
              </div>
              <div class="quantity">
              Quality: <?php echo ' '.$values['quantity']; ?>
              </div>
            </div>
            <div class="right">
              <div class="p-price">
                <?php
                  
                  // $current_language = get_locale();

                  // if( $current_language == 'vi' ){
                  //   echo   ($_product ->get_price()) *$values['quantity']  ; echo 'VNĐ' ; ;
                  // }
                  
                  // if( $current_language == 'en_US' ){
                  //   $convertPrice = 0.0000427862 ;
                  //   echo  ($_product ->get_price() * $convertPrice) *$values['quantity'] ;echo '$';
                  // }
                
                  echo wc_price($_product->get_price() * $values['quantity']);
                ?>
              </div>
              <span class="delete delete-checkout-icon" data-itemkey="<?php echo $item; ?>"><img src="<?php echo get_template_directory_uri().'/assets/del-b2.svg' ?>" /></span>
            </div>
          </div>
        </div>
        
        <div class="thumbnail checkout_product_thumbnail">
          <img src="<?php echo wp_get_attachment_image_url($_product->get_image_id(),'sp-chkout-img'); ?>" alt="">
        </div>

      </div>
      <?php
      }
      ?>
    </div>
  </div>
  <?php
  }else{
    ?>
    <div class="empty-cart">
      Your cart is empty!
    </div>
    <?php
  }
  die();
}
