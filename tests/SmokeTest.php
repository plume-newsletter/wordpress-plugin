<?php
use PHPUnit\Framework\TestCase;

final class SmokeTest extends TestCase {
	public function test_stubs_load() {
		$this->assertTrue( function_exists( 'wp_remote_post' ) );
		$this->assertSame( 'a@b.co', is_email( 'a@b.co' ) );
		$this->assertFalse( is_email( 'nope' ) );
	}
}
