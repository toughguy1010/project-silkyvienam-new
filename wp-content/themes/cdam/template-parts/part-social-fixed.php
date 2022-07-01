<?php
global $post;
global $product;

$homeID = get_option('page_on_front');
$homeFields = get_field_objects( $homeID );

$social = $homeFields['zwc_social_fixed']['value'];
?>

<ul id="social-fixed">
  <?php
  foreach ($social as $key => $val) {
    $type = $val['type'];
    $image = $val['image'];
    $image_hover = $val['image_hover'];
    $url = $val['url'];
    if( $type == 'facebook' ){
      $url = 'https://www.facebook.com/sharer/sharer.php?u='.urlencode( esc_url( get_permalink($post->ID) ) );
    }
    if( $type == 'pinterest' && !empty($product->get_image_id()) ){
      $url = 'https://www.pinterest.com/pin/create/button/?url='.esc_url( get_permalink($post->ID) ).'&media='.wp_get_attachment_image_src( $product->get_image_id() , 'pin-btn' )[0].'&description='.urlencode($post->post_title);
    }
    ?>
    <li class="social-fixed-<?php echo $type; ?>">
      <a <?php echo ($type == 'pinterest') ? 'data-pin-do="buttonPin" data-pin-custom="true" data-pin-nopin="true"' : ''; ?> <?php echo ($type == 'other' || $type == 'facebook') ? 'target="_blank"' : ''; ?> href="<?php echo ($url); ?>"><?php echo wp_get_attachment_image($image,'full'); ?></a>
      <a class="hover" <?php echo ($type == 'pinterest') ? 'data-pin-do="buttonPin" data-pin-custom="true" data-pin-nopin="true"' : ''; ?> <?php echo ($type == 'other' || $type == 'facebook') ? 'target="_blank"' : ''; ?> href="<?php echo ($url); ?>"><?php echo wp_get_attachment_image($image_hover,'full'); ?></a>
    </li>
    <?php
  }
  ?>
</ul>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
