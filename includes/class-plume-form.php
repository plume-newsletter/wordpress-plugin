<?php
defined( 'ABSPATH' ) || exit;

class Plume_Form {

	/**
	 * Render the signup form. $args: list, button, name(bool), placeholder,
	 * notice(optional pre-escaped status HTML shown above the form).
	 */
	public static function render( $args ) {
		$args = array_merge(
			array(
				'list'        => '',
				'button'      => __( 'Subscribe', 'plume-newsletter' ),
				'name'        => false,
				'placeholder' => __( 'you@example.com', 'plume-newsletter' ),
				'notice'      => '',
			),
			(array) $args
		);

		ob_start();
		?>
		<form class="plume-signup" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php echo $args['notice']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- pre-escaped status HTML built by status_notice() ?>
			<input type="hidden" name="action" value="plume_subscribe" />
			<input type="hidden" name="plume_list" value="<?php echo esc_attr( $args['list'] ); ?>" />
			<input type="hidden" name="plume_ts" value="<?php echo esc_attr( (string) time() ); ?>" />
			<?php wp_nonce_field( 'plume_subscribe', 'plume_nonce' ); ?>
			<p class="plume-hp" style="position:absolute;left:-9999px" aria-hidden="true">
				<label>Leave this field empty
					<input type="text" name="plume_hp" tabindex="-1" autocomplete="off" value="" />
				</label>
			</p>
			<?php if ( $args['name'] ) : ?>
				<input type="text" name="plume_name" placeholder="<?php echo esc_attr__( 'Your name', 'plume-newsletter' ); ?>" />
			<?php endif; ?>
			<input type="email" name="plume_email" required placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>" />
			<button type="submit"><?php echo esc_html( $args['button'] ); ?></button>
		</form>
		<?php
		return trim( ob_get_clean() );
	}

	/** Shortcode [plume_signup list="" button="" name="true" placeholder=""]. */
	public static function shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'list'        => get_option( 'plume_newsletter_list_id', '' ),
				'button'      => __( 'Subscribe', 'plume-newsletter' ),
				'name'        => 'false',
				'placeholder' => __( 'you@example.com', 'plume-newsletter' ),
			),
			$atts
		);
		return self::render(
			array(
				'list'        => $atts['list'],
				'button'      => $atts['button'],
				'name'        => in_array( strtolower( (string) $atts['name'] ), array( 'true', '1', 'yes' ), true ),
				'placeholder' => $atts['placeholder'],
				'notice'      => self::status_notice(),
			)
		);
	}

	/** Renders a success/error notice when redirected back with ?plume_signup=. */
	private static function status_notice() {
		if ( empty( $_GET['plume_signup'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			return '';
		}
		$ok  = ( 'ok' === $_GET['plume_signup'] ); // phpcs:ignore WordPress.Security.NonceVerification
		$msg = $ok
			? __( 'Thanks! Check your email to confirm your subscription.', 'plume-newsletter' )
			: __( 'Sorry, something went wrong. Please try again later.', 'plume-newsletter' );
		return '<p class="plume-notice plume-notice-' . ( $ok ? 'ok' : 'error' ) . '">' . esc_html( $msg ) . '</p>';
	}
}
