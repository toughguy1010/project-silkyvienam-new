<?php
/**
*
*
* Template Name: Custom page
*
*
*/

get_header();
global $post;
?>
<div id="primary" class="content-area">
  <main id="main" class="site-main custom-page">
    <?php
    // $homeID = get_option('page_on_front');
  	// $homeFields = get_field_objects( $homeID );

    $pageFields = get_field_objects($post->ID);
    ?>
    <div class="outer">
        <?php
        foreach ($pageFields['zwc_custom_page']['value'] as $key => $pageField) {
          ?>
          <div class="wrap-content">
            <div class="left">
              <img src="<?php echo wp_get_attachment_image_url($pageField['image'],'full'); ?>" alt="">
            </div>
            <div class="right">
              <?php echo apply_filters('acf_the_content',$pageField['content']); ?>
            </div>
          </div>
          <?php
        }
        ?>
    </div>
  </main>
</div>
<?php
get_footer();
