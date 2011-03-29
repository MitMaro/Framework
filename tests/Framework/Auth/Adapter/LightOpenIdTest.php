<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Tests\Auth\Adapter;

if (!class_exists('\LightOpenId')) {
	require 'Mocks/LightOpenId.php';
}

use
	Framework\Auth\Adapter
;

class LightOpenId_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Auth\Adapter\LightOpenId::__construct
	 * @covers \Framework\Auth\Adapter\LightOpenId::getReturnUrl
	 * @covers \Framework\Auth\Adapter\LightOpenId::getTrustRoot
	 * @covers \Framework\Auth\Adapter\LightOpenId::getRawData
	 */
	public function test_construct_plain() {
		
		$_SERVER['HTTPS'] = true;
		$_SERVER['HTTP_HOST'] = 'www.example.com';
		$_SERVER['REQUEST_URI'] = '/test/page';
		
		$_GET['foo'] = 'bar';
		$_POST['bar'] = 'foo';
		
		$openId = new Adapter\LightOpenId();
		
		$this->assertEquals('https://www.example.com', $openId->getTrustRoot());
		$this->assertEquals('https://www.example.com/test/page', $openId->getReturnUrl());
		$this->assertEquals(array('foo' => 'bar', 'bar' => 'foo'), $openId->getRawData());
		
		unset($_SERVER['HTTPS'], $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'], $_GET['foo'], $_POST['bar']);
	}
	
	/**
	 * @covers \Framework\Auth\Adapter\LightOpenId::__construct
	 * @covers \Framework\Auth\Adapter\LightOpenId::getReturnUrl
	 * @covers \Framework\Auth\Adapter\LightOpenId::getTrustRoot
	 * @covers \Framework\Auth\Adapter\LightOpenId::getRawData
	 */
	public function test_construct_full() {
		
		$openId = new Adapter\LightOpenId(
			array('foo' => 'bars', 'bars' => 'foo'),
			'https://www.example.net',
			'https://www.example.net/test/page2'
		);
		
		$this->assertEquals('https://www.example.net', $openId->getTrustRoot());
		$this->assertEquals('https://www.example.net/test/page2', $openId->getReturnUrl());
		$this->assertEquals(array('foo' => 'bars', 'bars' => 'foo'), $openId->getRawData());
		
	}
	
	/**
	 * @covers \Framework\Auth\Adapter\LightOpenId::authenticate
	 */
	public function test_authenticate() {
		$openId = new Adapter\LightOpenId(
			array('foo' => 'bars', 'bars' => 'foo'),
			'https://www.example.net',
			'https://www.example.net/test/page2'
		);
		
		$result = $openId->authenticate();
		
		$this->assertTrue($result->isAuthenticated());
		$this->assertEquals(array('abc' => 'def'), $result->getIdentity());
		
	}
	
}
