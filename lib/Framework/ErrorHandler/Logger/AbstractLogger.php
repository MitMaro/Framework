<?php
/**
 * @package  Framework\ErrorHandler\Logger
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */


namespace Framework\ErrorHandler\Logger;

abstract class AbstractLogger {
	
	/**
	 * @static 
	 * @var arrayThe error code messages lookup array
	 */
	protected static $error_lookup_codes = array (
		E_ERROR => 'Error',
		E_WARNING => 'Warning',
		E_PARSE => 'Parsing Error',
		E_NOTICE => 'Notice',
		E_CORE_ERROR => 'Core Error',
		E_CORE_WARNING => 'Core Warning',
		E_COMPILE_ERROR => 'Compile Error',
		E_COMPILE_WARNING => 'Compile Warning',
		E_USER_ERROR => 'User Error',
		E_USER_WARNING => 'User Warning',
		E_USER_NOTICE => 'User Notice',
		E_STRICT => 'Strict Notice',
		E_RECOVERABLE_ERROR => 'Catchable Fatal Error',
		E_DEPRECATED => 'Deprecated',
		E_USER_DEPRECATED => 'User Deprecated'
	);
	
	/**
	 * Returns a friendly message for an error code. If code is not found returns the error code.
	 *
	 * @param integer $code The error code
	 *
	 * @return string|integer The error message or the error code 
	 */
	public function lookupErrorCode($code) {
		
		if (isset(self::$error_lookup_codes[$code])) {
			return self::$error_lookup_codes[$code];
		}
		return $code;
	}
	
	/**
	 * The error handler, sends the error to all loggers
	 *
	 * @param integer $error_number The level of the error raised
	 * @param string $error_string The error message
	 * @param string $error_file The filename that the error was raised
	 * @param integer $error_line The line number the error was raised
	 * @param array $backtrace A backtrace with error handling calls removed
	 * @param array $error_context An array that points to the active symbol table at the point the error occurred
	 * @param string $exception The exceptions class name if this method was called from an exception
	 */
	abstract public function handle($error_number, $error_string, $error_file, $error_line, $backtrace, $error_context, $exception = null);
	
}
