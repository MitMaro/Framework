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
	Framework\Auth\Auth,
	Framework\Auth\Result,
	Framework\Auth\Adapter\AdapterInterface,
	Framework\Auth\Storage\StorageInterface
;

class Auth_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Auth\Auth::__construct
	 */
	public function test_construct() {
		$auth = new Auth(new TestAdapter());
		$auth = new Auth(new TestAdapter(), new TestStorage());
	}
	
	/**
	 * @covers \Framework\Auth\Auth::authenticate
	 */
	public function test_authenticate() {
		$auth = new Auth(new TestAdapter(), new TestStorage());
		
		$result2 = $auth->authenticate();
		
		$result = new Result();
		$result->setAuthenticated();
		$result->setIdentity(array('foo' => 'bar'));
		
		$this->assertEquals($result, $result2);
	}
	
	
	/**
	 * @covers \Framework\Auth\Auth::getIdentity
	 */
	public function test_identity() {
		$auth = new Auth(new TestAdapter(), new TestStorage());
		
		$this->assertNull($auth->getIdentity());
		
		$result = $auth->authenticate();
		
		$this->assertEquals(array('foo'=>'bar'), $auth->getIdentity());
	}
}


class TestAdapter implements AdapterInterface {
	
	public function authenticate() {
		$result = new Result();
		$result->setAuthenticated();
		$result->setIdentity(array('foo' => 'bar'));
		return $result;
	}
	
}

class TestStorage implements StorageInterface {
	
	protected $data;
	
	public function read() {
		return $this->data;
	}

	public function isEmpty() {
		return count($this->data) === 0;
	}
	
	public function write($data) {
		$this->data = $data;
	}

	public function clear() {
		$this->data = array();
	}
	
}
