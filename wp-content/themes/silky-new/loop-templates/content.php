<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */
do_action('blog-style');

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article class="blog-content-item" <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">
	
		
	</header><!-- .entry-header -->


		<div class="entry-content blog-category-content">
		<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>
			<?php
			the_title(
				sprintf( '<h2 class="blog-content-item-title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
				'</a></h2>'
			);
			the_excerpt();
			understrap_link_pages();
			?>

		</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php //understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
