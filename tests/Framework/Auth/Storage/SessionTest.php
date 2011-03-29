<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Tests\Auth\Storage;

use
	\Framework\Auth\Storage\Session
;

class Session_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Auth\Storage\Session::__construct
	 * @covers \Framework\Auth\Storage\Session::write
	 * @covers \Framework\Auth\Storage\Session::read
	 * @covers \Framework\Auth\Storage\Session::clear
	 * @covers \Framework\Auth\Storage\Session::isEmpty
	 */
	public function test() {
		$storage = new Session('test');
		
		$storage->write('abc');
		
		$this->assertEquals('abc', $storage->read());
		
		$this->assertFalse($storage->isEmpty());
		
		$storage->clear();
		
		$this->assertEquals(null, $storage->read());
		
		$this->assertTrue($storage->isEmpty());
		
	}
	
}
