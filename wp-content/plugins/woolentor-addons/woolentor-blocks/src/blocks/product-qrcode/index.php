<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WooLentorBlocks_Product_QRCode{

	/**
     * [$_instance]
     * @var null
     */
    private static $_instance = null;

    /**
     * [instance] Initializes a singleton instance
     * @return [Actions]
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

	/**
	 * The Constructor.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'init' ] );
	}

	public function init(){

		// Return early if this function does not exist.
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		// Load attributes from block.json.
		ob_start();
		include WOOLENTOR_BLOCK_PATH . '/src/blocks/product-qrcode/block.json';
		$metadata = json_decode( ob_get_clean(), true );

		register_block_type(
			$metadata['name'],
			array(
				'title' 		  => __('WL: Product QR Code', 'woolentor'),
				'attributes'      => $metadata['attributes'],
				'render_callback' => [ $this, 'render_content' ]
			)
		);

	}

	public function render_content( $settings, $content ){
		
		$uniqClass 	 = 'woolentorblock-'.$settings['blockUniqId'];
		$areaClasses = array( $uniqClass, 'woolentor-qrcode' );

		!empty( $settings['className'] ) ? $areaClasses[] = $settings['className'] : '';

		ob_start();

		$product = wc_get_product();
		if( empty( $product ) ){
			$product = wc_get_product( woolentor_get_last_product_id() );
		}

		$product_id = $product->get_id();

		$quantity = ( !empty( $settings['quantity'] ) ? $settings['quantity'] : 1 );
        if( $settings['addCartUrl'] == 'yes' ){
            $url = get_the_permalink( $product_id ).sprintf( '?add-to-cart=%s&quantity=%s', $product_id, $quantity );
        }else{
            $url = get_the_permalink( $product_id );
        }

        $title = get_the_title( $product_id );
        $product_url   = urlencode( $url );

        $size      = ( !empty( $settings['size'] ) ? $settings['size'] : 120 );
        $dimension = $size.'x'.$size;
		$image_src = sprintf( 'https://api.qrserver.com/v1/create-qr-code/?size=%s&ecc=L&qzone=1&data=%s', $dimension, $product_url );
		
		echo '<div class="'.implode(' ', $areaClasses ).'">';
			echo sprintf('<img src="%1$s" alt="%2$s">', $image_src, $title );
		echo '</div>';

		return ob_get_clean();

	}

}
WooLentorBlocks_Product_QRCode::instance();