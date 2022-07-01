<?php
// Enable the user with no privileges to run ajax_login() in AJAX
add_action( 'wp_ajax_nopriv_zwc_cart_popup', 'zenzweb_ajax_zwc_cart_popup' );
add_action( 'wp_ajax_zwc_cart_popup', 'zenzweb_ajax_zwc_cart_popup' );

function zenzweb_ajax_zwc_cart_popup(){
  // Nonce is checked security
  // check_ajax_referer( 'zwc_get_popup', 'nonce_get_popup' );

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
  <span class="close"><img src="<?php echo get_template_directory_uri().'/assets/close.svg' ?>" /></span>
  <?php if( !empty($items) ) { ?>
  <div class="top">
    <div class="listing-cart">
    <?php

    foreach($items as $item => $values) {
      $_product =  wc_get_product( $values['data']->get_id() );
      ?>
      <div class="item">

        <div class="thumbnail">
          <img src="<?php echo wp_get_attachment_image_url($_product->get_image_id(),'full'); ?>" alt="">
        </div>

        <div class="wrap-item-detail">

          <div class="wrap-title">
            <div class="title">
              <a href="<?php echo esc_url( get_permalink( $_product->get_parent_id() ) ); ?>"><?php echo "<b>".$_product->get_title() .'</b>'; ?></a>
            </div>
            <span class="delete" data-itemkey="<?php echo $item; ?>"><img src="<?php echo get_template_directory_uri().'/assets/del.svg' ?>" /></span>
          </div>

          <div class="wrap-attr">
            <div class="left">
              <div class="attr">
                <?php
                foreach ($_product->get_attributes() as $slug => $attr_val) {
                  $term = get_term_by('slug', $attr_val, $slug);
                  $temp = wc_attribute_label($slug).': '.$term->name;
                  ?>
                  <div class="attr-item">
                    <?php echo $temp; ?>
                  </div>
                  <?php
                }
                ?>
              </div>
              <div class="quantity">
                  Qty: <?php echo ' '.$values['quantity']; ?>
              </div>
            </div>
            <div class="right">
              <div class="p-price">
                <?php
                  echo wc_price($_product->get_price() * $values['quantity']);
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
      }
      ?>
    </div>
  </div>

  <div class="bottom">
    <div class="wrap-bottom">
      <div class="cart-total">
        <div class="coll-left">
          <span>
           Total
          </span>
        </div>
        <div class="coll-right">
          <span>
            <?php
            echo $cart->get_cart_total();
            ?>
          </span>
        </div>
      </div>

      <?php get_template_part('template-parts/part','cart-popup-action'); ?>

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
