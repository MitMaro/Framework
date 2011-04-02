<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Tests\ErrorHandler\Logger;

use
	Framework\ErrorHandler\Logger\AbstractLogger
;

class AbstractLogger_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\ErrorHandler\Logger\AbstractLogger::lookupErrorCode
	 */
	public function test_lookupErrorCode() {
		$obj = $this->getMockForAbstractClass('\Framework\ErrorHandler\Logger\AbstractLogger');
		
		$this->assertEquals('Error', $obj->lookupErrorCode(E_ERROR));
		$this->assertEquals('Warning', $obj->lookupErrorCode(E_WARNING));
		$this->assertEquals('Parsing Error', $obj->lookupErrorCode(E_PARSE));
		$this->assertEquals('Notice', $obj->lookupErrorCode(E_NOTICE));
		$this->assertEquals('Core Error', $obj->lookupErrorCode(E_CORE_ERROR));
		$this->assertEquals('Core Warning', $obj->lookupErrorCode(E_CORE_WARNING));
		$this->assertEquals('Compile Error', $obj->lookupErrorCode(E_COMPILE_ERROR));
		$this->assertEquals('Compile Warning', $obj->lookupErrorCode(E_COMPILE_WARNING));
		$this->assertEquals('User Error', $obj->lookupErrorCode(E_USER_ERROR));
		$this->assertEquals('User Warning', $obj->lookupErrorCode(E_USER_WARNING));
		$this->assertEquals('User Notice', $obj->lookupErrorCode(E_USER_NOTICE));
		$this->assertEquals('Strict Notice', $obj->lookupErrorCode(E_STRICT));
		$this->assertEquals('Catchable Fatal Error', $obj->lookupErrorCode(E_RECOVERABLE_ERROR));
		$this->assertEquals('Deprecated', $obj->lookupErrorCode(E_DEPRECATED));
		$this->assertEquals('User Deprecated', $obj->lookupErrorCode(E_USER_DEPRECATED));
		$this->assertEquals(-23, $obj->lookupErrorCode(-23));
	}
	
}
