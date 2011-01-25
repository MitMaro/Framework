<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Exception\InvalidValue
;

class LogicExceptionInvalidValue_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Exception\InvalidValue
	 */
	public function testAll() {
		new InvalidValue();
	}
}
