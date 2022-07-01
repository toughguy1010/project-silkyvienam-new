<?php
global $product;
?>
<div class="zwc-custom-thumbnail">
  <img class="zoom-img" src="<?php echo wp_get_attachment_image_src( $product->get_image_id(), 'full' )[0]; ?>" alt="">
  <?php
  if ( $attachment_ids = $product->get_gallery_image_ids() ) {
    foreach ( $attachment_ids as $attachment_id ) {
      ?>
      <img class="zoom-img" src="<?php echo wp_get_attachment_image_src( $attachment_id, 'full' )[0]; ?>" alt="">
      <?php
    }
  }
  ?>
</div>
<img class="scroll" src="<?php echo get_template_directory_uri().'/assets/scroll.svg' ?>" />
<img class="zoom-back" src="<?php echo get_template_directory_uri().'/assets/btn-back.svg'; ?>" alt="">
<?php
