<?php
use PHPUnit\Framework\TestCase;

final class HandlerTest extends TestCase {
	public function test_is_bot_true_when_honeypot_filled() {
		$this->assertTrue( Plume_Handler::is_bot( array( 'plume_hp' => 'x', 'plume_ts' => (string) ( time() - 30 ) ) ) );
	}
	public function test_is_bot_true_when_submitted_too_fast() {
		$this->assertTrue( Plume_Handler::is_bot( array( 'plume_hp' => '', 'plume_ts' => (string) time() ) ) );
	}
	public function test_is_bot_false_for_human() {
		$this->assertFalse( Plume_Handler::is_bot( array( 'plume_hp' => '', 'plume_ts' => (string) ( time() - 30 ) ) ) );
	}
	public function test_is_bot_true_when_timestamp_missing() {
		$this->assertTrue( Plume_Handler::is_bot( array( 'plume_hp' => '' ) ) );
	}
	public function test_wants_json_reads_x_requested_with() {
		$this->assertTrue( Plume_Handler::wants_json( array( 'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest' ) ) );
		$this->assertFalse( Plume_Handler::wants_json( array() ) );
	}
}
