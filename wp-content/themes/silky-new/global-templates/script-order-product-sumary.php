<?php $formatted_destination    = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package['destination'], ', ' );
$has_calculated_shipping  = ! empty( $has_calculated_shipping );
$show_shipping_calculator = ! empty( $show_shipping_calculator );
$calculator_text          = '';?>
<script type="text/javascript">
jQuery.noConflict();
jQuery(function($){
	$(function(){

		function zwc_order_product_sumary(){
			$.ajax({
					type:  'POST',
					url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
					contentType: "application/x-www-form-urlencoded; charset=UTF-8",
					dataType: 'html',
					data: {
						'action': 'zwc_order_product_sumary',
						// 'nonce_checkout_key' : $('#nonce_get_data').val(),
						// '_wp_http_referer' : $('#nonce_get_data').next().val(),
					},
					beforeSend: function(){
						$('#order-product-sumary').addClass('loadingpage');
						$('#order-product-sumary').html('');
					},
					success: function (obj) {
						$('#order-product-sumary').html(obj);
						// debugger;
					},
					complete: function(){
						$('#order-product-sumary').removeClass('loadingpage');

						$(document).find( "#order-product-sumary" ).on('click','.delete',function(e){
							e.preventDefault();
							var item_key = $(this).data('itemkey');
							var item = $(this);

							$.ajax({
									type:  'POST',
									url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
									contentType: "application/x-www-form-urlencoded; charset=UTF-8",
									dataType: 'html',
									data: {
										'action': 'zwc_order_delete',
										'item_key': item_key,
										// 'nonce_checkout_key' : $('#nonce_get_data').val(),
										// '_wp_http_referer' : $('#nonce_get_data').next().val(),
									},
									beforeSend: function(){
										item.parent().parent().parent().addClass('loadingpage');
									},
									success: function (obj) {
										$('#order-product-sumary').html(obj);
									},
									complete: function(){
										update_shipping_met_install();
										update_shipping_met();
										item.parent().parent().parent().removeClass('loadingpage');
										$( 'body' ).trigger( 'update_checkout' );
									},
									error:   function(error) {
										console.log(error); // For testing (to be removed)
									}
							});
					  });

					},
					error:   function(error) {
						console.log(error); // For testing (to be removed)
					}
			});
		}



		$(document).find('#order-product-sumary').on('click','.delete',function(e){
			e.preventDefault();
			var item_key = $(this).data('itemkey');
			var item = $(this);

			$.ajax({
					type:  'POST',
					url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
					contentType: "application/x-www-form-urlencoded; charset=UTF-8",
					dataType: 'html',
					data: {
						'action': 'zwc_order_delete',
						'item_key': item_key,
						// 'nonce_checkout_key' : $('#nonce_get_data').val(),
						// '_wp_http_referer' : $('#nonce_get_data').next().val(),
					},
					beforeSend: function(){
						item.parent().parent().parent().addClass('loadingpage');
					},
					success: function (obj) {
						$('#order-product-sumary').html(obj);
					},
					complete: function(){
						item.parent().parent().parent().removeClass('loadingpage');
						$( 'body' ).trigger( 'update_checkout' );
					},
					error:   function(error) {
						console.log(error); // For testing (to be removed)
					}
			});

		});

		$(document).find('#order-product-sumary').on('click','.remove-coupon',function(e){
			e.preventDefault();
			var coupon = $(this).data('coupon');
			var item = $(this).parent().parent().parent();

			$.ajax({
					type:  'POST',
					url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
					contentType: "application/x-www-form-urlencoded; charset=UTF-8",
					dataType: 'html',
					data: {
						'action': 'zwc_remove_coupon',
						'coupon': coupon,
						// 'nonce_checkout_key' : $('#nonce_get_data').val(),
						// '_wp_http_referer' : $('#nonce_get_data').next().val(),
					},
					beforeSend: function(){
						item.addClass('loadingpage');
					},
					success: function (obj) {

					},
					complete: function(){
						item.removeClass('loadingpage');
						$( 'body' ).trigger( 'update_checkout' );
						location.reload();
					},
					error:   function(error) {
						console.log(error); // For testing (to be removed)
					}
			});

		});

		$(document).find('#redeem-coupon').on('click','button[name="redeem-coupon"]',function(e){
			e.preventDefault();
			var item = $(this);
			var item_parent = $(this).parent();

			$.ajax({
					type:  'POST',
					url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
					dataType: 'json',
					data: {
						'action': 'zwc_apply_coupon',
						'coupon': $('#coupon').val(),
						'redeem-coupon': $(this).val(),
						// 'nonce_checkout_key' : $('#nonce_get_data').val(),
						// '_wp_http_referer' : $('#nonce_get_data').next().val(),
					},
					beforeSend: function(){
						item_parent.addClass('loadingpage');
						item.attr('disabled',true);
					},
					success: function (obj) {
						item_parent.find('#coupon').val('');
						zwc_order_product_sumary();
					},
					complete: function(){
						item_parent.removeClass('loadingpage');
						$( 'body' ).trigger( 'update_checkout' );
						item.attr('disabled',false);
					},
					error:   function(error) {
						console.log(error); // For testing (to be removed)
					}
			});

		});

		window.update_shipping_met = function update_shipping_met(){
			$(document).find('#order-product-sumary').on('click','#zwc_chosen_method',function(e){
				e.preventDefault();
				var item = $(this);
				var	shipping = item.find("input[name='zwc_chosen_method']:checked").val();

				$.ajax({
						type:  'POST',
						url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
						contentType: "application/x-www-form-urlencoded; charset=UTF-8",
						dataType: 'json',
						data: {
							'action': 'zwc_change_shipping_method',
							'shipping': shipping,
								// 'nonce_checkout_key' : $('#nonce_get_data').val(),
								// '_wp_http_referer' : $('#nonce_get_data').next().val(),
						},
						beforeSend: function(){
							item.addClass('loadingpage');
							$('#billing_first_name_field').parent().addClass('loadingpage');
							$( 'body' ).trigger( 'update_checkout' );
						},
						success: function (obj) {
							$('#zwc_chosen_method').html(obj.html);
							$('#order-product-sumary').find('.cart-total').find('.coll-right').html(obj.total);
						},
						complete: function(){
							item.removeClass('loadingpage');
							$('#billing_first_name_field').parent().removeClass('loadingpage');
						},
						error:   function(error) {
							console.log(error); // For testing (to be removed)
						}
				});

			});
		}

		window.update_shipping_met_install = function update_shipping_met_install(){
				console.log('met_install');
				var item = $('#zwc_chosen_method');
				var	shipping = item.find("input[name='zwc_chosen_method']:checked").val();

				$.ajax({
						type:  'POST',
						url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
						contentType: "application/x-www-form-urlencoded; charset=UTF-8",
						dataType: 'json',
						data: {
							'action': 'zwc_change_shipping_method',
							'shipping': shipping,
							// 'nonce_checkout_key' : $('#nonce_get_data').val(),
							// '_wp_http_referer' : $('#nonce_get_data').next().val(),
						},
						beforeSend: function(){
							item.addClass('loadingpage');
							$('#billing_first_name_field').parent().addClass('loadingpage');
							$( 'body' ).trigger( 'update_checkout' );
						},
						success: function (obj) {
							$('#zwc_chosen_method').html(obj.html);
							$('#order-product-sumary').find('.cart-total').find('.coll-right').html(obj.total);
						},
						complete: function(){
							item.removeClass('loadingpage');
							$('#billing_first_name_field').parent().removeClass('loadingpage');
						},
						error:   function(error) {
							console.log(error); // For testing (to be removed)
						}
				});

		}

	

		$(document).on('change','select[name=billing_country],select[name=billing_state],select[name=billing_city]',function(){
			console.log($(this));

			var checkout_is_updated = false;
			$( document.body ).on( 'updated_checkout', function(){
				// just once
				if ( checkout_is_updated == false ) {
					update_shipping_met_install();
					checkout_is_updated = true;
				}
			});
		});

		zwc_order_product_sumary();
		update_shipping_met();

	});
});
</script>

