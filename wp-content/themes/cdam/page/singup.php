<?php
/**
*
*
* Template Name: Signup
*
*
*/

get_header();
wp_nonce_field( 'custom_checkout_z', 'nonce_checkout_key' );

$homeID = get_option('page_on_front');
$homeFields = get_field_objects( $homeID );

$signinup = $homeFields['zwc_home_signinup']['value'];
if (is_user_logged_in()) {
  if ( wp_redirect( esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) ) ) {
    exit;
  }
}

?>
<main id="primary" class="site-main singinup">

  <!-- <div class="outer"> -->

    <div class="wrap-singinup">

      <!-- <div class="left"> -->

        <div class="ltitle">
          Create Account
        </div>

        <div class="singinup-content">

          <form id="signup"  method="post">
            <div class="sign-row">
              <label for="">First Name<span>*</span></label>
              <input type="text" name="firstname" value="" required>
            </div>
            <div class="sign-row">
              <label for="">Last Name<span>*</span></label>
              <input type="text" name="lastname" value="" required>
            </div>
            <div class="sign-row">
              <label for="">Phone<span>*</span></label>
              <input type="tel" name="phone" value="" required>
            </div>
            <div class="sign-row">
              <label for="">Email<span>*</span></label>
              <input type="email" name="email" value="" required>
            </div>
            <div class="sign-row">
              <label for="">Password<span>*</span></label>
              <input type="password" name="password" value="" required>
            </div>
            <div class="sign-row">
              <label for="">Confirm Password<span>*</span></label>
              <input type="password" name="password2" value="" required>
            </div>
            <div class="sign-row">
              Password must be at least 8 characters; must contain at least one uppercase letter, one numeric digit, and one special character.
            </div>
            <div class="sign-row">
              <label for="">Birthday<span>*</span></label>
              <div id="wrap-brithday">
                <select id="signup-day" name="day">
                  <option>Day of Month</option>
                </select>
                <select id="signup-month" name="month">
                  <option>Month</option>
                </select>
                <select id="signup-year" name="year">
                  <option>Year</option>
                </select>
              </div>
            </div>
            <div class="wrap-policy">
              <div class="sign-row policy">
                <input type="checkbox" name="check_subscribe" value="1">
                Subscribe to newsletter
              </div>
              <div class="sign-row policy">
                <input type="checkbox" name="check_policy" value="1" required>
                <?php wc_checkout_privacy_policy_text(); ?>
              </div>
              <div class="sign-row">
                <!-- <input type="submit" name="signup" value="create account" required> -->
                <button type="submit" class="signin" name="button"><span></span>Register</button>
              </div>
            </div>
            <div class="sign-row" id="error-sign">

            </div>
          </form>

        </div>

      <!-- </div> -->

    </div>

    <script type="text/javascript">
      jQuery(function($){
        $(function(){

          $('form#signup').on('submit', function(e){
            var data = $('form#signup').serialize();
            data = data+'&action=ajaxregis&nonce_checkout_key='+$('#nonce_checkout_key').val()+'&_wp_http_referer='+$('#nonce_checkout_key').next().val();
            // var captcha = grecaptcha.getResponse(myCaptcha);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo admin_url( 'admin-ajax.php' ) ?>',
                data: data,
                beforeSend: function(){
                  $('#signup').find('input').removeClass('error');
                  $('#signup').addClass('loadingpage');
                },
                success: function(data){
                  // prepCaptcha();
                  console.log(data);
                  if ( data.loggedin == true ){
                    window.location.href = data.url;
                  } else {
                    $('#error-sign').html(data.message);
                    $('#signup').find('input[name="'+data.name+'"]').addClass('error');
                  }
                },
                complete: function(){
                  $('#signup').removeClass('loadingpage');
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
