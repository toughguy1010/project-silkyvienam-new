<?php
	defined( 'ABSPATH' ) || exit;
	if (isset($_POST['calc_shipping_country'])) {
		if (class_exists('WC_Shortcode_Cart')) {
			WC_Shortcode_Cart::calculate_shipping();
	}
	}
	WC()->cart->calculate_totals();
	WC()->cart->calculate_shipping();
?>

<div class="wopb-cart-total cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">
	<?php do_action( 'woocommerce_before_cart_totals' ); ?>
	<div class="wopb-table-heading"><?php esc_html_e( $attr['cartTotalTxt'] ); ?></div>

	<div class="wopb-cart-total-section">
	<!-- shop_table_responsive -->
		<table cellspacing="0" class="shop_tableA shop_table_responsiveA">
			<tbody>
				<tr class="cart-subtotal">
					<th><?php echo esc_html_e( $attr['subTotalTxt'] ); ?></th>
					<td class="wopb-total-price"><?php wc_cart_totals_subtotal_html(); ?></td>
				</tr>

				<!-- // Coupon LVL -->
				<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
					<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
						<td class="wopb-total-price" data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>">
                            <?php wc_cart_totals_coupon_html( $coupon ); ?>
                        </td>
					</tr>
				<?php endforeach; ?>

				
				<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
					<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>
					<?php wc_cart_totals_shipping_html(); ?>
					<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

				<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>
					<tr class="shipping">
						<th><?php echo __( 'Shipping', 'product-blocks' ); ?></th>
						<td class="wopb-total-price"><?php woocommerce_shipping_calculator(); ?></td>
					</tr>
				<?php endif; ?>
				
				<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
					<tr class="fee">
						<th><?php echo esc_html( $fee->name ); ?></th>
						<td class="wopb-total-price" data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></td>
					</tr>
				<?php endforeach; ?>

				<?php
				if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
					$taxable_address = WC()->customer->get_taxable_address();
					$estimated_text = '';
					if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
						$estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'product-blocks' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
					}
					if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
						foreach ( WC()->cart->get_tax_totals() as $code => $tax ) {
							?>
							<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
								<th><?php echo esc_html( $tax->label ) . $estimated_text; ?></th>
								<td class="wopb-total-price"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
							</tr>
						<?php
						}
					} else { ?>
						<tr class="tax-total">
							<th><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; ?></th>
							<td class="wopb-total-price" data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></td>
						</tr>
					<?php
					}
				}
				?>

				<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>
				
				<tr class="order-total">
					<th><?php echo $attr['totalTxt'] ? $attr['totalTxt'] :__( 'Total', 'product-blocks' ); ?></th>
					<td class="wopb-total-price" data-title="<?php esc_attr_e( 'Total', 'product-blocks' ); ?>"><?php wc_cart_totals_order_total_html(); ?></td>
				</tr>
			</tbody>
			<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

		</table>
		
		<div class="wc-proceed-to-checkout">
			<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button button alt wc-forward">
				<?php esc_html_e( $attr['checkoutTxt'], 'product-blocks' ); ?> &rarr;
			</a>
		</div>
	</div>
	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>

