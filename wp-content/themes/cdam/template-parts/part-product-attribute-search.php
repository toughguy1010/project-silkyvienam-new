<?php
global $product;

$attr = $product->get_attributes();

$pa_mau = $attr['pa_colour'];
$label_mau = wc_attribute_label($pa_mau['name']);
$pa_parse_mau = wc_get_product_terms( $product->get_id(), $pa_mau['name'] );

$pa_size = $attr['pa_size'];
$label_size = wc_attribute_label($pa_size['name']);
$pa_parse_size = wc_get_product_terms( $product->get_id(), $pa_size['name'] );

?>
<ul>
  <?php
  foreach ($pa_parse_size as $key => $size) {
    ?>
    <li class="p-li-size <?php echo $key == 0 ? 'active' : ''; ?>" data-sizeterm="<?php echo $size->term_id; ?>" data-size="<?php echo $size->name; ?>" data-sizetext="<?php echo $size->name; ?>"><?php echo $size->name; ?></li>
    <?php
  }
  ?>
</ul>
<ul class="color">
  <?php
  foreach ($pa_parse_mau as $key => $mau) {
    ?>
    <li class="p-li-color <?php echo $key == 0 ? 'active' : ''; ?>" data-colorterm="<?php echo $mau->term_id; ?>" data-color="<?php echo $mau->name; ?>" data-colortext="<?php echo $mau->name; ?>" style="background: <?php echo zwc_parse_text_to_color($mau->term_id); ?>;"></li>
    <?php
  }
  ?>
</ul>
