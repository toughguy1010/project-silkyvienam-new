<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header();

do_action('product_style');	

// $cate = get_queried_object();
// var_dump($cate, is_shop(), is_product_category());

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );
// get_template_part('global-templates/part','loading-image-category');

if (is_shop()) {
	if ( woocommerce_product_loop() ) {
		/**
		 * Hook: woocommerce_before_shop_loop.
		 *
		 * @hooked woocommerce_output_all_notices - 10
		 * @hooked woocommerce_result_count - 20
		 * @hooked woocommerce_catalog_ordering - 30
		 */
		do_action( 'woocommerce_before_shop_loop' );
	
		woocommerce_product_loop_start();
	
		if ( wc_get_loop_prop( 'total' ) ) {
			while ( have_posts() ) {
				the_post();
	
				/**
				 * Hook: woocommerce_shop_loop.
				 */
				do_action( 'woocommerce_shop_loop' );
	
				wc_get_template_part( 'content', 'product' );
			}
		}
	
		woocommerce_product_loop_end();
	
		/**
		 * Hook: woocommerce_after_shop_loop.
		 *
		 * @hooked woocommerce_pagination - 10
		 */
		do_action( 'woocommerce_after_shop_loop' );
	} else {
		/**
		 * Hook: woocommerce_no_products_found.
		 *
		 * @hooked wc_no_products_found - 10
		 */
		do_action( 'woocommerce_no_products_found' );
	}
	
} 
elseif (is_product_category()) {
	echo 'ddddd';
	global $wp_query;

    // get the query object
    $cat = $wp_query->get_queried_object();
	var_dump($cat);


	$args = array(
		'post_type'             => 'product',
		'post_status'           => 'publish',
		'ignore_sticky_posts'   => 1,
		'posts_per_page'        => '12',
		'tax_query'             => array(
			array(
				'taxonomy'      => 'product_cat',
				'field' => 'term_id', //This is optional, as it defaults to 'term_id'
				'terms'         => $cat->term_id,
				'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
			),
			array(
				'taxonomy'      => 'product_visibility',
				'field'         => 'slug',
				'terms'         => 'exclude-from-catalog', // Possibly 'exclude-from-search' too
				'operator'      => 'NOT IN'
			)
		)
	);
	$products = new WP_Query($args);
	// var_dump($products);
		echo' <div class = "collection-product-content">';
		woocommerce_product_loop_start();
		
		if ( wc_get_loop_prop( 'total' ) ) {
			while ( have_posts() ) {
				the_post();
	
				/**
				 * Hook: woocommerce_shop_loop.
				 */
				do_action( 'woocommerce_shop_loop' );
	
				wc_get_template_part( 'content', 'product' );
				
			}
		}
	
		woocommerce_product_loop_end();
		echo' </div>';
}

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<?php

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );


  
/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */

do_action( 'woocommerce_sidebar' );

get_footer( );

