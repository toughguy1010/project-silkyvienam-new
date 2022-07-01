<?php
global $product;
$childrens = $product->get_children();
$first_child = wc_get_product($childrens[0]);
$first_child_id = $first_child->get_id();
// $first_child_terms = get_the_terms ( $first_child_id, 'product_cat' );
// $first_child_terms_id = $first_child_terms[0]->term_id;
?>
<div class="bio">
  Shop the look
</div>
<div class="zwc-product-sumary collection">
  <div class="listing">
    <?php

    foreach ($childrens as $key => $children) {
      $p_children = wc_get_product($children);
      // $p_variation = $p_children->get_available_variations();
      // $first_p = wc_get_product( $p_variation[0]['variation_id'] );

      if( $p_children->get_type() == 'variable' ){
        $p_variation = $p_children->get_available_variations();
        $first_p = wc_get_product( $p_variation[0]['variation_id'] );
      }

      if( $p_children->get_type() == 'simple' ){
        $first_p = $product;
      }

      $p_id = $p_children->get_id();
      $name = $p_children->get_name();

      $attr = $p_children->get_attributes();

      $pa_mau = $attr['pa_colour'];
      $label_mau = wc_attribute_label($pa_mau['name']);
      $pa_parse_mau = wc_get_product_terms( $p_id, $pa_mau['name'] );

      $pa_size = $attr['pa_size'];
      $label_size = wc_attribute_label($pa_size['name']);
      $pa_parse_size = wc_get_product_terms( $p_id, $pa_size['name'] );
      ?>
      <div class="item" data-product-id="<?php echo $p_id; ?>">
        <div class="info">
          <div class="p-size">
            <div class="p-name">
              <a href="<?php echo get_permalink( $p_id ); ?>"><?php echo $name; ?></a>
            </div>
            <div class="p-size-detail">
              <div>Select <?php echo $label_size ; ?>: <span class="p-preview-size"><?php echo $pa_parse_size[0]->name; ?></span></div>
              <ul class="wrap-attr-self-<?php echo $p_children->get_id(); ?>">
                <?php

                $attribute = wp_list_pluck($p_children->get_available_variations(),'attributes','variation_id');

                $check_active = 0;
                $temp_size_fisrt = '';
                foreach ($pa_parse_size as $ks => $size) {

                  foreach ($attribute as $kv => $value) {

                    if ( strtolower(str_replace("-en","",$value['attribute_pa_size'])) == strtolower(str_replace("/","-",zenzweb_remove_unicode_char($size->name)))
                      && strtolower(str_replace("-en","",$value['attribute_pa_colour'])) == strtolower(zenzweb_remove_unicode_char($pa_parse_mau[0]->name)) ){

                      $variable = wc_get_product($kv);
                      if( $variable->get_stock_status() != 'outofstock' ){
                        echo '<li class="p-li-size '.($check_active == 0 ? 'active' : '').'" data-sizeterm="'.$size->term_id.'" data-size="'.$size->name.'" data-sizetext="'.$size->name.'">'.$size->name.'</li>';
                        if( $check_active == 0 ){
                          $temp_size_fisrt = $size->name;
                        }
                        $check_active++;
                      }else{
                        echo '<li class="p-li-size disabled" data-sizeterm="'.$size->term_id.'" data-size="'.$size->name.'" data-sizetext="'.$size->name.'">'.$size->name.'</li>';
                      }
                    }

                  }

                }
                if( $temp_size_fisrt != '' ){
                  ?>
                  <script type="text/javascript">
                    jQuery.noConflict();
                    jQuery(function($){
                      $('.wrap-attr-self-<?php echo $p_children->get_id(); ?>').parent().parent().find('.p-preview-size').html('<?php echo $temp_size_fisrt; ?>');
                    });
                  </script>
                  <?php
                }
                if( $check_active == 0 ){
                  ?>
                  <script type="text/javascript">
                    jQuery.noConflict();
                    jQuery(function($){
                      $('.wrap-attr-self-<?php echo $p_children->get_id(); ?>').find('li').first().addClass('active');
                    });
                  </script>
                  <?php
                }
                ?>
              </ul>
            </div>
          </div>
          <div class="p-color">
            <div class="p-name">
              <?php echo $label_mau; ?>
            </div>
            <div class="p-color-detail">
              <div><span class="p-preview-color"><?php echo $pa_parse_mau[0]->name; ?></span></div>
              <ul>
                <?php
                foreach ($pa_parse_mau as $key => $mau) {
                  ?>
                  <li class="p-li-color <?php echo $key == 0 ? 'active' : ''; ?>" data-colorterm="<?php echo $mau->term_id; ?>" data-color="<?php echo $mau->name; ?>" data-colortext="<?php echo $mau->name; ?>" style="background: <?php echo zwc_parse_text_to_color($mau->term_id); ?>;"></li>
                  <?php
                }
                ?>
              </ul>
            </div>
          </div>
          <div class="p-price">
            <div class="p-name">
              Price
            </div>
            <div class="p-price-detail">
              <?php echo $first_p->get_price_html(); ?>
            </div>
          </div>
        </div>
        <div class="btn-cart">
          <div class="add-to-cart">
            <?php get_template_part('template-parts/part','atc-btn'); ?>
          </div>
        </div>
      </div>
      <?php
    }

    ?>
    <?php get_template_part('template-parts/script','atc-collection'); ?>
  </div>
</div>
