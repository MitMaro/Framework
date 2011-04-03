<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Tests\ErrorHandler\Logger;

use
	Framework\ErrorHandler\Logger\StandardOut
;

class StandardOut_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\ErrorHandler\Logger\StandardOut::handle
	 */
	public function test_handle_error() {
		$logger = new StandardOut();
		
		
		ob_start();
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
		
		$result = trim(ob_get_contents());
		ob_end_clean();
		
		# replace date
		$result = preg_replace(
			'/[0-9]{1,2}:[0-9]{2}:[0-9]{2} [ap]m/i',
			'12:01:01 am',
			$result
		);
		
		$this->assertEquals(trim(file_get_contents(__DIR__ . '/../../../data/ErrorHandler/error.log.2')), $result);
		
	}
	
	/**
	 * @covers \Framework\ErrorHandler\Logger\StandardOut::handle
	 */
	public function test_handle_exception() {
		$logger = new StandardOut();
		
		
		ob_start();
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
		
		$result = trim(ob_get_contents());
		ob_end_clean();
		
		# replace date
		$result = preg_replace(
			'/[0-9]{1,2}:[0-9]{2}:[0-9]{2} [ap]m/i',
			'12:01:01 am',
			$result
		);
		
		$this->assertEquals(trim(file_get_contents(__DIR__ . '/../../../data/ErrorHandler/exception.log.2')), $result);
		
	}
	
}
