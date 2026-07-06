<?php
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase {
	protected function tearDown(): void { unset( $GLOBALS['__plume_remote_post'], $GLOBALS['__plume_last_post'] ); }

	public function test_subscribe_url_is_trailing_slash_safe() {
		$this->assertSame( 'https://p.test/subscribe/abc', Plume_Client::subscribe_url( 'https://p.test/', 'abc' ) );
		$this->assertSame( 'https://p.test/subscribe/abc', Plume_Client::subscribe_url( 'https://p.test', 'abc' ) );
	}

	public function test_subscribe_posts_json_body_and_maps_200_to_ok() {
		$GLOBALS['__plume_remote_post'] = function ( $url, $args ) {
			return array( 'response' => array( 'code' => 200 ), 'body' => 'Check your email to confirm.' );
		};
		$res = Plume_Client::subscribe( 'https://p.test', 'list-1', 'a@b.co', 'Ann' );
		$this->assertTrue( $res['ok'] );
		$this->assertNotEmpty( $res['message'] );
		$sent = $GLOBALS['__plume_last_post'];
		$this->assertSame( 'https://p.test/subscribe/list-1', $sent['url'] );
		$this->assertSame( array( 'email' => 'a@b.co', 'name' => 'Ann' ), json_decode( $sent['args']['body'], true ) );
		$this->assertSame( 'application/json', $sent['args']['headers']['Content-Type'] );
	}

	public function test_subscribe_maps_404_to_generic_error_without_leaking_body() {
		$GLOBALS['__plume_remote_post'] = function () { return array( 'response' => array( 'code' => 404 ), 'body' => 'not found' ); };
		$res = Plume_Client::subscribe( 'https://p.test', 'bad', 'a@b.co', '' );
		$this->assertFalse( $res['ok'] );
		$this->assertStringNotContainsStringIgnoringCase( 'not found', $res['message'] );
	}

	public function test_subscribe_maps_wp_error_to_generic_error() {
		$GLOBALS['__plume_remote_post'] = function () { return new WP_Error_Stub( 'boom' ); };
		$res = Plume_Client::subscribe( 'https://p.test', 'list-1', 'a@b.co', '' );
		$this->assertFalse( $res['ok'] );
		$this->assertStringNotContainsStringIgnoringCase( 'boom', $res['message'] );
	}
}
