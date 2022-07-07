<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// $bootstrap_version = get_theme_mod( 'understrap_bootstrap_version', 'bootstrap4' );
// $navbar_type       = get_theme_mod( 'understrap_navbar_type', 'collapse' );
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Silky VN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />

    <?php wp_head();?>
</head>

<body>

    <div class="wrapper">
        <!-- Header start -->
        <div class="header-section">
            <nav class="navbar navbar-expand-lg ">
                <!-- <div class="navbar-nav nav-list">
                    <div class="nav-item link-shop-item ">
                        <a class="nav-link active shop-link  " aria-current="page" href="#">Shop</a>
                        <div class="sub-shop-menu">
                            <ul class="sub-shop-list">
                                <li class="shop-item">
                                    <a href="" class="shop-item-title">Sản phẩm mới</a>
                                </li>
                                <li class="shop-item menu-1">
                                    <a href="" class="shop-item-title shop-item-active">Tất cả sản phẩm</a>
                                    <div class="sub-menu-1">
                                        <ul class="sub-list-1">
                                            <div class="sub-item-1">
                                                <a href="">Váy</a>
                                            </div>
                                            <div class="sub-item-1">
                                                <a href="">Áo</a>
                                            </div>
                                            <div class="sub-item-1">
                                                <a href="">Quần</a>
                                            </div>
                                            <div class="sub-item-1">
                                                <a href="">Jumpsuit</a>
                                            </div>
                                            <div class="sub-item-1">
                                                <a href="">Áo khoác</a>
                                            </div>
                                            <div class="sub-item-1">
                                                <a href="">Áo dài</a>
                                            </div>
                                            <div class="sub-item-1">
                                                <a href="">Sleepwear</a>
                                            </div>
                                        </ul>
                                    </div>
                                </li>
                                <li class="shop-item menu-2">
                                    <a href="" class="shop-item-title shop-item-active">Quà tặng</a>
                                    <div class="sub-menu-2">
                                        <ul class="sub-list-2">
                                            <div class="sub-item-2 ">
                                                <a href="">Khăn</a>
                                            </div>
                                            <div class="sub-item-2 ms-3">
                                                <a href="">Khăn trơn</a>
                                            </div>
                                            <div class="sub-item-2 ms-3">
                                                <a href="">Khăn thêu</a>
                                            </div>
                                            <div class="sub-item-2 ms-3">
                                                <a href="">Khăn vẽ</a>
                                            </div>
                                            <div class="sub-item-2">
                                                <a href="">Cà vạt</a>
                                            </div>
                                            <div class="sub-item-2">
                                                <a href="">Khẩu trang</a>
                                            </div>

                                        </ul>
                                    </div>
                                </li>
                                </li>
                                <li class="shop-item menu-1">
                                    <a href="" class="shop-item-title shop-item-active">Chất liệu</a>
                                    <div class="sub-menu-1">
                                        <ul class="sub-list-1">
                                            <div class="sub-item-1">
                                                <a href="">Lụa</a>
                                            </div>
                                            <div class="sub-item-1">
                                                <a href="">Đũi</a>
                                            </div>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="nav-item me-3 link-collection-item">
                        <a class="nav-link active collection-link " aria-current="page" href="#">Bộ sưu tập</a>
                        <div class="sub-collection-menu">
                            <ul class="sub-collection-list">
                                <li class="sub-collection-item">
                                    <a href="">Pre Fall Winter 2022</a>
                                </li>
                                <li class="sub-collection-item">
                                    <a href="">Spring Summer 2022</a>
                                </li>
                                <li class="sub-collection-item">
                                    <a href="">Fall Winter 2022</a>
                                </li>
                                <li class="sub-collection-item">
                                    <a href="">Spring Summer 2022</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="nav-item  link-about-item ">
                        <a class="nav-link active about-link" aria-current="page" href="about">Câu chuyện SILKY</a>
                        <div class="sub-about-menu">
                            <ul class="sub-about-list">
                                <li class="sub-about-item">
                                    <a href="about">Giới thiệu</a>
                                </li>
                                <li class="sub-about-item">
                                    <a href="blog">Blog </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Liên hệ</a>
                    </div>

                </div> -->
                <?php
                wp_nav_menu(
                    array(
                        'theme_location'  => 'primary',
                        'container_class' => 'collapse navbar-collapse',
                        'container_id'    => 'navbarNavDropdown',
                        'menu_class'      => 'navbar-nav ml-auto',
                        'fallback_cb'     => '',
                        'menu_id'         => 'main-menu',
                        'depth'           => 6,
                        'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
                    )
		        );
		        ?>
                <div class="header-logo">
                <img src="<?php echo get_template_directory_uri() . '/img/header-logo-img.jpg'; ?>" class="logo-respon" />
                    <!-- <img src="/assets/img/header-logo-img.jpg" alt="" class="logo-respon"> -->

                </div>
                <div class="header-feature">
                    <div class="header-feature-list">
                        <div class="header-feature-item switch-languae-btn">
                            <div class="switch-english-btn">EN</div>
                            <div class="switch-btn-layer"></div>
                            <div class="switch-vietnamese-btn">VN</div>
                        </div>
                    </div>
                    <div class="header-feature-list">
                        <div class="header-feature-item searching-form">
                            <input type="text" class="search-input" placeholder=" Search...">
                            <div class="search-btn">
                                <svg id="Group_59" data-name="Group 59" xmlns="http://www.w3.org/2000/svg" width="13.448" height="13.435" viewBox="0 0 13.448 13.435">
                                <g id="Group_58" data-name="Group 58" transform="translate(0 0)">
                                  <path id="Path_24" data-name="Path 24" d="M-2519.812,1856.667a1.113,1.113,0,0,1-.364-.287l-.356-.35-.711-.7-.712-.7-.712-.7-.712-.7-.011-.011-.009-.008a.092.092,0,0,0-.12-.007,5.938,5.938,0,0,1-1.065.65,5.694,5.694,0,0,1-2.794.531,5.542,5.542,0,0,1-3.2-1.22,5.538,5.538,0,0,1-1.815-2.559,5.576,5.576,0,0,1-.02-3.514,5.5,5.5,0,0,1,1.056-1.857,5.4,5.4,0,0,1,3.178-1.858,5.569,5.569,0,0,1,5.586,2,5.147,5.147,0,0,1,1.156,2.592,5.392,5.392,0,0,1-1.146,4.3c-.061.078-.126.154-.191.231a.093.093,0,0,0,.006.126l1.416,1.394q.983.968,1.967,1.936a.444.444,0,0,1,.013.645.472.472,0,0,1-.358.093A.44.44,0,0,1-2519.812,1856.667Zm-7.228-3.12h.009a6.548,6.548,0,0,0,.7-.055,4.732,4.732,0,0,0,3.118-1.813,4.514,4.514,0,0,0,.924-3.551,4.418,4.418,0,0,0-1.118-2.389,4.72,4.72,0,0,0-4.589-1.529,4.635,4.635,0,0,0-2.555,1.424,4.635,4.635,0,0,0-.859,5.072A4.738,4.738,0,0,0-2527.04,1853.548Z" transform="translate(2532.68 -1843.26)"/>
                                </g>
                              </svg>
                            </div>
                        </div>
                    </div>
                    <div class="header-feature-list link-cart-item">
                        <div id="cart-btn" class="header-feature-item cart-btn">
                            <svg class="cart-icon" xmlns="http://www.w3.org/2000/svg" width="11.984" height="13.973" viewBox="0 0 11.984 13.973">
                            <defs>
                              <style>
                                .cls-1 {
                                  fill: #282828;
                                }
                                .cart-icon:hover .cls-1{
                                    fill: #866733;
                                }

                              </style>
                            </defs>
                            <path id="Path_9" data-name="Path 9" class="cls-1" d="M-35.743,70.273c.107-1.835,1.442-3.5,2.682-3.5a3.7,3.7,0,0,1,2.795.758,3.609,3.609,0,0,1,1.152,2.675,1.652,1.652,0,0,0,.8.061c.961.012,1.356.351,1.417,1.311.134,2.088.247,4.178.371,6.268.028.488.087.975.1,1.464.019.99-.429,1.436-1.412,1.436h-9.112c-1.037,0-1.5-.458-1.457-1.513.07-1.76.172-3.517.258-5.276.031-.625.052-1.252.092-1.876a5.53,5.53,0,0,1,.116-.929,1.017,1.017,0,0,1,1.123-.882C-36.473,70.269-36.124,70.273-35.743,70.273Zm3.328,9.639c1.491,0,2.981-.026,4.471.012.579.014.718-.233.678-.731-.044-.526-.075-1.054-.106-1.582q-.179-2.96-.355-5.92c-.024-.418-.175-.6-.648-.593q-4.058.036-8.116,0c-.532-.007-.7.209-.718.662-.035.744-.065,1.487-.1,2.23q-.131,2.639-.267,5.279c-.023.449.121.669.634.658C-35.434,79.891-33.923,79.911-32.414,79.911Zm2.458-9.661a2.55,2.55,0,0,0-1.287-2.37,2.248,2.248,0,0,0-2.535.113,2.526,2.526,0,0,0-1.1,2.257Z" transform="translate(38.414 -66.777)"/>
                          </svg>
                        </div>
                        
                    </div>
                </div>
            </nav>
        </div>
        <!-- Header end -->
