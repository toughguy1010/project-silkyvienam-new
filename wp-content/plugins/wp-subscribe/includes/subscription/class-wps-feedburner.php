<?php
/**
 * FeedBurner Subscription
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPS_Subscription_FeedBurner extends WPS_Subscription_Base {

	public function the_form( $id, $options ) {
		?>

		<form action="https://feedburner.google.com/fb/a/mailverify?uri=<?php echo esc_attr( $options['feedburner_id'] ); ?>" method="post" class="wp-subscribe-form wp-subscribe-feedburner" id="wp-subscribe-form-<?php echo esc_attr( $id ); ?>" target="popupwindow">

			<input class="regular-text email-field" type="email" name="email" placeholder="<?php echo esc_attr( $options['email_placeholder'] ) ?>" required>

			<input type="hidden" name="uri" value="<?php echo esc_attr( $options['feedburner_id'] ); ?>">

			<input type="hidden" name="loc" value="en_US">

			<input type="hidden" name="form_type" value="<?php echo esc_attr( $options['form_type'] ); ?>">

			<input type="hidden" name="service" value="<?php echo esc_attr( $options['service'] ); ?>">

			<input type="hidden" name="widget" value="<?php echo isset( $options['widget_id'] ) ? esc_attr( $options['widget_id'] ) : '0'; ?>">
			<?php if( ! empty( $options['consent_text'] ) ) : ?>
				<div class="wps-consent-wrapper">
					<label for="consent-field">
						<input class="consent-field" id="consent-field" type="checkbox" name="consent" required />
						<?php echo wp_kses_post( $options['consent_text'] ); ?>
					</label>
				</div>
			<?php endif; ?>
			<input class="submit" type="submit" name="submit" value="<?php echo esc_attr( $options['button_text'] ) ?>">

		</form>

		<?php
	}

	public function get_fields() {

		$fields = array(
			'feedburner_id' => array(
				'id'    => 'feedburner_id',
				'name'  => 'feedburner_id',
				'type'  => 'text',
				'title' => __( 'Feedburner ID', 'wp-subscribe' ),
			)
		);

		return $fields;
	}
}
