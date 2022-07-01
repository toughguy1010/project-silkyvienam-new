<?php
global $product;
$type = $product->get_type();

switch ($type) {
  case 'simple':
    get_template_part('template-parts/content','product-sumary-variable');
    break;

  case 'variable':
    get_template_part('template-parts/content','product-sumary-variable');
    break;

  case 'grouped':
    get_template_part('template-parts/content','product-sumary-grouped');
    break;

  default:
    // code...
    break;
}
?>
