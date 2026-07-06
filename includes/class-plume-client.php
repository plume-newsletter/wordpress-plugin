<?php
if ( ! defined( 'ABSPATH' ) && ! defined( 'PLUME_NEWSLETTER_TESTING' ) ) {
	// Allow load under PHPUnit (no ABSPATH) but block direct web access in WP.
	if ( PHP_SAPI !== 'cli' ) { exit; }
}

/**
 * The only Plume-facing code. Calls the public double-opt-in subscribe
 * endpoint and normalizes the result to array('ok'=>bool,'message'=>string).
 * Never returns Plume's raw response body to the caller.
 */
class Plume_Client {

	public static function subscribe_url( $base, $list_id ) {
		return rtrim( $base, '/' ) . '/subscribe/' . rawurlencode( $list_id );
	}

	public static function subscribe( $base, $list_id, $email, $name ) {
		$res = wp_remote_post(
			self::subscribe_url( $base, $list_id ),
			array(
				'timeout' => 10,
				'headers' => array( 'Content-Type' => 'application/json' ),
				'body'    => wp_json_encode( array( 'email' => $email, 'name' => $name ) ),
			)
		);

		if ( is_wp_error( $res ) ) {
			return self::error();
		}
		$code = (int) wp_remote_retrieve_response_code( $res );
		if ( $code >= 200 && $code < 300 ) {
			return array(
				'ok'      => true,
				'message' => __( 'Thanks! Check your email to confirm your subscription.', 'plume-newsletter' ),
			);
		}
		return self::error();
	}

	private static function error() {
		return array(
			'ok'      => false,
			'message' => __( 'Sorry, something went wrong. Please try again later.', 'plume-newsletter' ),
		);
	}
}
