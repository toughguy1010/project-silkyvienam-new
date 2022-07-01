<div class="cart-action">
  <div class="view-bag">
    <a class="view-bag-btn" href="<?php echo function_exists('pll_get_post') ? esc_url( get_permalink( pll_get_post( get_option( 'woocommerce_cart_page_id' ) ) ) ) : esc_url( wc_get_cart_url() ); ?>"><span></span> View Cart</a>
  </div>
  <div class="proceed">
    <a class="proceed-btn" href="<?php echo function_exists('pll_get_post') ? esc_url( get_permalink( pll_get_post( get_option( 'woocommerce_checkout_page_id' ) ) ) ) : esc_url( wc_get_checkout_url() ); ?>"><span></span> Check Out</a>
  </div>
</div>
