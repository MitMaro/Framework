<?php
/**
 * @package  Framework\AccessControl\Exception
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\AccessControl\Exception;

class InvalidAssertion extends Exception {
	public function __construct($message = '', $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}
