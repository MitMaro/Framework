<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Tests\ErrorHandler\Logger;

use
	Framework\ErrorHandler\Logger\File
;

class File_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\ErrorHandler\Logger\File::__construct
	 */
	public function test_construct_NonExistingFile_OK() {
		@unlink(__DIR__ . '/test.log'); // remove the file if it exists
		$logger = new File(__DIR__ . '/test.log');
		@unlink(__DIR__ . '/test.log'); // clean up
	}
	
	/**
	 * @covers \Framework\ErrorHandler\Logger\File::__construct
	 * @expectedException \Framework\ErrorHandler\Exception\Logger
	 */
	public function test_construct_NonExistingFile_NotWritable() {
		
		// double check to make sure / is not writable
		if (is_writable('/bin')) {
			$this->markTestSkipped('The directory /bin is writable, this should not be.');
		}
		$logger = new File('/bin');
	}
	
	/**
	 * @covers \Framework\ErrorHandler\Logger\File::__construct
	 * @expectedException \Framework\ErrorHandler\Exception\Logger
	 */
	public function test_construct_NonExistingFile_Denied() {
		
		// double check to make sure / is not writable
		if (is_writable('/bin')) {
			$this->markTestSkipped('The directory /bin is writable, this should not be.');
		}
		$logger = new File('/bin/idonotexist.deleteme.log');
	}
	
	/**
	 * @covers \Framework\ErrorHandler\Logger\File::handle
	 */
	public function test_handle_error() {
		
		$dir = sys_get_temp_dir();
		
		@unlink($dir . '/phpunit.test.error.log'); // remove the file if it exists
		$logger = new File($dir . '/phpunit.test.error.log', 6);
		
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
		
		$result = trim(file_get_contents($dir . '/phpunit.test.error.log.1'));
		
		# replace date
		$result = preg_replace(
			'#[a-z]{3} [a-z]{3} [0-9]{1,2} [0-9]{1,2}:[0-9]{2}:[0-9]{2} [0-9]{4}#i',
			'Thu Mar 31 22:28:39 2011',
			$result
		);
		
		$this->assertEquals(trim(file_get_contents(__DIR__ . '/../../../data/ErrorHandler/error.log')), $result);
		
		@unlink($dir . '/phpunit.test.error.log'); // clean up
	}
		
	/**
	 * @covers \Framework\ErrorHandler\Logger\File::handle
	 */
	public function test_handle_exception() {
		
		$dir = sys_get_temp_dir();
		
		@unlink($dir . '/phpunit.test.exception.log'); // remove the file if it exists
		$logger = new File($dir . '/phpunit.test.exception.log', 6);
		
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
					),
				),
			),
			null,
			'MyException'
		);
		
		$result = trim(file_get_contents($dir . '/phpunit.test.exception.log.1'));
		
		# replace date
		$result = preg_replace(
			'#[a-z]{3} [a-z]{3} [0-9]{1,2} [0-9]{1,2}:[0-9]{2}:[0-9]{2} [0-9]{4}#i',
			'Thu Mar 31 22:28:39 2011',
			$result
		);
		
		$this->assertEquals(trim(file_get_contents(__DIR__ . '/../../../data/ErrorHandler/exception.log')), $result);
		
		
		@unlink($dir . '/phpunit.test.exception.log'); // clean up
	}
	
}
