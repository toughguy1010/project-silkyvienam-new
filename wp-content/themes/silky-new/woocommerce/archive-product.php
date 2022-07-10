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

// get_template_part('global-templates/part','loading-image-category');

if (is_shop()) {
	do_action( 'woocommerce_before_main_content' );
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
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<?php

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );


	
} 
elseif (is_product_category()) {
	$cate = get_queried_object();

	$cateid = $cate -> term_id;
	$posts_per_page = 2;
	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	
// var_dump($cate);
	?>
	<div class="collection-wrapp-header">
        <!-- <img class="collection-header-img" src="" alt=""> -->
        <img src="<?php echo get_template_directory_uri() . '/img/header-collection.png'; ?>" class="collection-header-img" />
        <div class="header-collection-desc">
            <div class="header-colletion-name">
                <?php echo $cate ->name ?>
            </div>
            <div class="header-colletion-line"></div>
            <div class="content-header-collection-desc"> <?php echo category_description($cateid); ?></div>
        </div>
    </div>
	<div class="collection_category_product_list">
		<?php
		$collection_products = new WP_Query(array(
			'post_type'=>'product',
			'post_status'=>'publish',
			'tax_query' => array(
			array(
				'taxonomy' => 'product_cat',
				'field' => 'id',
				'terms' => $cateid
			)
			),
			'orderby' => 'ID',
			'order' => 'DESC',
			'posts_per_page'=> $posts_per_page,
			'paged' => $paged,
		));
		// var_dump($collection_products);

		?>
		<?php while ( $collection_products->have_posts() ) :
							$collection_products->the_post();

							get_template_part('global-templates/content','product');

						endwhile; ; wp_reset_query() ;?>
	</div>
	<div class="pagination-collection">
		<?php
		$big = 999999999; // need an unlikely integer
		$page_args = array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?page=%#%',
			'current' => max( 1, $paged ),
			'total' => $collection_products->max_num_pages,
			'prev_text' => '< ',
			'next_text' => ' >',
		);
		var_dump($collection_products->max_num_pages);
		echo paginate_links( $page_args );
		
		?>
	</div>
	
	
	
	<?php


	
		woocommerce_product_loop_start();
		
		// if ( wc_get_loop_prop( 'total' ) ) {
		// 	while ( have_posts() ) {
		// 		the_post();
	
		// 		/**
		// 		 * Hook: woocommerce_shop_loop.
		// 		 */
		// 		do_action( 'woocommerce_shop_loop' );
	
		// 		wc_get_template_part( 'content', 'product' );
				
		// 	}
		// }
	
		woocommerce_product_loop_end();
}


  
/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */

do_action( 'woocommerce_sidebar' );

get_footer( );

