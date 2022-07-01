<?php
global $post;
$pageFields   = get_field_objects($post->ID);

$magazine     = $pageFields['publisher']['value'];
$extenal_link = $pageFields['extenal_link']['value'];
?>
<div class="item">
  <div class="wrap-item magazine-hover" data-fetimage="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id($post->ID),'full'); ?>">
    <div class="publisher">
      <span><?php echo $magazine; ?></span><span>|</span><?php cdam_posted_on(); ?>
    </div>
    <div class="extenal-link">
      <a target="_blank" href="<?php echo esc_url($extenal_link); ?>"><?php echo $post->post_title; ?></a>
    </div>
  </div>
</div>
