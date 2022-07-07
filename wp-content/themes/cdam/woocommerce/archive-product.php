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

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

get_template_part('template-parts/part','loading-image-category');

$cate = get_queried_object();

$cateFields = get_field_objects( $cate->taxonomy.'_'.$cate->term_id );
$cat_type = $cateFields['zwc_product_cat_type']['value'];

$type = $cat_type['value'];

switch ($type) {
	case 'shop':
		?>
		<div class="outer2">
		<div class="woocommerce-products-header">
			<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
				<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
			<?php endif; ?>
		</div>
		<?php
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

				$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
				if( ! wp_is_mobile() ){
					$posts_per_page = 9;
				}else{
					$posts_per_page = 8;
				}
					$loops = new WP_Query(
						array(
							'post_type' => 'product',
							'posts_per_page' => $posts_per_page,
							'paged' => $paged,
							'tax_query' => array(
								'relation' => 'AND',
								array(
									'taxonomy' => $cate->taxonomy,
									'field'    => 'term_id',
									'terms'    => $cate->term_id,
								),
								array(
					        'taxonomy' => 'product_type',
					        'field'    => 'slug',
					        'terms'    => array('variable','simple'),
						    ),
							),
							'post_status' => 'publish',
						)
					);
					wp_reset_query();

					while ( $loops->have_posts() ) :
						$loops->the_post();

						get_template_part( 'template-parts/content', 'product-shop' );

					endwhile;
					?>
					<div class="pagi">
						<?php
						$big = 999999999; // need an unlikely integer
						$page_args = array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format' => '?page=%#%',
							'current' => max( 1, $paged ),
							'total' => $loops->max_num_pages,
							'prev_text' => '< ',
							'next_text' => ' >',
						);
						if( wp_is_mobile() ){
							$page_args['end_size'] = 0;
							$page_args['mid_size'] = 0;
						}
						echo paginate_links( $page_args );
						?>
					</div>
					<?php

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
		</div>
		<?php
		break;

	case 'collection':
		?>

	<div class="outer2 collection-category">
		<?php

		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		if( ! wp_is_mobile() ){
			$posts_per_page = 9;
		}else{
			$posts_per_page = 6;
		}

		if( $paged == 1){

			$addition_collection = $cateFields['zwc_product_cat_type_collection']['value'];
			?>
			<div class="top-desc">

				<div class="left">
					<div class="woocommerce-products-header">
						<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
							<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
						<?php endif; ?>
					</div>
					<div>
						<div class="term-description">
							<?php echo nl2br($cate->description); ?>
						</div>
						<?php if( !empty($addition_collection['video']) ){ ?>
							<div class="collection-video">
								<a data-fancybox="video-gallery" data-src="https://www.youtube.com/watch?v=<?php echo $addition_collection['video']; ?>"><img src="<?php echo get_template_directory_uri().'/assets/play.svg' ?>" /> View Runway video</a>
							</div>
						<?php } ?>
					</div>
				</div>

				<div class="right">
					<img src="<?php echo wp_get_attachment_image_url($addition_collection['image'],'full'); ?>" alt="">
				</div>

			</div>
			<?php
		}

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

					$loops = new WP_Query(
						array(
							'post_type' => 'product',
							'posts_per_page' => $posts_per_page,
							'paged' => $paged,
							'tax_query' => array(
								'relation' => 'AND',
								array(
									'taxonomy' => $cate->taxonomy,
									'field'    => 'term_id',
									'terms'    => $cate->term_id,
								),
								array(
										'taxonomy' => 'product_type',
										'field'    => 'slug',
										'terms'    => 'grouped',
								),
							),
							'post_status' => 'publish',
						)
					);
					wp_reset_query();

					while ( $loops->have_posts() ) :
						$loops->the_post();

						get_template_part( 'template-parts/content', 'product' );

					endwhile;

					?>
					<div class="pagi">
						<?php
						$big = 999999999; // need an unlikely integer
						$page_args = array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format' => '?page=%#%',
							'current' => max( 1, $paged ),
							'total' => $loops->max_num_pages,
							'prev_text' => '< ',
							'next_text' => ' >',
						);
						if( wp_is_mobile() ){
							$page_args['end_size'] = 0;
							$page_args['mid_size'] = 0;
						}
						echo paginate_links( $page_args );
						?>
					</div>
					<?php
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
	</div>
		<?php
		break;

	default:
		// code...
		break;
}



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

get_footer( 'shop' );
