<?php

namespace ataylorme\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Brain\Monkey;

class TestAssert extends TestCase {
	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();
	}

	protected function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}

	public function testAssertTrue() {
		$this->assertTrue( true );
	}
}
