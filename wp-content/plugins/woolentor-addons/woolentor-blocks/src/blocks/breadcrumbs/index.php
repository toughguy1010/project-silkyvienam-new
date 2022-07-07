<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WooLentorBlocks_Breadcrumbs{

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
		include WOOLENTOR_BLOCK_PATH . '/src/blocks/breadcrumbs/block.json';
		$metadata = json_decode( ob_get_clean(), true );

		register_block_type(
			$metadata['name'],
			array(
				'title' 		  => __('WL: Breadcrumbs', 'woolentor'),
				'attributes'      => $metadata['attributes'],
				'render_callback' => [ $this, 'render_content' ]
			)
		);

	}

	public function render_content( $settings, $content ){
		
		$uniqClass 	 = 'woolentorblock-'.$settings['blockUniqId'];
		$areaClasses = array( $uniqClass, 'woolentor-breadcrumb' );
		!empty( $settings['className'] ) ? $areaClasses[] = $settings['className'] : '';

        $args = [
            'delimiter'   => !empty( $settings['separator'] ) ? '<span class="breadcrumb-separator">'.$settings['separator'].'</span>' : '<span class="breadcrumb-separator">&nbsp;&#47;&nbsp;</span>',
            'wrap_before' => '<nav class="woocommerce-breadcrumb">',
            'wrap_after'  => '</nav>',
        ];

		ob_start();
		echo '<div class="'.implode(' ', $areaClasses ).'">';
			woocommerce_breadcrumb( $args );
		echo '</div>';
		return ob_get_clean();

	}

}
WooLentorBlocks_Breadcrumbs::instance();