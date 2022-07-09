<?php
global $product;
// $productFields = get_field_objects($product->get_id());
// $imgHoverId = $productFields['zwc_product_hover']['value'];

$img_src = wp_get_attachment_url( $product->get_image_id() );
// $img_src_hover = wp_get_attachment_url( $imgHoverId );
?>

<div class="product-collection-item">
        <a class="image_sp" href="<?php the_permalink() ;?>"><?php the_post_thumbnail("medium",array( "title" => get_the_title(),"alt" => get_the_title() ));?></a>
        <h4 class="title_sp"><a href="<?php the_permalink() ;?>"><?php the_title() ;?></a></h4>
		<div class="collection-product-short-desc">
		<?php
		global $product;
		
		?>
		</div>
        <span class="price">
			<?php 
		
			
				echo apply_filters('silky_filter-product-price',$product->get_price_html() )
			?>
		</span>
    </div>
