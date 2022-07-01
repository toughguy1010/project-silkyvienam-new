<?php
$homeID = get_option('page_on_front');
$homeFields = get_field_objects( $homeID );

$footer = $homeFields['zwc_home_ohter']['value'];
$copyright = $homeFields['zwc_copy_right']['value'];
?>

<ul class="policy">
  <?php
  foreach ($footer as $key => $val) {
    $anchor = $val['anchor'];
    $url = $val['url'];
    $url = zwc_parse_url_menu($url);
    ?>
    <li class="item">
      <a href="<?php echo esc_url($url); ?>"><?php echo $anchor; ?></a>
    </li>
    <?php
  }
  ?>
</ul>

<div class="copyright">
  <?php
  echo $copyright;
  ?>
</div>
