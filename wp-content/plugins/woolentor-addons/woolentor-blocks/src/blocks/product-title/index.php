<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WooLentorBlocks_Product_Title{

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
		include WOOLENTOR_BLOCK_PATH . '/src/blocks/product-title/block.json';
		$metadata = json_decode( ob_get_clean(), true );

		register_block_type(
			$metadata['name'],
			array(
				'title' 		  => __('WL: Product Title', 'woolentor'),
				'attributes'      => $metadata['attributes'],
				'render_callback' => [ $this, 'render_content' ]
			)
		);

	}

	public function render_content( $settings, $content ){
		
		$uniqClass 	 = 'woolentorblock-'.$settings['blockUniqId'];
		$areaClasses = array( $uniqClass, 'product_title' );

		!empty( $settings['className'] ) ? $areaClasses[] = $settings['className'] : '';

        $title_html_tag = woolentor_validate_html_tag( $settings['titleTag'] );

		ob_start();
        echo sprintf( "<%s class='%s'>%s</%s>", $title_html_tag, implode(' ', $areaClasses ), get_the_title(), $title_html_tag  );
		return ob_get_clean();

	}

}
WooLentorBlocks_Product_Title::instance();