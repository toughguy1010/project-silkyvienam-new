<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WooLentorBlocks_Product_Image{

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
		include WOOLENTOR_BLOCK_PATH . '/src/blocks/product-image/block.json';
		$metadata = json_decode( ob_get_clean(), true );

		register_block_type(
			$metadata['name'],
			array(
				'title' 		  => __('WL: Product Image', 'woolentor'),
				'attributes'      => $metadata['attributes'],
				'render_callback' => [ $this, 'render_content' ]
			)
		);

	}

	public function render_content( $settings, $content ){
		
		$uniqClass 	 = 'woolentorblock-'.$settings['blockUniqId'];
		$areaClasses = array( $uniqClass, 'woolentor-product-image' );

		!empty( $settings['className'] ) ? $areaClasses[] = $settings['className'] : '';

		ob_start();
		$product = wc_get_product();
		if ( empty( $product ) ) { return; }
		echo '<div class="'.implode(' ', $areaClasses ).'">';
			/**
             * Hook: woocommerce_before_single_product_summary.
             *
             * @hooked woocommerce_show_product_sale_flash - 10
             * @hooked woocommerce_show_product_images - 20
             */
			woocommerce_show_product_sale_flash();
			woocommerce_show_product_images();
            // do_action( 'woocommerce_before_single_product_summary' );
		echo '</div>';
		return ob_get_clean();

	}

}
WooLentorBlocks_Product_Image::instance();