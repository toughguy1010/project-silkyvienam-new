<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();	
do_action('homepage_style');

// $container = get_theme_mod( 'understrap_container_type' );
?>
       <!-- Content start -->
	   <div class="wrap-content">
            <div class="slider">
                <div class="slider-img"></div>
                <a href="shop" class="slider-btn slider-btn-1">
                    <p>Chất liệu</p>
                </a>
                <a href="shop" class="slider-btn slider-btn-2">
                    <p>Quần áo</p>
                </a>
                <a href="shop" class="slider-btn slider-btn-3">
                    <p>Bộ <br> sưu tập</p>
                </a>
                <a href="shop" class="slider-btn slider-btn-4">
                    <p>Quà tặng</p>
                </a>
            </div>
        </div>
        <!-- Content end-->
<?php
get_footer();

?>