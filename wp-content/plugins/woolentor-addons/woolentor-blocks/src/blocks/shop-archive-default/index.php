<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WooLentorBlocks_Shop_Archive_Default{

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
		include WOOLENTOR_BLOCK_PATH . '/src/blocks/shop-archive-default/block.json';
		$metadata = json_decode( ob_get_clean(), true );

		register_block_type(
			$metadata['name'],
			array(
				'title' 		  => __('WL: Product Archive Layout (Default)', 'woolentor'),
				'attributes'      => $metadata['attributes'],
				'render_callback' => [ $this, 'render_content' ]
			)
		);

	}

	public function render_content( $settings, $content ){

		if ( get_post_type() == 'woolentor-template'){
			\WooLentor_Default_Data::instance()->theme_hooks('woolentor-product-archive-addons');
		}
		
		$uniqClass 	 = 'woolentorblock-'.$settings['blockUniqId'];
		$areaClasses = array( $uniqClass, 'product_related' );
		!empty( $settings['className'] ) ? $areaClasses[] = $settings['className'] : '';

		if( isset( $settings['saleTagShow'] ) && $settings['saleTagShow'] === false){
			$areaClasses[] = 'woolentor-archive-sale-badge-hide';
		}else{
			!empty( $settings['saleTagPosition'] ) ? $areaClasses[] = 'woolentor-archive-sale-badge-'.$settings['saleTagPosition'] : '';
		}
		!empty( $settings['columns']['desktop'] ) ? $areaClasses[] = 'woolentor-products-columns-'.$settings['columns']['desktop'] : 'woolentor-products-columns-4';
		!empty( $settings['columns']['laptop'] ) ? $areaClasses[] = 'woolentor-products-columns-laptop-'.$settings['columns']['laptop'] : 'woolentor-products-columns-laptop-3';
		!empty( $settings['columns']['tablet'] ) ? $areaClasses[] = 'woolentor-products-columns-tablet-'.$settings['columns']['tablet'] : 'woolentor-products-columns-tablet-2';
		!empty( $settings['columns']['mobile'] ) ? $areaClasses[] = 'woolentor-products-columns-mobile-'.$settings['columns']['mobile'] : 'woolentor-products-columns-mobile-1';

		ob_start();
		
		if ( WC()->session && function_exists( 'wc_print_notices' ) ) {
            wc_print_notices();
        }

        if ( ! isset( $GLOBALS['post'] ) ) {
            $GLOBALS['post'] = null;
        }

        $options = [
			'query_post_type'	=> ! empty( $settings['paginate'] ) ? 'current_query' : '',
			'columns' 			=> $settings['columns']['desktop'],
			'rows' 				=> $settings['rows'],
			'paginate' 			=> !empty( $settings['paginate'] ) ? 'yes' : 'no',
		];
        $options['editor_mode'] = get_post_type() === 'woolentor-template' ? true : false;

		if( !empty( $settings['paginate'] ) ){
			$options['paginate'] = 'yes';
			$options['allow_order'] = !empty( $settings['allowOrder'] ) ? 'yes' : 'no';
			$options['show_result_count'] = !empty( $settings['showResultCount'] ) ? 'yes' : 'no';
		}else{
			$options['order'] 	= !empty( $settings['order'] ) ? $settings['order'] : 'desc';
			$options['orderby'] = !empty( $settings['orderBy'] ) ? $settings['orderBy'] : 'date';
		}

        $shortcode = new \Archive_Products_Render( $options );

        $content = $shortcode->get_content();

		echo '<div class="'.implode(' ', $areaClasses ).'">';
			if ( strip_tags( trim( $content ) ) ) {
				echo $content;
			} else{
				echo '<div class="products-not-found"><p class="woocommerce-info">' . esc_html__( 'No products were found matching your selection.','woolentor' ) . '</p></div>';
			}
		echo '</div>';

		return ob_get_clean();

	}

}
WooLentorBlocks_Shop_Archive_Default::instance();