<div class="cart-action">
  <div class="update-cart">
    <a class="update-cart-btn" href="javascript:;"><span></span> Update Cart</a>
  </div>
  <div class="proceed">
    <a class="proceed-btn" href="<?php echo function_exists('pll_get_post') ? esc_url( get_permalink( pll_get_post( get_option( 'woocommerce_checkout_page_id' ) ) ) ) : esc_url( wc_get_checkout_url() ); ?>"><span></span> Proceed To Checkout</a>
  </div>
</div>
