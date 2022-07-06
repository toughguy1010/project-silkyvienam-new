  <?php get_header();

  do_action('about_style')
   ?>
  <header class="about-header entry-header">
	<?php
                do_action('head');
            ?>
<?php // the_title( '<h1 class="entry-title about-title">', '</h1>' ); ?>

	</header><!-- .entry-header -->

	<?php // echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="about-section entry-content">
		
	
		<?php
		the_content();
		understrap_link_pages();
		?>
		
		<div class="entry-meta">

			<?php // understrap_posted_on(); ?>

		</div><!-- .entry-meta -->
	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php // understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

        <?php 
 get_footer();
?>  