<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WooLentorBlocks_Product_Related{

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
		include WOOLENTOR_BLOCK_PATH . '/src/blocks/product-related/block.json';
		$metadata = json_decode( ob_get_clean(), true );

		register_block_type(
			$metadata['name'],
			array(
				'title' 		  => __('WL: Related Product', 'woolentor'),
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

		$args = [
			'posts_per_page' => 4,
			'columns' => 4,
			'orderby' => $settings['orderBy'],
			'order'   => $settings['order'],
		];
		if ( ! empty( $settings['perPage'] ) ) {
			$args['posts_per_page'] = $settings['perPage'];
		}
		if ( ! empty( $settings['columns']['desktop'] ) ) {
			$args['columns'] = $settings['columns']['desktop'];
		}

		// Get related Product
		$args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), 
			$args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );
		$args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );

		echo '<div class="'.implode(' ', $areaClasses ).'">';
			wc_get_template( 'single-product/related.php', $args );
		echo '</div>';

		return ob_get_clean();

	}

}
WooLentorBlocks_Product_Related::instance();