jQuery(function($) {
  // if( $('#woocommerce_cdam_shipping_method_district').length > 0 ){
    $(document).on('click','#woocommerce_cdam_shipping_method_district_clear',function(){
      // $('#woocommerce_cdam_shipping_method_district').val('');
      $("#woocommerce_cdam_shipping_method_district option:selected").prop("selected", false);
    });
  // }
});
