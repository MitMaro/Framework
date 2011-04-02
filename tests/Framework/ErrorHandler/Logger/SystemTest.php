<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Tests\ErrorHandler\Logger;

use
	Framework\ErrorHandler\Logger\System
;

class System_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\ErrorHandler\Logger\System::__construct
	 * @covers \Framework\ErrorHandler\Logger\System::handle
	 */
	public function test_handle_error() {
		
		// this test really doesn't do much other than check for some runtime errors
		$logger = new System(6);
		
		$logger->handle(
			1,
			'Test Error',
			'A/File.php',
			41,
			array (
				array (
					'file' => 'B/File.php',
					'line' => 10,
					'class' => 'BClass',
					'type' => '->',
					'args' => array (
						'arg1' => 'long value1',
						'arg2' => 'value2',
						'arg3' => new \stdClass()
					)
				),
				array (
					'file' => 'B/File.php',
					'line' => 10,
					'class' => 'BClass',
					'type' => '->',
					'args' => null
				),
				array (
					'file' => 'B/File.php',
					'line' => 10,
					'class' => 'BClass',
					'type' => false,
					'args' => false
				),
				array (
					'file' => 'B/File.php',
					'line' => 10,
					'class' => false,
					'type' => false,
					'args' => false
				),
				array (
					'file' => 'B/File.php',
					'line' => false,
					'class' => false,
					'type' => false,
					'args' => false
				),
				array (
					'file' => false,
					'line' => false,
					'class' => false,
					'type' => false,
					'args' => false
				),
			),
			null
		);
		
	}
	
	/**
	 * @covers \Framework\ErrorHandler\Logger\System::handle
	 */
	public function test_handle_exception() {
		$logger = new System(6);
		
		// this test really doesn't do much other than check for some runtime errors
		
		$logger->handle(
			1,
			'Test Error',
			'A/File.php',
			41,
			array (
				array (
					'file' => 'B/File.php',
					'line' => 10,
					'class' => 'BClass',
					'type' => '->',
					'args' => array (
						'arg1' => 'long value1',
						'arg2' => 'value2',
						'arg3' => new \stdClass()
					)
				),
				array (
					'file' => 'B/File.php',
					'line' => 10,
					'class' => 'BClass',
					'type' => '->',
					'args' => null
				),
				array (
					'file' => 'B/File.php',
					'line' => 10,
					'class' => 'BClass',
					'type' => false,
					'args' => false
				),
				array (
					'file' => 'B/File.php',
					'line' => 10,
					'class' => false,
					'type' => false,
					'args' => false
				),
				array (
					'file' => 'B/File.php',
					'line' => false,
					'class' => false,
					'type' => false,
					'args' => false
				),
				array (
					'file' => false,
					'line' => false,
					'class' => false,
					'type' => false,
					'args' => false
				),
			),
			null,
			'MyException'
		);
		
	}
	
}
