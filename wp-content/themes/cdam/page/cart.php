<?php
/**
*
*
* Template Name: Cart
*
*
*/

get_header();

?>
<div id="primary" class="content-area">
  <main id="main" class="site-main">
    <div id="cart-page">
      <h1 class="entry-title">
        <?php echo $post->post_title; ?>
      </h1>
      <div class="wrap-cart-page">
        <?php
        // $cart = WC()->cart;
        // $items = $cart->get_cart();

        // foreach($items as $item => $values) {
        //   $_product =  wc_get_product( $values['data']->get_id() );
        //   $_product = pll_get_post($values['data']->get_id(),pll_current_language());
        //   if( $_product == '' ){
        //     $cart->remove_cart_item($item);
        //   }
        // }

        $cart = WC()->cart;
        $items = $cart->get_cart();
        ?>
        <div class="top">
          <div class="listing-cart">

          <?php
          foreach($items as $item => $values) {
            $_product =  wc_get_product( $values['data']->get_id() );
            ?>
            <div class="item <?php echo $item; ?>">

              <div class="thumbnail">
                <?php print_r(wp_get_attachment_image($_product->get_image_id(),'cart-thumb')); ?>
              </div>

              <div class="wrap-item-detail">

                <div class="wrap-title">
                  <div class="title">
                    <a href="<?php echo esc_url( get_permalink( $_product->get_parent_id() ) ); ?>"><?php echo $_product->get_title(); ?></a>
                  </div>
                  <span class="delete" data-itemkey="<?php echo $item; ?>"><img src="<?php echo get_template_directory_uri().'/assets/del-b.svg' ?>" /></span>
                </div>

                <div class="wrap-attr">
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
                  <div class="p-price">
                    <span>Price</span>
                    <?php
                    echo $_product->get_price_html();
                    ?>
                  </div>
                  <div class="quantity">
                    <span>Qty:</span>
                    <div class="change-qty">
                      <span class="pre">-</span>
                      <label data-itemkey="<?php echo $item; ?>"><?php echo $values['quantity']; ?></label>
                      <span class="next">+</span>
                    </div>
                  </div>
                  <div class="p-total">
                    <span>Total</span>
                    <?php
                    echo wc_price($_product->get_price() * $values['quantity']);
                    ?>
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
                    <?php echo wc_price(-$discount_total) ?>
                  </span>
                  <?php get_template_part('template-parts/part','listing-coupon'); ?>
                </div>
              </div>
            <?php endif; ?>
            <div class="cart-items item">
              <div class="coll-left">
                <span>
                 <?php
                 $count = $cart->get_cart_contents_count();
                 echo $count > 0 ? ( $count == 1 ? $count.' item' : $count.' items' ) : ''; ?>
                </span>
              </div>
              <div class="coll-right">
                <?php
                echo $cart->get_cart_total();
                ?>
              </div>
            </div>
            <div class="cart-total item">
              <div class="coll-left">
                <span>
                 Total
                </span>
              </div>
              <div class="coll-right">
                <?php
                echo $cart->get_cart_total();
                ?>
              </div>
            </div>
          </div>
        </div>
        <?php get_template_part('template-parts/part','cart-popup-action-in-cart'); ?>
      </div>
    </div>
  </main>
</div>
<?php
get_footer();
