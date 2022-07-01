<?php 

	/*
	Plugin Name: Image Hover Effects
	Description: Add beautiful Image hover effects with caption to your website.
	Plugin URI: http://webdevocean.com/image-hover-effects
	Author: Labib Ahmed
	Author URI: http://webdevocean.com
	Version: 5.2
	License: GPL2
	Text Domain: la-captionhover 
	*/
	
	/*
	
	    Copyright (C) 2022  Labib Ahmed  webdevocean@gmail.com
	
	    This program is free software; you can redistribute it and/or modify
	    it under the terms of the GNU General Public License, version 2, as
	    published by the Free Software Foundation.
	
	    This program is distributed in the hope that it will be useful,
	    but WITHOUT ANY WARRANTY; without even the implied warranty of
	    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	    GNU General Public License for more details.
	
	    You should have received a copy of the GNU General Public License
	    along with this program; if not, write to the Free Software
	    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	*/

	add_action( 'activated_plugin', 'wdo_free_ihe_activation_redirect' );

	function wdo_free_ihe_activation_redirect( $plugin ) {
	    if( $plugin == plugin_basename( __FILE__ ) ) {
	        exit( wp_redirect( admin_url( 'admin.php?page=caption_hover' ) ) );
	    }
	}

	include_once ('plugin.class.php');
	if (class_exists('LA_Caption_Hover')) {
		$object = new LA_Caption_Hover;
	}
	
 ?>