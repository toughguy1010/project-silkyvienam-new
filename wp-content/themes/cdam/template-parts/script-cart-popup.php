<?php
global $product;
?>
<script type="text/javascript">
jQuery.noConflict();
jQuery(function($){
	$(function(){

		window.update_menu_cart = function update_menu_cart(){
			$.ajax({
					type:  'POST',
					url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
					contentType: "application/x-www-form-urlencoded; charset=UTF-8",
					dataType: 'html',
					data: {
						'action': 'zwc_cart_menu_update',
						// 'nonce_checkout_key' : $('#nonce_get_data').val(),
						// '_wp_http_referer' : $('#nonce_get_data').next().val(),
					},
					beforeSend: function(){
						// $('.cart-show').addClass('loadingpage');
					},
					success: function (obj) {
						$('.cart-show').html(obj);
					},
					complete: function(){
						// $('.cart-show').removeClass('loadingpage');
					},
					error:   function(error) {
						console.log(error); // For testing (to be removed)
					}
			});
		}

		// $(window).bind('load',function(){
		// 	update_menu_cart();
		// });

		$(document).find( ".cart-show" ).on('click',function(){

			$.ajax({
					type:  'POST',
					url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
					contentType: "application/x-www-form-urlencoded; charset=UTF-8",
					dataType: 'html',
					data: {
						'action': 'zwc_cart_popup',
						// 'nonce_checkout_key' : $('#nonce_get_data').val(),
						// '_wp_http_referer' : $('#nonce_get_data').next().val(),
					},
					beforeSend: function(){
						$('#cart-popup').addClass('loadingpage');
						$('#cart-popup').html('');
					},
					success: function (obj) {
						$('#cart-popup').html(obj);
					},
					complete: function(){
						$('#cart-popup').removeClass('loadingpage');
						$('#cart-popup').find('.close').on('click',function(){
					    $(this).parent().removeClass('show');
					  });

						update_menu_cart();

						$(document).find( "#cart-popup" ).on('click','.delete',function(e){
							e.preventDefault();
							var item_key = $(this).data('itemkey');
							var item = $(this);

							$.ajax({
									type:  'POST',
									url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
									contentType: "application/x-www-form-urlencoded; charset=UTF-8",
									dataType: 'html',
									data: {
										'action': 'zwc_cart_popup_delete',
										'item_key': item_key,
										// 'nonce_checkout_key' : $('#nonce_get_data').val(),
										// '_wp_http_referer' : $('#nonce_get_data').next().val(),
									},
									beforeSend: function(){
										item.parent().parent().parent().addClass('loadingpage');
									},
									success: function (obj) {
										$('#cart-popup').html(obj);
									},
									complete: function(){
										item.parent().parent().parent().removeClass('loadingpage');
										$('#cart-popup').find('.close').on('click',function(){
									    $(this).parent().removeClass('show');
									  });

										update_menu_cart();
									},
									error:   function(error) {
										console.log(error); // For testing (to be removed)
									}
							});

							$('#cart-popup').addClass('show');

					  });

					},
					error:   function(error) {
						console.log(error); // For testing (to be removed)
					}
			});

			$('#cart-popup').addClass('show');

	  });

		$(document).find('#cart-page').find( ".wrap-item-detail" ).on('click','.delete',function(e){
			e.preventDefault();
			var item_key = $(this).data('itemkey');
			var item = $(this);

			$.ajax({
					type:  'POST',
					url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
					contentType: "application/x-www-form-urlencoded; charset=UTF-8",
					dataType: 'html',
					data: {
						'action': 'zwc_cart_delete',
						'item_key': item_key,
						// 'nonce_checkout_key' : $('#nonce_get_data').val(),
						// '_wp_http_referer' : $('#nonce_get_data').next().val(),
					},
					beforeSend: function(){
						item.parent().parent().parent().addClass('loadingpage');
					},
					success: function (obj) {
						$('#cart-page').find('.wrap-cart-page').html(obj);
					},
					complete: function(){
						item.parent().parent().parent().removeClass('loadingpage');

						update_menu_cart();
						cart_change_qty();
					},
					error:   function(error) {
						console.log(error); // For testing (to be removed)
					}
			});

		});

		window.cart_change_qty =  function cart_change_qty(){
			$(document).find('#cart-page').find( ".change-qty" ).on('click','.pre, .next',function(e){
				e.preventDefault();
				var qty = $(this).parent().find('label').text();
				if( $(this).hasClass('pre') ){
					qty = (qty*1) - 1;
					if( qty < 0 ){

					}else{
						$(this).parent().find('label').html(qty);
					}
				}
				if( $(this).hasClass('next') ){
					qty = (qty*1) + 1;
					$(this).parent().find('label').html(qty);
				}

			});
		}

		cart_change_qty();

		$(document).find('#cart-page').find( ".wrap-cart-page" ).on('click','.update-cart-btn',function(e){
			e.preventDefault();
			var arr_itemkey = new Array();
			$(document).find('#cart-page').find('.change-qty').each(function(index){
				arr_itemkey.push($(this).find('label').data('itemkey')+'|'+$(this).find('label').text());
			});
			var item = $(this);

			$.ajax({
					type:  'POST',
					url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
					contentType: "application/x-www-form-urlencoded; charset=UTF-8",
					dataType: 'json',
					data: {
						'action': 'zwc_cart_update',
						'item_key': arr_itemkey,
						// 'nonce_checkout_key' : $('#nonce_get_data').val(),
						// '_wp_http_referer' : $('#nonce_get_data').next().val(),
					},
					beforeSend: function(){
						item.parent().parent().parent().addClass('loadingpage');
					},
					success: function (obj) {
						console.log(obj);
						if( obj.success == true ){
							var data = obj.data;
							var remove_item = data.remove_item;
							if( remove_item ){
								for(i in remove_item){
									$(document).find('#cart-page').find('.'+remove_item[i]).remove();
								}
							}
							var items = data.items;
							for(i in items){
								var key = Object.keys(items[i])[0];
								$(document).find('#cart-page').find('.'+key).find('.p-total').html('<span>Total</span>'+items[i][key]);
							}
							$(document).find('#cart-page').find('.cart-items .coll-left').html('<span>'+data.count+'</span>');
							$(document).find('#cart-page').find('.cart-items .coll-right').html(data.cart_total);
							$(document).find('#cart-page').find('.cart-coupon .coll-right').html(data.discount);
							// $(document).find('#cart-page').find('.cart-shipping .coll-right').html(data.shipping_total);
							$(document).find('#cart-page').find('.cart-total .coll-right').html(data.total);
						}
					},
					complete: function(){
						$(document).find('#cart-page').find('.wrap-cart-page').removeClass('loadingpage');

						update_menu_cart();
					},
					error:   function(error) {
						console.log(error); // For testing (to be removed)
					}
			});

		});

		$(document).find( ".open-customize" ).on('click',function(){
			$('#form-customize').find('input[name="productid"]').val( $(this).data('pid') );
			$('#customize-product').addClass('show');
			$('#customize-preview').addClass('show');
			$('#customize-preview').addClass('layer');
			$('body').addClass('overflow-h');
			$('.zwc-custom-thumbnail').addClass('customize');
		});

		$(document).find( "#customize-product" ).on('click','.close',function(){
			$('#customize-product').removeClass('show');
			$('#customize-preview').removeClass('show');
			$('#customize-preview').removeClass('layer');
			$('body').removeClass('overflow-h');
			$('.zwc-custom-thumbnail').removeClass('customize');
			$('#customize-product').find('.measurements.step-1').addClass('show');
			$('#customize-product').find('.measurements.step-2').removeClass('show');
			$('#form-customize')[0].reset();
		});

		// $(document).find( "#customize-product" ).find('.hint').tooltip();

		$(document).find( "#customize-product" ).find('.next-step').on('click',function(){
			var em = 0;
			$(this).parent().parent().find('.item').find('input.size').each(function(index){
				if( $(this).val() == '' && $(this).data('req') == 1 ){
					$(this).addClass('error');
					em = 1;
				}
			});
			if( em == 0 ){
				$(document).find( "#customize-product" ).find('.measurements').toggleClass('show');
			}
		});

		$(document).find( "#customize-product" ).find('input.size').on('change',function(){
			if( $(this).val() != '' ){
				$(this).removeClass('error');
			}
		});

		$(document).find( "#customize-product" ).find('.mesur-action').on('click','.edit',function(){
			$(document).find( "#customize-product" ).find('.measurements').toggleClass('show');
		});

		$(document).find( "#customize-product" ).find('.size').on('change',function(){
			$(document).find( "#customize-product" ).find('.rsize-'+$(this).data('size')).html($(this).val()+'cm');
		});

		$(document).find( "#form-customize" ).on('submit',function(e){
			e.preventDefault();
			var data = $(this).serialize()+'&action=zwc_create_customize';
			$.ajax({
					type:  'POST',
					url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
					dataType: 'json',
					data: data,
					beforeSend: function(){
						$('#form-customize').addClass('loadingpage');
					},
					success: function (obj) {
						// console.log(obj);
						$('#customize-product').html(obj['html']);
					},
					complete: function(){
						$('#form-customize').removeClass('loadingpage');
					},
					error:   function(error) {
						console.log(error); // For testing (to be removed)
					}
			});

		});

		$(document).find( "#customize-product" ).find('.customize').hover(
	    function() {
				$.ajax({
						type:  'POST',
						url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
						dataType: 'html',
						data: {
							'action': 'zwc_show_customize',
							'image': $(this).data('id'),
							// 'nonce_checkout_key' : $('#nonce_get_data').val(),
							// '_wp_http_referer' : $('#nonce_get_data').next().val(),
						},
						beforeSend: function(){
							$('#customize-preview').addClass('loadingpage');
						},
						success: function (obj) {
							// console.log(obj);
							$('#customize-preview').html(obj);
							$('#customize-preview').removeClass('layer');
						},
						complete: function(){
							$('#customize-preview').removeClass('loadingpage');
						},
						error:   function(error) {
							console.log(error); // For testing (to be removed)
						}
				});

	    }, function() {
	      $('#customize-preview').html('');
				$('#customize-preview').addClass('layer');
	    }
	  );

		$(document).mouseover(function(e) {
	    var container = $(".customize");
	    if (!container.is(e.target) && container.has(e.target).length === 0) {
	      $('#customize-preview').html('');
	    }
	  });

		$('#customize-preview').on('click','img',function(){
			$(this).parent().addClass('layer');
		});

		update_menu_cart();

	});
});
</script>
