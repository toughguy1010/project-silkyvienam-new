<?php
global $product;
// $productFields = get_field_objects($product->get_id());
// $imgHoverId = $productFields['zwc_product_hover']['value'];

$img_src = wp_get_attachment_url( $product->get_image_id() );
// $img_src_hover = wp_get_attachment_url( $imgHoverId );
?>

<div class="product-collection-item">
        <a class="product_colletion_img" href=""><?php the_post_thumbnail("medium",array( "title" => get_the_title(),"alt" => get_the_title() ));?></a>
        <a href="<?php the_permalink() ;?>" class="product_colletion_btn">Shop the look</a>
    </div>
