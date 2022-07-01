<?php
/**
*
*
* Template Name: Trang chủ
*
*
*/

get_header();
?>
<div id="page-home" class="content-area">
  <main id="main-home" class="site-main">
    <?php
    if( ! wp_is_mobile() ){
      get_template_part( 'template-parts/home', 'main' );
    } else {
      get_template_part( 'template-parts/back', 'svg-mb' );

      $homeID = get_option('page_on_front');
    	$homeFields = get_field_objects( $homeID );

      $homeMenu = $homeFields['zwc_home_menu']['value'];

      foreach ($homeMenu as $key => $val_menu) {
        $type = $val_menu['type']['value'];
        $anchor = $val_menu['anchor'];
        $url = $val_menu['url'];
        $url = zwc_parse_url_menu($url);
        $sub_item = $val_menu['sub_item'];

        ?>
        <ul id="home-menu-<?php echo $type; ?>" class="home-menu">
          <a href="<?php echo esc_url( $url ); ?>"><?php echo $anchor; ?></a>
          <?php
          if( !empty( $sub_item ) ){
            ?>
            <ul class="home-sub-item-menu">
              <?php
              foreach ( $sub_item as $key => $val) {
                $anchor = $val['anchor'];
                $url = $val['url'];
                $url = zwc_parse_url_menu($url);
                ?>
                <li class="home-sub-item-menu-item">
                  <a href="<?php echo esc_url( $url ); ?>"><?php echo $anchor; ?></a>
                </li>
                <?php
              }
              ?>
            </ul>
            <?php
          }
          ?>
        </ul>
        <?php
      }
    }
    ?>
  </main>
</div>
<?php
get_footer();
