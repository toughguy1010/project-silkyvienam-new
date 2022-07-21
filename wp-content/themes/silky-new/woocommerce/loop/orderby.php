<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<form class="woocommerce-ordering custom-select" method="get">
	<!-- <label for="orderby">Sắp xếp</label> -->
		<!-- <select name="orderby" class="orderby form-select" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
				<?php foreach ( $catalog_orderby_options as $option_id => $name ) : ?>
					<option value="<?php echo esc_attr( $option_id ); ?>" <?php selected( $orderby, $option_id ); ?>><?php echo esc_html( $name ); ?></option>
				<?php endforeach; ?>
		</select> -->
	<div class="  sorting-btn " style="position:relative ;"  >
		<input type="button" id="select_staff" class="  dropdown-toggle" type="button" data-toggle="dropdown" value="Sắp xếp">
		<ul id="admin_cal_list" class=" " >
			<input type="hidden" id="admin_id" class="form-control" name="orderby" class="orderby form-select" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>" value="popularity">
					<?php foreach ( $catalog_orderby_options as $option_id => $name ) : ?>
						<option value="<?php echo esc_attr( $option_id ); ?>" <?php selected( $orderby, $option_id ); ?>><?php echo esc_html( $name ); ?></option>
					<?php endforeach; ?>
		</ul>
		<div class="sorting-arrow-btn"></div>
	</div>
	
	<input type="hidden" name="paged" value="1" />
	<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
</form>
</div>
</div>
</div>
</div>