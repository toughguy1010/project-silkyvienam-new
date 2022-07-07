<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WooLentorBlocks_Product_Upsell{

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
		include WOOLENTOR_BLOCK_PATH . '/src/blocks/product-upsell/block.json';
		$metadata = json_decode( ob_get_clean(), true );

		register_block_type(
			$metadata['name'],
			array(
				'title' 		  => __('WL: Product Upsell', 'woolentor'),
				'attributes'      => $metadata['attributes'],
				'render_callback' => [ $this, 'render_content' ]
			)
		);

	}

	public function render_content( $settings, $content ){
		
		$uniqClass 	 = 'woolentorblock-'.$settings['blockUniqId'];
		$areaClasses = array( $uniqClass, 'product_related' );
		!empty( $settings['className'] ) ? $areaClasses[] = $settings['className'] : '';

		!empty( $settings['columns']['desktop'] ) ? $areaClasses[] = 'woolentor-products-columns-'.$settings['columns']['desktop'] : 'woolentor-products-columns-4';
		!empty( $settings['columns']['laptop'] ) ? $areaClasses[] = 'woolentor-products-columns-laptop-'.$settings['columns']['laptop'] : 'woolentor-products-columns-laptop-3';
		!empty( $settings['columns']['tablet'] ) ? $areaClasses[] = 'woolentor-products-columns-tablet-'.$settings['columns']['tablet'] : 'woolentor-products-columns-tablet-2';
		!empty( $settings['columns']['mobile'] ) ? $areaClasses[] = 'woolentor-products-columns-mobile-'.$settings['columns']['mobile'] : 'woolentor-products-columns-mobile-1';

		ob_start();
		$product = wc_get_product();
		if ( empty( $product ) ) { return; }

		// Get upsell Product
		$product_per_page   = '-1';
        $columns            = 4;
        $orderby            = 'rand';
        $order              = 'desc';
        if ( ! empty( $settings['columns']['desktop'] ) ) {
            $columns = $settings['columns']['desktop'];
        }
        if ( ! empty( $settings['orderby'] ) ) {
            $orderby = $settings['orderby'];
        }
        if ( ! empty( $settings['order'] ) ) {
            $order = $settings['order'];
        }
		if ( ! empty( $settings['perPage'] ) ) {
			$product_per_page = $settings['perPage'];
		}

		echo '<div class="'.implode(' ', $areaClasses ).'">';
			woocommerce_upsell_display( $product_per_page, $columns, $orderby, $order );
		echo '</div>';

		return ob_get_clean();

	}

}
WooLentorBlocks_Product_Upsell::instance();