<?php
defined( 'ABSPATH' ) || exit;

class Plume_Settings {
	public static function register() {
		register_setting(
			'plume_newsletter',
			'plume_newsletter_base_url',
			array(
				'sanitize_callback' => 'esc_url_raw',
				'default'           => '',
			)
		);
		register_setting(
			'plume_newsletter',
			'plume_newsletter_list_id',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => '',
			)
		);

		add_settings_section( 'plume_main', '', '__return_false', 'plume_newsletter' );
		add_settings_field( 'plume_base', __( 'Plume base URL', 'plume-newsletter' ), array( __CLASS__, 'field_base' ), 'plume_newsletter', 'plume_main' );
		add_settings_field( 'plume_list', __( 'Default list ID', 'plume-newsletter' ), array( __CLASS__, 'field_list' ), 'plume_newsletter', 'plume_main' );
	}

	public static function menu() {
		add_options_page( 'Plume', 'Plume', 'manage_options', 'plume_newsletter', array( __CLASS__, 'page' ) );
	}

	public static function field_base() {
		printf(
			'<input type="url" name="plume_newsletter_base_url" value="%s" class="regular-text" placeholder="https://app.yourplume.com" />',
			esc_attr( get_option( 'plume_newsletter_base_url', '' ) )
		);
	}

	public static function field_list() {
		printf(
			'<input type="text" name="plume_newsletter_list_id" value="%s" class="regular-text" /><p class="description">%s</p>',
			esc_attr( get_option( 'plume_newsletter_list_id', '' ) ),
			esc_html__( 'Copy a list ID from your Plume dashboard (Lists).', 'plume-newsletter' )
		);
	}

	public static function page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return; }
		echo '<div class="wrap"><h1>' . esc_html__( 'Plume Newsletter', 'plume-newsletter' ) . '</h1><form method="post" action="options.php">';
		settings_fields( 'plume_newsletter' );
		do_settings_sections( 'plume_newsletter' );
		submit_button();
		echo '</form><p>' . esc_html__( 'Add a form with the [plume_signup] shortcode or the Plume Signup widget.', 'plume-newsletter' ) . '</p></div>';
	}
}
