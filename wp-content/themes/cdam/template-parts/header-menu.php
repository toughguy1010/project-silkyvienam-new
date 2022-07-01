<?php
$homeID = get_option('page_on_front');
$homeFields = get_field_objects( $homeID );

$logo_id = $homeFields['zwc_logo_hover']['value'];
$current_user = wp_get_current_user();
?>
<div class="nav-menu">
  <div class="top">
    <div class="site-branding <?php if( ! is_front_page() ) { echo 'other'; } ?>">
      <a href="<?php echo home_url(); ?>"><img src="<?php echo wp_get_attachment_url($logo_id); ?>" alt=""></a>
    </div>
    <div class="languages">
      <?php
      $langs = pll_the_languages( array(
        'dropdown' => 1,
        'show_names' => 1,
        'raw' => 1
      ) );
      $order_lang = wp_list_pluck($langs,'slug','current_lang');
      krsort($order_lang);

      foreach ($order_lang as $key => $order) {
        $lang = $langs[$order];
        ?>
        <a href="<?php echo $key != 0 ? 'javascript:;' : $lang['url'] ?>"><?php echo $lang['name']; ?></a>
        <?php
      }
      ?>
    </div>
  </div>
  <ul class="nav-menu-nav">
  <?php
  foreach ($homeFields['zwc_home_menu']['value'] as $key => $value) {
    $anchor = $value['anchor'];
    $url = $value['url'];
    $url = zwc_parse_url_menu($url);
    ?>
    <li class="item <?php if( !empty( $value['sub_item'] ) ){ echo 'has-child'; } ?>">
      <a href="<?php echo esc_url( $url ); ?>"><?php echo $anchor; ?></a>
      <?php
      if( !empty( $value['sub_item'] ) ){
        ?>
        <img class="extend-menu" src="<?php echo get_template_directory_uri() .'/assets/arr-w.svg' ?>" alt="">
        <ul class="home-sub-item-menu">
          <?php
          foreach ( $value['sub_item'] as $key => $val) {
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
    </li>
    <?php
  }
  ?>
  </ul>
  <?php if( wp_is_mobile() ) { ?>
  <ul class="nav-menu-meta">
    <?php
    foreach ($homeFields['zwc_home_menu_meta']['value'] as $key => $value) {

      $class_chk = $value['class'];

      $anchor = $value['anchor'];
      $url = $value['url'];
      $url = zwc_parse_url_menu($url);
      if( $class_chk == 'menu-account' ){
      ?>
      <li class="item <?php if( !empty( $value['sub_menu'] ) ){ echo 'has-child'; } ?>">
        <a class="<?php echo $value['class'] ?>" href="<?php echo esc_url( $url ); ?>"><?php echo $anchor; ?></a>
        <?php
        if( !empty( $value['sub_menu'] ) ){
          ?>
          <img class="extend-menu" src="<?php echo get_template_directory_uri() .'/assets/arr-w.svg' ?>" alt="">
          <ul class="home-sub-item-menu">
            <?php
            if( $class_chk == 'menu-account' ){
              if ( is_user_logged_in() ) {
                ?>
                <li class="home-sub-item-menu-item account-header"><?php printf( __( '<a href="javascript:;">Hi %s!</a>', 'cdam' ), esc_html( $current_user->display_name ) ) ?></li>
                <?php
              }
              foreach ( $value['sub_menu'] as $key => $val) {
                $class_sub_chk = $val['class'];
                $anchor = $val['anchor'];
                $url = $val['url'];
                $url = zwc_parse_url_menu($url);

                if ( ! is_user_logged_in() ) {
                  if( $class_sub_chk == 'menu-login' || $class_sub_chk == 'menu-register' ){
                    ?>
                    <li class="home-sub-item-menu-item">
                      <a href="<?php echo esc_url( $url ); ?>"><?php echo $anchor; ?></a>
                    </li>
                    <?php
                  }
                }else{
                  if( ! $class_sub_chk == 'menu-login' && ! $class_sub_chk == 'menu-register' ){
                    ?>
                    <li class="home-sub-item-menu-item">
                      <a href="<?php echo esc_url( $url ); ?>"><?php echo $anchor; ?></a>
                    </li>
                    <?php
                  }else{

                  }
                }

              }
            }else{
              foreach ( $value['sub_menu'] as $key => $val) {
                $anchor = $val['anchor'];
                $url = $val['url'];
                $url = zwc_parse_url_menu($url);
                ?>
                <li class="home-sub-item-menu-item">
                  <a href="<?php echo esc_url( $url ); ?>"><?php echo $anchor; ?></a>
                </li>
                <?php
              }
            }
            ?>
          </ul>
          <?php
        }
        ?>
      </li>
      <?php
    }
    }
    ?>
  </ul>
  <?php } ?>
  <div class="subcribe">
    <span>Newsletter</span>
    <input class="subcribe-input" type="text" name="" value="">
    <a href="javascript:;"><span></span>subscribe</a>
    <span class="noti"></span>
  </div>

  <div class="social">
    <div class="wrap">
      <?php
      foreach ($homeFields['zwc_social']['value'] as $key => $value) {
        ?>
        <div class="item">
          <a href="<?php echo $value['url']; ?>"><img src="<?php echo wp_get_attachment_image_url($value['icon']); ?>" /></a>
        </div>
        <?php
      }
      ?>
    </div>
    <div class="copyright">
      <?php
      $copyright = $homeFields['zwc_copy_right']['value'];
      echo $copyright;
      ?>
    </div>
  </div>
</div>
