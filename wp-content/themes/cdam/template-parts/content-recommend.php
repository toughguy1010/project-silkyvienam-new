<?php
global $product;
$productFields = get_field_objects($product->get_id());
$product_recom = $productFields['zwc_product_recommend']['value'];
if( !empty($product_recom)){
?>
  <div class="zwc-product-recommended">
    <div class="title">
      Recommended
    </div>
    <ul class="products">
    <?php
    $loops = new WP_Query(
      array(
        'post_type' => 'product',
        'post__in' => $product_recom,
        'paged' => $paged,
        'tax_query' => array(
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
    </ul>
  </div>
<?php
}
