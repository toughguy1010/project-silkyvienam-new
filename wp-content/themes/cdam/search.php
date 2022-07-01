<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package cdam
 */

get_header();
global $wp_query;

?>

	<main id="primary" class="site-main">
		<div class="outer2">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php
						/* translators: %s: search query. */
						printf( esc_html__( '%s Result(s) found for `%s`', 'cdam' ), $wp_query->found_posts, '<span>' . get_search_query() . '</span>' );
						?>
					</h1>
				</header><!-- .page-header -->

				<ul class="products">
				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', 'product-shop-search' );

				endwhile;

				?>
				<div class="pagi">
					<?php
					$big = 999999999; // need an unlikely integer
					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?page=%#%',
						'current' => max( 1, $paged ),
						'total' => $wp_query->max_num_pages,
						'prev_text' => '< ',
						'next_text' => ' >',
					) );
					?>
				</div>
				</ul>
				<?php

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>

		</div>
	</main><!-- #main -->

<?php
get_footer();
