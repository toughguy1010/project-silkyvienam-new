<?php
/**
 * Product
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/global/body/product.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen.
 * @see     https://docs.xootix.com/side-cart-woocommerce/
 * @version 2.1
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$productClasses = apply_filters( 'xoo_wsc_product_class', $productClasses );

?>

<div data-key="<?php echo $cart_item_key ?>" class="<?php echo implode( ' ', $productClasses ) ?>">

	<?php do_action( 'xoo_wsc_product_start', $_product, $cart_item_key ); ?>

	

	<div class="xoo-wsc-sum-col">
		<?php do_action( 'xoo_wsc_product_summary_col_start', $_product, $cart_item_key ); ?>
		<div class="xoo-wsc-sm-info">
			
			<div class="xoo-wsc-sm-left">
				
				<?php if( $showPname ): ?>
					<span class="xoo-wsc-pname"><?php echo $product_name; ?></span>
					<?php endif; ?>
					<?php if( $showPdel ): ?>
					<span class="xoo-wsc-smr-del <?php echo $delete_icon ?>"></span>
				<?php endif; ?>
					<?php if( $showPmeta ) echo $product_meta ?>
					
					<?php if( $showPprice && ( $qtyPriceDisplay === 'separate' ) ): ?>
						<div class="xoo-wsc-pprice">
							<?php echo __( 'Price: ', 'side-cart-woocommerce' ) . $product_price 
							?>
						</div>
						<?php endif; ?>
						

				<!-- Quantity -->

				<div class="xoo-wsc-qty-price">

					<?php if( $showPprice && $qtyPriceDisplay === 'one_liner' ): ?>
						<span>Quantity: <?php echo $cart_item['quantity']; ?></span>
						<?php if( $showPtotal ): ?>
							<span class="detail-cart-product-price">  <?php echo $product_subtotal ;
							// $current_language = get_locale();

							// if( $current_language == 'vi' ){
							//   echo   ($_product ->get_price()) *$cart_item['quantity']  ; echo 'VNĐ' ; ;
							// }
							
							// if( $current_language == 'en_US' ){
							// 	$convertPrice = 0.0000427862 ;
							//   echo  ($_product ->get_price() * $convertPrice) *$cart_item['quantity'] ;echo '$';
							// }
						
							
							
							?></span>
						<?php endif; ?>

					<?php else: ?>
						<span class=""><?php _e( 'Qty:', 'side-cart-woocommerce' ) ?></span> <span><?php echo $cart_item['quantity']; ?></span>
					<?php endif;
					 ?>
				</div>
				
			</div>

			<!-- End Quantity -->

			<div class="xoo-wsc-sm-right">

				

				<?php if( $showPtotal && ( $qtyPriceDisplay === 'separate' ) ): ?>
					<span class="xoo-wsc-smr-ptotal"><?php echo $product_subtotal ?></span>
				<?php endif; ?>

			</div>

		</div>

		<?php do_action( 'xoo_wsc_product_summary_col_end', $_product, $cart_item_key ); ?>

	</div>
	<?php if( $showPimage ): ?>

<div class="xoo-wsc-img-col">

	<?php echo $thumbnail; ?>

	<?php do_action( 'xoo_wsc_product_image_col', $_product, $cart_item_key ); ?>

</div>

<?php endif; ?>

	<?php do_action( 'xoo_wsc_product_end', $_product, $cart_item_key );	
// var_dump($cart_item_key);
?>

</div>	