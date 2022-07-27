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
        <div class="header-section header-desktop">
            <nav class="navbar navbar-expand-lg  ">
            <div class="menu-desktop">
                <?php
                wp_nav_menu( 
                    array( 
                        'theme_location' => 'main', 
                        'container' => 'false', 
                        'menu_id' => 'header-menu', 
                        'menu_class' => 'header-desktop-menu-list'
                     ) 
                  ); 
                ?> 
            </div>
           
                <a href="http://silkyvietnam.vn/" class="header-logo">
                <img src="<?php echo get_template_directory_uri() . '/img/header-logo-img.jpg'; ?>" class="logo-respon" />
                    <!-- <img src="/assets/img/header-logo-img.jpg" alt="" class="logo-respon"> -->
                 
                
                    <?php
                // wp_nav_menu( 
                //     array( 
                //         'theme_location' => 'language', 
                //         'container' => 'false', 
                //         'menu_id' => '', 
                //         'menu_class' => ''
                //      ) 
                //   ); 
                ?> 
                </a>
                <div class="header-feature">
                    <div class="header-feature-list wdlog-btn ">
                        <div class="header-feature-item ">
                        
                        <!-- <div id="weglot_here"></div> -->
             
                        </div>
                       
                    </div>
                    <div class="header-feature-list">
                     
                        <?php 
                        get_search_form();
                        
                        ?>
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
        <div class="header-section header-mobile">

            <nav class="navbar navbar-expand-lg  ">
            <div class="menu-mobile">
            <div class="menu-mobile-btn">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>
         
            <div class="menu-mobile-content">
                <div class="menu-mobile-control-btn">
                    <div class="back-menu-btn-group">
                    <div class="back-menu-btn-1">
                    <img src="<?php echo get_template_directory_uri() .'/assets/back-menu-btn.svg';?>" alt="">

                    </div>
                    <div class="back-menu-btn-2">
                    <img src="<?php echo get_template_directory_uri() .'/assets/back-menu-btn.svg';?>" alt="">
                    </div>
                    </div>
                    <div class="close-menu-btn">
                    <img src="<?php echo get_template_directory_uri() .'/assets/close-menu-btn.svg';?>" alt="">
                  
                    </div>
                </div>
                <div class="menu-mobile-list">
               
                <?php
                wp_nav_menu( 
                    array( 
                        'theme_location' => 'main', 
                        'container' => 'false', 
                        'menu_id' => 'header-menu', 
                        'menu_class' => 'header-mobile-menu-list'
                     ) 
                  ); 
                ?> 
                 <div class="header-feature-list search-form-mobile">
                     
                     <?php 
                     get_search_form();
                     
                     ?>
                 </div>
                </div>
            </div>
            </div>
           
                <a href="http://silkyvietnam.vn/" class="header-logo">
                <img src="<?php echo get_template_directory_uri() . '/img/header-logo-img.jpg'; ?>" class="logo-respon" />
                    <!-- <img src="/assets/img/header-logo-img.jpg" alt="" class="logo-respon"> -->

                </a>
                <div class="header-feature">
                <div class="header-feature-list wdlog-btn ">
                        
                        <div id="weglot_here"></div>
              
                   
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

