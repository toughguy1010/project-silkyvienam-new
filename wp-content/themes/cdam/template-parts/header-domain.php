<?php
$homeID = get_option('page_on_front');
$homeFields = get_field_objects( $homeID );

if( !is_front_page() ){
  ?>
  <ul id="domain-menu">
  <?php
  foreach ($homeFields['zwc_home_menu_domain']['value'] as $key => $value) {
    $anchor = $value['anchor'];
    $url = $value['url'];
    $url = zwc_parse_url_menu($url);
    ?>
    <li>
      <a href="<?php echo $url ?>"><?php echo wp_get_attachment_image($value['image'],'full'); ?></a>
    </li>
    <?php
  }
  ?>
  </ul>
  <?php
}
