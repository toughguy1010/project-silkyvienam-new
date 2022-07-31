<?php
/**
 * The template for displaying search results pages
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
global $wp_query;

$container = get_theme_mod( 'understrap_container_type' );

?>

<div class="wrapper" id="search-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check and opens the primary div -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<?php if ( have_posts() ) : ?>

					<header class="page-header">

							<h1 class="page-title search-title">
								<?php
								printf(
									/* translators: %s: query term */
									esc_html__( 'Search results for: %s', 'understrap' ),
									'<span>' . get_search_query() . '</span>'
								);
								?>
							</h1>

					</header><!-- .page-header -->
				<div class="product-search-result">
					<?php /* Start the Loop */ ?>
					<?php
					
					// do_action( 'woocommerce_before_shop_loop' );
					
					// woocommerce_product_loop_start();

					while ( have_posts() ) :
						the_post();

						/*
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						do_action( 'woocommerce_shop_loop' );
						get_template_part( 'loop-templates/content', 'search' );
						echo '</a>';
						
					endwhile;
					?>

				<?php else : ?>

					<?php get_template_part( 'loop-templates/content', 'none' ); ?>

				<?php endif; 
				
				
				// woocommerce_product_loop_end();
	
				/**
				 * Hook: woocommerce_after_shop_loop.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				// do_action( 'woocommerce_after_shop_loop' );
	
				
				?>

				
				</div>
		
			</main><!-- #main -->

			<!-- The pagination component -->
			

			<!-- Do the right sidebar check -->
			<?php // get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->
	<?php //understrap_pagination(); 
	
	
	?>
<div class="pagi search-pagination">
					<?php
					$totalpost = $wp_query->found_posts;
		$posts_per_page = 2;
		// $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
					$big = 999999999; // need an unlikely integer
					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?page=%#%',
						'current' => max( 1, $paged ),
						'total' => ceil( $wp_query -> max_num_pages) ,
						'prev_text' => '< ',
						'next_text' => ' >',
					) );
					
					?>
				</div>
</div><!-- #search-wrapper -->

<?php
// var_dump($paged);

// echo $totalpost;
get_footer();
