<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// $container = get_theme_mod( 'understrap_container_type' );
?>
<style>
.sib_signup_box_inside_1{
    display: flex;
    justify-content: space-between;
    width: 100%;
}
.sib_msg_disp{
    display: none !important  ;
}
.footer-search-form form{
width: 100%;
}
.footer-search-form .submit-btn{
margin-right: 5px;
    /* margin-left: 100%; */
}
.sib-email-area{
margin-left: 5px;
width: 100%;
border: 2px white solid;
outline:  0px !important;
}
.footer-search-form .submit-btn input{
    background-color: white;
    border: 2px solid white !important;
}
.footer-search-form
{
    height: 36px !important;
}
</style>

        <!-- Footer start -->
        <div class="footer-section footer-desktop">
            <div class="wrap-footer">
                <div class="footer-content">
                    <div class="footer-contact">
                        <div class="footer-contact-infor">
                            <!-- <div class="footer-contact-item fw-bold footer-title">Silky VietNam</div>
                            <div class="footer-contact-item ">Email: silkyvietnaminfo@gmail.com</div>
                            <div class="footer-contact-item ">Địa chỉ: Số 5 Hàng Bông , Hoàn Kiếm , Hà Nội</div>
                            <div class="footer-contact-item ">Điện thoại : (+84) 89808 3735</div> -->
                       <?php
                         wp_nav_menu( 
                            array( 
                                'theme_location' => 'footer', 
                                'container' => 'false', 
                                'menu_id' => 'footer-menu', 
                                'menu_class' => ' '
                             ) 
                          ); 
                       ?>
                        </div>
                        <div class="footer-service ">
                            <div class="footer-service-item footer-hidden-element ">Silky VietNam</div>
                            <a href="http://silkyvietnam.vn/chinh-sach-dieu-khoan/" class="footer-service-item ">Chính sách & Điều khoản</a>
                            <a href="http://silkyvietnam.vn/chinh-sach-quyen-rieng-tu/" class="footer-service-item ">Chính sách về Quyền riêng tư & Cookies</a>
                            <a href="http://silkyvietnam.vn/van-chuyen-hoan-tra/" class="footer-service-item ">Vận chuyển & Hoàn trả</a>
                        </div>
                    </div>
                    <div class="footer-input-form">
                        <div class="footer-input-item fw-bold mb-2">Nhận thông tin từ Silky Việt Nam</div>
                        <div class="footer-input-item footer-search-form ">

                        <?php
                        echo do_shortcode('[sibwp_form id=1]');
                        ?>
                            <!-- <input type="text" class="footer-search-input" placeholder=" Email*">
                            <a href="" class="footer-search-btn">
                                OK
                            </a> -->
                        </div>
                        <div class="footer-input-item footer-hidden-element ">Silky VietNam</div>
                        <div class="footer-input-item footer-hidden-element ">Silky VietNam</div>
                    </div>
                </div>
                <div class="footer-line"></div>
                <div class="footer-desc">
                    <div class="social-connection">
                        <div class="social-connection-item"> Kết nối với Silky Việt Nam:</div>
                        <!-- <a href="" class="social-connection-item"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="" class="social-connection-item"><i class="fa-brands fa-instagram"></i></a> -->
                        <?php
                          wp_nav_menu( 
                            array( 
                                'theme_location' => 'social', 
                                'container' => 'false', 
                                'menu_id' => 'social-menu', 
                                'menu_class' => ' '
                             ) 
                          ); 
                       ?>
                    </div>
                    <div class="logo-footer">
                <img src="<?php echo get_template_directory_uri() . '/img/footer-logo-img.png'; ?>" class="logo-img-respon" />

                        <!-- <img src="/assets/img/footer-logo-img.png" alt="" class="logo-img-respon"> -->
                    </div>
                    <div class="copy-right">Copyright 2022 © SILKYVIETNAM - All rights reserved</div>
                </div>
            </div>
        </div>

    </div>




    <!-- footer mobile -->
    <div class="footer-section  footer-mobile">
            <div class="wrap-footer">
                <div class="footer-content">
                    <div class="footer-contact">
                        <div class="footer-contact-infor">
                            <!-- <div class="footer-contact-item fw-bold footer-title">Silky VietNam</div>
                            <div class="footer-contact-item ">Email: silkyvietnaminfo@gmail.com</div>
                            <div class="footer-contact-item ">Địa chỉ: Số 5 Hàng Bông , Hoàn Kiếm , Hà Nội</div>
                            <div class="footer-contact-item ">Điện thoại : (+84) 89808 3735</div> -->
                       <?php
                         wp_nav_menu( 
                            array( 
                                'theme_location' => 'footer', 
                                'container' => 'false', 
                                'menu_id' => 'footer-menu', 
                                'menu_class' => ' '
                             ) 
                          ); 
                       ?>
                        </div>
                        <div class="footer-service ">
                            <div class="footer-service-item footer-hidden-element ">Silky VietNam</div>
                            <a href="http://silkyvietnam.vn/chinh-sach-dieu-khoan/" class="footer-service-item ">Chính sách & Điều khoản</a>
                            <a href="http://silkyvietnam.vn/chinh-sach-quyen-rieng-tu/" class="footer-service-item ">Chính sách về Quyền riêng tư & Cookies</a>
                            <a href="http://silkyvietnam.vn/van-chuyen-hoan-tra/" class="footer-service-item ">Vận chuyển & Hoàn trả</a>
                        </div>
                    </div>
                    <div class="footer-input-form">
                        <div class="footer-input-item fw-bold mb-2">Nhận thông tin từ Silky Việt Nam</div>
                        <div class="footer-input-item footer-search-form ">
                            <input type="text" class="footer-search-input" placeholder=" Email*">
                            <a href="" class="footer-search-btn">
                                OK
                            </a>
                        </div>
                        <div class="footer-input-item footer-hidden-element ">Silky VietNam</div>
                        <div class="footer-input-item footer-hidden-element ">Silky VietNam</div>
                    </div>
                    <div class="footer-desc">
                    <div class="social-connection">
                        <div class="social-connection-item"> Kết nối với Silky Việt Nam:</div>
                        <!-- <a href="" class="social-connection-item"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="" class="social-connection-item"><i class="fa-brands fa-instagram"></i></a> -->
                        <?php
                          wp_nav_menu( 
                            array( 
                                'theme_location' => 'social', 
                                'container' => 'false', 
                                'menu_id' => 'social-menu', 
                                'menu_class' => ' '
                             ) 
                          ); 
                       ?>
                    </div>
                   
                    <div class="copy-right">Copyright 2022 © SILKYVIETNAM - All rights reserved</div>
                  
                </div>
                </div>
                <div class="footer-line"></div>
                <div class="logo-footer">
                        <img src="<?php echo get_template_directory_uri() . '/img/footer-logo-img.png'; ?>" class="logo-img-respon" />

                        <!-- <img src="/assets/img/footer-logo-img.png" alt="" class="logo-img-respon"> -->
                    </div>
            </div>
        </div>

    </div>

    <!-- Footer end-->
    <!-- <script src="/js/header.js"></script> 
     <script src="/js/blog.js"></script> -->
    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<?php
    wp_footer();
   
?>
</body>

</html>