<?php
/**
 * Side Cart Container
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/xoo-wsc-container.php.
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

extract( Xoo_Wsc_Template_Args::cart_container() );

?>

<div class="xoo-wsc-container">

	<div class="xoo-wsc-basket">

		<?php if( $showCount === "yes" ): ?>
			<span class="xoo-wsc-items-count"><?php echo xoo_wsc_cart()->get_cart_count() ?></span>
		<?php endif; ?>
		<svg class="cart-icon" xmlns="http://www.w3.org/2000/svg" width="11.984" height="13.973" viewBox="0 0 11.984 13.973">
                            <defs>
                              <style>
                                .cls-1 {
                                  fill: #282828;
                                }
                                .cart-icon:hover .cls-1{
                                    fill: #866733;
                                }

                              </style>
                            </defs>
                            <path id="Path_9" data-name="Path 9" class="cls-1" d="M-35.743,70.273c.107-1.835,1.442-3.5,2.682-3.5a3.7,3.7,0,0,1,2.795.758,3.609,3.609,0,0,1,1.152,2.675,1.652,1.652,0,0,0,.8.061c.961.012,1.356.351,1.417,1.311.134,2.088.247,4.178.371,6.268.028.488.087.975.1,1.464.019.99-.429,1.436-1.412,1.436h-9.112c-1.037,0-1.5-.458-1.457-1.513.07-1.76.172-3.517.258-5.276.031-.625.052-1.252.092-1.876a5.53,5.53,0,0,1,.116-.929,1.017,1.017,0,0,1,1.123-.882C-36.473,70.269-36.124,70.273-35.743,70.273Zm3.328,9.639c1.491,0,2.981-.026,4.471.012.579.014.718-.233.678-.731-.044-.526-.075-1.054-.106-1.582q-.179-2.96-.355-5.92c-.024-.418-.175-.6-.648-.593q-4.058.036-8.116,0c-.532-.007-.7.209-.718.662-.035.744-.065,1.487-.1,2.23q-.131,2.639-.267,5.279c-.023.449.121.669.634.658C-35.434,79.891-33.923,79.911-32.414,79.911Zm2.458-9.661a2.55,2.55,0,0,0-1.287-2.37,2.248,2.248,0,0,0-2.535.113,2.526,2.526,0,0,0-1.1,2.257Z" transform="translate(38.414 -66.777)"/>
                          </svg>
		<!-- <span class="xoo-wsc-bki xoo-wsc-icon-basket1"></span> -->

		<?php do_action( 'xoo_wsc_basket_content' ); ?>

	</div>

	<div class="xoo-wsc-header">

		<?php do_action( 'xoo_wsc_header_start' ); ?>

		<?php xoo_wsc_helper()->get_template( 'xoo-wsc-header.php' ); ?>

		<?php do_action( 'xoo_wsc_header_end' ); ?>

	</div>


	<div class="xoo-wsc-body">

		<?php do_action( 'xoo_wsc_body_start' ); ?>

		<?php xoo_wsc_helper()->get_template( 'xoo-wsc-body.php' ); ?>

		<?php do_action( 'xoo_wsc_body_end' ); ?>

	</div>

	<div class="xoo-wsc-footer">

		<?php do_action( 'xoo_wsc_footer_start' ); ?>

		<?php xoo_wsc_helper()->get_template( 'xoo-wsc-footer.php' ); ?>

		<?php do_action( 'xoo_wsc_footer_end' ); ?>

	</div>

	<span class="xoo-wsc-loader"></span>

</div>