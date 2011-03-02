<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Tests\Session;

use
	\Framework\Session\Session
;

class Session_Test extends \PHPUnit_Framework_TestCase {
	
	public function setUp() {
		Session::setNamespace('unittest');
		Session::close();
		Session::init();
	}
	
	/**
	 * @covers \Framework\Session\Session::init
	 * @covers \Framework\Session\Session::__construct
	 */
	public function testInit() {
		// make sure the session is not started
		$this->assertNotEquals("", session_id());
	}
	
	/**
	 * @covers \Framework\Session\Session::close
	 * @covers \Framework\Session\Session::__destruct
	 */
	public function testClose() {
		Session::close();
		// this is hard to test as I do not know a way to determine is the session has been
		// written
		$this->assertEquals(0, count($_SESSION['unittest']));
	}
	
	/**
	 * @covers \Framework\Session\Session::setNamespace
	 * @covers \Framework\Session\Session::getNamespace
	 */
	public function testSetNamespace() {
		Session::setNamespace('newnamespace');
		$this->assertEquals('newnamespace', Session::getNamespace());
	}
	
	/**
	 * @covers \Framework\Session\Session::pushOnce
	 */
	public function testPushOnce() {
		$_SESSION['unittest']['__once__'] = array('__namespace__' => array('abc' => '1'));
		Session::pushOnce();
		Session::close();
		Session::init();
		$this->assertEquals('1', Session::getOnce('abc'));
	}
	
	/**
	 * @covers \Framework\Session\Session::getOnce
	 */
	public function testGetOnce() {
		$_SESSION['unittest']['__once__']['__namespace__'] = array('a' => '1');
		$this->assertEquals('1', Session::getOnce('a'));
		$this->assertEquals('2', Session::getOnce('b', '2'));
	}
	
	
	/**
	 * @covers \Framework\Session\Session::get
	 */
	public function testGet() {
		$_SESSION['unittest']['__namespace__'] = array('a' => '1');
		$this->assertEquals('1', Session::get('a'));
		$this->assertEquals('2', Session::get('b', '2'));
	}
	
	/**
	 * @covers \Framework\Session\Session::getAllOnceValues
	 */
	public function testGetAllOnceValues() {
		$_SESSION['unittest']['__once__']['__namespace__'] = array('a' => '1');
		$this->assertEquals(array('a' => '1'), Session::getAllOnceValues());
		$this->assertNull(Session::getAllOnceValues('does not exist'));
	}
	
	/**
	 * @covers \Framework\Session\Session::getAllValues
	 */
	public function testGetAllValues() {
		$_SESSION['unittest']['__namespace__'] = array('a' => '1');
		$this->assertEquals(array('a' => '1'), Session::getAllValues());
		$this->assertNull(Session::getAllValues('does not exist'));
	}
	
	/**
	 * @covers \Framework\Session\Session::reset
	 */
	public function testReset() {
		$_SESSION['unittest']['__namespace__'] = array('abc' => '1');
		Session::setOnce('a', '1');
		Session::reset();
		Session::close();
		Session::init();
		$this->assertEquals(1, count($_SESSION['unittest']));
		$this->assertEquals(0, count($_SESSION['unittest']['__once__']));
	}
	
	/**
	 * @covers \Framework\Session\Session::set
	 */
	public function testSet() {
		Session::set(null, '1');
		Session::set(null, '2');
		Session::set('a', '1');
		
		$this->assertEquals(
			array(1, 2, 'a' => 1),
			$_SESSION['unittest']['__namespace__']
		);
	}
	
	/**
	 * @covers \Framework\Session\Session::setOnce
	 */
	public function testSetOnce() {
		Session::setOnce(null, '1');
		Session::setOnce(null, '2');
		Session::setOnce('a', '1');
		Session::close();
		Session::init();
		
		$this->assertEquals(
			array(1, 2, 'a' => 1),
			$_SESSION['unittest']['__once__']['__namespace__']
		);
	}
	
}
