<?php
/**
 * Single post partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
do_action('blog-style');
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<?php
                do_action('head');
            ?>
	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>


	</header><!-- .entry-header -->

	<?php // echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="entry-content">

		<?php
		the_content();
		understrap_link_pages();
		?>
		
		<div class="entry-meta">

			<?php understrap_posted_on(); ?>

		</div><!-- .entry-meta -->
	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
