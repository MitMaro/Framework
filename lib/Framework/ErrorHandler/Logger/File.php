<?php
/**
 * @package  Framework\ErrorHandler\Logger
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */
namespace Framework\ErrorHandler\Logger;

use
	Framework\ErrorHandler\Exception
;

class File extends AbstractLogger {
	
	/**
	 * @var string The log path
	 */
	protected $log_file_path;
	
	/**
	 * @var integer The max length of arguments
	 */
	protected $max_arg_length;
	
	/**
	 * @param string $log_file_path The path to log the errors
	 * @param integer $max_arg_length The maximum length of the argument
	 *
	 * @throws Exception\Logger if the path given is not writable
	 */
	public function __construct($log_file_path, $max_arg_length = 13) {
		
		if (!file_exists($log_file_path)) {
			if (!touch($log_file_path)) {
				throw new Exception\Logger('Log file is not writable: ' . $log_file_path);
			}
		} elseif (!is_writable($logFilePath)) {
			throw new Exception\Logger('Log file is not writable: ' . $log_file_path);
		}
		
		$this->log_file_path = $log_file_path;
		$this->max_arg_length = (int)$max_arg_length;
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
	public function handle($error_number, $error_string, $error_file, $error_line, $backtrace, $error_context, $exception = null) {
		
		$log = array();
		
		// slightly different message from exceptions
		if (is_null($exception)) {
			$log[] =
				'[' . date('D M d H:i:s Y') . '] [' . $this->lookupErrorCode($error_number) . '] ' . $error_string .
				': ' . $error_file . ' on line: ' . $error_line . "\n";
		} else {
			$log[] =
				'[' . date('D M d H:i:s Y') . '] Uncaught Exception: ' . $exception .
				'[' . $error_number . ']:' . strip_tags(html_entity_decode($error_string, ENT_QUOTES)) .
				': ' . $error_file . ' on line: ' . $error_line . "\n";
		}
		
		$log[] = "Trace:\n";
		
		foreach ($backtrace as $trace) {
			
			// make sure these are set to a resonable 
			isset($trace['file']) ? null : $trace['file'] = '';
			isset($trace['line']) ? null : $trace['line'] = '-';
			isset($trace['class']) ? null : $trace['class'] = '';
			isset($trace['type']) ? null : $trace['type'] = '';
			isset($trace['args']) ? null : $trace['args'] = array();
			
			foreach ($trace['args'] as $k => $arg) {
				if (is_string($arg) && strlen(trim($arg)) > $this->max_arg_length + 3) {
					$trace['args'][$k] = substr(trim($arg), 0 , $this->max_arg_length) . "...";
				} elseif (is_object($arg)) {
					$trace['args'][$k] = 'Object[' . get_class($arg) . ']';
				} else {
					$trace['args'][$k] = (string)$arg;
				}
			}
			
			$log[] =
				'       ' . $trace['class'] . $trace['type'] . $trace['function'] .
				'(' . implode(', ', $trace['args']) . ') in file ' . $trace['file'] . ' on line: ' . $trace['line'] . "\n";
			
		}
		
		foreach ($log as $l) {
			error_log($l, 3, $this->log_file_path);
		}
	}
	
}
