<?php
/**
 * Quickview Addons Core.
 * 
 * @package WOPB\Quickview
 * @since v.1.1.0
 */

namespace WOPB;

defined('ABSPATH') || exit;

/**
 * Quickview class.
 */
class Quickview {

    /**
	 * Setup class.
	 *
	 * @since v.1.1.0
	 */
    public function __construct(){
        add_action('wp_ajax_wopb_quickview', array($this, 'wopb_quickview_callback'));
        add_action('wp_ajax_nopriv_wopb_quickview', array($this, 'wopb_quickview_callback'));

        add_filter('wopb_settings', array($this, 'get_option_settings'), 10, 1);
    }
    
    
    /**
	 * Quickview Addons Intitial Setup Action
     * 
     * @since v.1.1.0
	 * @return NULL
	 */
    public function initial_setup(){
        
        // Set Default Value
        $initial_data = array(
            'quickview_heading'         => 'yes',
            'quickview_mobile_disable'  => '',
            'quickview_text'            => __('Quick View', 'product-blocks'),
            'quickview_navigation'      => 'yes',
            'quickview_link'            => 'yes',
            'quickview_gallery_enable'  => 'yes',
            'quickview_cart_redirect'   => '',
            'quickview_image_disable'    => '',
            'quickview_sales_disable'    => '',
            'quickview_rating_disable'   => '',
            'quickview_title_disable'    => '',
            'quickview_price_disable'    => '',
            'quickview_excerpt_disable'  => '',
            'quickview_stock_disable'    => '',
            'quickview_sku_disable'      => '',
            'quickview_cart_disable'     => '',
            'quickview_category_disable' => '',
            'quickview_tag_disable'      => '',
            'wopb_quickview'            => 'true'
        );
        foreach ($initial_data as $key => $val) {
            wopb_function()->set_setting($key, $val);
        }
    }
    

    /**
	 * Quickview Addons Default Settings Param
     * 
     * @since v.1.1.0
     * @param ARRAY | Default Filter Congiguration
	 * @return ARRAY
	 */
    public static function get_option_settings($config){
        $arr = array(
            'quickview' => array(
                'label' => __('QuickView', 'product-blocks'),
                'attr' => array(
                    'quickview_heading' => array(
                        'type' => 'heading',
                        'label' => __('Quick View Settings', 'product-blocks'),
                    ),
                    'quickview_mobile_disable' => array(
                        'type' => 'switch',
                        'label' => __('Enable / Disable', 'product-blocks'),
                        'default' => '',
                        'desc' => __('Disable Quickview on Mobile.', 'product-blocks')
                    ),
                    'quickview_navigation' => array(
                        'type' => 'switch',
                        'label' => __('Enable / Disable', 'product-blocks'),
                        'default' => 'yes',
                        'desc' => __('Enable Product Navigation.', 'product-blocks')
                    ),
                    'quickview_link' => array(
                        'type' => 'switch',
                        'label' => __('Enable / Disable', 'product-blocks'),
                        'default' => 'yes',
                        'desc' => __('Enable Product Link.', 'product-blocks')
                    ),
                    'quickview_gallery_enable' => array(
                        'type' => 'switch',
                        'label' => __('Enable / Disable', 'product-blocks'),
                        'default' => 'yes',
                        'pro' => true,
                        'desc' => __('Enable Gallery Images.', 'product-blocks')
                    ),
                    'quickview_cart_redirect' => array(
                        'type' => 'switch',
                        'label' => __('Enable / Disable', 'product-blocks'),
                        'default' => '',
                        'desc' => __('Enable Cart Redirect.', 'product-blocks')
                    ),
                    'quickview_text' => array(
                        'type' => 'text',
                        'label' => __('Quick View Text', 'product-blocks'),
                        'default' => __('Quick View', 'product-blocks'),
                    ),
                    'quickview_image_disable' => array(
                        'type' => 'switch',
                        'label' => __('Disable Element in QuickView', 'product-blocks'),
                        'default' => '',
                        'desc' => __('Image', 'product-blocks')
                    ),
                    'quickview_sales_disable' => array(
                        'type' => 'switch',
                        'label' => '',
                        'default' => '',
                        'desc' => __('Sales', 'product-blocks')
                    ),
                    'quickview_rating_disable' => array(
                        'type' => 'switch',
                        'label' => '',
                        'default' => '',
                        'desc' => __('Rating', 'product-blocks')
                    ),
                    'quickview_title_disable' => array(
                        'type' => 'switch',
                        'label' => '',
                        'default' => '',
                        'desc' => __('Title', 'product-blocks')
                    ),
                    'quickview_price_disable' => array(
                        'type' => 'switch',
                        'label' => '',
                        'default' => '',
                        'desc' => __('Price', 'product-blocks')
                    ),
                    'quickview_stock_disable' => array(
                        'type' => 'switch',
                        'label' => '',
                        'default' => '',
                        'desc' => __('Stock', 'product-blocks')
                    ),
                    'quickview_sku_disable' => array(
                        'type' => 'switch',
                        'label' => '',
                        'default' => '',
                        'desc' => __('SKU', 'product-blocks')
                    ),
                    'quickview_excerpt_disable' => array(
                        'type' => 'switch',
                        'label' => '',
                        'default' => '',
                        'desc' => __('Excerpt', 'product-blocks')
                    ),
                    'quickview_cart_disable' => array(
                        'type' => 'switch',
                        'label' => '',
                        'default' => '',
                        'desc' => __('Add to Cart', 'product-blocks')
                    ),
                    'quickview_category_disable' => array(
                        'type' => 'switch',
                        'label' => '',
                        'default' => '',
                        'desc' => __('Category', 'product-blocks')
                    ),
                    'quickview_tag_disable' => array(
                        'type' => 'switch',
                        'label' => '',
                        'default' => '',
                        'desc' => __('Tag', 'product-blocks')
                    ),
                    'wopb_quickview' => array(
                        'type' => 'hidden',
                        'value' => 'true'
                    )
                )
            )
        );
        
        return array_merge($config, $arr);
    }


    /**
	 * Quickview Add Action Callback.
     * 
     * @since v.1.1.0
	 * @return ARRAY | With Custom Message
	 */
    public function wopb_quickview_callback() {
        if (!wp_verify_nonce($_REQUEST['wpnonce'], 'wopb-nonce')) {
            return ;
        }

        global $post;
        $post_id = sanitize_text_field($_POST['postid']);
        $post_list = sanitize_text_field($_POST['postList']);

        if ($post_id) {
            $args = array(
                'post_type'     => 'product',
                'post__in'      => array( $post_id ),
                'orderby'       => 'date',
                'post_status'   => 'publish',
                'order'         => 'DESC'
            );
            $loop = new \WP_Query($args);
            

            if($loop->have_posts()){
                while($loop->have_posts()) {
                    $loop->the_post(); 
                    $post_id = get_the_ID();
                    $product = wc_get_product($post_id);

                    echo '<div class="wopb-modal-content">';
                        echo '<div class="wopb-quick-view-modal">';
                            
                        
                            if ( wopb_function()->get_setting('quickview_image_disable') != 'yes' ) {
                                echo '<div class="wopb-quick-view-image">';
                                    $img_full = array();
                                    if (has_post_thumbnail()) {
                                        $temp = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
                                        if ( isset($temp[0]) ) { 
                                            $img_full[] = $temp[0];
                                        }
                                    }
                                    $attachment_ids = $product->get_gallery_image_ids();
                                    if ( wopb_function()->get_setting('quickview_gallery_enable') == 'yes' && !empty($attachment_ids) ) {
                                        foreach ($attachment_ids as $key => $value) {
                                            $temp = wp_get_attachment_image_src( $value, 'full' );
                                            if ( isset($temp[0]) ) { 
                                                $img_full[] = $temp[0];
                                            }
                                        }
                                        if (!empty($img_full)) {
                                            echo '<div class="quickview-slider">';
                                            foreach ($img_full as $k => $val) {
                                                echo '<div><img alt="'.esc_attr(get_the_title()).'" src="'.esc_url($img_full[$k]).'"/></div>';
                                            }
                                            echo '</div>';
                                        }
                                    } else {
                                        if (isset($img_full[0])) {
                                            if ( wopb_function()->get_setting('quickview_link') == 'yes' ) {
                                                echo '<a href="'.esc_url(get_permalink()).'"><img alt="'.esc_attr(get_the_title()).'" src="'.esc_url($img_full[0]).'" /></a>';
                                            } else {
                                                echo '<img alt="'.esc_attr(get_the_title()).'" src="'.esc_url($img_full[0]).'" />';
                                            }
                                            
                                        }   
                                    }
                                    // Sales Percentage
                                    if ( wopb_function()->get_setting('quickview_sales_disable') != 'yes' ) {
                                        $save_percentage = ($product->get_sale_price() && $product->get_regular_price()) ? round( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() * 100 ).'%' : '';
                                        if($save_percentage){
                                            echo '<span class="wopb-quick-view-sale">-'.esc_html($save_percentage).' <span>'.esc_html_e('Sale!', 'product-blocks').'</span></span>';
                                        }
                                    }
                                echo '</div>';//wopb-quick-view-image
                            }
                            

                            echo '<div class="wopb-quick-view-content">';
                                
                                // Show Review
                                if ( wopb_function()->get_setting('quickview_rating_disable') != 'yes' ) {
                                    echo '<div class="wopb-star-rating">';
                                        echo '<span style="width: '.(($product->get_average_rating() / 5 ) * 100).'%">';
                                            echo '<strong itemprop="ratingValue" class="wopb-rating">'.wp_kses_post($product->get_average_rating()).'</strong>';
                                            esc_html_e('out of 5', 'product-blocks');
                                        echo '</span>';
                                    echo '</div>';
                                    echo '<span class="wopb-review-count">( '.wp_kses_post($product->get_rating_count()).__(' customer review', 'product-blocks').' )</span>';
                                }

                                // Show Title
                                if ( wopb_function()->get_setting('quickview_title_disable') != 'yes' ) {
                                    if ( wopb_function()->get_setting('quickview_link') == 'yes' ) {
                                        echo '<h3 class="wopb-quick-title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) .'</a></h3>';
                                    } else {
                                        echo '<h3 class="wopb-quick-title">'.esc_html(get_the_title()).'</h3>';
                                    }
                                }
                                
                                echo '<div class="wopb-quick-divider"></div>';
                                
                                // Show Price
                                if ( wopb_function()->get_setting('quickview_price_disable') != 'yes' ) {
                                    echo '<div class="wopb-product-price">'.wp_kses_post($product->get_price_html()).'</div>';
                                }
                                
                                // Show Excerpt
                                if ( wopb_function()->get_setting('quickview_excerpt_disable') != 'yes' ) {
                                    echo '<div class="wopb-quick-description">'.esc_html(get_the_excerpt()).'</div>';
                                }
                                
                                // Show Stock
                                if ( wopb_function()->get_setting('quickview_stock_disable') != 'yes' ) {
                                    if($product->get_stock_status() == 'outofstock'){
                                        echo '<div class="wopb-quick-outofstock"><span>'.esc_html__('AVAILABILITY:', 'product-blocks').'</span> '.esc_html__('Out of Stock', 'product-blocks').'</div>';
                                    }
                                    if($product->get_stock_status() == 'instock'){
                                        echo '<div class="wopb-quick-instock"><span>'.esc_html__('AVAILABILITY:', 'product-blocks').'</span> '.esc_html__('In Stock', 'product-blocks').'</div>';
                                    }
                                }

               
                                // Show SKU
                                if ( wopb_function()->get_setting('quickview_sku_disable') != 'yes' ) {
                                    echo '<div class="wopb-quick-sku"><span>'.esc_html__('SKU:', 'product-blocks').'</span>'.esc_html($product->get_sku()).'</div>';
                                }

                                // Show Add To Cart
                                if ( wopb_function()->get_setting('quickview_cart_disable') != 'yes' ) {
                                    $quantity = $product->get_stock_quantity();
                                    echo '<div class="wopb-add-to-cart">';
                                        echo '<div class="wopb-quantity-add">';
                                            echo '<span class="wopb-add-to-cart-minus">-</span>'; 
                                            echo '<input type="number" class="wopb-add-to-cart-quantity" min="1" '.($quantity ? 'max="'.esc_attr($quantity).'"' : '' ).' value="1" />';
                                            echo '<span class="wopb-add-to-cart-plus">+</span>';
                                        echo '</div>';
                                        
                                        $cart_url = wopb_function()->get_setting('quickview_cart_redirect') == 'yes' ? ' data-redirect="'.esc_url(wc_get_cart_url()).'"' : '';

                                        echo '<div class="wopb-cart-btn" '.esc_url($cart_url).'>';
                                            echo wopb_function()->get_add_to_cart($product);
                                        echo '</div>';
                                    echo '</div>';
                                }

                                // Show Category
                                    if ( wopb_function()->get_setting('quickview_category_disable') != 'yes' ) {
                                    $cat = get_the_terms($post_id, 'product_cat');
                                    if(!empty($cat)) {
                                        echo '<div class="wopb-quick-category">';
                                        echo '<span>'.__('Category:', 'product-blocks').'</span>';
                                        foreach ($cat as $val) {
                                            echo '<a href="'.esc_url(get_term_link($val->term_id)).'">'.esc_html($val->name).'</a> ';
                                        }
                                        echo '</div>';
                                    }
                                }

                                // Show Tag
                                if ( wopb_function()->get_setting('quickview_tag_disable') != 'yes' ) {
                                    $tag = get_the_terms($post_id, 'product_tag');
                                    if(!empty($tag)) {
                                        echo '<div class="wopb-quick-tag">';
                                        echo '<span>'.__('Tags:', 'product-blocks').'</span>';
                                        foreach ($tag as $val) {
                                            echo '<a href="'.esc_url(get_term_link($val->term_id)).'">'.esc_html($val->name).'</a> ';
                                        }
                                        echo '</div>';
                                    }
                                }
                            echo '</div>';//wopb-quick-view-content
                        echo '</div>';//wopb-quick-view-modal
                        echo '<div class="wopb-modal-close"></div>';
                    echo '</div>';//wopb-modal-content

                    echo '<div class="wopb-quick-view-navigation">';

                    
                    if ( wopb_function()->get_setting('quickview_navigation') == 'yes' ) {
                        // Previous Link
                        if ($post_list) {
                            $p_id = explode(',', $post_list);
                            $key = array_search($post_id, $p_id);
                            $key = isset($p_id[ $key - 1 ]) ? $p_id[ $key - 1 ] : '';
                            if( $key ){
                                echo '<div class="wopb-quick-view-previous wopb-quickview-btn" data-list="'.esc_attr($post_list).'" data-postid="'.esc_attr($key).'">';
                                    $thumbnail = get_post_thumbnail_id( $key );
                                    echo '<span><svg class="icon" viewBox="0 0 64 64"><path id="arrow-left-1" d="M46.077 55.738c0.858 0.867 0.858 2.266 0 3.133s-2.243 0.867-3.101 0l-25.056-25.302c-0.858-0.867-0.858-2.269 0-3.133l25.056-25.306c0.858-0.867 2.243-0.867 3.101 0s0.858 2.266 0 3.133l-22.848 23.738 22.848 23.738z"></path></svg></span>';
                                    echo '<div class="wopb-quick-view-btn-image">';
                                        if ($thumbnail) {
                                            $t_img = wp_get_attachment_image_src( $thumbnail , 'thumbnail' );
                                            if(isset($t_img[0])){
                                                echo '<img src="'.esc_url($t_img[0]).'" alt="'.esc_attr(get_the_title($key)).'" />';
                                            }
                                        }
                                        echo '<h4>'.esc_html(get_the_title($key)).'</h4>';
                                    echo '</div>';//wopb-quick-view-btn-image
                                echo '</div>';
                            }
                        }
                        // Next Link
                        if ($post_list) {
                            $p_id = explode(',', $post_list);
                            $key = array_search($post_id, $p_id);
                            $key = isset($p_id[ $key + 1 ]) ? $p_id[ $key + 1 ] : '';
                            if( $key ){
                                echo '<div class="wopb-quick-view-next wopb-quickview-btn" data-list="'.esc_attr($post_list).'" data-postid="'.esc_attr($key).'">';
                                    $thumbnail = get_post_thumbnail_id( $key );
                                    echo '<span><svg class="icon" viewBox="0 0 64 64"><path id="arrow-right-1" d="M17.919 55.738c-0.858 0.867-0.858 2.266 0 3.133s2.243 0.867 3.101 0l25.056-25.302c0.858-0.867 0.858-2.269 0-3.133l-25.056-25.306c-0.858-0.867-2.243-0.867-3.101 0s-0.858 2.266 0 3.133l22.848 23.738-22.848 23.738z"></path></svg></span>';
                                    echo '<div class="wopb-quick-view-btn-image">';
                                        if ($thumbnail) {
                                            $t_img = wp_get_attachment_image_src( $thumbnail , 'thumbnail' );
                                            if(isset($t_img[0])){
                                                echo '<img src="'.esc_url($t_img[0]).'" alt="'.esc_attr(get_the_title($key)).'" />';
                                            }
                                        }
                                        echo '<h4>'.esc_html(get_the_title($key)).'</h4>';
                                    echo '</div>';//wopb-quick-view-btn-image
                                echo '</div>';
                            }
                        }
                    }
                    echo '</div>';//wopb-quick-view-navigation
                    
                }
                wp_reset_postdata();
            }
        }
        die();
    }
}