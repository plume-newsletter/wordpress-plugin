<?php
// Minimal WordPress function stubs so plugin classes can be unit-tested
// without a WordPress install. Tests that need to vary wp_remote_post set
// $GLOBALS['__plume_remote_post'] to a callable.

class WP_Error_Stub {
	public $msg;
	public function __construct( $m = 'error' ) { $this->msg = $m; }
}

if ( ! function_exists( 'wp_remote_post' ) ) {
	function wp_remote_post( $url, $args = array() ) {
		$GLOBALS['__plume_last_post'] = array( 'url' => $url, 'args' => $args );
		$cb = isset( $GLOBALS['__plume_remote_post'] ) ? $GLOBALS['__plume_remote_post'] : null;
		return $cb ? $cb( $url, $args ) : array( 'response' => array( 'code' => 200 ), 'body' => 'ok' );
	}
}
if ( ! function_exists( 'is_wp_error' ) ) {
	function is_wp_error( $thing ) { return $thing instanceof WP_Error_Stub; }
}
if ( ! function_exists( 'wp_remote_retrieve_response_code' ) ) {
	function wp_remote_retrieve_response_code( $r ) { return is_array( $r ) && isset( $r['response']['code'] ) ? $r['response']['code'] : 0; }
}
if ( ! function_exists( 'wp_remote_retrieve_body' ) ) {
	function wp_remote_retrieve_body( $r ) { return is_array( $r ) && isset( $r['body'] ) ? $r['body'] : ''; }
}
if ( ! function_exists( 'wp_json_encode' ) ) {
	function wp_json_encode( $data ) { return json_encode( $data ); }
}
if ( ! function_exists( '__' ) ) {
	function __( $text, $domain = null ) { return $text; }
}
if ( ! function_exists( 'esc_html__' ) ) {
	function esc_html__( $text, $domain = null ) { return $text; }
}
if ( ! function_exists( 'esc_html' ) ) {
	function esc_html( $t ) { return htmlspecialchars( (string) $t, ENT_QUOTES ); }
}
if ( ! function_exists( 'esc_attr' ) ) {
	function esc_attr( $t ) { return htmlspecialchars( (string) $t, ENT_QUOTES ); }
}
if ( ! function_exists( 'esc_url' ) ) {
	function esc_url( $t ) { return filter_var( $t, FILTER_SANITIZE_URL ); }
}
if ( ! function_exists( 'is_email' ) ) {
	function is_email( $email ) { return filter_var( $email, FILTER_VALIDATE_EMAIL ) ? $email : false; }
}
if ( ! function_exists( 'sanitize_text_field' ) ) {
	function sanitize_text_field( $s ) { return trim( preg_replace( '/[\r\n\t ]+/', ' ', strip_tags( (string) $s ) ) ); }
}
if ( ! function_exists( 'shortcode_atts' ) ) {
	function shortcode_atts( $defaults, $atts ) {
		$atts = (array) $atts;
		$out  = array();
		foreach ( $defaults as $k => $v ) { $out[ $k ] = array_key_exists( $k, $atts ) ? $atts[ $k ] : $v; }
		return $out;
	}
}

if ( ! function_exists( 'admin_url' ) ) {
	function admin_url( $path = '' ) { return 'https://wp.test/wp-admin/' . ltrim( $path, '/' ); }
}
if ( ! function_exists( 'wp_nonce_field' ) ) {
	function wp_nonce_field( $action = -1, $name = '_wpnonce', $referer = true, $echo = true ) {
		$f = '<input type="hidden" name="' . esc_attr( $name ) . '" value="nonce-' . esc_attr( $action ) . '" />';
		if ( $echo ) { echo $f; }
		return $f;
	}
}
if ( ! function_exists( 'esc_attr__' ) ) { function esc_attr__( $t, $d = null ) { return $t; } }
if ( ! function_exists( 'get_option' ) ) {
	function get_option( $k, $default = false ) { return isset( $GLOBALS['__plume_options'][ $k ] ) ? $GLOBALS['__plume_options'][ $k ] : $default; }
}
if ( ! function_exists( 'wp_verify_nonce' ) ) {
	function wp_verify_nonce( $nonce, $action = -1 ) { return ( $nonce === 'nonce-' . $action ) ? 1 : false; }
}
if ( ! function_exists( 'wp_unslash' ) ) { function wp_unslash( $v ) { return $v; } }
if ( ! function_exists( 'sanitize_email' ) ) { function sanitize_email( $e ) { return is_email( $e ) ? $e : ''; } }

require_once __DIR__ . '/../includes/class-plume-client.php';
require_once __DIR__ . '/../includes/class-plume-form.php';
require_once __DIR__ . '/../includes/class-plume-handler.php';
