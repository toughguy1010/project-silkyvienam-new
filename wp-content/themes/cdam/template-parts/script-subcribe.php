<?php wp_nonce_field( 'custom_zwc_subscibe', 'nonce_zwc_subscibe_key' ); ?>
<script type="text/javascript">
jQuery.noConflict();
jQuery(function($){
	$(function(){

	$(document).find('#masthead').find('.nav-menu').find('.subcribe').find('a').on('click',function(){
    var btn = $(this);
    var parent = $(this).parent();
    var email = parent.find('.subcribe-input').val();

    parent.find('.noti').html('');

    if(email == ''){
      parent.find('.noti').html('Email not correctly!');
      return false;
    }
    $.ajax({
			type:  'POST',
			url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			dataType: 'json',
			data: {
				'action': 'zwc_subscibe',
				'email': email,
				'nonce_zwc_subscibe_key' : $('#nonce_zwc_subscibe_key').val(),
				'_wp_http_referer' : $('#nonce_zwc_subscibe_key').next().val(),
			},
			beforeSend: function(){
				parent.addClass('loadingpage');
			},
			success: function (obj) {
				console.log(obj);
				if( obj['success'] == true ){
          parent.find('.subcribe-input').val('');
					parent.find('.noti').html(obj['mess']);
				} else if( obj['success'] == false ){

				}
			},
			complete: function(){
				parent.removeClass('loadingpage');
			},
			error:   function(error) {
				console.log(error); // For testing (to be removed)
			}
		});
  });

});
});
</script>
