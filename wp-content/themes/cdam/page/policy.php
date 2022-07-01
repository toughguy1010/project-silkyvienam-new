<?php
/**
*
*
* Template Name: Other
*
*
*/

get_header();
global $post;
?>
<div id="primary" class="content-area">
  <main id="main" class="site-main">
    <?php
    $homeID = get_option('page_on_front');
  	$homeFields = get_field_objects( $homeID );

    // $pageFields = get_field_objects($post->ID);
    ?>

    <div class="outer">
      <div class="wrap-content">
        <div class="left">
          <ul class="policy-navigation">
            <?php
            foreach ($homeFields['zwc_home_ohter']['value'] as $key => $value) {
              $anchor = $value['anchor'];
              $url = $value['url'];
              $menu_id = zwc_parse_url_menu_id($url);
              $url = zwc_parse_url_menu($url);
              ?>
              <li class="item <?php echo ($post->ID == $menu_id) ? 'active' : ''; ?>">
                <a href="<?php echo esc_url( $url ); ?>"><?php echo $anchor; ?></a>
              </li>
              <?php
            }
            ?>
          </ul>
        </div>
        <div class="right">
          <?php the_content(); ?>
        </div>
      </div>
    </div>
  </main>
</div>
<?php
get_footer();
