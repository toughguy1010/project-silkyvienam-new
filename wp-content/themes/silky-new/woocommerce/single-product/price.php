<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>
<p class="price_detail_product <?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php 
echo $product->get_price_html(); 
// $current_language = get_locale();

// 		if( $current_language == 'vi' ){
// 		  echo   apply_filters('silky_filter-product-price',$product->get_price()  ); echo 'VNĐ' ; ;
// 		}
		
// 		if( $current_language == 'en_US' ){
// 			$convertPrice = 0.0000427862 ;
// 		  echo apply_filters('silky_filter-product-price', ceil($product->get_price() * $convertPrice)  );echo '$';
// 		}

?></p>
