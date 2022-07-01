<?php
/**
*
*
* Template Name: Magazine
*
*
*/

get_header();

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

$posts_per_page = 6;

$loops = new WP_Query(
  array(
    'post_type' => 'zwc_magazine',
    'posts_per_page' => $posts_per_page,
    'paged' => $paged,
    'post_status' => 'publish',
    'orderby' => 'menu_order',
    'order'   => 'DESC',
  )
);
wp_reset_query();

?>
<div id="primary" class="content-area">
  <main id="main" class="site-main custom-page">

    <div class="outer">

      <div class="wrap-content">

        <div class="left show-magazine-hover">
          <?php
          $f_post = $loops->posts[0];
          ?>
          <img src="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id($f_post->ID), 'full' ); ?>" alt="">
        </div>

        <div class="right">

          <?php
          while ( $loops->have_posts() ) :
            $loops->the_post();

            get_template_part( 'template-parts/content', 'magazine' );

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
        </div>

      </div>

    </div>
  </main>
</div>
<?php
get_footer();
