<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package cdam
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function cdam_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'cdam_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function cdam_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'cdam_pingback_header' );

if( ! function_exists( 'zwc_parse_url_menu' ) ){
	function zwc_parse_url_menu($url){
		$type = $url['type'];

		switch ($type) {
			case 'page':
				return !empty($url[$type]) ? get_permalink( $url[$type] ) : '#';
				break;
			case 'tax':
				return !empty($url[$type]) ? get_term_link( $url[$type], 'product_cat' ) : '#';
				break;
			case 'cate':
				return !empty($url[$type]) ? get_term_link( $url[$type], 'category' ) : '#';
				break;
			case 'tag':
				return !empty($url[$type]) ? get_term_link( $url[$type], 'post_tag' ) : '#';
				break;
			case 'custom':
				return !empty($url[$type]) ? home_url().$url[$type] : '#';
				break;

			default:
				return '#';
				break;
		}
	}
}

if( ! function_exists( 'zwc_parse_url_menu_id' ) ){
	function zwc_parse_url_menu_id($url){
		$type = $url['type'];

		switch ($type) {
			case 'page':
				return !empty($url[$type]) ? $url[$type] : '#';
				break;
			case 'tax':
				return !empty($url[$type]) ? $url[$type] : '#';
				break;
			case 'cate':
				return !empty($url[$type]) ? $url[$type] : '#';
				break;
			case 'tag':
				return !empty($url[$type]) ? $url[$type] : '#';
				break;
			case 'custom':
				return !empty($url[$type]) ? $url[$type] : '#';
				break;

			default:
				return '#';
				break;
		}
	}
}

if( ! function_exists( 'zwc_parse_page_id' ) ){
	function zwc_parse_page_id(){
		if( is_page() ){
			global $post;
			return $post->ID;
		}

		if( is_tax() ){
			$cat = get_queried_object();

			$cateFields = get_field_objects( $cat->taxonomy.'_'.$cat->term_id );
			$cat_type = $cateFields['zwc_product_cat_type']['value'];

			$type = $cat_type['value'];

			if( $type == 'collection' || $type == 'shop' ){
	      return $type;
	    }

			return $cat->term_id;
		}

		if( 'product' == get_post_type() ){
			global $post;
			$cat = get_the_terms($post->ID,'product_cat');
			$cat = $cat[0];

			$cateFields = get_field_objects( $cat->taxonomy.'_'.$cat->term_id );
			$cat_type = $cateFields['zwc_product_cat_type']['value'];

			$type = $cat_type['value'];

			if( $type == 'collection' || $type == 'shop' ){
				return $type;
			}
		}

		return false;
	}
}
