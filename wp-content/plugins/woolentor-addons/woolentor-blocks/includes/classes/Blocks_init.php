<?php
namespace WooLentorBlocks;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load general WP action hook
 */
class Blocks_init {


	/**
     * [$_instance]
     * @var null
     */
    private static $_instance = null;
    public static $blocksList = [];

    /**
     * [instance] Initializes a singleton instance
     * @return [Blocks_init]
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
		$this->dynamic_blocks_include();
	}

    /**
     * Load Dynamic blocks
     */
    public function dynamic_blocks_include(){

        $blockList = self::block_list();
		$blockDir  = WOOLENTOR_BLOCK_PATH . '/src/blocks/';
        $gelerate_active_block_list = [];

		foreach ( $blockList as $block_category_key => $blocks ) {

            if( is_array( $blocks ) ){
                foreach( $blocks as $key => $block ){

                    $blockDirName = str_replace('woolentor/', '', trim(preg_replace('/\(.+\)/', '', $block['name'])));
			        $blockFilepath = $blockDir . $blockDirName . '/index.php';
                    
                    if( $block['active'] === true && woolentorBlocks_get_option( $key, 'woolentor_gutenberg_tabs', 'on' ) === 'on' ){
                        array_push( $gelerate_active_block_list, $blockDirName );
                        if( file_exists( $blockFilepath ) ){
                            require_once ( $blockFilepath );
                        }
                    }

                }
            }
            self::$blocksList[$block_category_key] = $gelerate_active_block_list;
            $gelerate_active_block_list = [];

		}

    }

    /**
     * Block List
     */
    public static function block_list(){

        $blockList = [
            'common' => [
                'brand_logo' => array(
                    'label'  => __('Brand Logo','woolentor'),
                    'name'   => 'woolentor/brand-logo',
                    'active' => true,
                ),
                'category_grid' => array(
                    'label'  => __('Category Grid','woolentor'),
                    'name'   => 'woolentor/category-grid',
                    'active' => true,
                ),
                'image_marker' => array(
                    'label'  => __('Image Marker','woolentor'),
                    'name'   => 'woolentor/image-marker',
                    'active' => true,
                ),
                'special_day_offer' => array(
                    'label'  => __('Special Day Offer','woolentor'),
                    'name'   => 'woolentor/special-day-offer',
                    'active' => true,
                ),
                'store_feature' => array(
                    'label'  => __('Store Feature','woolentor'),
                    'name'   => 'woolentor/store-feature',
                    'active' => true,
                ),
                'product_tab' => array(
                    'label'  => __('Product tab','woolentor'),
                    'name'   => 'woolentor/product-tab',
                    'active' => true,
                ),
                'promo_banner' => array(
                    'label'  => __('Promo Banner','woolentor'),
                    'name'   => 'woolentor/promo-banner',
                    'active' => true,
                ),
                'faq' => array(
                    'label'  => __('FAQ','woolentor'),
                    'name'   => 'woolentor/faq',
                    'active' => true,
                ),
                'product_curvy' => array(
                    'label'  => __('Product Curvy','woolentor'),
                    'name'   => 'woolentor/product-curvy',
                    'active' => true,
                ),
                'universal_product' => array(
                    'label'  => __('Universal Product','woolentor'),
                    'name'   => 'woolentor/universal-product',
                    'active' => true,
                ),
                'archive_title' => array(
                    'label'  => __('Archive Title','woolentor'),
                    'name'   => 'woolentor/archive-title',
                    'active' => true,
                ),
                'breadcrumbs' => array(
                    'label'  => __('Breadcrumbs','woolentor'),
                    'name'   => 'woolentor/breadcrumbs',
                    'active' => true,
                ),
            ],

            'builder_common' =>[

            ],

            'single' => [
                'product_title' => array(
                    'label'  => __('Product Title','woolentor'),
                    'name'   => 'woolentor/product-title',
                    'active' => true,
                ),
                'product_price' => array(
                    'label'  => __('Product Price','woolentor'),
                    'name'   => 'woolentor/product-price',
                    'active' => true,
                ),
                'product_addtocart' => array(
                    'label'  => __('Product Add To Cart','woolentor'),
                    'name'   => 'woolentor/product-addtocart',
                    'active' => true,
                ),
                'product_short_description' => array(
                    'label'  => __('Product Short Description','woolentor'),
                    'name'   => 'woolentor/product-short-description',
                    'active' => true,
                ),
                'product_description' => array(
                    'label'  => __('Product Description','woolentor'),
                    'name'   => 'woolentor/product-description',
                    'active' => true,
                ),
                'product_rating' => array(
                    'label'  => __('Product Rating','woolentor'),
                    'name'   => 'woolentor/product-rating',
                    'active' => true,
                ),
                'product_image' => array(
                    'label'  => __('Product Image','woolentor'),
                    'name'   => 'woolentor/product-image',
                    'active' => true,
                ),
                'product_meta' => array(
                    'label'  => __('Product Meta','woolentor'),
                    'name'   => 'woolentor/product-meta',
                    'active' => true,
                ),
                'product_additional_info' => array(
                    'label'  => __('Product Additional Info','woolentor'),
                    'name'   => 'woolentor/product-additional-info',
                    'active' => true,
                ),
                'product_tabs' => array(
                    'label'  => __('Product Tabs','woolentor'),
                    'name'   => 'woolentor/product-tabs',
                    'active' => true,
                ),
                'product_stock' => array(
                    'label'  => __('Product Stock','woolentor'),
                    'name'   => 'woolentor/product-stock',
                    'active' => true,
                ),
                'product_qrcode' => array(
                    'label'  => __('Product QR Code','woolentor'),
                    'name'   => 'woolentor/product-qrcode',
                    'active' => true,
                ),
                'product_related' => array(
                    'label'  => __('Product Related','woolentor'),
                    'name'   => 'woolentor/product-related',
                    'active' => true,
                ),
                'product_upsell' => array(
                    'label'  => __('Product Upsell','woolentor'),
                    'name'   => 'woolentor/product-upsell',
                    'active' => true,
                )
            ],

            'shop' => [
                'shop_archive_product' => [
                    'title'  => __('Archive Layout Default','woolentor'),
                    'name'   => 'woolentor/shop-archive-default',
                    'active' => true,
                ],
            ]
            
        ];

        return apply_filters( 'woolentor_block_list', $blockList );
        
    }

    /* Manage Template type */
    public function get_template_type( $type ){

        switch ( $type ) {

            case 'single':
            case 'quickview':
                $template_type = 'single';
                break;

            case 'shop':
            case 'archive':
                $template_type = 'shop';
                break;

            case 'cart':
                $template_type = 'cart';
                break;

            case 'emptycart':
                $template_type = 'emptycart';
                break;

            case 'minicart':
                $template_type = 'minicart';
                break;

            case 'checkout':
            case 'checkouttop':
                $template_type = 'checkout';
                break;

            case 'myaccount':
            case 'myaccountlogin':
            case 'dashboard':
            case 'orders':
            case 'downloads':
            case 'edit-address':
            case 'edit-account':
                $template_type = 'myaccount';
                break;

            case 'thankyou':
                $template_type = 'thankyou';
                break;

            default:
                $template_type = '';

        }

        return $template_type;

    }


}
