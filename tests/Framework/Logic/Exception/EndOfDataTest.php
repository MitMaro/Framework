<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Exception\EndOfData
;

class LogicExceptionEndOfData_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Exception\EndOfData
	 */
	public function testAll() {
		new EndOfData();
	}
}
