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
            <div class="slider-homepage">
                <div class="slider-img">
                <?php if ( function_exists( 'soliloquy' ) ) { soliloquy( '907' ); } ?>
                </div>
                <div class="slider-content"></div>
            </div>

        </div>


<!-- recent post -->
        <ul>
<?php
    $args = array( 'numberposts' => '4' );
    $recent_posts = wp_get_recent_posts( $args );
    foreach( $recent_posts as $recent ){
        echo get_the_post_thumbnail( );
        echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </li> ';
        echo the_excerpt();
    }
?>
</ul>

        <!-- Content end-->
<?php
get_footer();

?>