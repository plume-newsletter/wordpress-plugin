<?php
defined( 'ABSPATH' ) || exit;

class Plume_Handler {

	const MIN_SECONDS = 2; // faster than this after render => bot.

	/** Honeypot filled, or the form was submitted implausibly fast. */
	public static function is_bot( $post ) {
		if ( ! empty( $post['plume_hp'] ) ) {
			return true;
		}
		$ts = isset( $post['plume_ts'] ) ? (int) $post['plume_ts'] : 0;
		return ( $ts <= 0 ) || ( ( time() - $ts ) < self::MIN_SECONDS );
	}

	public static function wants_json( $server ) {
		return isset( $server['HTTP_X_REQUESTED_WITH'] )
			&& strtolower( $server['HTTP_X_REQUESTED_WITH'] ) === 'xmlhttprequest';
	}

	/** admin-post handler for both logged-in and anonymous submissions. */
	public static function handle() {
		$post  = wp_unslash( $_POST );   // phpcs:ignore WordPress.Security.NonceVerification -- checked below
		$nonce = isset( $post['plume_nonce'] ) ? $post['plume_nonce'] : '';
		$ok    = wp_verify_nonce( $nonce, 'plume_subscribe' ) && ! self::is_bot( $post );

		if ( $ok ) {
			$email = sanitize_email( isset( $post['plume_email'] ) ? $post['plume_email'] : '' );
			$name  = sanitize_text_field( isset( $post['plume_name'] ) ? $post['plume_name'] : '' );
			$list  = sanitize_text_field( isset( $post['plume_list'] ) ? $post['plume_list'] : '' );
			$base  = get_option( 'plume_newsletter_base_url', '' );
			if ( '' === $list ) {
				$list = get_option( 'plume_newsletter_list_id', '' ); }

			if ( ! is_email( $email ) || '' === $base || '' === $list ) {
				$result = array(
					'ok'      => false,
					'message' => __( 'Please enter a valid email address.', 'plume-newsletter' ),
				);
			} else {
				$result = Plume_Client::subscribe( $base, $list, $email, $name );
			}
		} else {
			// Bots and bad nonces get a generic "success" — no info leak, no subscriber created.
			$result = array(
				'ok'      => true,
				'message' => __( 'Thanks! Check your email to confirm your subscription.', 'plume-newsletter' ),
			);
		}

		self::respond( $result, wp_get_referer() );
	}

	private static function respond( $result, $back ) {
		if ( self::wants_json( $_SERVER ) ) {
			wp_send_json( $result );
			return;
		}
		$flag = $result['ok'] ? 'ok' : 'error';
		$url  = add_query_arg( 'plume_signup', $flag, $back ? $back : home_url( '/' ) );
		wp_safe_redirect( $url );
		exit;
	}
}
