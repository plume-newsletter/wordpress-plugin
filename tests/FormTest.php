<?php
use PHPUnit\Framework\TestCase;

final class FormTest extends TestCase {
	protected function tearDown(): void { unset( $GLOBALS['__plume_options'] ); }

	public function test_render_contains_email_nonce_honeypot_timetrap_and_action() {
		$html = Plume_Form::render( array( 'list' => 'list-1' ) );
		$this->assertStringContainsString( 'type="email"', $html );
		$this->assertStringContainsString( 'name="plume_email"', $html );
		$this->assertStringContainsString( 'name="action"', $html );            // admin-post action field
		$this->assertStringContainsString( 'value="plume_subscribe"', $html );
		$this->assertStringContainsString( 'name="plume_hp"', $html );          // honeypot
		$this->assertStringContainsString( 'name="plume_ts"', $html );          // time-trap
		$this->assertStringContainsString( 'value="nonce-plume_subscribe"', $html );
		$this->assertStringContainsString( 'value="list-1"', $html );           // list carried in a hidden field
	}

	public function test_name_field_hidden_by_default_and_shown_when_enabled() {
		$this->assertStringNotContainsString( 'name="plume_name"', Plume_Form::render( array( 'list' => 'x' ) ) );
		$this->assertStringContainsString( 'name="plume_name"', Plume_Form::render( array( 'list' => 'x', 'name' => true ) ) );
	}

	public function test_shortcode_uses_settings_list_default_and_attribute_override() {
		$GLOBALS['__plume_options'] = array( 'plume_newsletter_list_id' => 'settings-list' );
		$this->assertStringContainsString( 'value="settings-list"', Plume_Form::shortcode( array() ) );
		$this->assertStringContainsString( 'value="attr-list"', Plume_Form::shortcode( array( 'list' => 'attr-list' ) ) );
	}

	public function test_render_escapes_list_and_button() {
		$html = Plume_Form::render( array( 'list' => '"><script>', 'button' => '"><b>' ) );
		$this->assertStringNotContainsString( '<script>', $html );
		$this->assertStringNotContainsString( '"><b>', $html );
	}
}
