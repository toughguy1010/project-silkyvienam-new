<?php
if( ! function_exists( 'get_thanhpho_quanhuyen' ) ){
  function get_thanhpho_quanhuyen(){
    $temp2 = array();
    foreach (array_unique(wp_list_pluck(get_quan_huyen(),'matp')) as $key => $city_code) {
      foreach (get_quan_huyen() as $key => $city) {
        if( $city['matp'] == $city_code ){
          $temp2[$city_code][$city['maqh']] = $city['name'];
        }
      }
    }
    return $temp2;
  }
}
