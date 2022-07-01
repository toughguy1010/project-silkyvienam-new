<?php
/**
*
*
* Template Name: Signin
*
*
*/

get_header();
wp_nonce_field( 'custom_checkout_z', 'nonce_checkout_key' );

$homeID = get_option('page_on_front');
$homeFields = get_field_objects( $homeID );
$signinup = $homeFields['zwc_home_signinup']['value'];

if (is_user_logged_in()) {
  wp_redirect( esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) ) ;
  exit;
}

?>
<main id="primary" class="site-main singinup">

  <!-- <div class="outer"> -->

    <div class="wrap-singinup">

      <div class="left">

        <div class="ltitle">
          Login
        </div>

        <div class="singinup-content">

          <form id="signin"  method="post">
            <div class="sign-row">
              <label for="">Email</label>
              <input type="text" name="username" value="" required>
            </div>
            <div class="sign-row">
              <label for="">Password</label>
              <input type="password" name="password" value="" required>
            </div>
            <div class="sign-row">
              <!-- <input type="submit" name="signup" value="Login" required> -->
              <button type="submit" name="button"><span></span>Login</button>
            </div>
            <div class="sign-row forgot">
              <a href="<?php echo esc_url( wc_lostpassword_url() ); ?>">Forgot Your Password?</a>
            </div>
            <div class="sign-row" id="error-sign">

            </div>
          </form>

        </div>

		<div class="social-login">
			<?php //echo do_shortcode('[nextend_social_login]'); ?>

			<a href="https://chatsbycdam.com/wp-login.php?loginSocial=facebook&amp;redirect=https%3A%2F%2Fchatsbycdam.com%2Fchatbydam%2Fdang-nhap%2F" rel="nofollow" aria-label="Login with <b>Facebook</b>" data-plugin="nsl" data-action="connect" data-provider="facebook" data-popupwidth="600" data-popupheight="679"><span></span>Login with Facebook</a>
			<a href="https://chatsbycdam.com/wp-login.php?loginSocial=google&amp;redirect=https%3A%2F%2Fchatsbycdam.com%2Fchatbydam%2Fdang-nhap%2F" rel="nofollow" aria-label="Continue with <b>Google</b>" data-plugin="nsl" data-action="connect" data-provider="google" data-popupwidth="600" data-popupheight="600"><span></span>Login with Google</a>
		</div>

      </div>

      <div class="right">

        <div class="ltitle">
          Create account
        </div>

        <div class="singinup-content">
          <div class="sign-row">
          Register to receive a personalised shopping experience, faster checkout and promotions.
          </div>
          <div class="sign-row">
            <a class="signin" href="<?php echo esc_url( get_permalink($signinup['signup']) ); ?>"><span></span>Register</a>
          </div>
        </div>

      </div>

    </div>

    <script type="text/javascript">
      jQuery(function($){
        $(function(){
          $('form#signin').on('submit', function(e){
              // var captcha = grecaptcha.getResponse(myCaptcha);
              $.ajax({
                  type: 'POST',
                  dataType: 'json',
                  url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
                  data: {
                      'action': 'ajaxlogin',
                      'username': $('form#signin input[name="username"]').val(),
                      'password': $('form#signin input[name="password"]').val(),
                      'nonce_checkout_key' : $('#nonce_checkout_key').val(),
                      '_wp_http_referer' : $('#nonce_checkout_key').next().val(),
                      // 'g-recaptcha-response' : captcha
                  },
                  beforeSend: function(){
                    $('#signin').addClass('loadingpage');
                    $('#signin').find('input').removeClass('error');
                  },
                  success: function(data){
                    // prepCaptcha();
                    console.log(data);
                    if ( data.loggedin == true ){
                      window.location.href = data.url;
                    } else {
                      $('#error-sign').html(data.message);
                      $('#signin').find('input[name="'+data.name+'"]').addClass('error');
                    }
                  },
                  complete: function(){
                    $('#signin').removeClass('loadingpage');
                  },
                  error:   function(error) {
                    console.log(error); // For testing (to be removed)
                  }
              });
              e.preventDefault();
          });
        });
      });
    </script>

  <!-- </div> -->

  <?php get_template_part( 'template-parts/content', 'subcri-footer' ); ?>

</main><!-- #main -->
<?php
get_footer();
