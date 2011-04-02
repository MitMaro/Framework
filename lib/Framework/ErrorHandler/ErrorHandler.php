<?php
/**
 * @package  Framework\ErrorHandler
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\ErrorHandler;

class ErrorHandler {
	
	/**
	 * @var array The loggers
	 */
	protected $loggers = array();
	
	/**
	 * Add a logger
	 *
	 * @param Logger\LoggerInterface $logger The logger
	 */
	public function addLogger(Logger\AbstractLogger $logger) {
		$this->loggers[] = $logger;
	}
	
	/**
	 * Set this class as the error handler
	 *
	 * @param integer $level The error reporting level
	 *
	 * @return callback The old error handler, null if the system error handler
	 */
	public function setAsErrorHandler($level = E_ALL) {
		error_reporting($level);
		return set_error_handler(array($this, 'errorHandler'), $level);
	}
	
	/**
	 * Set this class as the error handler
	 *
	 * @param integer $level The error reporting level
	 *
	 * @return callback The old exception handler, null if the system exception handler
	 */
	public function setAsExceptionHandler() {
		return set_exception_handler(array($this, 'exceptionHandler'));
	}
	
	/**
	 * The error handler, sends the error to all loggers
	 *
	 * @param integer $error_number The level of the error raised
	 * @param string $error_string The error message
	 * @param string $error_file The filename that the error was raised
	 * @param integer $error_line The line number the error was raised
	 * @param array $error_context An array that points to the active symbol table at the point the error occurred
	 */
	public function errorHandler($error_number, $error_string, $error_file, $error_line, $error_context, $backtrace = null) {
		
		// catch supressed/ignored errors
		if (!(error_reporting() & $error_number)) {
			return;
		}
	
		$backtrace = debug_backtrace();

		
		// remove this method as it is not needed
		array_shift($backtrace);
		
		// remove the call to trigger_error if it was used
		if(isset($backtrace[0]['function']) && $backtrace[0]['function'] == 'trigger_error'){
			array_shift($backtrace[0]);
		}
		

		// loop over each logger callings it's handle method
		foreach ($this->loggers as $logger) {
			$logger->handle($error_number, $error_string, $error_file, $error_line, $backtrace, $error_context);
		}
		
	}
	
	/**
	 * The exception handler, sends all exception to all loggers
	 *
	 * @param Exception $e The exception object
	 */
	public function exceptionHandler($e){
		
		// loop over each logger callings it's handle method
		foreach ($this->loggers as $key => $logger) {
			try {
				$logger->handle($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(), $e->getTrace(), null, get_class($e));
			} catch (\Exception $e){
				
				// remove the bad logger
				unset($this->loggers[$key]);
				
				trigger_error(
					get_class($e) . ' thrown within the ' . get_class($logger) . ' logger. Message: ' . $e->getMessage() . ' on line ' . $e->getLine(),
					E_USER_WARNING
				);
				break;
			}
		}
	}
	
	
	/**
	 * Get the registered loggers
	 *
	 * @return array An array of loggers
	 */
	public function getLoggers() {
		return $this->loggers;
	}
	
}
