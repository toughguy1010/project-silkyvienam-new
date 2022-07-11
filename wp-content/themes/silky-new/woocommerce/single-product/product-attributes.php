<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $product_attributes ) {
	return;
}
?>
<table class="woocommerce-product-attributes shop_attributes">
	<?php foreach ( $product_attributes as $product_attribute_key => $product_attribute ) : ?>
		<div class="woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo esc_attr( $product_attribute_key ); ?>">
			<div class="woocommerce-product-attributes-item__label "><?php echo wp_kses_post( $product_attribute['label'] ); ?></div>
			<div class="woocommerce-product-attributes-item__value "><?php echo wp_kses_post( $product_attribute['value'] ); ?></div>
		</div>
	<?php endforeach; ?>
</table>

<div class="button-wrapper sizechart-btn">
				<a class="<?php 
            echo  esc_attr( $size_chart_get_button_class ) ;
            ?> md-size-chart-btn" chart-data-id="chart-<?php 
            echo  esc_attr( $chart_id ) ;
            ?>" href="javascript:void(0);" id="chart-button">
					<?php 
            echo  esc_html( $popup_label ) ;
            ?>
				</a>
			</div>

