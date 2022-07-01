<?php get_header();
do_action('blog-style');
?>

        <!-- content start -->
        <div class="wrapper-content">
            <div class="menu-btn d-flex ">
                <a href="" class="menu-btn-item fw-lighter">Câu chuyện Silky</a>
                <div class="menu-btn-line"></div>
                <a href="" class="menu-btn-item fw-bold">Blog</a>
            </div>
            <div class="menu-content">
                <ul class="menu-blog-list">
                    <?php 
                    // echo '<pre>';
                    // var_dump($wp_query);
                    // echo '</pre>';
                    if (have_posts()) :
                        while(have_posts()) :
                            the_post();
                    ?>
                    <!-- post start -->
                    <li class="menu-item">
                        <a href="<?php the_permalink(); ?>" class="blog-item">
                            <?php the_post_thumbnail('grid_post_thumbnail', array(
                                'alt' => get_post_meta(get_post_thumbnail_id( get_the_ID()),
                                '_wp_attachment_image_alt', true)
                            )) ?>
                            <div class="blog-img">

                                <!-- <img src="/assets/img/blog/blog-img-1.png" alt="" class="blog-img-respon"> -->
                            </div>
                            <div class="blog-title">nghề trồng dâu nuôi tằm dệt lụa của việt nam</div>
                            <div class="blog-line"></div>
                            <div class="blog-desc">SilkyVietnam được hình thành từ gợi ý của một nhà văn hóa, họa sĩ, một học giả Việt Kiều Pháp về việc khôi phục nghề trồng dâu nuôi tằm dệt lụa của Việt Nam. Sau nhiều ngày nghiên cứu và sau chuyến tìm hiểu, gặp gỡ các chuyên
                                gia hàng đầu tại Bảo Lộc - Lâm Đồng, người sáng lập Silky - cô Phạ</div>
                        </a>
                    </li>
                    <!-- post end -->
                   <?php
                        endwhile;
                    endif;
                    ?>
                </ul>
            </div>
            <div class="pagination">
                <ul class="pagination-list">
                    <li class="pagination-item ">
                        <div class="pagination-btn active-pagination" id="pagination-btn">1</div>
                    </li>
                    <li class="pagination-item">
                        <div class="pagination-btn " id="pagination-btn">2</div>
                    </li>
                    <li class="pagination-item">
                        <div class="pagination-btn " id="pagination-btn">3</div>
                    </li>
                    <li class="pagination-item">
                        <div class="pagination-btn " id="pagination-btn">4</div>
                    </li>
                    <li class="pagination-item">
                        <div class="pagination-btn ">
                            <svg class=" " xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 9 17">
                                <text id="_ " class=" " data-name="&gt;" transform="translate(1 13.5)" font-size="9" font-family="SegoeUI-Light, Segoe UI" font-weight="300"><tspan  x="1" y="-2">&gt;</tspan></text>
                            </svg>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- content end -->
        <script src="/assets/js/blog.js"></script>

<?php get_footer();
 ?>