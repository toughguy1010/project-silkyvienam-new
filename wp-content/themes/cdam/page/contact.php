<?php
/**
*
*
* Template Name: Liên hệ
*
*
*/

get_header();
global $post;
?>
<div id="primary" class="content-area">
  <main id="main" class="site-main">
    <?php
    // $homeID = get_option('page_on_front');
  	// $homeFields = get_field_objects( $homeID );

    $pageFields = get_field_objects($post->ID);
    ?>
    <div class="outer">
      <div class="wrap-content">
        <div class="left">
          <?php
          the_content();
          ?>
        </div>
        <div class="right">
          <?php
          echo apply_filters('acf_the_content',$pageFields['zwc_contact_form']['value']);
          ?>
        </div>
      </div>
    </div>
  </main>
</div>
<?php
get_footer();
