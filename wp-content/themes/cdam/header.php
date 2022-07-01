<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package cdam
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

	<header id="masthead" class="site-header">

		<div id="btnz">
			<div class="bar1"></div>
			<div class="bar2"></div>
			<div class="bar3"></div>
		</div>

		<div class="site-branding <?php if( ! is_front_page() ) { echo 'other'; } ?>">
			<?php
			the_custom_logo();
			?>
		</div>

		<?php get_template_part( 'template-parts/header', 'main' ); ?>

		<?php get_template_part( 'template-parts/header', 'meta' ); ?>

		<?php get_template_part( 'template-parts/header', 'menu' ); ?>

	</header>
