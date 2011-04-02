<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Tests\ErrorHandler;

use
	Framework\ErrorHandler\ErrorHandler,
	Framework\ErrorHandler\Logger\AbstractLogger
;

class ErrorHandler_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\ErrorHandler\ErrorHandler::addLogger
	 * @covers \Framework\ErrorHandler\ErrorHandler::getLoggers
	 */
	public function test_addGetLoggers() {
		
		$erHandler = new ErrorHandler();
		
		$logger = new TestLogger();
		
		$erHandler->addLogger($logger);
		
		$this->assertEquals(array($logger), $erHandler->getLoggers());
		
	}
	
	/**
	 * @covers \Framework\ErrorHandler\ErrorHandler::setAsErrorHandler
	 */
	public function test_setAsErrorHandler() {
		
		$erHandler = new ErrorHandler();
		
		$oldError = $erHandler->setAsErrorHandler(E_USER_WARNING);
		
		$this->assertEquals(E_USER_WARNING, error_reporting());
		
		$last = set_error_handler(array($this, 'errorHandler'), E_ALL);
		
		$this->assertEquals('Framework\ErrorHandler\ErrorHandler', get_class($last[0]));
		$this->assertEquals('errorHandler', $last[1]);
		
		set_error_handler($oldError, E_ALL);
		
	}
	
	/**
	 * @covers \Framework\ErrorHandler\ErrorHandler::setAsExceptionHandler
	 */
	public function test_setAsExceptionHandler() {
		
		$erHandler = new ErrorHandler();
		
		$oldException = $erHandler->setAsExceptionHandler();
		
		$last = set_exception_handler(array($this, 'exceptionHandler'));
		
		$this->assertEquals('Framework\ErrorHandler\ErrorHandler', get_class($last[0]));
		$this->assertEquals('exceptionHandler', $last[1]);
		
		set_exception_handler($oldException);
		
	}
	
	/**
	 * @covers \Framework\ErrorHandler\ErrorHandler::errorHandler
	 */
	public function test_errorHandler_simple() {
		
		$erHandler = new ErrorHandler();
		
		$erHandler->setAsErrorHandler(E_ALL);
		
		$logger = $this->getMock('Framework\Tests\ErrorHandler\TestLogger');
		$logger
			->expects($this->once())
			->method('handle')
			->with(
				$this->equalTo(E_USER_NOTICE),
				$this->equalTo('Test Error'),
				$this->equalTo(__FILE__),
				$this->greaterThan(__LINE__),
				$this->isType('array'),
				$this->isType('array'),
				$this->isNull()
			)
		;
		
		$erHandler->addLogger($logger);
		
		trigger_error('Test Error', E_USER_NOTICE);
		
		restore_error_handler();
		
	}
	
	/**
	 * @covers \Framework\ErrorHandler\ErrorHandler::errorHandler
	 */
	public function test_errorHandler_supressed() {
		
		$erHandler = new ErrorHandler();
		
		$erHandler->setAsErrorHandler(E_ALL);
		
		$logger = $this->getMock('Framework\Tests\ErrorHandler\TestLogger');
		$logger
			->expects($this->never())
			->method('handle')
		;
		
		$erHandler->addLogger($logger);
		
		@trigger_error('Test Error', E_USER_NOTICE);
		
		restore_error_handler();
		
	}
	
	/**
	 * @covers \Framework\ErrorHandler\ErrorHandler::exceptionHandler
	 */
	public function test_exceptionHandler_simple() {
		
		$erHandler = new ErrorHandler();
		
		$logger = $this->getMock('Framework\Tests\ErrorHandler\TestLogger');
		$logger
			->expects($this->once())
			->method('handle')
			->with(
				$this->equalTo(41),
				$this->equalTo('Test Exception'),
				$this->equalTo(__FILE__),
				$this->greaterThan(__LINE__),
				$this->isType('array'),
				$this->isNull(),
				$this->equalTo('Exception')
			)
		;
		
		$erHandler->addLogger($logger);
		
		$erHandler->exceptionHandler(new \Exception('Test Exception', 41));
		
	}
	
	/**
	 * @covers \Framework\ErrorHandler\ErrorHandler::exceptionHandler
	 */
	public function test_exceptionHandler_error() {
		
		// might be a better way to test this
		
		$erHandler = new ErrorHandler();
		
		$erHandler->setAsErrorHandler(E_ALL);
		
		$logger = $this->getMock('Framework\Tests\ErrorHandler\TestLogger');
		$logger
			->expects($this->exactly(2))
			->method('handle')
		;
		
		$erHandler->addLogger($logger); // This will catch the error caused by the next logger
		$erHandler->addLogger(new TestLogger());
		
		$erHandler->exceptionHandler(new \Exception('Test Exception', 41));
		
	}
	
	
	private function errorHandler($en, $es) {}
	private function exceptionHandler($e) {}
}

class TestLogger extends AbstractLogger {
	public function handle($error_number, $error_string, $error_file, $error_line, $backtrace, $error_context, $exception = null) {
		throw new \Exception();
	}
}
