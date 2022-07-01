<?php
global $related_products;
if ( $related_products ) : ?>

<section class="related products related-products ">

  <?php
  $heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'woocommerce' ) );

  if ( $heading ) :
    ?>
    <h2>Sản phẩm liên quan</h2>
  <?php endif; ?>
  
    <?php woocommerce_product_loop_start(); ?>

    <?php foreach ( $related_products as $related_product ) : ?>

        <?php
        $post_object = get_post( $related_product->get_id() );

        setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

        wc_get_template_part( 'content', 'product' );
        ?>

    <?php endforeach; ?>

  <?php woocommerce_product_loop_end(); ?> 

</section>
<?php
endif;

wp_reset_postdata();
