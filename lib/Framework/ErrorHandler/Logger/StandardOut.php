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

class StandardOut extends AbstractLogger {
	
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
		
		// the below styles should make the error appear even when they happen in
		// the middle of other html
		echo '<p style="font-family:monospace;font-size:14px;float:left;color:#000;background:#fff;width:100%;text-align:center;">';
		if (is_null($exception)) {
			echo 'A PHP error has occured in <b>' . $error_file . '</b> on line ';
			echo '<b>' . $error_line . '</b> @ <b>' . date('g:i:s a') . "</b><br/>";
			echo '<b>' . $this->lookupErrorCode($error_number) . ':</b> ' . $error_string;
		}
		else {
			echo 'An uncaught exception has occured in <b>' . $err['file'] . '</b> on line ';
			echo '<b>' . $error_line . '</b> @ <b>' . date('g:i:s a') . "</b><br/>";
			echo '<b>' . $exception . '[' . $error_number . ']:</b> ' . $error_string;
		}
		if (count($backtrace) > 0) {
			echo "<br/><b>Trace:</b><span style='font-size:12px;color:#666666;'><br/>";
			foreach($backtrace as $trace){
				
				// make sure these are set to a resonable 
				isset($trace['file']) ? null : $trace['file'] = '';
				isset($trace['line']) ? null : $trace['line'] = '-';
				isset($trace['class']) ? null : $trace['class'] = '';
				isset($trace['type']) ? null : $trace['type'] = '';
				isset($trace['args']) ? null : $trace['args'] = array();
				
				echo '&nbsp;&nbsp;&nbsp;&nbsp;' . $trace['class'] . $trace['type'] . $trace['function'];
				echo '(' . implode(', ', $trace['args']) . ')';
				echo  ' in file <b>' . $trace['file'] . '</b> on line: <b>' . $trace['line'] ."</b><br/>";
			}
			echo '</span>';
		}
		echo "</p>";
	}
	
}
