<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Tests\Auth;

if (!class_exists('\LightOpenId')) {
	require 'Mocks/LightOpenId.php';
}

use
	Framework\Auth\Result
;

class LightOpenId_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Auth\Result::setMessage
	 * @covers \Framework\Auth\Result::getMessage
	 */
	public function test_message() {
		$result = new Result();
		
		
		$this->assertEquals('Identity has not been set', $result->getMessage());
		$result->setIdentity(array());
		$this->assertNull($result->getMessage());
		$result->setMessage('foo bar');
		$this->assertEquals('foo bar', $result->getMessage());
	}
	
	/**
	 * @covers \Framework\Auth\Result::setIdentity
	 * @covers \Framework\Auth\Result::getIdentity
	 */
	public function test_identity() {
		$result = new Result();
		
		$result->setIdentity(array('abc' => 'cde'));
		$this->assertEquals(array('abc' => 'cde'), $result->getIdentity());
	}
	
	/**
	 * @covers \Framework\Auth\Result::setAuthenticated
	 * @covers \Framework\Auth\Result::isAuthenticated
	 */
	public function test_authenticated() {
		$result = new Result();
		
		$this->assertFalse($result->isAuthenticated());
		$result->setAuthenticated();
		$this->assertTrue($result->isAuthenticated());
	}
}
