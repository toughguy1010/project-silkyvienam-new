<?php
$homeID = get_option('page_on_front');
$homeFields = get_field_objects( $homeID );
?>
<div id="loading-image-category" class="">
  <?php echo wp_get_attachment_image($homeFields['zwc_image_transition']['value'], 'full') ?>
</div>
<script type="text/javascript">
jQuery(function($) {
  console.log(localStorage.getItem('zwc_cat_image'));
  if(localStorage.getItem('zwc_cat_image') != 'shown'){
    $('#loading-image-category').addClass('show');

    setInterval(function() {
      $('#loading-image-category').removeClass('show');
    }, 3000);

    localStorage.setItem('zwc_cat_image','shown');
  }
});
</script>
