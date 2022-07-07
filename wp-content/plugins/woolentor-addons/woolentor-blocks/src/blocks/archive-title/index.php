<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WooLentorBlocks_Archive_Title{

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
		include WOOLENTOR_BLOCK_PATH . '/src/blocks/archive-title/block.json';
		$metadata = json_decode( ob_get_clean(), true );

		register_block_type(
			$metadata['name'],
			array(
				'title' 		  => __('WL: Archive Title', 'woolentor'),
				'attributes'      => $metadata['attributes'],
				'render_callback' => [ $this, 'render_content' ]
			)
		);

	}

	public function render_content( $settings, $content ){
		
		$uniqClass 	 = 'woolentorblock-'.$settings['blockUniqId'];
		$areaClasses = array( $uniqClass, 'woolentor-archive-data-area' );

		!empty( $settings['className'] ) ? $areaClasses[] = $settings['className'] : '';

        $data       = woolentor_get_archive_data();
        $title_tag  = woolentor_validate_html_tag( $settings['titleTag'] );

        $title          = ( $settings['showTitle'] == true && !empty( $data['title'] ) ) ? sprintf( "<%s class='woolentor-archive-title'>%s</%s>", $title_tag, esc_html( $data['title'] ), $title_tag  ) : '';
        $description    = ( $settings['showDescription'] == true && !empty( $data['desc'] ) ) ? sprintf( "<div class='woolentor-archive-desc'>%s</div>", esc_html( $data['desc'] )  ) : '';
        $image          = ( $settings['showImage'] == 'yes' && !empty( $data['image_url'] ) ) ? sprintf( "<div class='woolentor-archive-image'><img src='%s' alt='%s'></div>", esc_url( $data['image_url'] ), esc_attr( $data['title'] )  ) : '';

		ob_start();
		echo '<div class="'.implode(' ', $areaClasses ).'">';
			echo sprintf( '%s %s %s', $image, $title, $description );
		echo '</div>';
		return ob_get_clean();

	}

}
WooLentorBlocks_Archive_Title::instance();