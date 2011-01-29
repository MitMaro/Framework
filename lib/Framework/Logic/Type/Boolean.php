<?php
/**
 * @package  Framework\Logic\Type
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Logic\Type;

class Boolean extends Base {
		
	/**
	 * Creates a boolean out of the given value
	 *
	 * @param mixed Any value that can be converted into a boolean
	 */
	public function __construct($value) {
		if (is_string($value) && $value === 'true') {
			$this->value = true;
		} else if (is_string($value) && $value === 'false') {
			$this->value = false;
		} else {
			$this->value = (boolean)$value;
		}
	}
}
