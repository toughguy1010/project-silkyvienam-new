<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package cdam
 */
?>
	<?php get_template_part('template-parts/part','cart-popup'); ?>
	<?php get_template_part('template-parts/script','cart-popup'); ?>
	<?php get_template_part('template-parts/part','search'); ?>
	<?php get_template_part('template-parts/header','domain'); ?>
	<?php get_template_part('template-parts/script','subcribe'); ?>
	<?php
	if( is_product() ){
		get_template_part('template-parts/part','social-fixed');
	}
	?>

	<?php
	// global $template;
	// $file = basename($template);
  // if( $file == 'home.php' || $file == 'custom.php' || $file == 'taxonomy-product-cat.php' ){
	// 	get_template_part('template-parts/part','social-fixed-mess');
	// }else if( is_checkout() ){
	// 	get_template_part('template-parts/part','social-fixed');
	// }else{
	//
	// }
	?>
	<footer id="colophon" class="site-footer <?php if( !is_front_page() ) { echo 'other'; } ?>">
		<div class="site-info">
			<?php get_template_part( 'template-parts/footer', 'main' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<div class="btn-scroll-top show">
	<img src="<?php echo esc_url( get_template_directory_uri() .'/assets/top.svg' ); ?>" alt="">
</div>


<?php wp_footer(); ?>

<!-- Messenger Plugin chat Code -->
<div id="fb-root"></div>

<!-- Your Plugin chat code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
var chatbox = document.getElementById('fb-customer-chat');
chatbox.setAttribute("page_id", "767587363263514");
chatbox.setAttribute("attribution", "biz_inbox");

window.fbAsyncInit = function() {
FB.init({
xfbml            : true,
version          : 'v12.0'
});
};

(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

</body>
</html>
