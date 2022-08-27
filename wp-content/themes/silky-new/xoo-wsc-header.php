<?php
/**
 * Side Cart Header
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/xoo-wsc-header.php.
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

extract( Xoo_Wsc_Template_Args::cart_header() );

?>

<div class="xoo-wsch-top">
							<div onclick="closeSideCartMenu1()" class="cart-toggle-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28.707 28.707">
                                    <defs>
                                        <style>
                                            .a {
                                                fill: none;
                                                stroke: rgb(255, 255, 255);
                                            }
                                        </style>
                                    </defs>
                                    <g transform="translate(0.354 0.354)">
                                        <line class="a" x2="28" y2="28" />
                                        <line class="a" x2="28" y2="28" transform="translate(28) rotate(90)" />
                                    </g>
                                </svg>
                            </div>
</div>
<script>

var cartMenu = document.querySelector('.xoo-wsc-modal')
function closeSideCartMenu1() {
        cartMenu.classList.remove("xoo-wsc-cart-active")
    }


</script>
