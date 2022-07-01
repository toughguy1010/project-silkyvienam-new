(function ($) {
	"use strict";

	$(document).on(
		"click",
		".wopb-wishlist-add, .wopb-wishlist-remove, .wopb-wishlist-cart-added",
		function (e) {
			e.preventDefault();
			const that = $(this);
			const _modal = $('.wopb-modal-wrap');
			const actionType = that.data("action");

			if (
				actionType == "remove" ||
				actionType == "cart_remove" ||
				actionType == "cart_remove_all"
			) {
				if (that.closest('tbody').find('tr').length <= 1) {
					that.closest("table").remove();
					_modal.removeClass('active');
				} else {
					that.closest("tr").remove();
				}
			}


			$.ajax({
				url: wopb_data.ajax,
				type: "POST",
				data: {
					action: "wopb_wishlist",
					post_id: that.data("postid"),
					type: actionType,
					wpnonce: wopb_data.security,
				},
				beforeSend: function () {
					if (that.data("redirect") == undefined && actionType == 'add' && that.hasClass('wopb-wishlist-active')) {
						_modal.find('.wopb-modal-body').html('');
						_modal.addClass('active');
						_modal.find('.wopb-modal-loading').addClass('active');
					}
				},
				success: function (response) {
					if (response.success) {
						if (actionType == "remove") {
							$('.wopb-wishlist-add[data-postid="'+that.data("postid")+'"]').removeClass('wopb-wishlist-active');
						}
						if (actionType == "add") {
							if(that.hasClass('wopb-wishlist-active')) {
								_modal.find('.wopb-modal-body').html(response.data.html);
        						$('.wopb-wishlist-modal-content .wopb-loop-variations-form').remove()
							}else{
								that.addClass('wopb-wishlist-active');
							}
						}
						const redirectUrl = that.data("redirect");
						if (redirectUrl) {
							window.location.href = redirectUrl;
						}
					}
				},
				complete: function (data) {
					_modal.find('.wopb-modal-loading').removeClass('active');
				},
				error: function (xhr) {
					console.log( "Error occured.please try again" + xhr.statusText + xhr.responseText );
				},
			});
		}
	);


})(jQuery);