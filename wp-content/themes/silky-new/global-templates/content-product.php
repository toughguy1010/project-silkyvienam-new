<?php
global $product;
// $productFields = get_field_objects($product->get_id());
// $imgHoverId = $productFields['zwc_product_hover']['value'];

$img_src = wp_get_attachment_url( $product->get_image_id() );
// $img_src_hover = wp_get_attachment_url( $imgHoverId );
?>

<div class="collection-item">
    <div class="collection-img">
        <?php the_post_thumbnail();?>
    </div> 
    <div class="collection-btn">
        <a href="<?php the_permalink() ;?>" class="product_colletion_btn">Shop the look</a>
    </div>
</div>
