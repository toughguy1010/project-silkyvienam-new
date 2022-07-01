<?php
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
    if( $type == 'other' ){
      ?>
      <li class="social-fixed-<?php echo $type; ?>">
        <a <?php echo $type == 'other' ? 'target="_blank"' : ''; ?> href="<?php echo esc_url($url); ?>"><?php echo wp_get_attachment_image($image,'full'); ?></a>
        <a class="hover" <?php echo $type == 'other' ? 'target="_blank"' : ''; ?> href="<?php echo esc_url($url); ?>"><?php echo wp_get_attachment_image($image_hover,'full'); ?></a>
      </li>
      <?php
    }
  }
  ?>
</ul>
