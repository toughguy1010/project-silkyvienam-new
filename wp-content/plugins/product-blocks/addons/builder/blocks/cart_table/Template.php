<?php
defined( 'ABSPATH' ) || exit;

    do_action( 'woocommerce_before_cart' );
    WC()->cart->calculate_totals();
    WC()->cart->calculate_shipping();

    function product_remove($args) {
        echo '<div class="product-remove">';
            echo apply_filters(
                'woocommerce_cart_item_remove_link',
                sprintf(
                    '<a href="%s" class="remove wopb-cart-product-remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                    esc_url( wc_get_cart_remove_url( $args['cart_item_key'] ) ),
                    esc_html__( 'Remove this item', 'product-blocks' ),
                    esc_attr( $args['product']->get_id() ),
                    esc_attr( $args['product']->get_sku() )
                ),
                $args['cart_item_key']
            );
        echo '</div>';
    }

    function product_thumbnail($args ) {
        $html = '';
        $html .= '<div class="wopb-product-image-section">';
            ob_start();
                printf( '<a href="%s">%s</a>', esc_url( $args['product_permalink'] ), $args['thumbnail'] );
            $html .= ob_get_clean();
            if ($args['attribute']['removeBtnPosition'] == 'withImage') {
                ob_start();
                   product_remove($args);
                $html .= ob_get_clean();
            }

            $html .= '</div>';

        return $html;
    }

    function cross_sell_product() {
        $cross_sell_product = '';
        ob_start();
            remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals' );
            do_action( 'woocommerce_cart_collaterals' );
        $cross_sell_product .= ob_get_clean();
        return $cross_sell_product;
    }

    $cross_sell_product = '';
    $cross_sell_class = '';
    $cart_form_class = ' wopb-cart-form';

    if($attr['showCrossSell'] && !empty(cross_sell_product())) {
        $cross_sell_class .= 'wopb-cart-cross-sell';
        if($attr['crossSellPosition'] == 'right') {
            $cart_form_class .= ' wopb-cart-form-left';
            $cross_sell_class .= ' wopb-cart-cross-sell-right';
        }elseif($attr['crossSellPosition'] == 'bottom') {
            $cart_form_class .= ' wopb-cart-form-bottom';
            $cross_sell_class .= ' wopb-cart-cross-sell-bottom';
        }
        $cross_sell_product .= '<div class="cart-collaterals '.esc_attr($cross_sell_class).'">'.cross_sell_product().'</div>';
    }
?>
<form class="woocommerce-cart-form <?php esc_attr_e($cart_form_class) ?>" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
    <?php do_action( 'woocommerce_before_cart_table' ); ?>
    <table class="woocommerce-cart-form__contents wopb-cart-table">
        <thead>
            <tr>
                <th><?php echo esc_html( $attr['productHead'] ); ?></th>
                <th class="wopb-cart-table-price" ><?php echo esc_html( $attr['priceHead'] ); ?></th>
                <th class="wopb-product-qty"><?php echo esc_html( $attr['qtyHead'] ); ?></th>
                <th class="wopb-product-subtotal"><?php echo esc_html( $attr['subTotalHead'] ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php do_action( 'woocommerce_before_cart_contents' ); ?>
            <?php
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                     $product = wc_get_product($cart_item['variation_id'] ? $cart_item['variation_id'] : $cart_item['product_id']);
                    $args = [
                      'attribute' => $attr,
                      'product' => $product,
                      'thumbnail' => apply_filters( 'woocommerce_cart_item_thumbnail', $product->get_image(), $cart_item, $cart_item_key ),
                      'product_permalink' => apply_filters( 'woocommerce_cart_item_permalink', $product->is_visible() ? $product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key ),
                      'cart_item_key' => $cart_item_key,
                      'cart_item' => $cart_item,
                    ];

                    $cart_item_name = '';
                    if ( ! $args['product_permalink'] ) {
                        $cart_item_name = wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $product->get_name(), $args['cart_item'], $args['cart_item_key'] ) . '&nbsp;' );
                    } else {
                        $cart_item_name = wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $args['product_permalink'] ), $product->get_name() ), $args['cart_item'], $args['cart_item_key'] ) );
                    }
                    if ( $product && $product->exists() && $args['cart_item']['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $args['cart_item'], $args['cart_item_key'] ) ) {
                ?>
                        <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $args['cart_item'], $args['cart_item_key'] ) ); ?>">
                            <td class="wopb-cart-table-small">
                                <?php
                                    if ($attr['removeBtnPosition'] !== 'withImage') {
                                        product_remove($args);
                                    }
                                    echo product_thumbnail($args);
                                ?>
                            </td>
                            <td data-title="<?php esc_attr_e(  $attr['productHead'], 'product-blocks' ); ?>">
                                <div class="wopb-cart-table-product-details">
                                    <div class="wopb-cart-table-medium">
                                        <?php
                                            if ($attr['removeBtnPosition'] == 'left') {
                                                product_remove($args);
                                            }
                                        ?>
                                        <?php echo product_thumbnail($args); ?>
                                    </div>

                                    <div class="wopb-cart-table-product-section">
                                        <?php
                                            echo $cart_item_name;
                                            do_action( 'woocommerce_after_cart_item_name', $args['cart_item'], $args['cart_item_key'] );
                                            echo wc_get_formatted_cart_item_data( $args['cart_item'] );

                                            if ( $product->backorders_require_notification() && $product->is_on_backorder( $args['cart_item']['quantity'] ) ) {
                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'product-blocks' ) . '</p>', $product->get_id() ) );
                                            }
                                        ?>
                                    </div>
                                </div>
                            </td>

                            <td class="wopb-cart-table-price" data-title="<?php esc_attr_e(  $attr['priceHead'], 'product-blocks' ); ?>">
                                <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $product ), $args['cart_item'], $args['cart_item_key'] ); ?>
                            </td>

                            <td class="wopb-product-qty" data-title="<?php esc_attr_e( $attr['qtyHead'], 'product-blocks' ); ?>">
                                <?php
                                    if ( $product->is_sold_individually() ) {
                                        $product_quantity = sprintf( '1 <input type="hidden" class="qty wopb-quantity" name="cart[%s][qty]" value="1" />', $args['cart_item_key'] );
                                    } else {
                                        $product_quantity = woocommerce_quantity_input(
                                            array(
                                                'input_name' => "cart[{$args['cart_item_key']}][qty]",
                                                'input_value' => $args['cart_item']['quantity'],
                                                'max_value' => $product->get_max_purchase_quantity(),
                                                'min_value' => '0',
                                                'product_name' => $product->get_name(),
                                            ),
                                            $product,
                                            false
                                        );
                                    }
                                    echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $args['cart_item_key'], $args['cart_item'] );
                                ?>
                            </td>

                            <td class="wopb-product-subtotal" data-title="<?php esc_html_e( $attr['subTotalHead'], 'product-blocks'); ?>">
                                <?php
                                    echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $product, $args['cart_item']['quantity'] ), $args['cart_item'], $args['cart_item_key'] );
                                ?>
                                <div class="wopb-cart-table-medium">
                                    <?php
                                        if ($attr['removeBtnPosition']=='right') {
                                            product_remove($args);
                                        }
                                    ?>
                                </div>
                            </td>

                        </tr>
            <?php
                    }
                }
            ?>

        </tbody>
    </table>

    <?php do_action( 'woocommerce_cart_contents' ); ?>

    <div class="wopb-cart-table-options">
        <span class="wopb-cart-table-option wopb-cart-table-first-option <?php echo (!$attr['showCoupon'] || !$attr['showContinue'])? 'wopb-cart-table-option-hidden':'' ?>">
            <?php if ($attr['showCoupon'] && wc_coupons_enabled()) : ?>
                <div class="wopb-cart-coupon-section">
                    <input type="text" name="coupon_code" id="coupon_code" class="wopb-coupon-code" value="" placeholder="<?php echo esc_attr($attr['couponInputPlaceholder']); ?>"/>
                    <button type="submit" class="wopb-cart-coupon-submit-btn" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'product-blocks' ); ?>">
                        <?php echo esc_html( $attr['couponBtnText'] ); ?>
                    </button>
                </div>
                <?php do_action( 'woocommerce_cart_coupon' ); ?>
            <?php endif; ?>

            <?php
                if ($attr['showContinue']) {
                    $return_to = wc_get_page_permalink( 'shop' );
            ?>
                <a class="wopb-cart-shopping-btn button " href=<?php printf( $return_to )?> >
                    &#8592;<?php echo esc_html( $attr['continueShoppingText'], 'product-blocks' ); ?>
                </a>
            <?php } ?>
        </span>

        <span class="wopb-cart-table-option wopb-cart-table-second-option  <?php echo (!$attr['showEmpty'] || !$attr['showUpdate'])? 'wopb-cart-table-option-hidden':'' ?>">
            <?php if ($attr['showEmpty']) : ?>
                <a class="wopb-cart-empty-btn " name="empty_cart" href="<?php echo wc_get_cart_url(); ?>?empty-cart"><?php echo ( $attr['emptyText'] ); ?></a>
            <?php endif; ?>
            <?php if($attr['showUpdate']) : ?>
                <button type="submit" class='wopb-cart-update-btn' name="update_cart" value="Update cart"><?php echo esc_html( $attr['updateText'] ); ?></button>
            <?php endif; ?>
        </span>

        <?php do_action( 'woocommerce_cart_actions' ); ?>
        <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
    </div>
    <?php do_action( 'woocommerce_after_cart_contents' ); ?>
    <?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<?php echo $cross_sell_product ?>

<?php do_action( 'woocommerce_after_cart' ); ?>
