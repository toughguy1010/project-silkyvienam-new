<?php get_header();
do_action('blog-style');

?>

        <!-- content start -->
        <div class="wrapper-content">
            <div class="breadcrumb-blog">
                <?php
                    do_action('head');
                ?>
            </div>
            <div class="menu-content">
                <ul class="menu-blog-list">
                    <?php 
                    // echo '<pre>';
                    // var_dump($wp_query);
                    // echo '</pre>';
                    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                    $args = array(
                        'post_type'=> 'post',
                        'orderby'    => 'ID',
                        'post_status' => 'publish',
                        'order'    => 'DESC',
                        
                        'posts_per_page' => 4,// this will retrive all the post that is published 
                        'paged' => $paged
                        );
                        $result = new WP_Query( $args );
                     
                        if ( $result-> have_posts() ) : ?>
                        <?php while ( $result->have_posts() ) : $result->the_post(); ?>
                            <li class="menu-item">
                                <a href="<?php the_permalink(); ?>" class="blog-item">
                                    <?php the_post_thumbnail('grid_post_thumbnail', array(
                                        'alt' => get_post_meta(get_post_thumbnail_id( get_the_ID()),
                                        '_wp_attachment_image_alt', true)
                                    )) ?>
                                    <div class="blog-img">

                                        <!-- <img src="/assets/img/blog/blog-img-1.png" alt="" class="blog-img-respon"> -->
                                    </div>
                                    <div class="blog-title"><?php the_title() ?></div>
                                    <div class="blog-line"></div>
                                    <div class="blog-desc"><?php the_excerpt()?></div>
                                </a>
                            </li>
                            
                        <?php endwhile; ?>
                        <?php endif; wp_reset_postdata();
                    
                    ?>
                </ul>
            </div>
            <div class="pagination-blog">
            
            <?php //the_title();
                        // the_post();
                        
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
        
        <!-- content end -->
        <script src="/assets/js/blog.js"></script>

<?php get_footer();


 ?>