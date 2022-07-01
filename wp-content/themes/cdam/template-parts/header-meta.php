<?php
$homeID = get_option('page_on_front');
$homeFields = get_field_objects( $homeID );

$current_user = wp_get_current_user();
?>

<ul class="meta-menu">
<?php
foreach ($homeFields['zwc_home_menu_meta']['value'] as $key => $value) {

  $class_chk = $value['class'];

  $anchor = $value['anchor'];
  $url = $value['url'];
  $url = zwc_parse_url_menu($url);
  ?>
  <li class="item <?php if( !empty( $value['sub_menu'] ) ){ echo 'has-child'; } ?>">
    <a class="<?php echo $value['class'] ?>" href="<?php echo esc_url( $url ); ?>"><?php echo $anchor; ?></a>
    <?php
    if( !empty( $value['sub_menu'] ) ){
      ?>
      <img class="extend-menu" src="<?php echo get_template_directory_uri() .'/assets/arrow.svg' ?>" alt="">
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
?>
</ul>
