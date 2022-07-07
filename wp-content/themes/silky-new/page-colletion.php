<?php
get_header();
do_action('product_style');	



// print the IMG HTML



?>
<div class="colletion-wrapper">
    <div class="collection-wrapp-header">
        <!-- <img class="collection-header-img" src="" alt=""> -->
        <img src="<?php echo get_template_directory_uri() . '/img/header-collection.png'; ?>" class="collection-header-img" />
    </div>
    <div class="collection-content">
        <?php
        $parent_id = 24;
        $termchildren = get_terms('product_cat',array('child_of' => $parent_id));
        foreach ($termchildren as $term) {
            // var_dump($term->term_id);
            $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true ); 
            $category_link = get_category_link( $term->term_id,'category_link',true );
            $image = wp_get_attachment_url( $thumbnail_id ); 
           
         
            echo '<div class="collection-item">';
                echo'<div class = "collection-img">';
                    echo"<img src='{$image}' alt=''  />";
                echo '</div>';
                ?> <div class="collection-btn">
                <a href="<?php echo $category_link ?>"> Shop the look</a></div> <?php 
            echo '</div>';
        }

        ?>
   
    
        
    </div>
</div>


 




<?php


get_footer( );
