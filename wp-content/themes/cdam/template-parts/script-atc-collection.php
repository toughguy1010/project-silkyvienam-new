<?php
global $product;
?>
<script type="text/javascript">
jQuery.noConflict();
jQuery(function($){
	$(function(){

		function filter_attribute(element){
			var pid = element.parent().parent().parent().parent().parent().data('product-id');
			var size = element.parent().parent().parent().parent().parent().find('.p-size-detail').find('li.p-li-size.active').data('size');
			var color = element.parent().parent().parent().parent().parent().find('.p-color-detail').find('li.p-li-color.active').data('color');
			var price = element.parent().parent().parent().parent().parent().find('.p-price-detail');

			$.ajax({
					type:  'POST',
					url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
					contentType: "application/x-www-form-urlencoded; charset=UTF-8",
					dataType: 'json',
					data: {
						'action': 'zwc_change_price',
						'pid': pid,
						'size': size,
						'color': color,
						// 'nonce_checkout_key' : $('#nonce_get_change_price').val(),
						// '_wp_http_referer' : $('#nonce_get_change_price').next().val(),
					},
					beforeSend: function(){
						element.parent().parent().parent().parent().parent().addClass('loadingpage');
					},
					success: function (obj) {
						console.log(obj);
						if( obj['success'] == true ){
							$('.zwc-custom-thumbnail').html(obj['image']);
							price.html(obj['price']);
							element.parent().parent().parent().parent().parent().find('.open-customize').data("pid", obj['variation_id']);
						} else if( obj['success'] == false ){

						}

					},
					complete: function(){
						element.parent().parent().parent().parent().parent().removeClass('loadingpage');
					},
					error:   function(error) {
						console.log(error); // For testing (to be removed)
					}
			});
		}

		function generate_size(element){
			var pid = element.parent().parent().parent().parent().parent().data('product-id');
			var color = element.parent().parent().parent().parent().parent().find('.p-color-detail').find('li.p-li-color.active').data('color');
			var size_html = element.parent().parent().parent().parent().parent().find('.p-size-detail');

			$.ajax({
					type:  'POST',
					url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
					contentType: "application/x-www-form-urlencoded; charset=UTF-8",
					dataType: 'json',
					data: {
						'action': 'zwc_generate_size',
						'pid': pid,
						'color': color,
						// 'nonce_checkout_key' : $('#nonce_get_generate_size').val(),
						// '_wp_http_referer' : $('#nonce_get_generate_size').next().val(),
					},
					beforeSend: function(){
						element.parent().parent().parent().parent().parent().addClass('loadingpage');
					},
					success: function (obj) {
						console.log(obj);
						if( obj['success'] == true ){
							// $('.zwc-custom-thumbnail').html(obj['image']);
							size_html.find('.p-preview-size').html(obj['size_chosen']);
							var new_size = size_html.find('ul').html(obj['html']);
							if( obj['check'] == 0 ){
								new_size.find('li').first().addClass('active');
							}
							element.parent().parent().parent().parent().parent().find('.open-customize').data("pid", obj['variation_id']);
						} else if( obj['success'] == false ){

						}

					},
					complete: function(){
						element.parent().parent().parent().parent().parent().removeClass('loadingpage');
						chosen_size();
					},
					error:   function(error) {
						console.log(error); // For testing (to be removed)
					}
			});
		}

		// filter_attribute($(document).find('.p-size-detail').find('li.p-li-size.active'));

		// $(document).find('.p-color-detail').find('li.p-li-color.active').each(function(index){
		// 	generate_size($(this));
		// });

		function chosen_size(){
			$(document).find('.p-size-detail').find('li.p-li-size').on("click", function(evt) {
				evt.preventDefault();

				if( $(this).hasClass('disabled') ){
					return false;
				}

				$(this).parent().find('.p-li-size').removeClass('active');
				$(this).parent().parent().find('.p-preview-size').html($(this).data('sizetext'));
				$(this).addClass('active');

				filter_attribute($(this));
			});
		}
		chosen_size();

		function chosen_color(){
			$(document).find('.zwc-product-sumary.collection').find('.p-color-detail').find('li.p-li-color').on("click", function(evt) {
				evt.preventDefault();

				$(this).parent().find('.p-li-color').removeClass('active');
				$(this).parent().parent().find('.p-preview-color').html($(this).data('colortext'));
				$(this).addClass('active');

				generate_size($(this));
				filter_attribute($(this));
			});
			$(document).find('.zwc-product-sumary.single').find('.p-color-detail').find('li.p-li-color').on("click", function(evt) {
				evt.preventDefault();

				$(this).parent().find('.p-li-color').removeClass('active');
				$(this).parent().parent().find('.p-preview-color').html($(this).data('colortext'));
				$(this).addClass('active');

				generate_size($(this));
				filter_attribute($(this));
			});
		}
		chosen_color();

		$(document).on("click", '.add_to_cart_button' ,function(evt) {
			evt.preventDefault();

			var pid = $(this).parent().parent().parent().parent().data('product-id');
			var size = $(this).parent().parent().parent().parent().find('.p-size-detail').find('li.p-li-size.active').data('size');
			var color = $(this).parent().parent().parent().parent().find('.p-color-detail').find('li.p-li-color.active').data('color');

			// var quality = $('.temp_quality').val();

			var price = $(this).parent().parent().parent().parent().find('.p-price-detail');
			var btn = $(this);

			$.ajax({
					type:  'POST',
					url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
					contentType: "application/x-www-form-urlencoded; charset=UTF-8",
					dataType: 'json',
					data: {
						'action': 'zwc_add_to_cart',
						'pid': pid,
						'size': size,
						'color': color,
						// 'quality': quality,
						// 'nonce_checkout_key' : $('#nonce_get_add_to_cart').val(),
						// '_wp_http_referer' : $('#nonce_get_add_to_cart').next().val(),
					},
					beforeSend: function(){
						btn.removeClass('added');
						btn.addClass('loadingpage');
						btn.parent().parent().find('.nb-error').html('');
					},
					success: function (obj) {
						console.log(obj);

						if( obj['success'] == true ){
							btn.addClass('added');
							price.html(obj['price']);
							$('.cart-show').click();
						} else if( obj['success'] == false ){
							btn.parent().parent().find('.nb-error').html(obj['data']);
						}

					},
					complete: function(){
						btn.removeClass('loadingpage');
						update_menu_cart();
					},
					error:   function(error) {
						console.log(error); // For testing (to be removed)
					}
			});

		});

	});
});
</script>
