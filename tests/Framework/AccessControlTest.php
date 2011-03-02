<?php
/**
 * @package  Framework\Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Tests;

use
	Framework\AccessControl,
	Framework\AccessControl\Assertion\AssertionInterface
;

class AccessControl_test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\AccessControl::addAssertion
	 */
	public function test_addAssertion_class() {
		
		$accessControl = new AccessControl();
		
		$accessControl->addAssertion('test', new TestTrueAssertion());
	}
	
	/**
	 * @covers \Framework\AccessControl::addAssertion
	 */
	public function test_addAssertion_name() {
		
		$accessControl = new AccessControl();
		
		$accessControl->addAssertion('test', 'Framework\Tests\TestTrueAssertion');
	}
	
	/**
	 * @covers \Framework\AccessControl::isAllowed
	 */
	public function test_isAllowed_named() {
		
		$accessControl = new AccessControl();
		
		$accessControl->addAssertion('test', new TestTrueAssertion());
		
		$this->assertTrue($accessControl->isAllowed('test', null));
	}
	
	/**
	 * @covers \Framework\AccessControl::isAllowed
	 */
	public function test_isAllowed_class() {
		
		$accessControl = new AccessControl();
		
		$this->assertTrue($accessControl->isAllowed(new TestTrueAssertion(), null));
	}
	
	/**
	 * @covers \Framework\AccessControl::isAllowed
	 * @expectedException \Framework\AccessControl\Exception\InvalidAssertion
	 */
	public function test_isAllowed_exceptions() {
		
		$accessControl = new AccessControl();
		
		$accessControl->isAllowed('invalid', null);
	}
	
}

class TestTrueAssertion implements AssertionInterface {
	public function assert($name, $role, $data){
		return true;
	}
}

class TestFalseAssertion implements AssertionInterface {
	public function assert($name, $role, $data){
		return false;
	}
}
