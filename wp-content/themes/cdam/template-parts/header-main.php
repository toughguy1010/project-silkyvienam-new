<?php
$homeID = get_option('page_on_front');
$homeFields = get_field_objects( $homeID );

if( !is_front_page() ){
  ?>
  <ul class="main-menu">
  <?php
  foreach ($homeFields['zwc_home_menu']['value'] as $key => $value) {
    $anchor = $value['anchor'];
    $url = $value['url'];
    $type = $value['type']['value'];
    
    $url_id = $url[$url['type']];
    if( $type == 'collection' || $type == 'shop' ){
      $url_id = $type;
    }

    $url = zwc_parse_url_menu($url);
    ?>
    <li class="item <?php if( !empty( $value['sub_item'] ) ){ echo 'has-child'; } ?> <?php echo zwc_parse_page_id() == $url_id ? 'active' : ''; ?>">
      <a href="<?php echo esc_url( $url ); ?>"><?php echo $anchor; ?></a>
      <?php
      if( !empty( $value['sub_item'] ) ){
        ?>
        <img class="extend-menu" src="<?php echo get_template_directory_uri() .'/assets/arrow.svg' ?>" alt="">
        <ul class="home-sub-item-menu">
          <?php
          foreach ( $value['sub_item'] as $key => $val) {
            $anchor = $val['anchor'];
            $url = $val['url'];
            $url_id = $url[$url['type']];
            $url = zwc_parse_url_menu($url);
            ?>
            <li class="home-sub-item-menu-item <?php echo zwc_parse_page_id() == $url_id ? 'active' : ''; ?>">
              <a href="<?php echo esc_url( $url ); ?>"><?php echo $anchor; ?></a>
            </li>
            <?php
          }
          ?>
        </ul>
        <?php
      }
      ?>
    </li>
    <?php
  }
  ?>
  </ul>
  <?php
}
