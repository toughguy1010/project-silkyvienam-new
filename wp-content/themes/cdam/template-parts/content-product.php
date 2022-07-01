<?php
global $product;
$productFields = get_field_objects($product->get_id());
$imgHoverId = $productFields['zwc_product_hover']['value'];

$img_src = wp_get_attachment_url( $product->get_image_id() );
$img_src_hover = wp_get_attachment_url( $imgHoverId );
?>

<li class="product">
  <a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>">
    <img src="<?php echo $img_src ? $img_src : 'https://place-hold.it/580x860'; ?>" alt="">
    <?php if( !empty($imgHoverId) ) { ?>
      <img class="hover" src="<?php echo $img_src_hover ? $img_src_hover : 'https://place-hold.it/580x860'; ?>" alt="">
    <?php }else{ ?>
      <img class="hover" src="<?php echo $img_src ? $img_src : 'https://place-hold.it/580x860'; ?>" alt="">
    <?php } ?>
  </a>
</li>
