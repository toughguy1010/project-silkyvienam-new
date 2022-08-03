<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

use MailPoet\Form\Block\Html;

defined( 'ABSPATH' ) || exit;
do_action('product_style');

do_action( 'woocommerce_before_cart' ); 

$cart = WC()->cart;

function excerpt_in_cart($cart_item_html, $product_data) {
    global $_product;
    
    $excerpt = get_the_excerpt($product_data['product_id']);
    $excerpt = substr($excerpt, 0, 80);
    
    echo $cart_item_html . '<p class="shortDescription" style="margin: 0 !important ; display: block">' . $excerpt . '' . '</p>';
    }
    
    add_filter('woocommerce_cart_item_name', 'excerpt_in_cart', 40, 2);

?>
<h2 class="view-cart-title">My cart</h2>
<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>
	
	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents view-cart-content " cellspacing="0"  cellpadding="0">
	
	<?php do_action( 'woocommerce_before_cart_contents' ); ?>
		<?php
			
		
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>

					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
						<!-- title product -->
						<td class="product-name view-cart-product-desc" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
							<div class="view-cart-product-title-action">
								<div class="view-cart-product-title">
									<?php
									if ( ! $product_permalink ) {
										echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
									} else {
										echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
									}
								
									do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

									// Meta data.
									echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

									// Backorder notification.
									if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
										echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
									}
									?>
								</div>
								<div class="view-cart-product-price">
								<?php

									// $current_language = get_locale();

									// if( $current_language == 'vi' ){
									// echo   ($_product ->get_price()) *$cart_item['quantity']  ; echo 'VNĐ' ; ;
									// }
									
									// if( $current_language == 'en_US' ){
									// 	$convertPrice = 0.0000427862 ;
									// echo  ($_product ->get_price() * $convertPrice) *$cart_item['quantity'] ;echo '$';
									// }
								

									 echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
								?>
								</div>
							</div>
							<div class="view-cart-attr">
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
							<div class="view-cart-product-content-action">
								<div class="cart-qty-wrap">
									<?php
										if ( $_product->is_sold_individually() ) {
											$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
										} else {
											$product_quantity = woocommerce_quantity_input(
												array(
													'input_name'   => "cart[{$cart_item_key}][qty]",
													'input_value'  => $cart_item['quantity'],
													'max_value'    => $_product->get_max_purchase_quantity(),
													'min_value'    => '0',
													'product_name' => $_product->get_name(),
												),
												$_product,
												false
											);
										}

										echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
									?>
								</div>
								<div class="cart-remove-product">
								
										<?php
											echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
												'woocommerce_cart_item_remove_link',
												sprintf(
													'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">
													<svg id="tHxYAj" xmlns="http://www.w3.org/2000/svg" width="12.347" height="13.892" viewBox="0 0 12.347 13.892">
													  <g id="Group_1514" data-name="Group 1514">
														<g id="Group_1513" data-name="Group 1513">
														  <path id="Path_3573" data-name="Path 3573" d="M204.156,394.22c-.371,0-.724,0-1.077,0-.295,0-.471-.151-.467-.391s.188-.386.478-.386q5.7,0,11.4,0c.3,0,.468.145.466.391s-.165.385-.468.386h-1.035a.466.466,0,0,0-.034.279q0,4.984,0,9.968c0,.447-.112.554-.562.554q-4.059,0-8.119,0c-.485,0-.584-.1-.584-.579V394.22Zm8.467,10.014v-10h-7.668v10Z" transform="translate(-202.612 -391.129)"/>
														  <path id="Path_3574" data-name="Path 3574" d="M208.792,391.906q-.936,0-1.872,0c-.276,0-.448-.149-.453-.382a.4.4,0,0,1,.444-.394q1.874,0,3.745,0a.4.4,0,0,1,.455.386c0,.239-.177.388-.47.388q-.924,0-1.849,0Z" transform="translate(-202.612 -391.129)"/>
														  <path id="Path_3575" data-name="Path 3575" d="M208.017,399.263q0,1.109,0,2.217c0,.28-.142.45-.375.458s-.4-.176-.4-.46q0-2.252,0-4.5a.387.387,0,0,1,.392-.441c.244,0,.384.161.385.444Q208.019,398.12,208.017,399.263Z" transform="translate(-202.612 -391.129)"/>
														  <path id="Path_3576" data-name="Path 3576" d="M210.329,399.264c0,.739,0,1.478,0,2.217,0,.284-.141.451-.375.457a.411.411,0,0,1-.4-.463q0-2.252,0-4.5c0-.279.151-.44.393-.439s.383.161.383.444q0,1.145,0,2.287Z" transform="translate(-202.612 -391.129)"/>
														</g>
													  </g>
													</svg>
													</a>',
													esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
													esc_html__( 'Remove this item', 'woocommerce' ),
													esc_attr( $product_id ),
													esc_attr( $_product->get_sku() )
												),
												$cart_item_key
											);
										?>
								</div>
							</div>
						</td>
					<!-- title product -->
					
					
					
					<!-- delete product -->
						
					<!-- delete product -->
					<!-- img product -->
						<td class="product-thumbnail view-car-product-img-wrapper">
							<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $product_permalink ) {
								echo $thumbnail; // PHPCS: XSS ok.
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
							}
							?>
						</td>
					<!-- img product -->
				
					<!-- product price -->

						
					<!-- product price -->
					<!-- product qty -->
					
					<!-- product qty -->

						
				</tr>
			
					<?php
				}
			}
			?>
			

			<?php do_action( 'woocommerce_cart_contents' ); ?>
		
			<!-- cart action -->
			<tr  class="cart-actions">
				<td colspan="6" class="actions">
					<div class="view-cart-action-line"></div>
					<div class="view-cart-total-section">
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
								// $amount = WC()->cart->cart_contents_total + WC()->cart->tax_total;
								// $current_language = get_locale();
						
								// 					if( $current_language == 'vi' ){
								// 					  echo  $amount   ; echo 'VNĐ' ; ;
								// 					}
													
								// 					if( $current_language == 'en_US' ){
								// 						$convertPrice = 0.0000427862 ;
								// 					  echo $amount  * $convertPrice ;echo '$';
								// 					}
									echo $cart->get_cart_total();
								?>
							</div>
						</div>
						<!-- cart total -->
						<div class="cart-items">
							<div class="view-cart-title-total"><?php esc_html_e( 'Total', 'woocommerce' ); ?></div>
							<div class="view-cart-price-total" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php 
							// $amount = WC()->cart->cart_contents_total + WC()->cart->tax_total;
							// $current_language = get_locale();
					
							// 					if( $current_language == 'vi' ){
							// 					  echo  $amount   ; echo 'VNĐ' ; ;
							// 					}
												
							// 					if( $current_language == 'en_US' ){
							// 						$convertPrice = 0.0000427862 ;
							// 					  echo $amount  * $convertPrice ;echo '$';
							// 					}
							wc_cart_totals_order_total_html(); 
							?></div>
						</div>
						<!-- cart total  -->
					</div>

					<div class="view-cart-btn-action">
						<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

						<!-- proceed checkout -->
						<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button button alt wc-forward">
							<?php esc_html_e( 'Proceed to checkout', 'woocommerce' ); ?>
						</a>
					</div>
					<!-- proceed checkout -->
					

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</td>
			</tr>
			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		
	</table>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-collaterals">
	<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		//do_action( 'woocommerce_cart_collaterals' );
	?>
</div>
<?php do_action( 'woocommerce_after_cart' ); ?>
