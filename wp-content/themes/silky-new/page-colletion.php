<?php
get_header();
do_action('product_style');	

// print the IMG HTML
$parent_id = 24;
// parent category ID
$parentterm = get_term_by( 'id', $parent_id, 'product_cat' ) ;
// child category ID

$termchildren = get_terms('product_cat',array('child_of' => $parent_id));

?>

<?php

    // echo $parentterm->name
?>
<div class="colletion-wrapper">
    <div class="collection-wrapp-header">
        <!-- <img class="collection-header-img" src="" alt=""> -->
        <img src="<?php echo get_template_directory_uri() . '/img/header-collection.png'; ?>" class="collection-header-img" />
        <div class="header-collection-desc">
            <div class="header-colletion-name">
                <?php echo $parentterm->name ?>
            </div>
            <div class="header-colletion-line"></div>
            <div class="content-header-collection-desc"> <?php echo category_description($parent_id); ?></div>
        </div>
    </div>
    <div class="collection-content">
        <?php
  
        //  echo category_description($parent_id);
        
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
    <div class="colletion-pagination">
        <?php 
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
            $args = array(
                'post_type'=> 'post',
                'orderby'    => 'ID',
                'post_status' => 'publish',
                'order'    => 'DESC',
                'posts_per_page' => 2,// this will retrive all the post that is published 
                'paged' => $paged
                );
                $result = new WP_Query( $args );
                echo paginate_links( array(
                    'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                    'total'        => $result->max_num_pages,
                    'current'      => max( 1, get_query_var( 'paged' ) ),
                    'format'       => '?paged=%#%',
                    'show_all'     => false,
                    'type'         => 'plain',
                    'end_size'     => 2,
                    'mid_size'     => 1,
                    'prev_next'    => true,
                    'prev_text'    => sprintf( '<i></i> %1$s', __( '<', 'text-domain' ) ),
                    'next_text'    => sprintf( '%1$s <i></i>', __( '>', 'text-domain' ) ),
                    'add_args'     => false,
                    'add_fragment' => '',
                ) );
        ?>
    </div>
</div>


 




<?php


get_footer( );
